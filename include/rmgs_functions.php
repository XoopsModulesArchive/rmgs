<?php
/*******************************************************************
* $Id: rmgs_functions.php 2 2006-12-11 20:49:07Z BitC3R0 $   *
* --------------------------------------------------------------   *
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
* --------------------------------------------------------------   *
* rmgs_functions.php:                                              *
* Funciones generales del modulo                                   *
* --------------------------------------------------------------   *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.2.5                                                  *
* @modificado: 28/12/2005 02:03:59 p.m.                            *
*******************************************************************/


/**
 * Numero total de imgenes existentes
 * @return int
 */
function rmgsTotalImages(){
	global $xoopsDB;
	
	$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("rmgs_imgs"));
	list($num) = $xoopsDB->fetchRow($result);
	
	return $num;
}

/**
 * Creamos una barra de navegacin para la
 * administracin del mdulo
 */
function makeNav(){
	global $xoopsConfig;
	$xc =& $xoopsConfig;
	$ret = "<table width='100%' cellspacing='1' class='outer'><tr class='head' align='center'>";
	$ret .= "<td><a href='categos.php' title='"._AS_RMGS_CATEGOS."'>"._AS_RMGS_CATEGOS."</a></td>";
	$ret .= "<td><a href='categos.php?op=new' title='"._AS_RMGS_NEWCATEGO."'>"._AS_RMGS_NEWCATEGO."</a></td>";
	$ret .= "<td><a href='images.php?op=upload' title='"._AS_RMGS_UPLOAD."'>"._AS_RMGS_UPLOAD."</a></td>";
	$ret .= "<td><a href='users.php' title='"._AS_RMGS_USERS."'>"._AS_RMGS_USERS."</a></td>";
	$ret .= "<td><a href='postals.php' title='"._AS_RMGS_POSTALS."'>"._AS_RMGS_POSTALS."</a></td>";
	$ret .= "</tr></table><br />";
	return $ret;
}
/**
 * Pie del mdulo
 */
function makeFoot(){
	$rtn = "<br /><div style='font-size: 10px; text-align: center; padding: 4px;'>
				Powered by <a href='http://www.xoops-mexico.com.mx'>RMSOFT GS 2.0</a>.
				CopyRight &copy; 2005 - 2006. 
				<a href='http://www.redmexico.com.mx'>Red Mxico Soft</a></div>";
	return $rtn;
}

/**
 * Cadena aleatoria
 */
function rmgsRandomWord($size=8,$prefix='rmgs_'){
	$chars = "abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$ret = '';
	$len = strlen($chars);
	for($i=1;$i<=$size;$i++){
		mt_srand((double) microtime() * 1000000);
		$sel = mt_rand(0, $len);
		$ret .= substr($chars, $sel, 1);
	}
	return $prefix.$ret;
}

/**
 * Creamos el directorio para el usuario
 */
function rmgsMakeUserDir($uid){
	global $xoopsModuleConfig, $member_handler;
	
	$xoopsUser =& $member_handler->getUser($uid);
	
	if (substr($xoopsModuleConfig['storedir'], strlen($xoopsModuleConfig['storedir']) - 1, 1) != '/'){
		$xoopsModuleConfig['storedir'] .= '/';
	}
	
	$xv = str_replace("XOOPS ", '',XOOPS_VERSION);
	$x22 = false;
	if (substr($xv, 2, 1)=='2'){ $x22 = true; $field = 'loginname'; } else { $field = 'uname'; }
	
	if (!is_dir($xoopsModuleConfig['storedir'].$xoopsUser->getVar($field))){
		mkdir($xoopsModuleConfig['storedir'].$xoopsUser->getVar($field));
		mkdir($xoopsModuleConfig['storedir'].$xoopsUser->getVar($field).'/sizes');
		mkdir($xoopsModuleConfig['storedir'].$xoopsUser->getVar($field).'/ths');
	}
	
	return $xoopsModuleConfig['storedir'].$xoopsUser->getVar($field);
}

/**
 * Funcin que agrega una diagonal al final de una ruta
 * @return string
 */
