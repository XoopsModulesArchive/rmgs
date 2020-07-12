<?php
/*******************************************************************
* $Id: form.class.php 2 2006-12-11 20:49:07Z BitC3R0 $          *
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

include XOOPS_ROOT_PATH.'/modules/rmgs/common/formelement.class.php';
include XOOPS_ROOT_PATH.'/modules/rmgs/common/formtexts.class.php';

class RMForm
{
	var $_fields = array();
	var $_name = '';
	var $_action = '';
	var $_extra = '';
	var $_method = '';
	var $_title = '';
	
	/**
	 * Función inicializadora
	 */
	function RMForm($title, $name, $action, $method='post')
	{
		$this->_name = $name;
		$this->_action = $action;
		$this->_method = $method;
		$this->_title = $title;
	}
	/**
	 * Agregar un nuevo campo de texto
	 */
	function setExtra($extra){
		$this->_extra = $extra;
	}
	function getExtra(){
		return $this->_extra;
	}
	function setMehod($method){
		if ($method == 'post' || $method == 'get'){
			$this->_method = $method;
		}
	}
	function setName($name){
		$this->_name = trim($name);
	}
	function getName(){
		return $this->_name;
	}
	function setAction($action){
		$this->_action = $action;
	}
	function getAction(){
		return $this->_action;
	}
	/**
	 * Agregamos nuevos elementos
	 * Estos elementos son instanacias de algun elemento de formulario
	 */
	function addElement(&$element){
		$this->_fields[] = $element;
	}
	/**
	 * Devolvemos el codigo HTML
	 */
	function render(){
		$ret = "<form name='".$this->_name."' id='".$this->_name."' action='".$this->_action."' method='".$this->_method."' ".$this->_extra.">
				<table width='100%' class='outer' cellspacing='1'>
					<tr><th colspan='2'>".$this->_title."</th></tr>";
		
		foreach ($this->_fields as $element){
			if (is_a($element, 'RMSubTitle') || is_a($element, 'RMHidden')){
				$ret .= $element->render();
			} else {
				$ret .= "<tr align='left' class='even'><td class='even'>".$element->getCaption();
				if ($element->getDescription()!=''){
					$ret .= "<br /><br /><span style='font-size: 10px;'>".$element->getDescription()."</span></td>";
				}
				$ret .= "<td>".$element->render()."</td></tr>";
			}
		}
		
		$ret .= "</table></form>";
		return $ret;
		
	}
	/**
	 * Escribe el contenido HTML
	 */
	function display(){
		echo $this->render();
	}
}
?>
