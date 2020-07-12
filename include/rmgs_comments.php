<?php
/*******************************************************************
* $Id: rmgs_comments.php 2 2006-12-11 20:49:07Z BitC3R0 $    *
* -------------------------------------------------------------    *
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
* -------------------------------------------------------------    *
* rmgs_comments.php:                                               *
* Control de Comentarios                                           *
* -------------------------------------------------------------    *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.4                                                  *
* @modificado: 02/03/2006 04:59:44 p.m.                            *
*******************************************************************/

function rmgs_com_update($id, $total_num){
	$db =& Database::getInstance();
	$sql = 'UPDATE '.$db->prefix('rmdp_imgs').' SET reviews = '.$total_num.' WHERE id_img = '.$id;
	$db->query($sql);
}

function rmgs_com_approve(&$comment){
	// notification mail here
}

function rmgs_xoops_search($queryarray, $andor, $limit, $offset, $userid){

	$db = Database::getInstance();
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	$timg = $db->prefix("rmgs_imgs");
	$tlink = $db->prefix("rmgs_keylink");
	$tkey = $db->prefix("rmgs_keys");
	
	$sql = "SELECT $timg.* FROM $tkey,$tlink,$timg ";
	if ( $userid != 0 ) {
		$sql .= " WHERE idu='".$userid."' AND ";
	} else {
		$sql .= " WHERE ";
	}
	
	$sql .= "(";
	foreach ($queryarray as $k){
		$sql .= "$tkey.key='$k' OR";
	}
	if (substr($sql, strlen($sql)-3, 3)==' OR'){ $sql = substr($sql, 0, strlen($sql) - 3); }
	$sql .= ") AND $tlink.key=$tkey.id_key AND $timg.id_img=$tlink.img ORDER BY `update` DESC LIMIT $offset,$limit";
	
	include_once XOOPS_ROOT_PATH.'/modules/rmgs/include/block.func.php';
	$mc = rmgs_bkget_config('rmgs');
	$result = $db->query($sql);
	$dir = str_replace(XOOPS_ROOT_PATH,XOOPS_URL,$mc['storedir']);
	if (substr($dir, strlen($dir) - 1, 1)!='/'){ $dir.='/'; }

	$version = str_replace("XOOPS ", "", XOOPS_VERSION);
	$version = substr($version, 0, 3);
	if ($version >= "2.2"){
		$xv = true;
	} else {
		$xv = false;
	}
	$i = 0;
	while ($row = $db->fetchArray($result)){
		$user = new XoopsUser($row['idu']);
		if ($xv){
			$fdir = $dir . $user->getVar('loginname');
		} else {
			$fdir = $dir . $user->getVar('uname');
		}
		$ret[$i]['image'] = 'pics_redir.php?file=' . base64_encode($fdir . '/ths/' . $row['file']);
		$ret[$i]['link'] = XOOPS_URL . '/modules/rmgs/view.php?id=' . $row['id_img'];
		$ret[$i]['title'] = ($row['titulo'] != '') ? $row['titulo'] : $row['file'];
		$ret[$i]['time'] = $row['fecha'];
		$ret[$i]['uid'] = $row['idu'];
		$i++;
	}
	
	return $ret;
}
?>

