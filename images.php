<?php
/*******************************************************************
* $Id: images.php 6 2008-02-12 15:25:56Z BitC3R0 $           *
* ------------------------------------------------------           *
* RMSOFT Gallery System 2.0                                        *
* Sistema Avanzado de Galeras                                     *
* CopyRight  2005 - 2006. Red Mxico Soft                         *
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
* ------------------------------------------------------           *
* images.php:                                                      *
* Mostar imgenes populares, mejor votadas y todas                 *
* ------------------------------------------------------           *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.2.5                                                  *
* @modificado: 28/02/2006 06:34:07 p.m.                            *
*******************************************************************/
$rmgs_location = 'imagenes';
include 'header.php';

$myts =& MyTextSanitizer::getInstance();
$q = isset($_GET['q']) ? $myts->addSlashes($_GET['q']) : 'all';
$xoopsOption['template_main'] = 'rmgs_images.html';

$tpl->assign('q_show', $q);
rmgsMakeNav();

if (!empty($xoopsUser)){
	$user = new GSUser($xoopsUser->getVar('uid'), false, $mc['quota'] * 1024 * 1024);
	rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
}
/**
 * Establecemos los resultados por pagina
 */
rmgsSetResults($user);

$limit = $_SESSION['rmgs_results'];
$pag = isset($_GET['pag']) ? intval($_GET['pag']) : (isset($_POST['psg']) ? $_POST['pag'] : 0);
if ($pag > 0){ $pag -= 1; }
$start = $pag * $limit;

$tbl = $db->prefix("rmgs_imgs");

$tpl->assign('lang_finda',_RMGS_FINDIMAGE);
$tpl->assign('lang_popularkeys', _RMGS_POPULARKEY);

switch ($q){
	case 'search':
		$kw = isset($_GET['kw']) ? $myts->addSlashes($_GET['kw']) : '';
		if ($kw==''){ redirect_header($_SERVER['HTTP_REFERER'], 1, _RMGS_ERR_KEYS); die(); }
		$myts =& MyTextSanitizer::getInstance();
		$kw = str_replace(" ","",$myts->makeTboxData4Show($kw));
		$kw = strtolower($kw);
		$tpl->assign('page_title',sprintf(_RMGS_TITLE_KEYS, $kw));
		$tpl->assign('xoops_pagetitle', sprintf(_RMGS_TITLE_KEYS, $kw));
		
		$tkey = $db->prefix("rmgs_keys");
		$tlink = $db->prefix("rmgs_keylink");
		
		list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $tkey, $tlink, $tbl WHERE $tkey.key='$kw' AND $tlink.key=$tkey.id_key AND $tbl.id_img=$tlink.img"));
		$result = $db->query("SELECT $tbl.* FROM $tkey, $tlink, $tbl WHERE $tkey.key='$kw' AND $tlink.key=$tkey.id_key AND $tbl.id_img=$tlink.img ORDER BY `update` DESC LIMIT $start, $limit");
		
		include_once('class/key.class.php');
		$key = new GSKey($kw);
		
		if ($key->getVar('found')){ $key->setPoint(); }
		$tpl->assign('is_search', true);
		$tpl->assign('search_key', $kw);
		break;
	case 'user':
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if ($id<=0){ header('location: index.php'); die(); }
		$user = new GSUser($id);
		$xv = str_replace("XOOPS ", '',XOOPS_VERSION);
		if (substr($xv, 2, 1)=='2'){ $field = 'loginname'; } else { $field = 'uname'; }
		list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $tbl WHERE idu='$id'"));
		$result = $db->query("SELECT * FROM $tbl WHERE idu='$id' ORDER BY `update` DESC LIMIT $start, $limit");
		$tpl->assign('page_title',sprintf(_RMGS_TITLE_USER, '"'.$user->getVar('uname').'"'));
		$tpl->assign('xoops_pagetitle', sprintf(_RMGS_TITLE_USER, $user->getVar($field)));
		$tpl->assign('user_id', $user->getVar('id'));
		break;
	case 'voted':
		list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $tbl WHERE votos>='$mc[bestvotes]'"));
		$result = $db->query("SELECT * FROM $tbl WHERE votos>='$mc[bestvotes]' ORDER BY votos DESC LIMIT $start, $limit");
		$tpl->assign('page_title',_RMGS_TITLE_VOTES);
		$tpl->assign('xoops_pagetitle', _RMGS_TITLE_VOTES);
		break;
	case 'pop':
		list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $tbl WHERE descargas>='$mc[populars]'"));
		$result = $db->query("SELECT * FROM $tbl WHERE descargas>='$mc[populars]' ORDER BY descargas DESC LIMIT $start, $limit");
		$tpl->assign('page_title',_RMGS_TITLE_POPULAR);
		$tpl->assign('xoops_pagetitle', _RMGS_TITLE_POPULAR);
		break;
	case 'all':
	default:
		// Mostramos todas las imgenes
		list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $tbl"));
		$result = $db->query("SELECT * FROM $tbl ORDER BY `update` DESC LIMIT $start, $limit");
		$tpl->assign('page_title',_RMGS_TITLE_ALL);
		$tpl->assign('xoops_pagetitle', _RMGS_TITLE_ALL);
}

/**
 * Procesamos los resultados
 */
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
	//$image = new GSImage($row['id_img']);
	$user = new GSUser($row['idu']);
	$isnew = rmgsIsNew($row['fecha'], $mc['newimage']);
	$isupdate = rmgsIsNew($row['update'], $mc['updateimage']);
	$tpl->append('images', array('id'=>$row['id_img'],
		'title'=>$row['titulo'],
		'file'=>$row['file'],
		'date'=>date($mc['format_date'], $row['fecha']),
		'votes'=>$row['votos'],
		'downs'=>$row['descargas'],
		'isnew'=>$isnew,'isupdate'=>$isupdate,
		'uid'=>$row['idu'],
		'uname'=>$user->getVar('uname'),
		'dir'=>rmgsWebDir($row['idu'])));
}

$tpl->assign('lang_page',_RMGS_PAG);
$tpl->assign('current_page', $pactual);

rmgsCreatePagesNav($tpages, $pactual, "?q=$q&amp;".($q=='search' ? "&amp;kw=$kw" : ($q=='user' ? "&amp;id=$id" : '')), "&amp;");

$tpl->assign('columns', $mc['columns']);
$tpl->assign('colw', (int)(100 / $mc['columns']));
$tpl->assign('lang_by', _RMGS_BY);
$tpl->assign('lang_since', _RMGS_SINCE);
$tpl->assign('lang_resxpag',_RMGS_RESULTS);
$tpl->assign('lang_showing',sprintf(_RMGS_SHOWING, $start + 1, $start + $db->getRowsNum($result), $rtotal));

/**
 * Creamos la nevegacin de resultados
 */
for($i=$mc['columns'];$i<=($mc['columns'] * 6);$i += $mc['columns']){
	if ($i==$_SESSION['rmgs_results']){
		$tpl->append('results', array('num'=>$i, 'selected'=>true));
	} else {
		$tpl->append('results', array('num'=>$i, 'selected'=>false));
	}
}

include 'footer.php';

?>