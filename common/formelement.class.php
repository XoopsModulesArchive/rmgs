<?php
/*********************************************************************
* $Id: formelement.class.php 2 2006-12-11 20:49:07Z BitC3R0 $  *
* -----------------------------------------------------------------  *
* RMSOFT Gallery System 2.0                                          *
* Sistema Avanzado de Galer�as                                       *
* CopyRight � 2005 - 2006. Red M�xico Soft                           *
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
* formelement.class.php:                                             *
* Clase b�sica para los elementos de un formulario                   *
* -----------------------------------------------------------------  *
* @copyright: � 2005 - 2006. BitC3R0.                                *
* @autor: BitC3R0                                                    *
* @paquete: RMSOFT GS 2.0                                            *
* @version: 0.1.0                                                    *
* @modificado: 17/12/2005 08:10:47 p.m.                              *
*********************************************************************/

class RMFormElement
{
	var $_name = '';
	var $_caption = '';
	var $_class = '';
	var $_extra = '';
	var $_required = '';
	var $_description = '';
	
	function FormElement(){
		exit("Esta clase no debe ser instanciada");
	}
	
	function setName($name){
		$this->_name = trim($name);
	}
	
	function getName(){
		return $this->_name;
	}
	
	function setClass($class){
		$this->_class = $class;
	}
	
	function getClass(){
		return $this->_class;
	}
	
	function setCaption($caption){
		$this->_caption = trim($caption);
	}
	
	function getCaption(){
		return $this->_caption;
	}
	
	function setDescription($desc){
		$this->_description = $desc;
	}
	
	function getDescription(){
		return $this->_description;
	}
	
	function setExtra($extra){
		$this->_extra = $extra;
	}
	
	function getExtra(){
		return $this->_extra;
	}
	/**
	 * Obtenemos la tabla html formateada
	 * metodo abastracto
	 */
	function render(){
		
	}
}
?>
