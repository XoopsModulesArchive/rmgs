<?php
/*******************************************************************
* $Id: users.php 2 2006-12-11 20:49:07Z BitC3R0 $            *
* -----------------------------------------------------            *
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
* -----------------------------------------------------            *
* users.php:                                                       *
* Este archivo controla las opciones independientes de cada        *
* uno de los usuarios, tales como capacidad de almacenamiento,     *
* álbumes, fotografías, etc.                                       *
* -----------------------------------------------------            *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.2                                                  *
* @modificado: 24/12/2005 02:48:59 p.m.                            *
*******************************************************************/
define('_RMGS_LOCATION','usuarios');
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

include XOOPS_ROOT_PATH.'/modules/rmgs/class/user.class.php';


function rmgsUsersList(){
	global $xoopsDB, $mc;
	
	$limit = 12;
	
	$pag = isset($_GET['pag']) ? $_GET['pag'] : 0;
	if ($pag > 0){ $pag -= 1; }
	$start = $pag * $limit;
	
	list($num) = $xoopsDB->fetchRow($xoopsDB->query("SELECT DISTINCT idu FROM ".$xoopsDB->prefix("rmgs_imgs")." GROUP BY idu"));
	$result = $xoopsDB->query("SELECT DISTINCT idu FROM ".$xoopsDB->prefix("rmgs_imgs")." GROUP BY idu ORDER BY fecha LIMIT $start, $limit");
	
	$rtotal = $num; // Numero total de resultados
	$tpages = (int)($num / $limit);
	if (($num % $limit) > 0){ $tpages++; }
	
	$pactual = $pag + 1;
	
	if ($pactual>$tpages){
		$rest = $pactual - $tpages;
		$pactual = $pactual - $rest + 1;
		$start = ($pactual - 1) * $limit;
	}
	
	$limit_all = $mc['quota'] * 1024 * 1024;
	
	xoops_cp_header();
	echo makeNav();
	echo "<table width='100%' class='outer' cellspacing='1'>
			<tr class='odd'><td align='left'>".sprintf(_AM_RMDP_PAGELOC, $pactual, $tpages)."</td>
			<td align='right'>"._AM_RMDP_GOPAGE;
		  for ($i=1;$i<=$tpages;$i++){
				echo "<a href='?pag=$i'>$i</a>&nbsp;";
		  }
	echo "</td></tr></table>";
	echo "<table width='100%' class='outer' cellspacing='1'>
			<tr><th colspan='5'>"._AS_RMGS_LISTTITLE."</th></tr>
			<tr class='head' align='center'><td>"._AS_RMGS_USER."</td>
			<td>"._AS_RMGS_USED."</td><td>"._AS_RMGS_IMAGES."</td>
			<td>"._AS_RMGS_ALBUM."</td>
			<td>"._AS_RMGS_OPTIONL."</tr>";			
	
	while ($row = $xoopsDB->fetchArray($result)){
		$user = new GSUser($row['idu'], true, $limit_all);
		echo "<tr class='even'><td align='left'><strong>".$user->getVar('uname')."</strong></td>
			<td align='center' nowrap='nowrap'>";
		$used = $user->getUsed();
		$percent = 150 / $user->getVar('limit');
		$percent = (int)($percent * $used);
		echo "<table style='width: 150px; font-size: 9px; color: #000000; padding: 0px;'>
				<tr><td style='padding: 2px; text-align: left; font-size: 9px;'>0 MB</td>
				<td style='padding: 2px; text-align: right; font-size: 9px;'>".rmgsConvertSize($user->getVar('limit'))."</td></tr>
				<tr><td colspan='2' style='padding: 0px; border: 1px solid #CCCCCC; font-size: 2px; height: 8px;'>
				<img src='../images/admin/quota.png' style='height: 8px; width: ".$percent."px;' />
				</td></tr>
				<tr><td colspan='2' style='padding: 2px; text-align: center; font-size: 9px; color: #0066FF;'>
				".sprintf(_AS_RMGS_LUSED, rmgsConvertSize($used))."
				</td></tr>
				</table>";
		echo "</td><td align='center'><strong>".$user->getVar('imgcount')."</strong></td>
			<td align='center'><strong>".$user->getVar('setscount')."</strong></td>
			<td align='center'><a href='?op=del&amp;id=$row[idu]&amp;pag=$pactual'>"._AS_RMGS_DELETE."</a>&nbsp;|
			<a href='?op=quota&amp;id=$row[idu]&amp;pag=$pactual'>"._AS_RMGS_SETQUOTA."</a></td></tr>";
	}	
	
	echo "</table>";
	echo makeFoot();
	xoops_cp_footer();
	
	
}

