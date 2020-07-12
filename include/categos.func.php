<?php
/*********************************************************************
* $Id: categos.func.php 2 2006-12-11 20:49:07Z BitC3R0 $  *
* -----------------------------------------------------------------  *
* RMSOFT Gallery System 2.0                                          *
* Sistema Avanzado de Galerías                                       *
* CopyRight © 2005 - 2006. Red México Soft                           *
* http://www.redmexico.com.mx                                        *
* http://www.xoops-mexico.net                                        *
*                                                                    *
* This program is free software; you can redistribute it and/or      *
* modify it under the terms of the GNU General Public License as     *
* published by the Free Software Foundation; either version 2 of     *
* the License, or (at your option) any later version.                *
*                                                                    *
* This program is distributed in the hope that it will be useful,    *
* but WITHOUT ANY WARRANTY; without even the implied warranty of     *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the       *
* GNU General Public License for more details.                       *
*                                                                    *
* You should have received a copy of the GNU General Public          *
* License along with this program; if not, write to the Free         *
* Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,     *
* MA 02111-1307 USA                                                  *
*                                                                    *
* -----------------------------------------------------------------  *
* categos_functions.php:                                             *
* Funciones para el manejo de las categorías                         *
* -----------------------------------------------------------------  *
* @copyright: © 2005 - 2006. BitC3R0.                                *
* @autor: BitC3R0                                                    *
* @paquete: RMSOFT GS v2.0                                           *
* @version: 0.1.1                                                    *
* @modificado: 27/12/2005 10:16:36 a.m.                              *
*********************************************************************/

include_once XOOPS_ROOT_PATH.'/modules/rmgs/class/catego.class.php';

/**
 * Obtenemos las categorías
 */
function getCategos($parent){
	global $db, $tpl, $mc;
	
	$result = $db->query("SELECT id_cat FROM ".$db->prefix("rmgs_categos")." WHERE parent='$parent' ORDER BY nombre");
	while ($row=$db->fetchArray($result)){
		$catego = new GSCategory($row['id_cat']);
		$tpl->append('categos', array('id'=>$catego->getVar('id'),'title'=>$catego->getVar('nombre', 1),
			'desc'=>$catego->getVar('desc', 1),'date'=>sprintf(_RMGS_SINCE, date($mc['format_date'], $catego->getVar('fecha'))),
			'subcat'=>rmgsGetSubcats($row['id_cat']), 'images'=>sprintf(_RMGS_IMGCOUNT, $catego->getImagesNum()),
			'isnew'=>rmgsIsNew($catego->getVar('fecha'), $mc['catnew_days'])));
	}
}

/**
 * Obtenemos la lista de subcategorías de una categoría dada
 */
function rmgsGetSubcats($parent){
	global $db, $tpl, $mc;
	
	$result = $db->query("SELECT id_cat FROM ".$db->prefix("rmgs_categos")." WHERE parent='$parent' ORDER BY nombre");
	$ret = array();
	while ($row=$db->fetchArray($result)){
		$catego = new GSCategory($row['id_cat']);
		$cat = array();
		$cat['id'] = $catego->getVar('id');
		$cat['title'] = $catego->getVar('nombre', 1);
		$cat['desc'] = $catego->getVar('desc', 1);
		$cat['date'] = date($mc['format_date'], $catego->getVar('date'));
		$ret[] = $cat;
	}
	
	return $ret;
}

/**
 * Crea un campo select con la lista de categorías
 */
function rmgsMakeCategoSelect(){
	global $db, $tpl;
	$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
	$tree = array();
	getCategosTree($tree, 0, 0, true);
	$selected = null;
	foreach ($tree as $k => $v){
		if ($v['id_cat']==$id){ $selected = true; } else { $selected = false; }
		$tpl->append('options',array('id'=>$v['id_cat'],'title'=>str_repeat('-', $v['space']).' '.$v['name'],'selected'=>$selected));
	}
	
	$tpl->assign('lang_goto',_RMGS_GOTO);
}

/**
 * Obtenemos una lista de las categorías
 */
function getCategosTree(&$tree, $parent=0,$space=0,$getname = false,$exclude=0){
	global $db;
	$result  = $db->query("SELECT id_cat, nombre FROM ".$db->prefix("rmgs_categos")." WHERE parent='$parent'");
	while ($row = $db->fetchArray($result)){
		$subret = array();
		$subret['id_cat'] = $row['id_cat'];
		$subret['space'] = $space;
		if ($getname){ $subret['name'] = $row['nombre']; }
		$tree[] = $subret;
		getCategosTree($tree, $row['id_cat'], $space + 2, $getname);
	}
}
?>

