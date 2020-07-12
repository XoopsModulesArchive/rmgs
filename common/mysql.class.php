<?php
/*******************************************************************
* $Id: mysql.class.php 2 2006-12-11 20:49:07Z BitC3R0 $      *
* -----------------------------------------------------------      *
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
* -----------------------------------------------------------      *
* mysql.class.php:                                                 *
* Procedimientos comunes con la base de datos MySQL                *
* -----------------------------------------------------------      *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Framework                                       *
* @version: 0.1.0                                                  *
* @modificado: 16/12/2005 11:28:28 p.m.                            *
*******************************************************************/

/**
 * Calse base para el trabajo con las tablas
 */
class MySQL
{
	var $db = null;
	
}


class Table extends MySQL
{
	var $_table = '';
	var $_names = array();
	var $_format = array();
	var $_ident = '';
	var $_fields = array();
	
	// Inicializador de la clase
	function Table($table, &$db){
		$this->_table = $table;
		$this->db =& $db;
		$result = $this->db->queryF("SHOW COLUMNS FROM ".$this->_table);
		while ($row = $this->db->fetchArray($result)){
			$this->_fields[] = $row;
			$this->_names[$row['Field']] = $row['Field'];
			if ($row['Key'] == 'PRI' && $row['Extra'] == 'auto_increment'){
				$this->_ident = $row['Field'];
			}
		}
	}
	/**
	 * Estructura de la tabla
	 * @return array con los valores
	 */	
	function getFields(){
		return $this->_fields;
	}
	/**
	 * Obtiene el contenido de una tabla
	 */
	function getContent($fields='*',$where='',$start=0,$limit=0){
		
		$sql = "SELECT $fields FROM $this->_table ";
		if ($where != ''){ $sql .= "WHERE $where "; }
		if ($limit>0){ $sql .= "LIMIT $start, $limit;"; }
		
		$result = $this->db->query($sql);
		$ret = array();
		
		while ($row = $this->db->fetchArray($result)){
			$ret[] = $row;
		}
		
		return $ret;
	}
	
}
?>


