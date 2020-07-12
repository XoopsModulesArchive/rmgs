<?php
/*******************************************************************
* $Id: gsobject.class.php 2 2006-12-11 20:49:07Z BitC3R0 $   *
* --------------------------------------------------------------   *
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
* --------------------------------------------------------------   *
* gsobject.class.php: Manejo de palabras clave                     *
* --------------------------------------------------------------   *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.3                                                  *
* @modificado: 22/12/2005 07:06:42 p.m.                            *
*******************************************************************/

/**
 * Clase base para todas las clases de 
 * RMSOFT GS 2.0
 */
class GSObject
{
	var $vars = array();
	var $db = null;
	var $_isNew = false;
	var $_errors = array();
	
	/**
	 * Inicializa variables
	 */
	function initVar($name,$value=null,$required=false)
	{
		$this->vars[$name] = array('value'=>$value,'required'=>$required);
	}
	/**
	 * Establece el valor de una variable
	 */
	function setVar($name, $value){
		if (isset($this->vars[$name])){
			$this->vars[$name]['value'] = $value;
		}
	}
	/**
	 * Establece varias variables de una vez
	 */
	function setVars($arrVars){
		if (!is_array($arrVars)) return;
		
		foreach ($arrVars as $k => $v){
			$this->setVar($k, $v);
		}
	}
	/**
	 * Devuelve una variable de nuestro array de variables
	 * @param int $value_type Indica el formato del tipo a devolver
	 * 0 = Valor normal, 1 = Cadena filtrada
	 */
	function getVar($name, $value_type = 0){
		if (!isset($this->vars[$name])){ return ; }
		switch ($value_type){
		    case 1: // Formateado
		    	$myts =& MyTextSanitizer::getInstance();
		    	return $myts->makeTareaData4Show($this->vars[$name]['value']);
		    case 2: // Para guardare
		    	$myts =& MyTextSanitizer::getInstance();
		    	return $myts->makeTareaData4Save($this->vars[$name]['value']);
			case 3: // Plano, sin HTML no XoopsCode
				$myts =& MyTextSanitizer::getInstance();
		    	return $myts->makeTareaData4Show($this->vars[$name]['value'], 0 ,0);
		    case 0:
		    default:
		          return $this->vars[$name]['value'];
		          break;
		}
	}
	/**
	 * Devuelve un array asociativo con los valores
	 * de las variables
	 */
	function getVars(){
		return $this->vars;
	}
	/**
	 * Inicializamos un objeto nuevo
	 */
	function setNew(){
		$this->_isNew = true;
	}
	function unsetNew(){
		$this->_isNew = false;
	}
	function isNew(){
		return $this->_isNew;
	}
	/**
	 * Creamos los errores
	 */
	function addError($text){
		$this->_errors[] = $text;
	}
	/**
	 * Obtenemos los errores
	 */
	function errors($html=true){
		$ret = '';
		
		if (count($this->_errors)<=0){ return; }
		
		if ($html){
		
			$ret .= "<div class='outer' style='padding: 1px;'>";
			foreach ($this->_errors as $k){
				$ret .= "<div class='odd'>$k</div>";
			}
			$ret .= "</div>";
		
		} else {
		
			foreach ($this->_errors as $k){
				$ret .= $k."<br />";
			}
		
		}
		
		return $ret;
	}
}
?>