function rmgsAddSlash($text){
	if ($text==''){ return; }
	if (substr($text, strlen($text) - 1, 1) != '/'){
		$text = $text . '/';
	}
	
	return $text;
}

/**
 * Formatea un tamo de archivo en KB, MB o GB
 * Params tomada de modulo mydownloads
 * Nombre original PrettySize
 *
 * @size = Tamao del archivo
 * @return = Cadena formateada
 */
function rmgsConvertSize($size) {
	$mb = 1024*1024;
	$gb = $mb * 1024;

	if ( $size >= $gb ) {
		$mysize = sprintf ("%01.2f",$size/$gb) . " GB";
	}elseif ($size >= $mb){
		$mysize = sprintf ("%01.2f",$size/$mb) . " MB";
	}elseif ( $size >= 1024 ) {
		$mysize = sprintf ("%01.2f",$size/1024) . " KB";
	}
	else {
	    $mysize = sprintf("%01.2f",$size);
	}
	return $mysize;
}

/**
 * rm() -- Very Vigorously erase files and directories. Also hidden files !!!!
 *
 * @param $dir string
 *                  be carefull to:
 *                        if($obj=='.' || $obj=='..') continue;
 *                    if not it will erase all the server...it happened to me ;)
 *                    the function is permission dependent.   
 */
function deletedir($dir) {
   if(!$dh = @opendir($dir)) return;
   while (($obj = readdir($dh))) {
       if($obj=='.' || $obj=='..') continue;
       if (!@unlink($dir.'/'.$obj)) deletedir($dir.'/'.$obj);
   }
   @rmdir($dir);
}

/**
 * Creamos la barra de navegacin
 */
function rmgsMakeNav(){
	global $tpl, $mc;
	
	$tpl->assign('lang_photos', _RMGS_PHOTOS);
	$tpl->assign('rmgs_modtitle_left', substr($mc['modtitle'], 0, (int)(strlen($mc['modtitle']) / 2)));
	$tpl->assign('rmgs_modtitle_right', substr($mc['modtitle'], (int)(strlen($mc['modtitle']) / 2)));
	$tpl->assign('lang_yourphotos', "<a href='mypics.php'>"._RMGS_YOURPHOTOS."</a>");
	$tpl->assign('lang_upload',"<a href='upload.php'>"._RMGS_UPLOAD."</a>");
	//$tpl->assign('lang_search',"<a href='search.php'>"._RMGS_SEARCH."</a>");
	$tpl->assign('lang_favorites',"<a href='favs.php'>"._RMGS_FAVORITES."</a>");
	$tpl->assign('lang_populars',"<a href='images.php?q=pop'>"._RMGS_POPULARS."</a>");
	$tpl->assign('lang_bestvote',"<a href='images.php?q=voted'>"._RMGS_BESTVOTE."</a>");
	$tpl->assign('thswidth', $mc['thwidth']);
}

/**
 * Obtenemos el directorio web
 */
function rmgsWebDir($idu){
	global $xoopsModuleConfig, $member_handler;
	
	$xoopsUser =& $member_handler->getUser($idu);
	$dir = $xoopsModuleConfig['storedir'];
	$dir = rmgsAddSlash($dir);
	$dir = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $dir);
	
	$xv = str_replace("XOOPS ", '',XOOPS_VERSION);
	$x22 = false;
	if (substr($xv, 2, 1)=='2'){ $x22 = true; $field = 'loginname'; } else { $field = 'uname'; }
	
	return $dir . $xoopsUser->getVar($field);
}

/**
 * Creamos la barra de uso de espacio
 */
