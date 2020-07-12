 <?php
/*******************************************************************
* $Id: image.class.php 2 2006-12-11 20:49:07Z BitC3R0 $      *
* -----------------------------------------------------------      *
* RMSOFT Gallery System 2.0                                        *
* Sistema Avanzado de Galeras                                     *
* CopyRight  2005 - 2006. Red Mxico Soft                         *
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
* image.class.php: Manejo de palabras clave                        *
* -----------------------------------------------------------      *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.3                                                  *
* @modificado: 22/12/2005 07:07:47 p.m.                            *
*******************************************************************/

include_once XOOPS_ROOT_PATH.'/modules/rmgs/class/gsobject.class.php';
include_once XOOPS_ROOT_PATH.'/modules/rmgs/class/key.class.php';

class GSImage extends GSObject
{

	var $_categos = array();
	var $_idCategos = array();
	var $_sizes = array();

	function GSImage($id=null){
		/**
		 * Inicializamos las variables
		 */
		$this->initVar('id','');
		$this->initVar('title','');
		$this->initVar('file','',true);
		$this->initVar('uid','',true);
		$this->initVar('date','');
		$this->initVar('update','');
		$this->initVar('votes','');
		$this->initVar('downloads','');
		$this->initVar('categos','');
		$this->initVar('keys','');
		$this->initVar('stringkeys','');
		$this->initVar('maxkey','');
		$this->initVar('minkey','');
		$this->initVar('found', '');
		$this->initVar('rating', '');
		$this->initVar('home',0);
		
		$this->db =& Database::getInstance();
		
		if (is_null($id)){
			$this->setNew();
			return;
		}
		
		$sql = "SELECT * FROM ".$this->db->prefix("rmgs_imgs")." WHERE id_img='$id'";
		$result = $this->db->query($sql);
		if ($this->db->getRowsNum($result)<=0){ $this->setVar('found', false); return; }
		
		$row = $this->db->fetchArray($result);
		
		$this->setVar('id',$id);
		$this->setVar('title',$row['titulo']);
		$this->setVar('file',$row['file']);
		$this->setVar('uid',$row['idu']);
		$this->setVar('date',$row['fecha']);
		$this->setVar('update',$row['update']);
		$this->setVar('votes',$row['votos']);
		$this->setVar('downloads',$row['descargas']);
		$this->setVar('categos',$this->getCategosId());
		$this->setVar('keys',$this->getKeys());
		$this->setVar('stringkeys', $this->getStringKeys());
		$this->setVar('found', true);
		$this->setVar('rating', $row['rating']);
		$this->setVar('home', $row['home']);
		$this->getSizes();
		return true;
	}
	/**
	 * Creamos las categoras
	 * @param array $categos Identificadores de las categoras
	 * @param string $categos Identificadores delimitados por comas (,)
	 */
	function setCategos($categos){
		
		if (is_array($categos)){
			$this->setVar('categos', $categos);
		} else {
			$cats = array();
			$cats = explode(',',str_replace(" ","",$categos));
			$this->setVar('categos', $cats);
		}
		
	}
	/**
	 * Obtenemos la lista de Categoras
	 */
	function getCategos(){
		if (!empty($this->_categos)){ return $this->_categos; }
		$categos = array();
		$tbl1 = $this->db->prefix("rmgs_imglink");
		$tbl2 = $this->db->prefix("rmgs_categos");
		$result = $this->db->query("SELECT $tbl2.* FROM $tbl1, $tbl2 WHERE $tbl1.id_img='".$this->getVar('id')."' AND $tbl2.id_cat=$tbl1.id_cat");
		while ($row=$this->db->fetchArray($result)){
			$categos[] = $row;
		}
		$this->_categos = $categos;
		return $categos;
	}
	/**
	 * Obtenemos los dientificadores de las categoras
	 * a las que pertenece una imgen
	 */
	function getCategosId(){
		if (!empty($this->_idCategos)){ return $this->_idCategos; }
		$categos = array();
		$result = $this->db->query("SELECT id_cat FROM ".$this->db->prefix("rmgs_imglink")." WHERE id_img='".$this->getVar('id')."'");
		while ($row=$this->db->fetchArray($result)){
			$categos[] = $row['id_cat'];
		}
		$this->_idCategos = $categos;
		return $this->_idCategos;
	}
	/**
	 * Obtenemos la cadena de palabras clave
	 */
	function getStringKeys(){
		if (!is_array($this->getVar('keys'))){ return; }
		
		$keys = $this->getVar('keys');
		$ret = '';
		foreach ($keys as $k => $v){
			$ret .= $v['key']." ";
		}
		
		$ret = trim($ret);
		return $ret;
	}
	/**
	 * Obtenemos las palabras clave de una imgen
	 * @return array con identificacdores de las palabras clave
	 **/
	function getKeys(){
		$keys = array();
		$tbl1 = $this->db->prefix("rmgs_keylink");
		$tbl2 = $this->db->prefix("rmgs_keys");
		$result = $this->db->query("SELECT $tbl2.* FROM $tbl1, $tbl2 WHERE $tbl1.img='".$this->getVar('id')."' AND $tbl2.id_key=$tbl1.key");
		while ($row=$this->db->fetchArray($result)){
			$keys[] = $row;
		}
		return $keys;
	}
	/**
	 * Guardamos una nueva imgen
	 */
	function save(){
		$sql = "INSERT INTO ".$this->db->prefix("rmgs_imgs")." (`titulo`,`file`,`idu`,`fecha`,`update`,`votos`,`descargas`)
				VALUES ('".$this->getVar('title',2)."','".$this->getVar('file')."',
				'".$this->getVar('uid')."','".$this->getVar('date')."','".$this->getVar('update')."',
				'".$this->getVar('votes')."','".$this->getVar('downloads')."')";
		$this->db->query($sql);
		$this->setVar('id', $this->db->getInsertId());
		
		// Almacenamos las categoras
		$datos = $this->getVar('categos');
		foreach ($datos as $k){
			$this->db->query("INSERT INTO ".$this->db->prefix("rmgs_imglink")." (`id_img`,`id_cat`)
					VALUES ('".$this->getVar('id')."','$k');");
		}
		
		// Almacenamos las palabras clave
		$datos = explode(" ",$this->getVar('stringkeys'));
		$idk = 0;
		$key = new GSKey();
		foreach ($datos as $k){
			if (strlen($k) >= $this->getVar('minkey') && strlen($k) <= $this->getVar('maxkey')){
				$key->setVar('text',strtolower($k));
				$idkey = $key->save();
				if ($idkey>0){
					$this->db->query("INSERT INTO ".$this->db->prefix("rmgs_keylink")." (`key`,`img`)
						VALUES ('$idkey','".$this->getVar('id')."');");
				}
			}
		}
	}
	
	/**
	 * Guardamos los cambios realizados a una imgen
	 */
	function saveChanges(){
		if ($this->getVar('id')<=0){ return; }
		$sql = "UPDATE ".$this->db->prefix("rmgs_imgs")." SET `titulo`='".$this->getVar('title',2)."',
				`file`='".$this->getVar('file')."',`idu`='".$this->getVar('uid')."',
				`votos`='".$this->getVar('votes')."',`descargas`='".$this->getVar('downloads')."',
				`update`='".time()."' WHERE id_img='".$this->getVar('id')."'";
		$this->db->query($sql);
		
		if ($this->db->error()!=''){ return false; }
		// Guardamos las relaciones entre categorias e imagenes
		$datos = $this->getVar('categos');
		$this->db->query("DELETE FROM ".$this->db->prefix("rmgs_imglink")." WHERE id_img='".$this->getVar('id')."'");

		foreach ($datos as $k){
			$this->db->query("INSERT INTO ".$this->db->prefix("rmgs_imglink")." (`id_img`,`id_cat`)
					VALUES ('".$this->getVar('id')."','$k');");
		}
		
		// Guardamos las palabras clave
		$datos = explode(" ",$this->getVar('stringkeys'));
		$this->db->query("DELETE FROM ".$this->db->prefix("rmgs_keylink")." WHERE img='".$this->getVar('id')."'");
		$key = new GSKey();
		foreach ($datos as $k){
			if (strlen($k) >= $this->getVar('minkey') && strlen($k) <= $this->getVar('maxkey')){
				$key->setVar('text',$k);
				$idkey = $key->save();
				if ($idkey>0){
					$this->db->query("INSERT INTO ".$this->db->prefix("rmgs_keylink")." (`key`,`img`)
						VALUES ('$idkey','".$this->getVar('id')."');");
				}
			}
		}
		
		return true;
		
	}
	/**
	 * Cargamos los tamaos adicionales para una imgen
	 */
	function getSizes(){
		if (!empty($this->_sizes)){ return $this->_sizes; }
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmgs_sizes")." WHERE id_img='".$this->getVar('id')."'");
		$rtn = array();
		while ($row=$this->db->fetchArray($result)){
			$rtn[] = $row;
		}
		$this->_sizes = $rtn;
		return $this->_sizes;
	}
	/**
	 * Numero total de diferentes tamaños
	 */
	function getSizesCount(){
		if (!is_array($this->getVar('sizes'))){
			return 0;
		} else {
			return count($this->getVar('sizes'));
		}
	}
	/**
	 * Agregamos un nuevo tamao a la imgen
	 */
	function addSize($title, $file, $type=0){
		if ($this->getVar('id')<=0){ return false; }
		if ($title=='') { return false; }
		if ($file==''){ return false; }
		
		$sql = "INSERT INTO ".$this->db->prefix("rmgs_sizes")." (`titulo`,`id_img`,`file`,`type`)
				VALUES ('$title','".$this->getVar('id')."','$file','$type')";
		$this->db->query($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Eliminar los tamaos registrados para esta imgen
	 * @param string $dir Directorio donde se ubican los distintos tamaos
	  * $dir debe contener la diagonal al final (/)
	 */
	function delSizes($dir){
		$result = $this->db->queryF("SELECT * FROM ".$this->db->prefix("rmgs_sizes")." WHERE id_img='".$this->getVar('id')."'");
		while ($row=$this->db->fetchArray($result)){
			unlink ($dir . $row['file']);
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_sizes")." WHERE id_img='".$this->getVar('id')."'");
	}
	/** 
	 * Eliminamos una imgen
	 * @param string $dir Directorio donde se ubican las imgenes
	 * Se require la diagonal al final (/)
	 */
	function delete(){
		$dir = rmgsMakeUserDir($this->getVar('uid'));
		$dir = rmgsAddSlash($dir);
		unlink ($dir . $this->getVar('file'));
		unlink ($dir . 'ths/' . $this->getVar('file'));
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_imglink")." WHERE id_img='".$this->getVar('id')."'");
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_keylink")." WHERE img='".$this->getVar('id')."'");
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_favoritos")." WHERE id_img='".$this->getVar('id')."'");
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_postales")." WHERE id_img='".$this->getVar('id')."'");
		
		foreach ($this->getSizes() as $k => $v){
			unlink($dir . 'sizes/' . $v['file']);
		}
		
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_sizes")." WHERE id_img='".$this->getVar('id')."'");
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_votes")." WHERE id_img='".$this->getVar('id')."'");
		
		//$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_setlink")." WHERE id_img='".$this->getVar('id')."'");
		$this->db->queryF("DELETE FROM ".$this->db->prefix("rmgs_imgs")." WHERE id_img='".$this->getVar('id')."'");
		
		
		$this->delSizes($dir . 'sizes/');
	}
	/**
	 * Incrementamosx en uno las descargas de la imgen
	 */
	function plusDownloads(){
		$sql = "UPDATE ".$this->db->prefix("rmgs_imgs")." SET `descargas`=`descargas`+1 WHERE id_img='".$this->getVar('id')."'"; 
		$this->db->queryF($sql);
		$this->setVar('downloads', $this->getVar('downloads')+1);
	}
	/**
	 * Proporciona el directorio web donde radica
	 * la imgen para la pgina inicial (Si existe)
	 */
	function getHomeImage(){
		global $mc;
		
		$user = new GSUser($this->getVar('uid'));
		$web = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $mc['storedir']);
		$web = rmgsAddSlash($web);
		$xv = str_replace("XOOPS ", '',XOOPS_VERSION);
		if (substr($xv, 2, 1)=='2'){ $field = 'loginname'; } else { $field = 'uname'; }
		return $web.'homes/'.$user->getVar($field).$this->getVar('file');		
	}
}
?>