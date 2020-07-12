<?php
/*******************************************************************
* $Id: search.func.php 2 2006-12-11 20:49:07Z BitC3R0 $      *
* -----------------------------------------------------------      *
* RMSOFT Gallery System 2.0                                        *
* Sistema Avanzado de Galerías                                     *
* CopyRight © 2005 - 2006. Red México Soft                         *
* http://www.redmexico.com.mx                                      *
* http://www.xoops-mexico.net                                      *
*                                                                  *
* This program is free software; you can redistribute it and/or    *
* modify it under the terms of the GNU General Public License as   *
* published by the Free Software Foundation; either version 2 of   *
* the License, or (at your option) any later version.              *
*                                                                  *
* This program is distributed in the hope that it will be useful,  *
* but WITHOUT ANY WARRANTY; without even the implied warranty of   *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the     *
* GNU General Public License for more details.                     *
*                                                                  *
* You should have received a copy of the GNU General Public        *
* License along with this program; if not, write to the Free       *
* Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,   *
* MA 02111-1307 USA                                                *
*                                                                  *
* -----------------------------------------------------------      *
* search.func.php:                                                 *
* Funciones para realizar busquedas en la base de datos            *
* -----------------------------------------------------------      *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.2                                                  *
* @modificado: 27/12/2005 04:10:05 p.m.                            *
*******************************************************************/

/**
 * Busqueda por categoría
 */
function rmgsSearchInCatego($limit){
	global $db, $tpl, $mc;
	
	$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
	$sort = isset($_GET['sort']) ? $_GET['sort'] : (isset($_POST['sort']) ? $_POST['sort'] : 'DESC');
	$key = isset($_GET['key']) ? $_GET['key'] : (isset($_POST['key']) ? $_POST['key'] : 'id_img');
	
	$pag = isset($_GET['pag']) ? $_GET['pag'] : (isset($_POST['pag']) ? $_POST['pag'] : 0);
	if ($pag > 0){ $pag -= 1; }
	$start = $pag * $limit;
	
	$timg = $db->prefix("rmgs_imgs");
	$tlnk = $db->prefix("rmgs_imglink");
	$catego = new GSCategory($id);
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix("rmgs_imglink")." WHERE id_cat='$id'"));
	$result = $db->query("SELECT $tlnk.*, $timg.id_img FROM $tlnk, $timg WHERE $tlnk.id_cat='$id' AND $timg.id_img=$tlnk.id_img ORDER BY $timg.$key $sort LIMIT $start, $limit");
	$rtotal = $num; // Numero total de resultados
	$tpages = (int)($num / $limit);
	if (($num % $limit) > 0){ $tpages++; }
	
	$pactual = $pag + 1;
	
	if ($pactual>$tpages){
		$rest = $pactual - $tpages;
		$pactual = $pactual - $rest + 1;
		$start = ($pactual - 1) * $limit;
	}
	
	while ($row = $db->fetchArray($result)){
		$image = new GSImage($row['id_img']);
		$user = new GSUser($image->getVar('uid'));
		$isnew = rmgsIsNew($image->getVar('date'), $mc['newimage']);
		$isupdate = rmgsIsNew($image->getVar('update'), $mc['updateimage']);
		$tpl->append('images', array('id'=>$image->getVar('id'),
			'title'=>$image->getVar('title', 1),
			'file'=>$image->getVar('file'),
			'date'=>date($mc['format_date'], $image->getVar('date')),
			'votes'=>$image->getVar('votes'),
			'downs'=>$image->getVar('downloads'),
			'isnew'=>$isnew,'isupdate'=>$isupdate,
			'uid'=>$image->getVar('uid'),
			'uname'=>$user->getVar('uname'),
			'dir'=>rmgsWebDir($image->getVar('uid'))));
	}
	
	$tpl->assign('lang_page',_RMGS_PAG);
	$tpl->assign('current_page', $pactual);
	rmgsCreatePagesNav($tpages, $pactual, "?id=".$catego->getVar('id'), '&amp;');
	
}

/**
 * Busqueda de imágenes agregadas en Favoritos
 * @param int $idu Id del Usuario
 * @param int $limit Limite de resultados por página
 */
