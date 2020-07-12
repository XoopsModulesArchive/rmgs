<?php
/*******************************************************************
* $Id: data.class.php 2 2006-12-11 20:49:07Z BitC3R0 $       *
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
* data.class.php: Manejo de palabras clave                         *
* ----------------------------------------------------------       *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.2                                                  *
* @modificado: 22/12/2005 07:07:52 p.m.                            *
*******************************************************************/

/**
 * Clase manejadora de imágenes y categorías
 * $db = referencia a la Base de Datos 
 */
class GSDataHandler
{
	var $db = null;
	var $_categosTree = array();
	
	function GSDataHandler(&$db)
	{
		$this->db =& $db;
	}
	/**
	 * Obtenemos la lista de imágenes que pertenecen a una
	 * categoría dada
	 */
	function imagesByCatego($id){
		$ret = array();
		$result  = $this->db->query("SELECT id_img FROM ".$this->db->prefix("rmgs_imglink")." WHERE id_cat='$id'");
		while ($row = $this->db->fetchArray($result)){
			$ret = $row['id_img'];
		}
		return $ret;
	}
	/**
	 * Obtenemos la lista de categorias a las que pertenece una imágen
	 */
	function categosByImage($id){
		$ret = array();
		$result  = $this->db->query("SELECT id_cat FROM ".$this->db->prefix("rmgs_imglink")." WHERE id_img='$id'");
		while ($row = $this->db->fetchArray($result)){
			$ret = $row['id_cat'];
		}
		return $ret;
	}
	/**
	 * Obtenermos el numero de imágenes en una categoría
	 */
	function imagesInCatego($id){
		$result = $this->db->query("SELECT COUNT(*) FROM " . $this->db->prefix("rmgs_imglink")." WHERE id_cat='$id'");
		list($num) = $this->db->fetchRow($result);
		return $num;
	}
	/**
	 * Obtenemos el numero de categorías a las que pertenece 
	 * una imágen
	 */
	function categosOfImage($id){
		$result = $this->db->query("SELECT COUNT(*) FROM " . $this->db->prefix("rmgs_imglink")." WHERE id_img='$id'");
		list($num) = $this->db->fetchRow($result);
		return $num;
	}
	/**
	 * Devuelve las categorias
	 * @return array 
	 */
	function getCategos($parent=0,$space=0,$getname = false,$exclude=0){
		$result  = $this->db->query("SELECT id_cat, nombre FROM ".$this->db->prefix("rmgs_categos")." WHERE parent='$parent'");
		while ($row = $this->db->fetchArray($result)){
			$subret = array();
			$subret['id_cat'] = $row['id_cat'];
			$subret['space'] = $space;
			if ($getname){ $subret['name'] = $row['nombre']; }
			$this->_categosTree[] = $subret;
			$this->getCategos($row['id_cat'], $space + 2, $getname);
		}
		return $this->_categosTree;
	}
}
?>