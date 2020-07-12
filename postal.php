<?php
/*******************************************************************
* $Id: postal.php 2 2006-12-11 20:49:07Z BitC3R0 $           *
* ------------------------------------------------------           *
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
* ------------------------------------------------------           *
* postal.php:                                                      *
* Este archivo permite crear, enviar y recibir postales            *
* ------------------------------------------------------           *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.4                                                  *
* @modificado: 24/02/2006 03:45:25 p.m.                            *
*******************************************************************/

$rmgs_location = 'postales';
include 'header.php';

$xoops_module_header .= "\n".'<script type="text/javascript" src="include/rmgs.js"></script>';

$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');
$return = isset($_GET['ret']) ? $_GET['ret'] : (isset($_POST['ret']) ? $_POST['ret'] : '');

if ($mc['postal']==0){
	redirect_header(base64_decode($return), 1, _RMGS_NOALLOWED);
	die();
}

$user = 0;
if (is_object($xoopsUser)){
	$tpl->assign('rmgs_user', array('id'=>$xoopsUser->getVar('uid'),'uname'=>$xoopsUser->getVar('uname'),
		'email'=>$xoopsUser->getVar('email'),'nombre'=>$xoopsUser->getVar('name')));
	$user = $xoopsUser->getVar('uid');
}

/**
 * Eliminamos las postales viejas
 */
deleteOldPostals();

switch ($op){
	case 'send':
	
		if (!is_object($xoopsUser) && $mc['postal_anonimo']==0){
			redirect_header(base64_decode($return), 1, _RMGS_NOALLOWED);
			die();
		}
	
		$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
		if ($id<=0){
			header('location: '.($return != '' ? base64_decode($return) : 'index.php'));
			die();
		}
		
		$image = new GSImage($id);
		if (!$image->getVar('found')){
			header('location: '.($return != '' ? base64_decode($return) : 'index.php'));
			die();
		}
		
		foreach ($_POST as $k => $v){
			$$k = $v;
		}
		
		$qstring = "postal.php?id=$id&amp;ret=$return&amp;op=create";
		
		include_once 'class/postal.class.php';
		$myts = MyTextSanitizer::getInstance();
		
		if ($titulo==''){ redirect_header($qstring, 1, _RMGS_ERRTITLE); die(); }
		if ($texto==''){ redirect_header($qstring, 1, _RMGS_ERRTEXT); die(); }
		if ($name_dest==''){ redirect_header($qstring, 1, _RMGS_ERRNAMEDEST); die(); }
		if ($mail_dest==''){ redirect_header($qstring, 1, _RMGS_ERRMAILDEST); die(); }
		if ($nombre==''){ redirect_header($qstring, 1, _RMGS_ERRNAME); die(); }
		if ($email==''){ redirect_header($qstring, 1, _RMGS_ERRMAIL); die(); }
		if ($template==''){ redirect_header($qstring, 1, _RMGS_ERRTPL); die(); }
		
		$postal = new GSPostal();
		$postal->setImagen($id);
		$postal->setTitulo($titulo);
		$postal->setTexto($myts->makeTareaData4Save($texto));
		$postal->setUser($user);
		$postal->setEmailSender($email);
		$postal->setNameSender($nombre);
		$postal->setEmailDest($mail_dest);
		$postal->setNameDest($name_dest);
		$postal->setTemplate($template);
		$postal->setRedirect($return);
		
		if (!$postal->create()){
			redirect_header($qstring, 2, _RMGS_ERRSENT);
			die();
		}
		
		/**
		 * Enviamos el email con información de la postal
		 **/
		$xoopsMailer =& getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setTemplate("postales.tpl");
		$xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH.'/modules/rmgs/language/'.$xoopsConfig['language'].'/mail_template');
		$xoopsMailer->assign('NAME', $name_dest);
		$xoopsMailer->assign('SENDER', $nombre);
		$xoopsMailer->assign('SITENAME', $xoopsConfig['sitename']);
		$xoopsMailer->assign('LINK', XOOPS_URL.'/modules/rmgs/postal.php?op=view&postal='.$postal->getVar('codigo'));
		$xoopsMailer->assign('URL', XOOPS_URL.'/modules/rmgs');
		$xoopsMailer->assign('MODNAME', $mc['modtitle']);
		$xoopsMailer->assign('DAYS', $mc['postaldays']);
		$xoopsMailer->setToEmails($mail_dest);
		$xoopsMailer->setFromEmail($mc['postal_mail']);
		$xoopsMailer->setFromName($nombre);
		$xoopsMailer->setSubject(sprintf(_RMGS_POSTALRECEIVE, $xoopsConfig['sitename']));
		if ($xoopsMailer->send()){
			redirect_header(base64_decode($return), 1, sprintf(_RMGS_POSTALSENT, $name_dest));
			die();
		} else {
			redirect_header($qstring, 2, _RMGS_ERRSENT);
			die();
		}
		
		break;
	case 'view':
		include_once 'class/postal.class.php';
		$myts = MyTextSanitizer::getInstance();
		
		$id = isset($_GET['postal']) ? $_GET['postal'] : '';
		if ($id==''){
			redirect_header('index.php', 1, _RMGS_NOEXISTS);
			die();
		}
		
		$postal = new GSPostal($id);
		$postal->display(true);
		die();
		
		break;
	default:
	
		if (!is_object($xoopsUser) && $mc['postal_anonimo']==0){
			redirect_header(base64_decode($return), 1, _RMGS_NOALLOWED);
			die();
		}
	
		$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
		if ($id<=0){
			header('location: '.($return != '' ? base64_decode($return) : 'index.php'));
			die();
		}
		
		$xoopsOption['template_main'] = 'rmgs_create_postal.html';
		rmgsMakeNav();
		
		if ($xoopsUser != ''){
			$user = new GSUser($xoopsUser->getVar('uid'), true, $mc['quota'] * 1024 * 1024);
			rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
		}
		
		$xoopsTpl->assign('lang_create_postal', _RMGS_CREATE_POSTAL);
		$image = new GSImage($id);
		$tpl->assign('img', array('id'=>$image->getVar('id'),'title'=>$image->getVar('title'),
			'dir'=>rmgsWebDir($image->getVar('uid')),'file'=>$image->getVar('file')));
		$tpl->assign('return',base64_decode($return));
		$tpl->assign('return_encode', $return);
		$tpl->assign('lang_name_dest',_RMGS_NAME_DEST);
		$tpl->assign('lang_email_dest',_RMGS_DEST_EMAIL);
		$tpl->assign('lang_postal_title',_RMGS_TITLE_POSTAL);
		$tpl->assign('lang_postal_content',_RMGS_POSTAL_CONTENT);
		$tpl->assign('lang_template',_RMGS_STEMPLATE);
		$tpl->assign('lang_yourname',_RMGS_YOUR_NAME);
		$tpl->assign('lang_yourmail',_RMGS_YOUR_MAIL);
		$tpl->assign('lang_preview', _RMGS_PREVIEW);
		$tpl->assign('lang_send', _SUBMIT);
		$tpl->assign('lang_cancel', _CANCEL);
		
		$dirh = @opendir(XOOPS_ROOT_PATH.'/modules/rmgs/tpls');
		while ($obj = readdir($dirh)){
			if ($obj=='.' || $obj=='..'){ continue; }
		
			$ext = explode(".", $obj);
			if ($ext[1]!='tpl'){ continue; }
			$tpl->append('templates', $ext[0]);
		}
}

include 'footer.php';
?>


