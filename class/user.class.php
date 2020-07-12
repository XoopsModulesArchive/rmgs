<?php
/*******************************************************************
* $Id: user.class.php 2 2006-12-11 20:49:07Z BitC3R0 $       *
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
* user.class.php:                                                  *
* Clase para el manejo de los usuarios que publican fotografías    *
* en el módulo.                                                    *
* ----------------------------------------------------------       *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.3                                                  *
* @modificado: 24/12/2005 02:57:42 p.m.                            *
*******************************************************************/

include_once XOOPS_ROOT_PATH.'/modules/rmgs/class/gsobject.class.php';

/**
 * Nos aseguramos que exista el lenguage buscado
 */
if (file_exists(XOOPS_ROOT_PATH . '/modules/rmgs/language/' . $xoopsConfig['language'] . '/users.php')) {
	include_once XOOPS_ROOT_PATH. '/modules/rmgs/language/' . $xoopsConfig['language'] . '/users.php';
} else {
	include_once XOOPS_ROOT_PATH . '/modules/rmgs/language/spanish/users.php';
}

class GSUser extends GSObject
{

	var $_xUser = null; 				// Almacena los datos del usuario XOOPS
	var $_wCategos = array();
	/**
	 * Cargamos las variables generales de la clase
	 */
	function GSUser($id, $new=true, $limit=0){
		
		if ($id<=0){ return false; }
		$this->db =& Database::getInstance();
		$this->_xUser = new XoopsUser($id);
		
		$this->initVar('id',$id);
		$this->initVar('votos',0);
		$this->initVar('rating',0);
		$this->initVar('limit',0);
		$this->initVar('storedir','');
		$this->initVar('webdir', '');
		$this->initVar('used',0);
		$this->initVar('imgcount',0);
		$this->initVar('setscount',0);
		$this->initVar('results',0);
		
		if ($new){
			$this->newUser($limit);
		}
		
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmgs_users")." WHERE uid='$id'");
		$num = $this->db->getRowsNum($result);
		if ($num<=0){ return false; }
		
		$row = $this->db->fetchArray($result);
		$this->setVar('id', $id);
		$this->setVar('votos', $row['votos']);
		$this->setVar('rating', $row['rating']);
		$this->setVar('limit', $row['limit']);
		$this->setVar('results', $row['results']);
		$this->setVar('imgcount', $this->imageCount());
		$this->setVar('setscount', $this->setsCount());
		$dir = rmgsMakeUserDir($this->getVar('id'));
		$dir = rmgsAddSlash($dir);
		$this->setVar('storedir', $dir);
		$this->setVar('webdir', rmgsWebDir($id));
		
	}
	/**
	 * Redefinimos la función getVar
	 */
	function getVar($var, $type=0, $format='s'){
		if (isset($this->vars[$var])){
			return parent::getVar($var, $type);
		} else {
			if (is_object($this->_xUser)){ return $this->_xUser->getVar($var, $format); }
		}
	}
	/**
	 * Creamos un nuevo usuario
	 * @params int $limit Limite de almacenamiento
	 */
	function newUser($limit){
		$result = $this->db->query("SELECT COUNT(*) FROM ".$this->db->prefix("rmgs_users")." WHERE uid='".$this->getVar('id')."'");
		list($num) = $this->db->fetchRow($result);
		if ($num>0){ 
			//$this->addError(_CU_ERR_EXISTS);
			return true;
		}
		
		$sql = "INSERT INTO ".$this->db->prefix("rmgs_users")." (`limit`,`rating`,`votos`,`uid`)
				VALUES ('$limit','0','0','".$this->getVar('id')."')";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
		
	}
	/**
	 * Obtenemos la cuota utilizada actualmente
	 */
	function getUsed(){
		if ($this->getVar('storedir')==''){
			$this->addError(_CU_ERR_NODIR);
			return false;
		}
		$total = $this->getDirSize($this->getVar('storedir'));
		$this->setVar('used', $total);
		return $total;
	}
	/**
	 * Comprobamos si el usuario ha alcanzado
	 * el límite de su cuata de almacenamiento
	 * @return array 0 = usuado, 1 = Libre
	 */
	function checkQuota(){
		$usado = $this->getUsed();
		$quota = $this->getVar('limit');
		$ret = array();
		$ret[] = $usado;
		$ret[] = $quota - $usado;
		return $ret;
	}
	/**
	 * Leemos un directorio y sus archivos
	 */
	function getDirSize($dir){
		$dir = rmgsAddSlash($dir);
		$total = 0;
		$gestor = opendir($dir);
		while (false !== ($archivo = readdir($gestor))) {
       		if (is_dir($dir . $archivo) && $archivo != '.' && $archivo != '..'){
				$total += $this->getDirSize($dir . $archivo);
			} else {
				$total += filesize($dir . $archivo);
			}
   		}
		
		return $total;
	}
	/**
	 * Obtenemos el total de imágenes que posee el usuario
	 */
	function imageCount(){
		$sql = "SELECT COUNT(*) FROM ".$this->db->prefix('rmgs_imgs')." WHERE idu='".$this->getVar('uid')."'";
		list($num) = $this->db->fetchRow($this->db->query($sql));
		return $num;
	}
	/**
	 * Obtenemos el total de albumes que posee el usuario
	 */
	function setsCount(){
		$sql = "SELECT COUNT(*) FROM ".$this->db->prefix('rmgs_sets')." WHERE idu='".$this->getVar('uid')."'";
		list($num) = $this->db->fetchRow($this->db->query($sql));
		return $num;
	}
	/**
	 * Establecemos una nueva quota de almacenamiento para el usuari9o
	 * @param int @quota mayor que 0
	 */
	function setQuota($quota){
		if ($quota<=0){ 
			$this->addError(_CY_ERR_QUOTA0);
			return false; 
		}
		
		$sql = "UPDATE ".$this->db->prefix('rmgs_users')." SET `limit`='".($quota * 1024 * 1024)."' WHERE uid='".$this->getVar('id')."'";
		$this->db->query($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Establecemos el numero de resultados por página
	 */
	function setResults($results){
		$sql = "UPDATE ".$this->db->prefix("rmgs_users")." SET results='$results' WHERE uid='".$this->getVar('id')."'";
		$this->db->query($sql);
		$this->setVar('results', $results);
	}
	/**
	 * Función para agregar una imágen a favoritos
	 * del usuario actual
	 * @param int $id Id de la imágen
	 */
	function addFavorite($id){
		$tbl = $this->db->prefix("rmgs_favorites");
		list($num) = $this->db->fetchRow($this->db->query("SELECT COUNT(*) FROM $tbl WHERE id_user='".$this->getVar('id')."' AND id_img='$id'"));
		if ($num>0){ $this->addError(_CU_ERR_FAVEXIST); return false; }
		$this->db->queryF("INSERT INTO $tbl (`id_user`,`id_img`,`fecha`) VALUES ('".$this->getVar('id')."','$id','".time()."')");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Función para eliminar una imágen de 
	 * los favoritos de un usuario
	 * @param int $id Id de la imágen
	 */
	function deleteFavorite($id){
		$tbl = $this->db->prefix("rmgs_favorites");
		$this->db->queryF("DELETE FROM $tbl WHERE id_user='".$this->getVar('id')."' AND id_img='$id'");
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Función para obtener los identificadores
	 * de las categorías en las que el usuario
	 * puede escribir
	 */
	function getWriteCategos(){
		
		if (!empty($this->_wCategos)){
			return $this->_wCategos;
		}
		
		$tbl = $this->db->prefix("rmgs_writes");
		
		$where = '';
		foreach ($this->_xUser->getGroups() as $k){
			$where .= "id_grp='$k' OR ";
		}
		
		if ($where == ''){ return; }
		
		$where = substr($where, 0, strlen($where) - 3);
		
		$result = $this->db->query("SELECT id_cat FROM $tbl WHERE $where GROUP BY id_cat");
		$rtn = array();
		while ($row = $this->db->fetchArray($result)){
			$rtn[] = $row['id_cat'];
		}
		
		$this->_wCategos = $rtn;
		return $this->_wCategos;
		
	}
	
}
?>