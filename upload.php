<?php
/*******************************************************************
* $Id: upload.php 2 2006-12-11 20:49:07Z BitC3R0 $           *
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
* upload.php:                                                      *
* Archivo para caragar nuevas imgenes al servidor                 *
* ------------------------------------------------------           *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.2.5                                                  *
* @modificado: 25/02/2006 11:31:14 p.m.                            *
*******************************************************************/
$rmgs_location = 'uploads';
include 'header.php';

$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');

if (!rmgsCheckUpload()){
	redirect_header('index.php',1,_RMGS_NOALLOWED);
	die();
}

/**
 * Si el usuario es un Webmaster entonces lo dirigimos
 * automticamente a la seccin de administracin de imgenes
 */
/*if ($xoopsUser->isAdmin()){
	header('location: admin/images.php?op=upload');
	die();
}*/

$return = isset($_GET['ret']) ? $_GET['ret'] : (isset($_POST['ret']) ? $_POST['ret'] : '');
$tpl->assign('return', $return);

$user = new GSUser($xoopsUser->getVar('uid'), true, $mc['quota'] * 1024 * 1024);
$quota = $user->checkQuota();
if ($quota[1]<=0){
	redirect_header('images.php?q=user&amp;id='.$user->getVar('uid'), 1, _RMGS_ERR_QUOTA);
	die();
}


switch($op){
	case 'upload':
		$save_dir = rmgsMakeUserDir($xoopsUser->getVar('uid'));
		foreach ($_POST as $k => $v){
			$$k = $v;
		}
		
		if ($keys==''){ redirect_header('upload.php?op=ret='.$return, 1, _RMGS_ERR_KEYS); die(); }
		if (empty($cat)){ redirect_header('upload.php?op=ret='.$return, 1, _RMGS_ERR_CATS); die(); }
		if (empty($_FILES['img'])){ redirect_header('upload.php?op=ret='.$return, 1, _RMGS_ERR_IMAGES); die(); }
		
		$allowed_categos = $user->getWriteCategos();
		
		/**
		 * Comprobamos que el usuario tenga permiso de
		 * escritura en las categoras seleccionadas
		 */
		foreach ($cat as $k){
			if (!in_array($k,$allowed_categos)){
				redirect_header('upload.php?op=ret='.$return, 1, _RMGS_ERR_ALLOWCATS);
				die();
			}
		}
		/**
		 * Comprobamos que el usuario tenga espacio suficiente
		 * para almacenar las imgenes enviadas
		 */
		$quota_status = $user->checkQuota();
		if ($user->getVar('limit') <= $quota_status[0]){
			redirect_header('upload.php?op=ret='.$ret, 1, _RMGS_ERR_QUOTA);
			die();
		}
		
		/**
		 * Almacenamos las imgenes
		 */
		include_once 'include/images_functions.php';
		foreach ($_FILES['img']['tmp_name'] as $k => $v){	
			if ($v != ''){
	              /**
			       * Creamos un nombre nico
			       */
				$split_name = explode('.',str_replace(" ","",$_FILES['img']['name'][$k]));
			    $ext = strrchr($_FILES['img']['name'][$k], ".");
				$ext = strtolower($ext);
		    	do
			          $newname = rmgsRandomWord(5, $split_name[0].'_') . $ext;
			    while (file_exists($save_dir . '/' . $newname));
			
		    	/**
			     * Almacenamos la imgen
			     */
			    if (move_uploaded_file($v, $save_dir . '/' . $newname)){
		    	      //rmgsMakeFormats($save_dir . '/' , $newname);
                	      rmgsImageResize($save_dir . '/' . $newname,$save_dir . '/' . $newname,$mc['imgwidth'],$mc['imgheight']);
                    	  //rmgsImageResize($save_dir . '/' . $newname,$save_dir . '/ths/' . $newname,$mc['thwidth'], $mc['thheight']);
						  resize_then_crop($save_dir . '/' . $newname,$save_dir . '/ths/' . $newname,$mc['thwidth'],$mc['thheight'],255,255,255);
			    }
			    
				/**
				 * Creamos la nueva imgen
				 */
			    $image = new GSImage();
			    
		    	$image->setVar('title','');
			    $image->setVar('file', $newname);
			    $image->setVar('uid', $xoopsUser->getVar('uid'));
			    $image->setVar('date', time());
				$image->setVar('update', time());
			    $image->setVar('votes',0);
			    $image->setVar('downloads',0);
			    if (isset($_POST['cat'])){
            		$image->setVar('categos', $_POST['cat']);
	            }
    	        $image->setVar('stringkeys', $_POST['keys']);
				$image->setVar('minkey',$mc['minkey']);
				$image->setVar('maxkey',$mc['maxkey']);
				$image->save();
			} 
		}
		
		redirect_header(base64_decode($return), 1, _RMGS_UPLOAD_OK);
		break;
	default:
	
		//$user = new GSUser($xoopsUser->getVar('uid'), true, $mc['quota'] * 1024 * 1024);
	
		$xoopsOption['template_main'] = "rmgs_upload.html";
		
		rmgsMakeNav();
		rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
		
		for ($i=1;$i<=$mc['uploads_cant'];$i++){
			$tpl->append('files', '<input type="file" name="img[]" size="40" />');
		}
		
		foreach ($user->getWriteCategos() as $k){
			$catego = new GSCategory($k);
			$tpl->append('categos', array('id'=>$catego->getVar('id'),'nombre'=>$catego->getVar('nombre')));
		}
		
		$tpl->assign('upload_tip', _RMGS_UPLOADTIP);
		$tpl->assign('lang_keywords', _RMGS_KEYWORDS);
		$tpl->assign('lang_spacekey',_RMGS_KEYSPACE);
		$tpl->assign('lang_upload', _RMGS_UPLOAD_IMAGES);
		$tpl->assign('lang_categos', _RMGS_SELECT_CATEGO);
		$tpl->assign('lang_submit', _SUBMIT);
		$tpl->assign('lang_cancel', _CANCEL);
		break;
}

include 'footer.php';
?>