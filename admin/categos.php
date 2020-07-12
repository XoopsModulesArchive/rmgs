<?php
/*******************************************************************
* $Id: categos.php 2 2006-12-11 20:49:07Z BitC3R0 $          *
* -------------------------------------------------------          *
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
* Default.php: Archivo PHP                                         *
* -------------------------------------------------------          *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: Archivo PHP                                            *
* @version: 0.1.0                                                  *
* @modificado: 16/12/2005 03:39:24 p.m.                            *
*******************************************************************/

define('_RMGS_LOCATION','categorias');
include '../../../include/cp_header.php';

/**
 * Nos aseguramos que exista el lenguage buscaado
 */
if (file_exists(XOOPS_ROOT_PATH . '/modules/rmgs/language/' . $xoopsConfig['language'] . '/admin.php')) {
	include_once XOOPS_ROOT_PATH. '/modules/rmgs/language/' . $xoopsConfig['language'] . '/admin.php';
} else {
	include_once XOOPS_ROOT_PATH . '/modules/rmgs/language/spanish/admin.php';
}

$mc =& $xoopsModuleConfig;
include '../include/rmgs_functions.php';
include XOOPS_ROOT_PATH.'/modules/rmgs/class/catego.class.php';

/**
 * Lista de categorías
 */
function rmgsCategosList(){
	global $xoopsDB, $mc;
	
	include XOOPS_ROOT_PATH.'/modules/rmgs/class/data.class.php';
	
	$dataHand = new GSDataHandler($xoopsDB);
	$categos = $dataHand->getCategos();
	xoops_cp_header();
	echo makeNav();
	$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("rmgs_imgs"));
	list($num) = $xoopsDB->fetchRow($result);
	
	echo "<div align='right'>".sprintf(_AS_RMGS_TOTALIMGS, $num)."</div>";
	echo "<table width='100%' class='outer' cellspacing='1'><tr align='center'>
			<tr><th colspan='5'>"._AS_RMGS_CATEGOSTITLE."</th></tr>
			<tr align='center' class='head'><td>ID</td><td>"._AS_RMGS_NAMEL."</td>
			<td>"._AS_RMGS_IMAGES."</td>
			<td>"._AS_RMGS_DATEL."</td><td>"._AS_RMGS_OPTIONL."</td></tr>";
	foreach ($categos as $key => $v){
		$catH = new GSCategory($v['id_cat']);
		echo "<tr class='even'><td align='right'>".$catH->getVar('id').".</td>
				<td align='left' style='padding-left: ".($v['space'] * 2)."px;'>";
				if ($v['space']>0){
					echo "<img src='../images/root.gif'>";
				} else {
					echo "<img src='../images/plus.gif'>";
				}
		echo "	<a href='images.php?cat=".$catH->getVar('id')."'>".$catH->getVar('nombre')."</a></td>
				<td align='left'>".sprintf(_AS_RMGS_IMGSINCAT, $catH->getImagesNum())."</td>
				<td align='center'>".date($mc['format_date'],$catH->getVar('fecha'))."</td>
				<td align='center'><a href='?op=del&amp;id=".$catH->getVar('id')."'>"._AS_RMGS_DELETE."</a>
				&nbsp;&nbsp;<a href='?op=edit&amp;id=".$catH->getVar('id')."'>"._AS_RMGS_EDIT."</a>&nbsp;
				<a href='images.php?cat=".$catH->getVar('id')."'>"._AS_RMGS_IMAGES."</a></td></tr>";
	}
	echo "</tr></table><br />";
	echo makeFoot();
	xoops_cp_footer();
}

/**
 * Mostramos el formulario para crear una nueva categoría
 */
