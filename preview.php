<?php
/*******************************************************************
* $Id: preview.php 2 2006-12-11 20:49:07Z BitC3R0 $          *
* -------------------------------------------------------          *
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
* -------------------------------------------------------          *
* preview.php:                                                     *
* Previsualización de postales                                     *
* -------------------------------------------------------          *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.5                                                  *
* @modificado: 25/02/2006 12:10:22 a.m.                            *
*******************************************************************/
include '../../mainfile.php';
$db =& $xoopsDB;			// Base de datos
$tpl =& $xoopsTpl;			// Plantillas
$mc =& $xoopsModuleConfig;	// Configuración del Módulo
$xoops_module_header = '<link rel="stylesheet" type="text/css" href="rmgs.css" />';

if (is_dir(XOOPS_ROOT_PATH.'/modules/rmgs/images/'.$xoopsConfig['language'])){
	$xoopsTpl->assign('mod_language',$xoopsConfig['language']);
} else {
	$xoopsTpl->assign('mod_language','spanish');
}

$xoopsTpl->assign('module_path', XOOPS_ROOT_PATH.'/modules/rmgs');
$xoopsTpl->assign('allow_upload', $mc['upload']);
$xoopsTpl->assign('allow_sets', $mc['sets']);
$xoopsTpl->assign('allow_postal', $mc['postal']);
$xoopsTpl->assign('rmgs_requesturi', base64_encode($_SERVER['REQUEST_URI']));

include 'include/rmgs_functions.php';
include 'class/image.class.php';
include 'class/user.class.php';
include 'class/catego.class.php';

if ($mc['postal']==0){
	redirect_header(base64_decode($return), 1, '_RMGS_NOALLOWED');
	die();
}

if (!is_object($xoopsUser) && $mc['postal_anonimo']==0){
	redirect_header(base64_decode($return), 1, '_RMGS_NOALLOWED');
	die();
}

foreach($_POST as $k => $v){
	$$k = $v;
}

include_once 'class/postal.class.php';

$image = new GSImage($id);
$p = new GSPostalTemplate($template);

$p->setImage(rmgsWebDir($image->getVar('uid')).'/'.$image->getVar('file'));
$p->setImageName($image->getVar('title'));
$p->setTitulo($titulo);
$p->setTexto($texto);
$p->setSenderName($nombre);
$p->setSenderMail($email);
$p->setDestName($name_dest);
$p->setDestMail($mail_dest);

echo $p->display();

?>