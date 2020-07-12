<?php
/*******************************************************************
* $Id: keys.php 2 2006-12-11 20:49:07Z BitC3R0 $             *
* ----------------------------------------------------             *
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
* ----------------------------------------------------             *
* keys.php:                                                        *
* Control para mostrar las claves mas populares                    *
* ----------------------------------------------------             *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.6                                                  *
* @modificado: 01/03/2006 11:44:29 a.m.                            *
*******************************************************************/
$rmgs_location = 'keys';
include 'header.php';

list($points) = $db->fetchRow($db->query("SELECT points FROM ".$db->prefix("rmgs_keys")." ORDER BY points DESC LIMIT 0,1"));
$result = $db->query("SELECT * FROM ".$db->prefix("rmgs_keys")." ORDER BY `key`,points ASC LIMIT 0,100");
$size = 60 / $points;

while ($row =$db->fetchArray($result)){
	$itemsize = (int)($size * $row['points']) + 10;
	//$itemsize <=0 ? $itemsize = '10' : $itemsize;
	$tpl->append('keys',array('id'=>$row['id_key'],'key'=>$row['key'],'size'=>$itemsize,'legend'=>sprintf(_RMGS_TOTAL_POINTS, $row['points'])));
}

$xoopsOption['template_main'] = "rmgs_keys.html";

rmgsMakeNav();

if (is_object($xoopsUser)){
	$user = new GSUser($xoopsUser->getVar('uid'), false, $mc['quota'] * 1024 * 1024);
	rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
}

include 'footer.php';
?>


