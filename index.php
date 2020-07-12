<?php
/*******************************************************************
* $Id: index.php 2 2006-12-11 20:49:07Z BitC3R0 $            *
* -----------------------------------------------------            *
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
* -----------------------------------------------------            *
* index.php:                                                       *
* Archivo indice                                                   *
* -----------------------------------------------------            *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.1                                                  *
* @modificado: 26/12/2005 06:51:12 p.m.                            *
*******************************************************************/
$rmgs_location = 'indice';
include 'header.php';

$xoopsOption['template_main'] = 'rmgs_index.html';

/**
 * Obtenemos una imgen para mostrar en la pgina principal
 */
include_once 'include/images_functions.php';
$hid = rmgsGetHomeImage();

if ($hid>=0){
	$hImage = new GSImage($hid);
	$tpl->assign('home_image', array('id'=>$hImage->getVar('id'),'titulo'=>$hImage->getVar('title'),
			'img'=>$hImage->getHomeImage()));
}

rmgsMakeNav();

if ($xoopsUser != ''){
	$xoopsTpl->assign('lang_welcome', sprintf(_RMGS_WELCOME, $xoopsUser->getVar('uname')));
	$user = new GSUser($xoopsUser->getVar('uid'), false, $mc['quota'] * 1024 * 1024);
	//rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
}

$result = $xoopsDB->query("SELECT id_img FROM ".$xoopsDB->prefix("rmgs_imgs")." ORDER BY fecha DESC LIMIT 0, $xoopsModuleConfig[thshome]");
while ($row=$xoopsDB->fetchArray($result)){
	$image = new GSImage($row['id_img']);
	$user = new XoopsUser($image->getVar('uid'));
	$dir = rmgsWebDir($image->getVar('uid'));
	$dir = rmgsAddSlash($dir);
	$xoopsTpl->append('recent_images', array('id'=>$image->getVar('id'),'title'=>$image->getVar('title'),'file'=>$image->getVar('file'),'idu'=>$image->getVar('uid'),'dir'=>$dir,
			'user'=>$user->getVar('uname')));
}

$tpl->assign('lang_all_pics', _RMGS_ALL_PHOTOS);
$tpl->assign('lang_by', _RMGS_BY);
$tpl->assign('lang_last', sprintf(_RMGS_LASTIMAGES, $xoopsModuleConfig['thshome']));
$tpl->assign('lang_categos', _RMGS_CATEGOS);
$tpl->assign('lang_finda',_RMGS_FINDIMAGE);
$tpl->assign('lang_popularkeys',_RMGS_POPULARKEY);
$tpl->assign('lang_upload_home',_RMGS_UPLOAD_HOME);
$tpl->assign('lang_mypics_home', _RMGS_YOURPHOTOS);
$tpl->assign('lang_favs_home', _RMGS_FAVS_HOME);

// Obtenemos las categoras
include 'include/categos.func.php';
getCategos(0);

include 'footer.php';
?>

