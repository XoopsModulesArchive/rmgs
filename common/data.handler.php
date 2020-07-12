<?php
/*******************************************************************
* $Id: data.handler.php 2 2006-12-11 20:49:07Z BitC3R0 $     *
* ------------------------------------------------------------     *
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
* ------------------------------------------------------------     *
* data.handler.php:                                                *
* Manejador de datos (Escritura y lectura de la base de datos)     *
* ------------------------------------------------------------     *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.0                                                  *
* @modificado: 17/12/2005 10:05:20 p.m.                            *
*******************************************************************/

include_once XOOPS_ROOT_PATH.'/modules/rmgs/common/form.class.php';

class RMDataHandler
{
	var $db = null;
	var $_uniques = array();
	var $_required = array();
	var $_table = '';
	var $_fields = array();
	var $_names = array();
	var $_error = '';
	var $_primary = '';
	var $_special = array();
	
	/**
	 * Variables para el control de datos
	 */
	var $_pages = 0;		// Total de páginas encontradas
	var $_rcount = 0;		// Total de resultados encontrados
	var $_psize = 15;		// Tamaño de la página de resultados
	var $_navpages = '';		// Navegación por las páginas
	var $_apage;			// Página actual
	
	/**
	 * Creamos una instancia de la base de datos
	 */
	function RMDataHandler(&$db){
		$this->db = $db;
	}
	/**
	 * Tamaño de la página de resultados
	 */
	function setPageSize($size){
		if ($size>0){ $this->_psize = $size; }
	}
	function getPageSize(){
		return $this->_psize;
	}
	/**
	 * Establecemos la tabla de trabajo
	 */
	function setTable($table){
		if ($table!=''){
			$this->_table = trim($table);
			$result = $this->db->query("SHOW COLUMNS FROM `".$this->_table."`;");
			while ($row = $this->db->fetchArray($result)){
				$this->_fields[] = $row['Field'];
				if ($row['Key']=='PRI' && $row['Extra']=='auto_increment'){ $this->_primary = $row['Field']; }
			}
		}
		$this->_uniques = array();
		$this->_required = array();
	}
	/**
	 * Creamos valores unicos en la base de datos
	 */
	function makeUnique($field){
		if ($field != '' && !in_array($field, $this->_uniques)){
			$this->_uniques[] = $field;
		}
	}
	function getUniques(){
		return $this->_uniques;
	}
	/**
	 * Creamos valores requeridos
	 */
	function setRequired($field){
		if ($field != '' && !in_array($field, $this->_required)){
			$this->_required[] = $field;
		}
	}
	function getRequired(){
		return $this->_required;
	}
	/**
	 * Establecemos nombres para los campos
	 * @param array $names  ej. array('id:ID','name:Nombre')
	 * @param string $names ej. 'id:ID,name:Nombre'
	 */
	function setNames($names){
		if (!is_array($names)){ 
			$names = explode(",", $names);
		}
		foreach ($names as $k){
			$tmp = explode(':',trim($k));
			$this->_names[$tmp[0]] = $tmp[1];
		}
	}
	/**
	 * Establecemos valores especiales
	 * @param array $special ej. array(fecha=>time();)
	 * @param string $spaciel  ej. 'fecha=>time()'
	 */
	function setSpecial($special){
		if (!is_array($special)){
			$special = explode(",", $special);
		}
		foreach ($special as $k){
			$ret = explode(":",$k);
			$this->_special[$ret[0]] = $ret[1];
		}
	}
	/**
	 * Guardamos las variables de Post
	 * @param int $PostOrGet 0 = POST, 1 = GET
	 */
	function saveData($PostOrGet=0){
		// Cargamos las variables post
		if ($PostOrGet==0){
			foreach ($_POST as $k => $v){ $$k = $v; }
		} else {
			foreach ($_GET as $k => $v){ $$k = $v; }
		}
		// Comrpobamos campos requeridos
		foreach ($this->_required as $k){
			if (!isset($$k) || $$k == ''){
				$this->_error = sprintf(_AS_RMGS_FIELDREQUIRED, $this->_names[$k]);
				return false;
			}
		}
		// Comprobamos los campos unicos
		if (count($this->_uniques)>0){
			$sql = "SELECT COUNT(*) FROM `$this->_table` WHERE ";
			foreach ($this->_uniques as $key){
				$sql .= "$key = '".$$key."' AND ";
			}
			$sql = substr($sql, 0, strlen($sql) - 5);
			$result = $this->db->query($sql);
			list($num) = $this->db->fetchRow($result);
			if ($num > 0){
				$ret = '';
				foreach($this->_uniques as $k){
					$ret .= $this->_names[$k].", ";
				}
				$ret = substr($ret, 0, strlen($ret) - 2);
				$this->_error = sprintf(_AS_RMGS_FIELDUNIQUE, $ret);
				return false;
			}
		}
		//Guardamos los datos
		$sql = "INSERT INTO `$this->_table` (";
		$ret = '';
		foreach ($this->_fields as $k){
			if ($k != $this->_primary){
				$sql .= "`$k`,";
				if (isset($this->_special[$k])){
					$$k = $this->makeSpecial($this->_special[$k]);
				}
				$ret .= "'".$$k."',";
			}
		}
		$ret = substr($ret, 0, strlen($ret) - 1);
		$sql = substr($sql, 0, strlen($sql) - 1);
		$sql .=  ") VALUES ($ret);";
		$this->db->query($sql);
		if ($this->db->error() != ''){
			$this->_error = $this->db->error();
			return false;
		}
		return true;
	}
	/**
	 * Guardamos modificaciones en un elemento de la tabla
	 * @param string $identifier Identificador por el cual se editará. Ej. 'id'
	 * @param int $PoG 0 = Post, 1 = GET
	 */
	function saveEdited($identifier, $PoG = 0){
		if ($PostOrGet==0){
			foreach ($_POST as $k => $v){ $$k = $v; }
		} else {
			foreach ($_GET as $k => $v){ $$k = $v; }
		}
		// Comrpobamos campos requeridos
		foreach ($this->_required as $k){
			if (!isset($$k) || $$k == ''){
				$this->_error = sprintf(_AS_RMGS_FIELDREQUIRED, $this->_names[$k]);
				return false;
			}
		}
		// Comprobamos los campos unicos
		if (count($this->_uniques)>0){
			$sql = "SELECT COUNT(*) FROM `$this->_table` WHERE $identifier <> ".$$identifier." ";
			foreach ($this->_uniques as $key){
				$sql .= "AND $key = '".$$key."' ";
			}
			//$sql = substr($sql, 0, strlen($sql) - 5);
			$result = $this->db->query($sql);
			list($num) = $this->db->fetchRow($result);
			if ($num > 0){
				$ret = '';
				foreach($this->_uniques as $k){
					$ret .= $this->_names[$k].", ";
				}
				$ret = substr($ret, 0, strlen($ret) - 2);
				$this->_error = sprintf(_AS_RMGS_FIELDUNIQUE, $ret);
				return false;
			}
		}
		//Guardamos los datos
		$sql = "UPDATE `$this->_table` SET ";
		$ret = '';
		foreach ($this->_fields as $k){
			if (isset($$k)){
				$sql .= "`$k`=";
				if (isset($this->_special[$k])){
					$$k = $this->makeSpecial($this->_special[$k]);
				}
				$sql .= "'".$$k."',";
			}
		}
		$sql = substr($sql, 0, strlen($sql) - 1);
		$sql .=  " WHERE $identifier='".$$identifier."';";
		$this->db->query($sql);
		if ($this->db->error() != ''){
			$this->_error = $this->db->error();
			return false;
		}
		return true;
		
	}
	/**
	 * Devolvemos el error
	 */
	function error(){
		return $this->_error;
	}
	/**
	 * Creamos datos especiales
	 */
	function makeSpecial($value){
		switch ($value){
			case 'time';
				return time();
				break;
		}
	}
	/**
	 * Elmiminamos una fila de la tabla
	 */
	function delete($where){
		if ($where==''){ return; }
		
		$sql = "DELETE FROM $this->_table WHERE $where";
		$this->db->query($sql);
		if ($this->db->error()==''){
			return true;
		} else {
			$this->_error = $this->db->error();
			return false;
		}		
	}
	/**
	 * Obtenemos las filas de una tabla
	 */
	function getContent($fields='*', $where='', $order='', $ad=''){
		if ($fields==''){ return; }
		
		/**
		 * Resultado inicial
		 */
		$start = isset($_GET['pag']) ? $_GET['pag'] : (isset($_POST['pag']) ? $_POST['pag'] : 0);
		if ($start>0){ $start --; }
		$start = $start * $this->_psize;
		/**
		 * Clave para ordenar
		 */
		if ($order=''){
			$order = isset($_GET['key']) ? $_GET['key'] : (isset($_POST['key']) ? $_POST['key'] : '');
		}
		/**
		 * Sentido del orden
		 */
		if ($ad == ''){
			$ad = isset($_GET['sort']) ? $_GET['sort'] : (isset($_POST['sort']) ? $_POST['sort'] : 'ASC');
		}
		
		$sql = "SELECT $fields FROM $this->_table ";
		$sql1 = "SELECT COUNT(*) FROM $this->_table ";
		if ($where!=''){ 
			$sql .= "WHERE $where "; 
			$sql1 = "WHERE $where ";
		}
		if ($order!=''){ $sql .= "ORDER BY $order $ad "; }
		if ($limit > 0){ $sql .= "LIMIT $start, $this->_psize;"; }
		
		$result = $this->db->query($sql1);
		list($num) = $this->db->fetchRow($result);
		$this->_rcount = $num;
		/**
		 * Calculamos el total de páginas
		 */
		$tpages = (int)($num / $this->_psize);
		if ($num % $this->_psize > 0){ $tpages ++; }
		
		$this->_pages = $tpages;
		
		if ($start<=0){ 
			$apage = 1; 
		} else {
			$apage = $start / $this->_psize;
		}
		$this->_apage = $apage;
		/**
		 * Creamos la barra de navegación por los resultados
		 */
		for ($i=1;$i<=$tpages;$i++){
			if ($i = $apage){
				$this->_navpages .= "&gt;&gt;<a href='?pag=$i&amp;key=$order&amp;sort=$ad'>$i</a>&lt;&lt; ";
			} else {
				$this->_navpages .= "<a href='?pag=$i&amp;key=$order&amp;sort=$ad'>$i</a> ";
			}
		}
		
		$result = $this->db->query($sql);
		$ret = array();
		while ($row = $this->db->fetchArray($result)){
			$ret[] = $row;
		}
		
		return $ret;
		
	}
	/**
	 * Navegación de páginas
	 */
	function getNavPages(){
		return $this->_navpages;
	}
	/**
	 * Obtenemos una fila
	 */
	function getRow($where){
		$sql = "SELECT * FROM $this->_table WHERE $where";
		$result = $this->db->query($sql);
		if ($this->db->getRowsNum($result)<=0){
			return false;
		} else {
			$row = $this->db->fetchArray($result);
			return $row;
		}
	}
}
?>