function rmgsMakeProgress($used, $limit){
	global $tpl;
	$percent = 150 / $limit;
	$percent = (int)($percent * $used); 
	
	$rtn = "<table cellpadding='0' cellspacing='0' border='0' style='padding: 0px; width:auto;'>";
	$rtn .= "<tr><td style='padding: 0px;' align='center'>
			<div style='text-align: left; padding: 0px; height: 8px; width: 150px; border: 1px solid #CCCCCC; background-color: #FFFFFF;'><img src='images/admin/quota.png' style='height: 8px; width: ".$percent."px;' /></div></td></tr>
	<tr><td style='text-align: center; padding: 3px; font-size: 9px;'>";
	$usado = rmgsConvertSize($used);
	$limite = rmgsConvertSize($limit);
	$rtn .= sprintf(_RMGS_QUOTA, $usado, $limite);
	$rtn .= "</td></tr></table>";
	$tpl->assign('progress', $rtn);
}

/**
 * Comprueba si un elemento es nuevo
 * @param $fecha Timestamp Unix del elemento
 * @param int $limit Dias limites
 * @return boolan. False = No es nuevo, True = Nuevo
 */
function rmgsIsNew($fecha, $limit){
	$current = time() - $fecha;
	$current = (int)($current / 86400);
	if ($current <= $limit){
		return true;
	} else {
		return false;
	}
}

/** 
 * Creamos una barra de navegacin para mostrar la
 * localizacin de un elemento dado
 * @param int $id Identificador del elemento
 * @param int $type Tipo de elemento ('img','cat','set','fav')
 * @param string $by Donde realizar la busqueda ('cat','set','fav')
 * @param array $elements valores necesarioas par ala busqueda
 */
function rmgsLocation($id, $by){
	global $mc, $tpl;
	
	$rtn = array();
	$ret = '';
	$page = '';
	switch ($by){
		case 'cat':
			$page = 'categos.php';
			rmgsGetParents($rtn, $id);				
		case 'set':
		
		case 'fav':
		
	}
	
	$img = "<img src='images/arrow.gif' align='absmiddle' border='0' />";
	$ret = "<strong>::</strong> <a href='./'>$mc[modtitle]</a> $img ";
	foreach ($rtn as $k => $v){
		$ret .= "<a href='$page?id=$v[id]'>$v[text]</a> $img ";
	}
	
	return $ret;
}

/**
 * Obtenemos categorias padres de una categoria
 */
function rmgsGetParents(&$rtn, $id){
	global $db;
	
	$result = $db->query("SELECT parent, id_cat, nombre FROM ".$db->prefix("rmgs_categos")." WHERE id_cat='$id'");
	if ($db->getRowsNum($result)<=0){ return; }
	$row = $db->fetchArray($result);
	
	if ($row['parent']>0){
		rmgsGetParents($rtn, $row['parent']);
	}
	
	$ret = array();
	$ret['id'] = $row['id_cat'];
	$ret['text'] = $row['nombre'];
	$rtn[] = $ret;
}

/**
 * Devuelve el porcentaje de votos para aumentar
 * un punto de rating
 */
function rmgsGlobalRating(){
	global $db;
	
	list($rate) = $db->fetchRow($db->query("SELECT rating FROM ".$db->prefix("rmgs_imgs")." ORDER BY rating DESC LIMIT 0, 1"));
	$rtn = $rate/70;
	return $rtn;
}

function rmgsGlobalPop(){
	global $db;
	
	list($downs) = $db->fetchRow($db->query("SELECT descargas FROM ".$db->prefix("rmgs_imgs")." ORDER BY descargas DESC LIMIT 0, 1"));
	$rtn = $downs/70;
	return $rtn;
}

/**
 * Calcula el rating de una descarga
 * Params
 * @votos = Cantidad de votos de la descarga
 * @rate = valor necesario de votos para ganar puntos
 */
function rmgsGetRating($votos, $rate){
	
	if ($rate==0){ return 0; }
	if ($votos < $rate){ 
		return 0; 
	} elseif ($votos == $rate){ 
		return 1; 
	} else {
		$rtn = (int)($votos / $rate);
	}
	
	return $rtn;
}

function rmgsGetPop($downs, $pop){
	
	if ($pop==0){ return 0; }
	if ($downs < $pop){ 
		return 0; 
	} elseif ($downs == $pop){ 
		return 1; 
	} else {
		$rtn = (int)($downs / $pop);
	}
	
	return $rtn;
}