/**
 * Modificamos la cuota de almacenamiento para un usuario especifico
 */
function rmgsQuota(){
	global $xoopsDB;
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$pag = isset($_GET['pag']) ? $_GET['pag'] : 0;
	
	if ($id<=0){
		header('location: users.php');
		die();
	}
	
	$user = new GSUser($id);
	
	xoops_cp_header();
	echo makeNav();
	
	include_once XOOPS_ROOT_PATH.'/modules/rmgs/common/form.class.php';
	$form = new RMForm(_AS_RMGS_SETQUOTA, 'frmQuota', 'users.php');
	$form->addElement(new RMLabel(_AS_RMGS_ACTUALQ, "<strong>".rmgsConvertSize($user->getVar('limit'))."</strong>"));
	$fElement = new RMText(_AS_RMGS_NEWQ, 'quota', 50, 30, ($user->getVar('limit') / 1024 / 1024));
	$fElement->setDescription(_AS_RMGS_NEWQDESC);
	$form->addElement($fElement);
	$form->addElement(new RMHidden('op', 'setquota'));
	$form->addElement(new RMHidden('id', $id));
	$form->addElement(new RMHidden('pag', $pag));
	$form->addElement(new RMLabel('', "<input type='submit' name='sbt' value='"._AS_RMGS_SEND."' class='formButton' /> &nbsp;
					<input type='button' name='cancel' value='"._AS_RMGS_CANCEL."' onclick='javascript: history.go(-1);' class='formButton' />"));
	$form->display();
	echo makeFoot();	
	xoops_cp_footer();
}

/**
 * Establecemos la nueva quota del usuario
 */
function rmgsSetQuota(){
	global $xoopsDB;
	
	foreach ($_POST as $k => $v){ $$k = $v; }
	
	if ($id<=0){ header('location: users.php'); die(); }
	if ($quota<=0){
		redirect_header('users.php?op=quota&amp;id='.$id.'&amp;pag='.$pag, 1, _AS_RMGS_ERRQUOTA);
		die();
	}
	
	$user = new GSUser($id);
	$user->setQuota($quota);
	if ($user->errors()!=''){
		redirect_header('users.php?op=quota&amp;id='.$id.'&amp;pag='.$pag, 2, sprintf(_AS_RMGS_ERRDB, $user->errors()));
		die();
	} else {
		redirect_header('users.php?pag='.$pag, 2, _AS_RMGS_QUOTAOK);
	}
	
}

/**
 * Eliminamos toda la información del usuarioç
 */
function rmgsDelete(){
	global $xoopsDB;
	
	$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
	$pag = isset($_GET['pag']) ? $_GET['pag'] : (isset($_POST['pag']) ? $_POST['pag'] : 0);
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	
	if ($ok){
		$user = new GSUser($id, false);
		$dir = rmgsMakeUserDir($id);
		deletedir($dir); // Eliminamos el directorio y los archivos
		$result = $xoopsDB->query("SELECT id_img FROM ".$xoopsDB->prefix("rmgs_imgs")." WHERE idu='$id'");
		while ($row = $xoopsDB->fetchArray($result)){
			$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("rmgs_imglink")." WHERE id_img='$row[id_img]'");
			$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("rmgs_keylink")." WHERE img='$row[id_img]'");
			$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("rmgs_setlink")." WHERE id_img='$row[id_img]'");
			$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("rmgs_sizes")." WHERE id_img='$row[id_img]'");
		}
		$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("rmgs_imgs")." WHERE idu='$id'");
		$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("rmgs_users")." WHERE uid='$id'");
		
		redirect_header('users.php', 1, _AS_RMGS_DELOK); die();

	} else {
		xoops_cp_header();
		echo makeNav();
		echo "<div class='confirmMsg' align='center'>
				<form name='frmDel' method='post' action='users.php'><br />
				"._AS_RMGS_CONFIRMDEL."<br /><br />
				<input type='submit' name='sbt' value='"._AS_RMGS_SEND."' class='formButton' />
				<input type='button' class='formButton' name='cancel' value='"._AS_RMGS_CANCEL."' onclick='javascript: history.go(-1);' />
				<input type='hidden' name='op' value='del' />
				<input type='hidden' name='id' value='$id' />
				<input type='hidden' name='pag' value='$pag' />
				<input type='hidden' name='ok' value='1' />
				</form><br />
				</div>";
		echo makeFoot();
		xoops_cp_footer();
	}
	
}

$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');

switch($op){
	case 'quota':
		rmgsQuota();
		break;
	case 'setquota':
		rmgsSetQuota();
		break;
	case 'del':
		rmgsDelete();
		break;
	default:
		rmgsUsersList();
		break;
}
?>