function rmgsNewCatego(){
	global $xoopsDB;
	
	include XOOPS_ROOT_PATH.'/modules/rmgs/common/form.class.php';
	include XOOPS_ROOT_PATH.'/modules/rmgs/class/data.class.php';
	
	$dHand = new GSDataHandler($xoopsDB);
	xoops_cp_header();
	echo makeNav();
	$form = new RMForm(_AS_RMGS_NEWCATEGO, 'frmNew', 'categos.php?op=save', 'post');
	$form->addElement(new RMText(_AS_RMGS_FNAME, 'nombre', 50, 100));
	$form->addElement(new RMTextArea(_AS_RMGS_FDESC,'desc'));
	$select = "<select name='parent'><option value='0'>"._AS_RMGS_SELECT."</option>";
	$categos = $dHand->getCategos(0,0,true);
	foreach ($categos as $k => $v){
		$select .= "<option value='$v[id_cat]'>".str_repeat("·", $v['space'])."$v[name]</option>";
	}
	$select .= "</select>";
	$form->addElement(new RMLabel(_AS_RMGS_PARENT, $select));
	/**
	 * Cargamos los grupos
	 */
	$select = "<select name='group[]' multiple='multiple' size='5'>
			<option value='0' selected='selected'>"._AS_RMGS_ALL."</option>";
	$result = $xoopsDB->query("SELECT groupid, name FROM ".$xoopsDB->prefix("groups")." ORDER BY name");
	while ($row=$xoopsDB->fetchArray($result)){
		$select .= "<option value='$row[groupid]'>$row[name]</option>";
	}
	$select .= "</select>";
	$fElement = new RMLabel(_AS_RMGS_GROUP, $select);
	$fElement->setDescription(_AS_RMGS_ACCESS_DESC);
	$form->addElement($fElement);
	
	$select = "<select name='write[]' multiple='multiple' size='5'>
			<option value='0' selected='selected'>"._AS_RMGS_ALL."</option>
			<option value='-1'>"._AS_RMGS_NOBODY."</option>";
	$result = $xoopsDB->query("SELECT groupid, name FROM ".$xoopsDB->prefix("groups")." ORDER BY name");
	while ($row=$xoopsDB->fetchArray($result)){
		$select .= "<option value='$row[groupid]'>$row[name]</option>";
	}
	$select .= "</select>";
	$fElement = new RMLabel(_AS_RMGS_WRITE, $select);
	$fElement->setDescription(_AS_RMGS_WRITEDESC);
	$form->addElement($fElement);
	
	$form->addElement(new RMButton('sbt',_AS_RMGS_SEND));
	echo $form->render();
	echo makeFoot();
	xoops_cp_footer();
	
}

/**
 * Guardamos los datos de una categoría
 */
function rmgsSaveCatego(){
	global $xoopsDB;
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	if ($nombre==''){
		redirect_header('categos.php?op=new', 1, _AS_RMGS_ERRNAME);
		die();
	}
	
	$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix("rmgs_categos")." WHERE nombre='$nombre' AND parent='$parent'";
	$result = $xoopsDB->query($sql);
	list($num) = $xoopsDB->fetchRow($result);
	if ($num>0){
		redirect_header('categos.php?op=new', 1, _AS_RMGS_ERREXIST);
		die();
	}
	
	$sql = "INSERT INTO ".$xoopsDB->prefix("rmgs_categos")." (`nombre`,`desc`,`fecha`,`parent`)
			VALUES ('$nombre','$desc','".time()."','$parent');";
	$xoopsDB->query($sql);
	if ($xoopsDB->error()!=''){
		redirect_header('categos.php?op=new', 1, sprintf(_AS_RMGS_ERRDB, $xoopsDB->error()));
		die();
	}
	
	$id = $xoopsDB->getInsertId();
	
	if(is_array($group) && !in_array(0, $group)){
		foreach ($group as $k){
			$sql = "INSERT INTO ".$xoopsDB->prefix("rmgs_groups")." (`id_cat`,`id_grp`)
					VALUES ('$id','$k')";
			$xoopsDB->query($sql);
		}
	}
	
	if(is_array($write) && !in_array(0, $write)){
		if (in_array(-1, $write)){
			$sql = "INSERT INTO ".$xoopsDB->prefix("rmgs_writes")." (`id_cat`,`id_grp`)
						VALUES ('$id','-1')";
			$xoopsDB->query($sql);
		} else {
			foreach ($write as $k){
				$sql = "INSERT INTO ".$xoopsDB->prefix("rmgs_writes")." (`id_cat`,`id_grp`)
						VALUES ('$id','$k')";
				$xoopsDB->query($sql);
			}
		}
	}
	
	redirect_header('categos.php', 1, _AS_RMGS_NEWOK);
		
}

