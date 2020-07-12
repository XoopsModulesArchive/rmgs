<?php
/*******************************************************************
* $Id: catego.class.php 2 2006-12-11 20:49:07Z BitC3R0 $     *
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
* catego.class.php: Manejo de palabras clave                       *
* ------------------------------------------------------------     *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.3                                                  *
* @modificado: 22/12/2005 07:07:57 p.m.                            *
*******************************************************************/

include_once XOOPS_ROOT_PATH . '/modules/rmgs/class/gsobject.class.php';

class GSCategory extends GSObject
{
	var $_imgnum = 0;
	/**
	 * Cargamos la informaciónd e una nueva categoría o
	 * incializamos una nueva
	 */
	function GSCategory($id = null)
	{
		$this->initVar('nombre','',true);
		$this->initVar('fecha','',true);
		$this->initVar('id','',true);
		$this->initVar('desc','',false);
		$this->initVar('parent','',false);
		$this->initVar('found','');
		$this->db =& Database::getInstance();
		
		if (!is_null($id)){
			$result = $this->db->query("SELECT * FROM ".$this->db->prefix('rmgs_categos')." WHERE id_cat='$id'");
			if ($this->db->getRowsNum($result)<=0){ $this->setVar('found', false); return false; }
			$row = $this->db->fetchArray($result);
			$this->setVar('nombre',$row['nombre']);
			$this->setVar('fecha',$row['fecha']);
			$this->setVar('id',$id);
			$this->setVar('desc',$row['desc']);
			$this->setVar('parent',$row['parent']);
			$this->setVar('found', true);
			return true;
		} else {
			$this->setNew();
			return true;
		}
	}
	/**
	 * Obetiene las imágenes que pertenecen a una categoría
	 */
	function getImages(){
		$dHan = new GSDataHandler($this->db);
		return $imgHan->imagesByCatego($this->getVar('id'));
	}
	/**
	 * Obtiene el numero de imágenes que pertenecen a la
	 * ca<textaría
	 */
	function getImagesNum(){
		$result = $this->db->query("SELECT COUNT(*) FROM ".$this->db->prefix("rmgs_imglink")." WHERE id_cat='".$this->getVar('id')."'");
		list($num) = $this->db->fetchRow($result);
		return $num;
	}
	/**
	 * Obtenemos los grupos con permisos de acceso
	 * @return array con identificadores de los grupos
	 */
	function getGroups(){
		$sql = "SELECT * FROM ".$this->db->prefix("rmgs_groups")." WHERE id_cat='".$this->getVar('id')."'";
		$result = $this->db->query($sql);
		$rtn = array();
		while ($row = $this->db->fetchArray($result)){
			$rtn[] = $row['id_grp'];
		}
		return $rtn;
	}
	
	/**
	 * Obtenemos los grupos con permsos de escritura
	 */
	function getWrites(){
		$sql = "SELECT * FROM ".$this->db->prefix("rmgs_writes")." WHERE id_cat='".$this->getVar('id')."'";
		$result = $this->db->query($sql);
		$rtn = array();
		while ($row = $this->db->fetchArray($result)){
			$rtn[] = $row['id_grp'];
		}
		return $rtn;
	}
	
	/** 
	 * Comprobamos los permisos del usuario
	 * @param object $user Usuario XOOPS
	 * @return boolean
	 */
	function canView(&$user){
		
		$permisos = array();
		$permisos = $this->getGroups();
		if (count($permisos)<=0){  return true; }
		
		if (in_array(0,$permisos)){ return true; }
	
		if ($user=='' && !in_array(0, $permisos)){
			return false;
		}
		
		if ($user->isAdmin()){ return true; }
	
		foreach ($user->getGroups() as $k => $v){
			if (in_array($v, $permisos)){
				return true;
			}
		}
		return false;
	}
}

?>