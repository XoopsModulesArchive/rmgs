<?php
/*******************************************************************
* $Id: block.func.php 2 2006-12-11 20:49:07Z BitC3R0 $       *
* ----------------------------------------------------------       *
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
* ----------------------------------------------------------       *
* block.func.php:                                                  *
* Funciones para inclusión en los bloques                          *
* ----------------------------------------------------------       *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.2                                                  *
* @modificado: 01/03/2006 09:19:32 p.m.                            *
*******************************************************************/

/**
 * Obtiene las opciones de configuración de un 
 * módulo específico
 * @returns array Module Configs
 */
function rmgs_bkget_config($modname='rmgs'){
	global $xoopsModuleConfig, $xoopsModule;

	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modname && $xoopsModule->getVar('isactive'))) {
		$retval= $xoopsModuleConfig;
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($modname);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
    		$retval= $moduleConfig;
		}
	}
	
	return $retval;
}

/**
 * Obtenemos una lista de categorías
 */
function rmgs_bkget_categos(&$tree,$parent=0,$space=2){
	$db = Database::getInstance();
	$result  = $db->query("SELECT id_cat, nombre FROM ".$db->prefix("rmgs_categos")." WHERE parent='$parent'");
	
	while ($row = $db->fetchArray($result)){
		$subret = array();
		$subret['id_cat'] = $row['id_cat'];
		$subret['space'] = $space;
		$subret['name'] = $row['nombre'];
		$tree[] = $subret;
		rmgs_bkget_categos($tree, $row['id_cat'], $space + 2);
	}
}
?>