/**
 * Funcion para editar una categoría
 */
function rmgsEdit(){
	global $xoopsDB;
	
	include XOOPS_ROOT_PATH.'/modules/rmgs/common/form.class.php';
	include XOOPS_ROOT_PATH.'/modules/rmgs/class/data.class.php';
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	
	if ($id <= 0){
		redirect_header('categos.php', 2, _AS_RMGS_NOTFOUND);
		die();
	}
	
	$catego = new GSCategory($id);
	if (!$catego){
		redirect_header('categos.php', 2, _AS_RMGS_NOTFOUND);
		die();
	}
	
	xoops_cp_header();
	echo makeNav();
	
	$dHand = new GSDataHandler($xoopsDB);
	$form = new RMForm(_AS_RMGS_EDITCATEGO, 'frmEdit', 'categos.php?op=saveedit');
	$form->addElement(new RMText(_AS_RMGS_FNAME, 'nombre', 50, 100, $catego->getVar('nombre')));
	$form->addElement(new RMTextArea(_AS_RMGS_FDESC, 'desc', 4, 45, $catego->getVar('desc')));
	$select = "<select name='parent'><option value='0'>"._AS_RMGS_SELECT."</option>";
	$categos = $dHand->getCategos(0,0,true);
	foreach ($categos as $k => $v){
		$select .= "<option value='$v[id_cat]' ";
		if ($v['id_cat']==$catego->getVar('parent')){
			$select .= " selected='selected' ";
		}
		$select .= ">".str_repeat("·", $v['space'])."$v[name]</option>";
	}
	$select .= "</select>";
	$form->addElement(new RMLabel(_AS_RMGS_PARENT, $select));
	$groups = $catego->getGroups();
	$select = "<select name='group[]' size='5' multiple='multiple'>
				<option value='0'";
			if (count($groups)<=0){ $select .= " selected='selected'"; }
	$select .= ">"._AS_RMGS_ALL."</option>";
	
	$result = $xoopsDB->query("SELECT groupid, name FROM ".$xoopsDB->prefix("groups")." ORDER BY name");
	while ($row=$xoopsDB->fetchArray($result)){
		if (in_array($row['groupid'], $groups)){
			$select .= "<option value='$row[groupid]' selected='selected'>$row[name]</option>";
		} else {
			$select .= "<option value='$row[groupid]'>$row[name]</option>";
		}
	}
	$select .= "</select>";
	$fElement = new RMLabel(_AS_RMGS_GROUP, $select);
	$fElement->setDescription(_AS_RMGS_ACCESS_DESC);
	$form->addElement($fElement);
	
	$writes = $catego->getWrites();
	$select = "<select name='write[]' size='5' multiple='multiple'>
				<option value='0'";
			if (count($writes)<=0){ $select .= " selected='selected'"; }
	$select .= ">"._AS_RMGS_ALL."</option>
			<option value='-1'";
			if (in_array(-1, $writes)){ $select .= " selected='selected'"; }
	$select .= ">"._AS_RMGS_NOBODY."</option>";
	
	$result = $xoopsDB->query("SELECT groupid, name FROM ".$xoopsDB->prefix("groups")." ORDER BY name");
	while ($row=$xoopsDB->fetchArray($result)){
		if (in_array($row['groupid'], $writes)){
			$select .= "<option value='$row[groupid]' selected='selected'>$row[name]</option>";
		} else {
			$select .= "<option value='$row[groupid]'>$row[name]</option>";
		}
	}
	$select .= "</select>";
	$fElement = new RMLabel(_AS_RMGS_WRITE, $select);
	$fElement->setDescription(_AS_RMGS_WRITEDESC);
	$form->addElement($fElement);
	
	$form->addElement(new RMHidden('id_cat',$id));
	$form->addElement(new RMLabel('','<input type="submit" name="sbt" value="'._AS_RMGS_SEND.'" /> <input type="button" name="cancel" value="'._AS_RMGS_CANCEL.'" onclick="javascript: history.go(-1);" />'));
	$form->display();
	
	echo makeFoot();
	xoops_cp_footer();
	
	
}
/**
 * Guardamos los cambios realizados en una categoría
 */
