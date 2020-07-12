<?php
/*******************************************************************
* $Id: postals.php 2 2006-12-11 20:49:07Z BitC3R0 $          *
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
* postals.php:                                                     *
* Administración de Postales creadas. Este archivo tambien         *
* permite crear nuevas plantillas para postales.                   *
* -------------------------------------------------------          *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.9                                                  *
* @modificado: 24/02/2006 04:09:10 p.m.                            *
*******************************************************************/

define('_RMGS_LOCATION','postales');
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
$db =& Database::getInstance();
$myts = MyTextSanitizer::getInstance();
include '../include/rmgs_functions.php';
include_once '../class/table.class.php';
include_once '../class/postal.class.php';

/**
 * Eliminamos las postales que tengan mas de x días
 * en la base de datos
 */
$limite = time() - ($mc['postaldays'] * 86400);
$db->queryF("DELETE FROM ".$db->prefix("rmgs_postales")." WHERE fecha<$limite");

function rmgsPostalsList(){
	global $db, $myts, $mc;
	
	$limit = 20;
	$pag = isset($_GET['pag']) ? $_GET['pag'] : (isset($_POST['psg']) ? $_POST['pag'] : 0);
	if ($pag > 0){ $pag -= 1; }
	$start = $pag * $limit;
	
	$tbl = $db->prefix("rmgs_postales");
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $tbl"));
	$result = $db->query("SELECT * FROM $tbl ORDER BY fecha DESC LIMIT $start, $limit");
	$rtotal = $num; // Numero total de resultados
	$tpages = (int)($num / $limit);
	if (($num % $limit) > 0){ $tpages++; }
	
	$pactual = $pag + 1;
	
	if ($pactual>$tpages){
		$rest = $pactual - $tpages;
		$pactual = $pactual - $rest + 1;
		$start = ($pactual - 1) * $limit;
	}
	
	xoops_cp_header();
	echo makeNav();
	
	$table = new GSTable(true);
	$table->setTableClass('');
	$table->openTbl('100%','',1);
	$table->setRowClass('',false);
	$table->openRow('');
	$table->setCellStyle('padding: 4px; font-size: 11px;');
	$table->addCell("<a href='postals.php'>"._AS_RMGS_POSTALS."</a> &bull;
			<a href='?op=tpls'>"._AS_RMGS_TPLS."</a>",0,'','left');
	
	$pages = _AM_RMDP_GOPAGE;
	for($i=1;$i<=$tpages;$i++){
		if ($i==$pactual){
			$pages .= "<span style='font-size: 12px; color: #FF0000;'>::$i::</a> ";
		} else {
			$pages .= "<a href='?pag=$i'>$i</a> ";
		}
	}
	
	$table->addCell($pages,0,'','right');
	$table->closeTbl();
	
	$table->setTableClass('outer');
	$table->setCellStyle("border-bottom: 1px solid #0066CC; border-right: 1px solid #0066CC; background: url(../images/bgth.jpg) repeat-x; height: 20px; color: #FFFFFF;");
	$table->openTbl('100%','',1);
	$table->openRow('left');
	$table->addCell(_AS_RMGS_POSTALTITLE, 1,5);
	$table->closeRow();
	$table->setRowClass('head');
	$table->setCellStyle("border-bottom: 1px solid #DBE691; border-right: 1px solid #DBE691; background: url(../images/bghead.jpg) repeat-x; height: 20px; color: #000000;");
	$table->openRow('center');
	$table->addCell(_AS_RMGS_TITLE, 0, '','center');
	$table->addCell(_AS_RMGS_FECHA, 0, '','center');
	$table->addCell(_AS_RMGS_TEMPLATE,0,'','center');
	$table->addCell(_AS_RMGS_USER,0,'','center');
	$table->addCell(_AS_RMGS_OPTIONS,0,'','center');
	$table->closeRow();
	
	$table->setRowClass('odd,even', true);
	$table->setCellStyle('');
	while ($row=$db->fetchArray($result)){
		$table->openRow();
		$table->addCell($myts->addSlashes($row['titulo']),0,'','left');
		$table->addCell(date($mc['format_date'], $row['fecha']),0,'','center');
		$table->addCell($row['plantilla'],0,'','center');
		
		if ($row['idu'] > 0){
			$user = new XoopsUser($row['idu']);
		}
		
		$table->addCell($row['idu'] > 0 ? $user->getVar('uname') : _AS_RMGS_ANONYM,0,'','center');
		$options = "<a href='../postal.php?op=view&amp;postal=$row[codigo]' target='_blank'><img src='../images/view.png' border='0' /></a>";
		$table->addCell($options,0,'','center');
		$table->closeRow();
	}
	
	$table->closeTbl();
	echo makeFoot();
	xoops_cp_footer();
}

function rmgsShowTemplates($edit=false){
	global $mc;
	
	xoops_cp_header();
	echo makeNav();
	
	$table = new GSTable(true);
	$table->setTableClass('');
	$table->openTbl('100%','',1);
	$table->setRowClass('',false);
	$table->openRow('');
	$table->setCellStyle('padding: 4px; font-size: 11px;');
	$table->addCell("<a href='postals.php'>"._AS_RMGS_POSTALS."</a> &bull;
			<a href='?op=tpls'>"._AS_RMGS_TPLS."</a>",0,'','left');
	$table->closeTbl();
	
	$table->openTbl('100%','',1);
	$table->setRowClass('head');

	$table->setRowClass('odd,even', true);
	$table->setCellStyle('');
	
	/**
	 * Leemos el directorio de plantillas
	 */
	$dir = XOOPS_ROOT_PATH.'/modules/rmgs/tpls/';
	
	$escribir = is_writable($dir);
	
	if (!$escribir){
		$table->openRow('left');
		$table->addCell('_AS_RMGS_NOWRITE', 0, 2,'left');
		$table->closeRow();
	}
	
	echo "<tr><td>";
	
	$table->setTableClass('outer');
	$table->setCellStyle("border-bottom: 1px solid #0066CC; border-right: 1px solid #0066CC; background: url(../images/bgth.jpg) repeat-x; height: 20px; color: #FFFFFF;");
	$table->openTbl();
	$table->openRow('left');
	$table->addCell(_AS_RMGS_TPLSLIST, 1,2);
	$table->closeRow();
	$table->setCellStyle('');
	
	$dirh = @opendir($dir);
	while ($obj = readdir($dirh)){
		if ($obj=='.' || $obj=='..'){ continue; }
		
		$ext = explode(".", $obj);
		if ($ext[1]!='tpl'){ continue; }
		$table->openRow();
		$table->addCell("<strong>$obj</strong>");
		$option = "<a href='?op=tpledit&amp;tpl=$ext[0]'>"._AS_RMGS_EDIT."</a>&nbsp; &bull; 
				&nbsp;<a href='?op=tpldel&amp;tpl=$ext[0]'>"._AS_RMGS_DELETE."</a>";
		$table->addCell($option, 0,'','center');
		$table->closeRow();
	}
	
	$table->closeTbl();
	
	echo "</td><td>";
	
	$table->setTableClass('outer');
	$table->setCellStyle("border-bottom: 1px solid #0066CC; border-right: 1px solid #0066CC; background: url(../images/bgth.jpg) repeat-x; height: 20px; color: #FFFFFF;");
	$table->openTbl();
	$table->openRow('left');
	$table->addCell(_AS_RMGS_NEWTPL, 1,2);
	$table->closeRow();
	$table->setCellStyle('');
	
	$tpl = null;
	if ($edit){
		$file = isset($_GET['tpl']) ? $_GET['tpl'] : '';
		$tpl = new GSPostalTemplate($file);
	}
	
	echo "<form name='frmAdd' method='post' action='postals.php?op=".($edit ? 'saveedittpl' : 'newtpl')."'>";
	$table->openRow();
	$table->addCell(_AS_RMGS_TPLTITLE,0,'','let');
	$table->addCell("<input type='text' size='30' name='titulo' maxlength='100' value='".(is_object($tpl) ? $tpl->getVar('name') : '')."' />",0,'','left');
	$table->closeRow();
	$table->openRow();
	$table->addCell(_AS_RMGS_TPLTEXT, 0, '','left');
	$table->addCell(rmgsSelectEditor('','texto',$mc['editor'],is_object($tpl) ? $tpl->getContent() : ''));
	$table->closeRow();
	$table->openRow();
	$table->addCell('');
	$table->addCell("<input type='submit' name='sbt' value='"._AS_RMGS_SEND."' />",0,'','left');
	$table->closeRow();
	if (is_object($tpl)){
		echo "<input type='hidden' name='tpl' value='".$file."' />";
	}
	echo "</form>";
	$table->closeTbl();
	
	echo "</td></tr>";
	
	$table->closeTbl();
	
	echo makeFoot();
	xoops_cp_footer();
}


function rmgsSaveTpl(){
	
	$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
	$texto = isset($_POST['texto']) ? $_POST['texto'] : '';
	
	if ($titulo==''){ redirect_header('postals.php?op=tpls', 1, _AS_RMGS_ERRTITLE); die(); }
	if ($texto==''){ redirect_header('postals.php?op=tpls', 1, _AS_RMGS_ERRTEXT); die(); }
	
	$tpl = new GSPostalTemplate($titulo);
	
	$texto = stripslashes($texto);
	
	if (!$tpl->create($texto, false)){
		redirect_header('postals.php?op=tpls', 2, $tpl->errors());
		die();
	} else {
		redirect_header('?op=tpls', 1, '');
		die();
	}
	
	
}

function rmgsSaveEditTpl(){
	
	$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
	$texto = isset($_POST['texto']) ? $_POST['texto'] : '';
	$file = isset($_POST['tpl']) ? $_POST['tpl'] : '';
	
	if ($file == ''){ header('location: postals.php?op=tpls'); die(); }
	
	if ($titulo==''){ redirect_header('postals.php?op=tpledit&amp;tpl='.$file, 1, _AS_RMGS_ERRTITLE); die(); }
	if ($texto==''){ redirect_header('postals.php?op=tpledit&amp;tpl='.$file, 1, _AS_RMGS_ERRTEXT); die(); }
	
	$tpl = new GSPostalTemplate($file);
	
	if (!file_exists($tpl->getVar('file'))){
		redirect_header('postals.php?op=tpledit&amp;tpl='.$file, 1, _AS_RMGS_ERREXIST);
		die();
	}
	
	if ($file != $titulo){
		if (file_exists($tpl->getVar('dir') . $titulo . '.tpl')){
			redirect_header('postals.php?op=tpledit&amp;tpl='.$file, 1, _AS_RMGS_ERRFILEEXISTS);
			die();
		}
		unlink($tpl->getVar('file'));
	}
	
	$tpl->setName($titulo);
	
	$texto = stripslashes($texto);
	
	if (!$tpl->create($texto, true)){
		redirect_header('postals.php?op=tpls', 2, $tpl->errors());
		die();
	} else {
		redirect_header('?op=tpls', 1, '');
		die();
	}
	
}

function rmgsDeleteTpl(){
	
	$file = isset($_GET['tpl']) ? $_GET['tpl'] : '';
	if ($file==''){ header('location: postals.php?op=tpls'); die(); }
	
	$tpl = new GSPostalTemplate($file);
	
	unlink($tpl->getVar('file'));
	
	redirect_header('postals.php?op=tpls', 1, '');
	
}


$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');

switch ($op){
	case 'tpls':
		rmgsShowTemplates();
		break;
	case 'newtpl':
		rmgsSaveTpl();
		break;
	case 'tpledit':
		rmgsShowTemplates(true);
		break;
	case 'saveedittpl':
		rmgsSaveEditTpl();
		break;
	case 'tpldel':
		rmgsDeleteTpl();
		break;
	default:
		rmgsPostalsList();
		break;
}
?>