/**
 * Obtiene una grfica formateada con el rating
 * de un elemento en particular
 * @param int $votos
 */
function rmgsGraphicRating($votos, $rate){
	$rating = rmgsGetRating($votos, $rate);
	
	$rtn = "<div style='background-color: #FFFFFF; text-align: right; margin-top: 2px; border: 1px solid #CCCCCC; font-size: 2px; padding: 0px; height: 14px; width: 70px; background: url(".XOOPS_URL."/modules/rmgs/images/rate.png) no-repeat;'>";
	$rtn .= "<img src='".XOOPS_URL."/modules/rmgs/images/bar.gif' alt='' border='0' style='width: ".(70 - $rating)."px; height: 14px;' />";
	$rtn .= "&nbsp;</div>";
	
	return $rtn;
}

function rmgsGraphicPop($downs, $pop){
	$rating = rmgsGetPop($downs, $pop);
	
	$rtn = "<div style='background-color: #FFFFFF; text-align: right; margin-top: 2px; border: 1px solid #CCCCCC; font-size: 2px; padding: 0px; height: 14px; width: 70px; background: url(".XOOPS_URL."/modules/rmgs/images/pop.png) no-repeat;'>";
	$rtn .= "<img src='".XOOPS_URL."/modules/rmgs/images/bar.gif' alt='' border='0' style='width: ".(70 - $rating)."px; height: 14px;' />";
	$rtn .= "&nbsp;</div>";
	
	return $rtn;
}

/**
 * Funcin para establecer los resultados por pgina
 */
function rmgsSetResults(&$user){
	global $mc;

	$results = isset($_GET['results']) ? $_GET['results'] : (isset($_SESSION['rmgs_results']) ? $_SESSION['rmgs_results'] : $mc['columns'] * 3);
	
	if (is_object($user)){
		if ($user->getVar('results') != $results) { $user->setResults($results); }
		if (!isset($_SESSION['rmgs_results']) || $_SESSION['rmgs_results'] != $user->getVar('results')){
			$_SESSION['rmgs_results'] = $user->getVar('results');
		}
	} else {
		if (!isset($_SESSION['rmgs_results']) || $_SESSION['rmgs_results'] != $results){
			$_SESSION['rmgs_results'] = $results;
		}
	}
	
}

/**
 * Devuelve el editor a utilizar para las descripciones
 * de las categoras y productos
 * @param string $caption
 * @param string $name Nombre en el formulario
 * @param string $value Texto inicial
 * @param boolean $as_object Devuel como objeto o como texto
 */
