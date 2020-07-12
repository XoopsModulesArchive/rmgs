<?php
/********************************************************************
* $Id: formbutton.class.php 2 2006-12-11 20:49:07Z BitC3R0 $  *
* ----------------------------------------------------------------  *
* RMSOFT Gallery System 2.0                                         *
* Sistema Avanzado de Galerías                                      *
* CopyRight © 2005 - 2006. Red México Soft                          *
* http://www.redmexico.com.mx                                       *
* http://www.xoops-mexico.net                                       *
*                                                                   *
* This program is free software; you can redistribute it and/or     *
* modify it under the terms of the GNU General Public License as    *
* published by the Free Software Foundation; either version 2 of    *
* the License, or (at your option) any later version.               *
*                                                                   *
* This program is distributed in the hope that it will be useful,   *
* but WITHOUT ANY WARRANTY; without even the implied warranty of    *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the      *
* GNU General Public License for more details.                      *
*                                                                   *
* You should have received a copy of the GNU General Public         *
* License along with this program; if not, write to the Free        *
* Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,    *
* MA 02111-1307 USA                                                 *
*                                                                   *
* ----------------------------------------------------------------  *
* formbutton.class.php:                                             *
* Creacion de botones para formularios                              *
* ----------------------------------------------------------------  *
* @copyright: © 2005 - 2006. BitC3R0.                               *
* @autor: BitC3R0                                                   *
* @paquete: RMSOFT GS v2.0                                          *
* @version: 0.1.0                                                   *
* @modificado: 17/12/2005 09:53:21 p.m.                             *
********************************************************************/

class RMButton extends RMFormElement
{
	var $_type = 'submit';
	var $_value = '';
	
	function RMButton($name, $value, $type = 'submit'){
		$this->setName($name);
		$this->_value = $value;
		$this->_type = $type;
		$this->setCaption = '&nbsp;';
	}
	function setType($type){
		$this->_type = $type;
	}
	function getType($type){
		return $this->_type;
	}
	function setValue($value){
		$this->_value = $value;
	}
	function getValue(){
		return $this->_value;
	}
	/**
	 * Devolvemos el codigo HTML
	 */
	function render(){
		$ret = "<input type='".$this->_type."' name='".$this->getName()."' id='".$this->getName()."' value='".$this->_value."' ".$this->getExtra()." />";
		return $ret;
	}
	
}
?>