function rmgsSearchInFavorites($idu, $limit){
	global $db, $tpl, $mc;
	
	
	$pag = isset($_GET['pag']) ? $_GET['pag'] : (isset($_POST['pag']) ? $_POST['pag'] : 0);
	if ($pag > 0){ $pag -= 1; }
	$start = $pag * $limit;
	
	$timg = $db->prefix("rmgs_imgs");
	$tfav = $db->prefix("rmgs_favorites");
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $tfav WHERE id_user='$idu'"));
	$result = $db->query("SELECT $tfav.fecha, $timg.id_img FROM $tfav, $timg WHERE $tfav.id_user='$idu' AND $timg.id_img=$tfav.id_img ORDER BY $tfav.fecha DESC LIMIT $start, $limit");
	$rtotal = $num; // Numero total de resultados
	$tpages = (int)($num / $limit);
	if (($num % $limit) > 0){ $tpages++; }
	
	$pactual = $pag + 1;
	
	if ($pactual>$tpages){
		$rest = $pactual - $tpages;
		$pactual = $pactual - $rest + 1;
		$start = ($pactual - 1) * $limit;
	}
	
	while ($row = $db->fetchArray($result)){
		$image = new GSImage($row['id_img']);
		$user = new GSUser($image->getVar('uid'));
		$isnew = rmgsIsNew($image->getVar('date'), $mc['newimage']);
		$isupdate = rmgsIsNew($image->getVar('update'), $mc['updateimage']);
		$tpl->append('images', array('id'=>$image->getVar('id'),
			'title'=>$image->getVar('title', 1),
			'file'=>$image->getVar('file'),
			'date'=>date($mc['format_date'], $image->getVar('date')),
			'votes'=>$image->getVar('votes'),
			'downs'=>$image->getVar('downloads'),
			'isnew'=>$isnew,'isupdate'=>$isupdate,
			'uid'=>$image->getVar('uid'),
			'uname'=>$user->getVar('uname'),
			'dir'=>rmgsWebDir($image->getVar('uid'))));
	}
	
	$tpl->assign('lang_page',_RMGS_PAG);
	$tpl->assign('current_page', $pactual);
	rmgsCreatePagesNav($tpages, $pactual, "ret=$return", '&amp;');
	
}

/**
 * Busqueda de imágenes de un usuario especifico
 * @param int $idu Id del Usuario
 * @param int $limit Limite de resultados por página
 */
function rmgsSearchUserPics($idu, $limit){
	global $db, $tpl, $mc;
	
	
	$pag = isset($_GET['pag']) ? $_GET['pag'] : (isset($_POST['pag']) ? $_POST['pag'] : 0);
	if ($pag > 0){ $pag -= 1; }
	$start = $pag * $limit;
	
	$tbl = $db->prefix("rmgs_imgs");
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $tbl WHERE idu='$idu'"));
	$result = $db->query("SELECT id_img FROM $tbl WHERE idu='$idu' ORDER BY fecha DESC LIMIT $start, $limit");
	$rtotal = $num; // Numero total de resultados
	$tpages = (int)($num / $limit);
	if (($num % $limit) > 0){ $tpages++; }
	
	$pactual = $pag + 1;
	
	if ($pactual>$tpages){
		$rest = $pactual - $tpages;
		$pactual = $pactual - $rest + 1;
		$start = ($pactual - 1) * $limit;
	}
	
	while ($row = $db->fetchArray($result)){
		$image = new GSImage($row['id_img']);
		$user = new GSUser($image->getVar('uid'));
		$isnew = rmgsIsNew($image->getVar('date'), $mc['newimage']);
		$isupdate = rmgsIsNew($image->getVar('update'), $mc['updateimage']);
		$tpl->append('images', array('id'=>$image->getVar('id'),
			'title'=>$image->getVar('title', 1),
			'file'=>$image->getVar('file'),
			'date'=>date($mc['format_date'], $image->getVar('date')),
			'votes'=>$image->getVar('votes'),
			'downs'=>$image->getVar('downloads'),
			'isnew'=>$isnew,'isupdate'=>$isupdate,
			'uid'=>$image->getVar('uid'),
			'uname'=>$user->getVar('uname'),
			'dir'=>rmgsWebDir($image->getVar('uid'))));
	}
	
	$tpl->assign('lang_page',_RMGS_PAG);
	$tpl->assign('current_page', $pactual);
	rmgsCreatePagesNav($tpages, $pactual, "", '?');
	
}

?>