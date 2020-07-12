<?php
/*******************************************************************
* $Id: mypics.php 2 2006-12-11 20:49:07Z BitC3R0 $           *
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
* mypics.php:                                                      *
* Archivo para administrar las imgenes de un usuario              *
* ------------------------------------------------------           *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.2                                                  *
* @modificado: 26/02/2006 10:46:40 p.m.                            *
*******************************************************************/

$rmgs_location = 'misimagenes';
include 'header.php';

if (!is_object($xoopsUser)){ 
	redirect_header(XOOPS_URL.'/user.php', 1, _RMGS_NOALLOWED);
	die();
}

$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');
$user = new GSUser($xoopsUser->getVar('uid'));
$tpl->assign('return', base64_encode($_SERVER['REQUEST_URI']));
$tpl->assign('other_sizes', $mc['othersizes']);

switch ($op){
	case 'del':
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if ($id<=0){ header('location: mypics.php'); }
		
		$image = new GSImage($id);
		$image->delete();
		/**
		 * Comprobamos que la imgen pertenezca al usuario actual
		 * de lo contrario no podr editarla
		 */
		if ($image->getVar('uid')!=$user->getVar('id')){
			redirect_header('mypics.php', 2, _RMGS_NOUSER);
			die();
		}
		
		redirect_header('mypics.php', 1, _RMGS_OKDELETE);
		die();
		break;
	case 'edit':
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$return = isset($_GET['ret']) ? $_GET['ret'] : 0;
		if ($id<=0){
			redirect_header(base64_decode($return), 1, _RMGS_ERRID);
			die();
		}
		
		if ($xoopsUser->isAdmin()){
			header('location: admin/images.php?op=edit&id='.$id); die();
		}
		
		$image = new GSImage($id);
		if (!$image){
			redirect_header(base64_decode($return), 1, _RMGS_ERRIMAGE);
			die();
		}
		/**
		 * Comprobamos que la imgen pertenezca
		 * al usuario actual
		 */
		if ($image->getVar('uid')!=$user->getVar('id')){
			redirect_header('mypics.php', 2, _RMGS_NOUSER);
			die();
		}
		
		$xoopsOption['template_main'] = 'rmgs_edit.html';
		
		rmgsMakeNav();
		rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
		
		include_once XOOPS_ROOT_PATH.'/modules/rmgs/common/form.class.php';
	
		$form = new RMForm(sprintf(_RMGS_EDIT_TITLE, $image->getVar('title')), 'frmEdit', 'mypics.php');
		$form->setExtra('enctype="multipart/form-data"');
		$form->addElement(new RMText(_RMGS_IMGTITLE, 'titulo', 50, 150, $image->getVar('title')));
		
		$fElement = new RMFile(_RMGS_IMGFILE, 'file', 45);
		$fElement->setDescription(_RMGS_IMGFILE_DESC);
		$form->addElement($fElement);
		$form->addElement(new RMLabel(_RMGS_IMGCYR_FILE, "<a href='".$user->getVar('webdir')."/".$image->getVar('file')."' target='_blank'><img src='".$user->getVar('webdir')."/ths/".$image->getVar('file')."' border='0' /></a>"));
		$form->addElement(new RMText(_RMGS_KEYWORDS, 'keys', 50, '', $image->getVar('stringkeys')));
		// Cargamos las categoras a las que pertence
		$select = "<select name='cats[]' size='8' multiple='multiple'>";
		
		include_once 'include/categos.func.php';
		$imgCat = $image->getCategosId();
		$userCats = $user->getWriteCategos();
		$cats = array();
		getCategosTree($cats,0,0,true);

		foreach ($cats as $k => $v){
			if (!in_array($v['id_cat'], $userCats)){ continue; }
			if (in_array($v['id_cat'], $imgCat)){
				$select .= "<option value='$v[id_cat]' selected='selected'>".str_repeat('-',$v['space'])." $v[name]</option>";
			} else {
				$select .= "<option value='$v[id_cat]'>".str_repeat('-',$v['space'])." $v[name]</option>";
			}
		}
		$select .= "</select>";
		$form->addElement(new RMLabel(_RMGS_SELECT_CATEGO, $select));
	
		$form->addElement(new RMLabel('',"<input type='submit' name='sbt' value='"._SUBMIT."' class='formButton' /> &nbsp;<input type='button' name='cancel' value='"._CANCEL."' onclick='javascript: history.go(-1);' />"));
		$form->addElement(new RMHidden('op','saveedit'));
		$form->addElement(new RMHidden('id',$image->getVar('id')));
		$form->addElement(new RMHidden('ret',$return));
		$xoopsTpl->assign('edit_form', $form->render());

		break;
	
	case 'saveedit':
		foreach ($_POST  as $k => $v){ $$k = $v; }
		
		if ($id<=0){
			redirect_header(base64_decode($return), 1, _RMGS_ERRID);
			die();
		}
		
		$image = new GSImage($id);
		if (!$image){
			redirect_header(base64_decode($return), 1, _RMGS_ERRIMAGE);
			die();
		}
		
		$newname = $image->getVar('file');
	
		if (is_uploaded_file($_FILES['file']['tmp_name'])){
			// Guardamos el archivo
			$split_name = explode('.',str_replace(" ","",$_FILES['file']['name']));
			$ext = strrchr($_FILES['file']['name'], ".");
			do
				$newname = rmgsRandomWord(5, $split_name[0].'_') . $ext;
			while (file_exists($user->getVar('storedir')  . $newname));
		
			/**
			 * Almacenamos la imgen
			 */
			if (move_uploaded_file($_FILES['file']['tmp_name'], $user->getVar('storedir') . $newname)){
				//rmgsMakeFormats($save_dir . '/' , $newname);
            	rmgsImageResize($user->getVar('storedir') . $newname, $user->getVar('storedir') . $newname,$mc['imgwidth'],$mc['imgheight']);
	            //rmgsImageResize($user->getVar('storedir') . $newname, $user->getVar('storedir') . 'ths/' . $newname,$mc['thwidth'], $mc['thheight']);
				resize_then_crop($user->getVar('storedir') . $newname,$user->getVar('storedir') . 'ths/' . $newname,$mc['thwidth'],$mc['thheight'],255,255,255);
			} else {
				redirect_header('mypics.php?op=edit&amp;id='.$id.'&amp;ret='.$ret, 1, _RMGS_ERRUPLOAD);
				die();
			}
		
			// Eliminamos el archivo anterior
			unlink($user->getVar('storedir') . $image->getVar('file'));
			unlink($user->getVar('storedir') . 'ths/' . $image->getVar('file'));
		}
	
		$image->setVar('title', $titulo);
		$image->setVar('file', $newname);
		$image->setVar('categos', $cats);
		$image->setVar('stringkeys', $keys);
		$image->setVar('maxkey',$mc['maxkey']);
		$image->setVar('minkey',$mc['minkey']);
		if ($image->savechanges()){
			redirect_header(base64_decode($ret), 1, _RMGS_EDITOK);
			die();	
		} else {
			redirect_header('mypics.php?op=edit&amp;id='.$id.'&amp;ret='.$ret, 2, _RMGS_ERRONDB);
			die();
		}
		
		break;
	case 'sizes':
		$return = isset($_GET['ret']) ? $_GET['ret'] : 0;
		if (!$mc['othersizes']){
			redirect_header(base64_decode($return), 1, _RMGS_ERRID);
			die();
		}
		
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if ($id<=0){
			redirect_header(base64_decode($return), 1, _RMGS_ERRID);
			die();
		}
		
		$image = new GSImage($id);
		rmgsMakeNav();
		rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
		
		$dir = rmgsWebDir($image->getVar('uid'));
		$dir = rmgsAddSlash($dir) . 'sizes/';
		
		$xoopsOption['template_main'] = 'rmgs_sizes.html';
		$tpl->assign('lang_sizes', $image->getVar('title') . ' - ' . _RMGS_SIZES_TITLE);
		$tpl->assign('image', array('id'=>$image->getVar('id')));
		$tpl->assign('lang_local', _RMGS_LOCAL);
		$tpl->assign('lang_remote', _RMGS_REMOTE);
		$tpl->assign('sizes', $image->getSizes());
		$tpl->assign('images_dir', $dir);
		$tpl->assign('lang_return', _RMGS_RETURN);
		$tpl->assign('return', base64_decode($return));
		$tpl->assign('return_encode', $return);
		$tpl->assign('lang_delete', _RMGS_DELETE);
		
		include_once XOOPS_ROOT_PATH.'/modules/rmgs/common/form.class.php';
		$form = new RMForm(_RMGS_FORM_TITLE, 'frmEdit', 'mypics.php');
		$form->setExtra('enctype="multipart/form-data"');
		$form->addElement(new RMText(_RMGS_IMGTITLE, 'titulo', 50, 50));
		if ($mc['sizes_local']){
			$form->addElement(new RMFile(_RMGS_FFILE, 'file', 45));
		}
		$form->addElement(new RMText(_RMGS_FFILE_URL, 'file_url', 50, 255));
		$form->addElement(new RMHidden('id', $id));
		$form->addElement(new RMHidden('ret', $return));
		$form->addElement(new RMHidden('op', 'savesize'));
		$form->addElement(new RMButton('sbt', _SUBMIT));
		$tpl->assign('form_sizes', $form->render());
		break;
	case 'savesize':
		foreach ($_POST as $k => $v){
			$$k = $v;
		}
		if (!$mc['othersizes']){
			redirect_header(base64_decode($ret), 1, _RMGS_ERRID);
			die();
		}
		
		if ($id<=0){
			redirect_header(base64_decode($return), 1, _RMGS_ERRID);
			die();
		}
		
		$image = new GSImage($id);
		if (!$image){
			redirect_header(base64_decode($return), 1, _RMGS_ERRID);
			die();
		}
		
		if ($image->getVar('uid')!=$xoopsUser->getVar('uid')){
			redirect_header(base64_decode($return), 1, _RMGS_NOUSER);
			die();
		}
		
		/**
	 	 * Comprobamos que se haya proporcionado un archivo
	 	 */
		if ($mc['sizes_local'] && $file_url==''){
			$dir = rmgsMakeUserDir($image->getVar('uid'));
			$dir = rmgsAddSlash($dir) . 'sizes/';
	
			if (is_uploaded_file($_FILES['file']['tmp_name'])){
				$split_name = explode(".",$_FILES['file']['name']);
				$ext = $split_name[1];
				do
					$newname = rmgsRandomWord(5, $split_name[0].'_') . "." . $ext;
				while (file_exists($dir  . $newname));
				if (!move_uploaded_file($_FILES['file']['tmp_name'], $dir . $newname)){
					redirect_header(base64_decode($return), 1, _RMGS_ERRONDB);
					die();
				}
			} else {
				redirect_header(base64_decode($return), 1, _RMGS_ERRUPLOAD);
				die();
			}
			$type = 0;
		} elseif ($file_url!=''){
			$newname = $file_url;
			$type = 1;
		} else {
			redirect_header(base64_decode($return), 1, _RMGS_ERRFILE);
			die();
		}
	
		if ($image->addSize($titulo, $newname, $type)){
			redirect_header(base64_decode($return), 1, '');
			die();
		} else {
			redirect_header(base64_decode($return), 1, _RMGS_ERRONDB);
			die();
		}
		
		break;
	case 'delsize':
		$return = isset($_GET['ret']) ? $_GET['ret'] : 0;
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$size = isset($_GET['size']) ? $_GET['size'] : 0;
		if ($id<=0){
			redirect_header(base64_decode($return), 1, _RMGS_ERRID);
			die();
		}
		
		$result = $db->query("SELECT * FROM ".$db->prefix("rmgs_sizes")." WHERE id_size='$size'");
		if ($db->getRowsNum($result)<=0){
			redirect_header('mypics.php?op=sizes&amp;id='.$id.'&amp;ret='.$return, 1, _RMGS_ERRSIZE);
			die();
		}
		$row = $db->fetchArray($result);
		
		$image = new GSImage($id);
		
		if ($image->getVar('uid')!=$xoopsUser->getVar('uid')){
			redirect_header('mypics.php?op=sizes&amp;id='.$id.'&amp;ret='.$return, 1, _RMGS_NOUSER);
			die();
		}
		
		if ($row['type']==0){
			// Eliminamos el archivo
			$dir = rmgsMakeUserDir($image->getVar('uid'));
			$dir = rmgsAddSlash($dir) . 'sizes/';
			unlink($dir . $row['file']);
		}
		$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("rmgs_sizes")." WHERE id_size='$size'");
		redirect_header('mypics.php?op=sizes&amp;id='.$id.'&amp;ret='.$return, 1, '');
		die();
		break;
	default:
	
		$xoops_module_header .= '<script type="text/javascript" src="'.XOOPS_URL.'/modules/rmgs/include/rmgs.js"></script>';
	
		$xoopsOption['template_main'] = 'rmgs_mypics.html';
		rmgsMakeNav();
		rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
		
		/**
		 * Establecemos los resultados por pagina
		 */
		rmgsSetResults($user);
		
		/** 
		 * Obtenemos las imgenes
		 */
		include_once 'include/search.func.php';
		rmgsSearchUserPics($user->getVar('id'), $_SESSION['rmgs_results']);
		
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
		
		$tpl->assign('columns', $mc['columns']);
		$tpl->assign('colw', (int)(100 / $mc['columns']));
		$xoopsTpl->assign('lang_by', _RMGS_BY);
		$xoopsTpl->assign('lang_since', _RMGS_SINCE);
		$tpl->assign('lang_resxpag',_RMGS_RESULTS);
		$xoopsTpl->assign('mypics_results', sprintf(_RMGS_MYPICS_TOTAL, $user->getVar('imgcount')));
		$tpl->assign('lang_delete', _RMGS_DELETE);
		$tpl->assign('lang_edit', _RMGS_EDIT);
		$tpl->assign('lang_confirmdel', _RMGS_CONFIRMDEL);
		$tpl->assign('lang_access',_RMGS_DDOWNS);
		$tpl->assign('lang_sizes',_RMGS_SIZES);
		
		break;
}

include 'footer.php';

?>