function rmgsSaveEdited(){
	global $xoopsDB;
	
	foreach ($_POST as $k => $v){
		$$k = $v;
	}
	
	if ($nombre==''){
		redirect_header('categos.php?op=edit&amp;id='.$id_cat, 1, _AS_RMGS_ERRNAME);
		die();
	}
	
	$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix("rmgs_categos")." WHERE nombre='$nombre' AND parent='$parent' AND id_cat<>'$id_cat'";
	$result = $xoopsDB->query($sql);
	list($num) = $xoopsDB->fetchRow($result);
	if ($num>0){
		redirect_header('categos.php?op=edit&amp;id='.$id_cat, 1, _AS_RMGS_ERREXIST);
		die();
	}
	
	$sql = "UPDATE ".$xoopsDB->prefix("rmgs_categos")." SET `nombre`='$nombre',`desc`='$desc',
			`parent`='$parent' WHERE id_cat='$id_cat'";
	$xoopsDB->query($sql);
	if ($xoopsDB->error()!=''){
		redirect_header('categos.php?op=edit&amp;id='.$id_cat, 1, sprintf(_AS_RMGS_ERRDB, $xoopsDB->error()));
		die();
	}

	$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgs_groups")." WHERE id_cat='$id_cat'");	
	if(is_array($group) && !in_array(0, $group)){
		foreach ($group as $k){
			$sql = "INSERT INTO ".$xoopsDB->prefix("rmgs_groups")." (`id_cat`,`id_grp`)
					VALUES ('$id_cat','$k')";
			$xoopsDB->query($sql);
		}
	}
	
	$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgs_writes")." WHERE id_cat='$id_cat'");	
	if(is_array($write) && !in_array(0, $write)){
		if (in_array(-1, $write)){
			$sql = "INSERT INTO ".$xoopsDB->prefix("rmgs_writes")." (`id_cat`,`id_grp`)
						VALUES ('$id_cat','-1')";
			$xoopsDB->query($sql);
		} else {
			foreach ($write as $k){
				$sql = "INSERT INTO ".$xoopsDB->prefix("rmgs_writes")." (`id_cat`,`id_grp`)
						VALUES ('$id_cat','$k')";
				$xoopsDB->query($sql);
			}
		}
	}
	
	redirect_header('categos.php', 1, _AS_RMGS_MODOK);
	
}
/**
 * Eliminamos una categoría
 */
function rmgsDelete(){
	global $xoopsDB;
	
	include_once XOOPS_ROOT_PATH . '/modules/rmgs/class/image.class.php';
	
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
	if ($ok){
		$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgs_categos")." WHERE id_cat='$id'");
		$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgs_groups")." WHERE id_cat='$id'");
		$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgs_writes")." WHERE id_cat='$id'");
		
		/**
		 * Eliminamos las fotografías
		 */
		$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgs_imglink")." WHERE id_cat='$id'");
		while ($row = $xoopsDB->fetchArray($result)){
			$image = new GSImage($row['id_img']);
			$image->delete();			
		}
		redirect_header('categos.php', 2, _AS_RMGS_DELOK);
	} else {
		xoops_cp_header();
		echo "<table width='60%' align='center' class='outer' cellspacing='1'>
				<tr class='even'><td align='center'>
				<form name='frmDel' action='categos.php' method='post'>
				<br />"._AS_RMGS_CONFIRMDEL."<br /><br />
				<input type='submit' name='sbt' value='"._AS_RMGS_DELETE."' />
				<input type='submit' name='sbt' value='"._AS_RMGS_CANCEL."' onclick='javascript: history.go(-1);' />
				<input type='hidden' name='ok' value='1' />
				<input type='hidden' name='op' value='del' />
				<input type='hidden' name='id' value='$id' />
				<br /></form></td></tr></table>";
		xoops_cp_footer();
	}
}

$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');

switch ($op){
	case 'new':
		rmgsNewCatego();
		break;
	case 'save':
		rmgsSaveCatego();
		break;
	case 'edit':
		rmgsEdit();
		break;
	case 'saveedit':
		rmgsSaveEdited();
		break;
	case 'del':
		rmgsDelete();
		break;
	default:
		rmgsCategosList();
		break;
}
?>