function rmgsSelectEditor($caption, $name, $type='dhtml', $value='', $width='100%', $height='400px', $addon=''){
	
	$editor = false;
	$x22=false;
	$xv=str_replace('XOOPS ','',XOOPS_VERSION);
	if(substr($xv,2,1)=='2') {
		$x22=true;
	}
	$editor_configs=array();
	$editor_configs["name"] =$name;
	$editor_configs["value"] = $value;
	$editor_configs["rows"] = 15;
	$editor_configs["cols"] = 50;
	$editor_configs["width"] = $width;
	$editor_configs["height"] = $height;

	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

	switch(strtolower($type)){
		case "spaw":
			if(!$x22) {
				if (is_readable(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php"))	{
					include_once(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php");
					$editor = new XoopsFormSpaw($caption, $name, $value);
				}
			} else {
				$editor = new XoopsFormEditor($caption, "spaw", $editor_configs);
			}
			break;

		case "fck":
			if(!$x22) {
				if ( is_readable(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php"))	{
					include_once(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php");
					$editor = new XoopsFormFckeditor($caption, $name, $value);
				}
			} else {
				$editor = new XoopsFormEditor($caption, "fckeditor", $editor_configs);
			}
			break;

		case "htmlarea":
			if(!$x22) {
				if ( is_readable(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php"))	{
					include_once(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php");
					$editor = new XoopsFormHtmlarea($caption, $name, $value);
				}
			} else {
				$editor = new XoopsFormEditor($caption, "htmlarea", $editor_configs);
			}
			break;

		case "dhtml":
			if(!$x22) {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 10, 50, $supplemental);
			} else {
				$editor = new XoopsFormEditor($caption, "dhtmltextarea", $editor_configs);
			}
			break;

		case "textarea":
			$editor = new XoopsFormTextArea($caption, $name, $value);
			break;

		case "koivi":
			if(!$x22) {
				if ( is_readable(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php"))	{
					include_once(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php");
					$editor = new XoopsFormWysiwygTextArea($caption, $name, $value, '100%', '400px', '');
				}
			} else {
				$editor = new XoopsFormEditor($caption, "koivi", $editor_configs);
			}
			break;
	}

	return $editor->render();

}

/**
 * Funcin para eliminar las postales antiguas
 */
function deleteOldPostals(){
	global $db, $mc;
	
	$tbl = $db->prefix("rmgs_postales");
	$limite = time() - (86400 * $mc['postaldays']);
	$sql = "DELETE FROM $tbl WHERE fecha<$limite";
	$db->queryF($sql);
	if ($db->error()!=''){
		return false;
	} else {
		return true;
	}
}

/**
 * Esta funcin verifica si el usuario actual puede
 * subir imgenes o no
 * @return boolean
 */
function rmgsCheckUpload(){
	global $mc, $db, $xoopsUser;
	
	if (!$mc['upload']){
		return false;
	}
	
	if (!is_object($xoopsUser)){
		return false;
	}
	
	return true;
}

/**
 * Formateo de pginas
 * @param int $tpages Total de Pginas a Generar
 * @param int $pactual Pgina Actual
 * @param string $link Vinculo de los elementos sin pag
 * @param string $conector conector para el parmetro pag (?,&)
 */
function rmgsCreatePagesNav($tpages, $pactual, $link, $conector = '&amp;'){
	global $tpl;
	
	/**
 	* Formateamos la salida de pginas
 	*/
	if ($tpages<=11){
		$rango[0] = 1; 
		$rango[1] = 
		$tpages; 
		$rango[2] = 0; 
		$rango[3] = 0;
		$rango[4] = 0;
		$rango[5] = 0;
	}elseif ($tpages>=12){
		if ($pactual<7){ 
			$rango[0] = 1; 
			$rango[1] = 8; 
			$rango[2] = $tpages - 1; 
			$rango[3] = $tpages;
			$rango[4] = 0;
			$rango[5] = 0;
		}
		if ($pactual>=7){ 
			$rango[0] = 1; 
			$rango[1] = 2; 
			if ($pactual<$tpages - 6){
				$rango[2] = $pactual - 3; 
				$rango[3] = $pactual + 3;
				$rango[4] = $tpages - 1;
				$rango[5] = $tpages;
			} else {
				$rango[2] = $tpages - 6; 
				$rango[3] = $tpages;
				$rango[4] = 0;
				$rango[5] = 0;
			}
		}
	}

	for ($i=$rango[0];$i<=$rango[1];$i++){
		if ($i==$pactual){
			$tpl->append('pages', "<span class='current_page'>$i</span>");
		} else {
			$tpl->append('pages', "<a href='$link".$conector."pag=$i' class='pages'>$i</a>");
		}
	}

	if ($rango[2] > 0){
		$tpl->append('pages',"&middot;&middot;&middot;");
		for ($i=$rango[2];$i<=$rango[3];$i++){
			if ($i==$pactual){
				$tpl->append('pages', "<span class='current_page'>$i</span>");
			} else {
				$tpl->append('pages', "<a href='$link".$conector."pag=$i' class='pages'>$i</a>");
			}
		}
	}

	if ($rango[4] > 0){
		$tpl->append('pages',"&middot;&middot;&middot;");
		for ($i=$rango[4];$i<=$rango[5];$i++){
			if ($i==$pactual){
				$tpl->append('pages', "<span class='current_page'>$i</span>");
			} else {
				$tpl->append('pages', "<a href='$link".$conector."pag=$i' class='pages'>$i</a>");
			}
		}
	}
}
?>
