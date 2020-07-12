<?php
/*******************************************************************
* $Id: key.class.php 2 2006-12-11 20:49:07Z BitC3R0 $        *
* ---------------------------------------------------------        *
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
* ---------------------------------------------------------        *
* key.class.php: Manejo de palabras clave                          *
* ---------------------------------------------------------        *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.2                                                  *
* @modificado: 22/12/2005 07:06:31 p.m.                            *
*******************************************************************/

include_once XOOPS_ROOT_PATH.'/modules/rmgs/class/gsobject.class.php';

class GSKey extends GSObject
{
	function GSKey($id = ''){
		$this->initVar('text','', true);
		$this->initVar('points',0);
		$this->initVar('id','');
		$this->initVar('found',false);
		
		$this->db =& Database::getInstance();
		
		if (is_null($id)){
			$this->setNew();
			return;
		}
		
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmgs_keys")." WHERE id_key='$id' OR `key`='$id'");
		$num = $this->db->getRowsNum($result);
		
		if ($num<=0){ $this->setVar('found', false); return; }
		
		$row = $this->db->fetchArray($result);
		
		$this->setVar('id', $row['id_key']);
		$this->setVar('text', $row['key']);
		$this->setVar('points', $row['points']);
		$this->setVar('found', true);
		
		return true;
	}
	
	function save(){
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmgs_keys")." WHERE `key`='".$this->getVar('text')."'");
		$num = $this->db->getRowsNum($result);
		if ($num<=0){
			$this->db->query("INSERT INTO ".$this->db->prefix("rmgs_keys")." (`key`,`points`) 
					VALUES ('".$this->getVar('text')."','".$this->getVar('points')."');");
			return $this->db->getInsertId();
		} else {
			$row = $this->db->fetchArray($result);
			return $row['id_key'];
		}
	}
	
	function setPoint(){
		$tbl = $this->db->prefix("rmgs_keys");
		$this->db->queryF("UPDATE $tbl SET `points`=`points`+1 WHERE id_key='".$this->getVar('id')."'");
		echo $this->db->error();
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
}
?>