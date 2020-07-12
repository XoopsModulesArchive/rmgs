<?php
/*******************************************************************
* $Id: postal.class.php 2 2006-12-11 20:49:07Z BitC3R0 $     *
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
* postal.class.php:                                                *
* Clase para el manejo de postales                                 *
* ------------------------------------------------------------     *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.4                                                  *
* @modificado: 24/02/2006 05:17:20 p.m.                            *
*******************************************************************/

include_once XOOPS_ROOT_PATH.'/modules/rmgs/class/gsobject.class.php';

class GSPostal extends GSObject
{
	function GSPostal($id=''){
		
		$this->db =& Database::getInstance();
		
		if ($id==''){
			return true;
		}		
		
		$result = $this->db->query("SELECT * FROM ".$this->db->prefix("rmgs_postales")." WHERE id_postal='$id' OR codigo='$id'");
		if ($this->db->getRowsNum($result )<=0){ return false; }
		
		$row = $this->db->fetchArray($result);
		foreach ($row as $k => $v){
			$this->initVar($k, $v);
		}
		
		return true;
	}
	
	/** 
	 * funciones para asignar los valores a las postales
	 */
	function setImagen($value){ $this->initVar('id_img', $value); }
	function setTitulo($value){ $this->initVar('titulo', $value); }
	function setTexto($value){ $this->initVar('texto', $value); }
	function setUser($value){ $this->initVar('idu', $value); }
	function setEmailSender($value){ $this->initVar('email_sender', $value); }
	function setNameSender($value){ $this->initVar('name_sender', $value); }
	function setEmailDest($value){ $this->initVar('email_dest', $value); }
	function setNameDest($value){ $this->initVar('name_dest', $value); }
	function setTemplate($value){ $this->initVar('plantilla', $value); }
	function setRedirect($value){ $this->initVar('redirect', $value); }
	
	/**
	 * Esta función crea una nueva postal
	 */
	function create(){
		$fecha = time();
		$codigo = md5($fecha . $this->getVar('email_dest') . $this->getVar('idu'));
		$this->initVar('codigo', $codigo);
		$this->initVar('fecha', $fecha);
		
		$tbl = $this->db->prefix("rmgs_postales");
		$sql = "INSERT INTO $tbl (`id_img`,`codigo`,`titulo`,`texto`,`idu`,`email_sender`,
				`name_sender`,`email_dest`,`name_dest`,`plantilla`,`fecha`,`redirect`) VALUES
				('".$this->getVar('id_img')."','".$this->getVar('codigo')."',
				'".$this->getVar('titulo')."','".$this->getVar('texto')."','".$this->getVar('idu')."',
				'".$this->getVar('email_sender')."','".$this->getVar('name_sender')."',
				'".$this->getVar('email_dest')."','".$this->getVar('name_dest')."',
				'".$this->getVar('plantilla')."','".$this->getVar('fecha')."',
				'".$this->getVar('redirect')."');";
		$this->db->queryF($sql);
		if ($this->db->error()!=''){
			$this->addError($this->db->error());
			return false;
		} else {
			return true;
		}
	}
	
	/** 
	 * Esta función despliega la plantilla para
	 * mostrarla en pantalla
	 * @param boolean $show True = Muestra como HTML, FALSE Lo gurada en una variable
	 */
	function display($show=true){
		
		$image = new GSImage($this->getVar('id_img'));
		$p = new GSPostalTemplate($this->getVar('plantilla'));

		$p->setImage(rmgsWebDir($image->getVar('uid')).'/'.$image->getVar('file'));
		$p->setImageName($image->getVar('title'));
		$p->setTitulo($this->getVar('titulo'));
		$p->setTexto($this->getVar('texto'));
		$p->setSenderName($this->getVar('name_sender'));
		$p->setSenderMail($this->getVar('email_sender'));
		$p->setDestName($this->getVar('name_dest'));
		$p->setDestMail($this->getVar('email_dest'));
		$p->setRedirect(base64_decode($this->getVar('redirect')));
		
		if ($show){
			echo $p->display();
		} else {
			return $p->display();
		}
	}
	
}

class GSPostalTemplate extends GSObject
{
	/** 
	 * Carga los valores de una plantilla
	 * @param string $id Nombre del directorio
	 */
	function GSPostalTemplate($id){
		
		$dir = XOOPS_ROOT_PATH . '/modules/rmgs/tpls/';
		
		$this->initVar('file',$dir . $id . '.tpl');
		$this->initVar('dir', $dir);
		$this->initVar('name', $id);
		$this->initVar('image');
		$this->initVar('image_name');
		$this->initVar('titulo');
		$this->initVar('texto');
		$this->initVar('sender_name');
		$this->initVar('sender_mail');
		$this->initVar('dest_name');
		$this->initVar('dest_mail');
		$this->initVar('redirect');

		if (!file_exists($dir.$id.'.tpl')){
			$this->addError('No existe la plantilla '. $id . '.tpl');
			return false;
		}
		
		return true;
		
	}
	
	function setName($value){ 
		if ($value==''){ return; }
		$this->setVar('name', $value); 
		$this->setVar('file', $this->getVar('dir') . $value .'.tpl');
	}
	
	/**
	 * Creamos un archivo deplantilla
	 * @param string $contenido Contenido del archivo (texto)
	 * @param boolean $overwrite Reemplaza el archivo si este existe
	 */
	function create($contenido,$overwrite=false){
		
		$myts = MyTextSanitizer::getInstance();
		
		$contenido = $myts->makeTareaData4Show($contenido, 1, 1, 0);
		
		if ($overwrite){
			if (!$g = fopen($this->getVar('file'), 'w')){
				$this->addError("No se puede abrir el archivo ".$this->getVar('name'));
				return false;
			}
			if (fwrite($g, $contenido) === FALSE){
				$this->addError("No se pudo escribir en el archivo ".$this->getVar('name'));
				return false;
			}
			return true;
		}
		
		if (file_exists($this->getVar('file'))){
			$this->addError("Ya existe el archivo".$this->getVar('name'));
			return false;
		}
		
		if (!$g = fopen($this->getVar('file'), 'w')){
			$this->addError("No se puede abrir el archivo ".$this->getVar('name'));
			return false;
		}
		if (fwrite($g, $contenido) === FALSE){
			$this->addError("No se pudo escribir en el archivo ".$this->getVar('name'));
			return false;
		}
		return true;
		
	}
	
	/**
	 * Obtenemos el contenido del archivo
	 */
	function getContent(){
		$g = fopen($this->getVar('file'), 'r');
		$contenido = fread($g, filesize($this->getVar('file')));
		fclose($g);
		return $contenido;
	}
	/**
	 * Funciones para asignar valores a la plantilla
	 */
	function setImage($value){
		$this->setVar('image',$value);
	}
	function setImageName($value){
		$this->setVar('image_name',$value);
	}
	function setTitulo($value){
		$this->setVar('titulo', $value);
	}
	function setTexto($value){
		$myts = MyTextSanitizer::getInstance();
		$value = $myts->makeTareaData4Show($value, 0, 1, 0);
		$this->setVar('texto', $value);
	}
	function setSenderName($value){
		$this->setVar('sender_name', $value);
	}
	function setSenderMail($value){
		$this->setVar('sender_mail', $value);
	}
	function setDestName($value){
		$this->setVar('dest_name', $value);
	}
	function setDestMail($value){
		$this->setVar('dest_mail', $value);
	}
	function setRedirect($value){
		$this->setVar('redirect', $value);
	}
	/**
	 * Esta función retorna la salida HTML de
	 * una plantilla. El contenido se lee del archivo
	 */
	function display(){
		global $tpl, $mc;
		
		$tpl->assign('rmgs_tpl_image', $this->getVar('image'));
		$tpl->assign('rmgs_tpl_imagename', $this->getVar('image_name'));
		$tpl->assign('rmgs_tpl_titulo', $this->getVar('titulo'));
		$tpl->assign('rmgs_tpl_text', $this->getVar('texto'));
		$tpl->assign('rmgs_tpl_sendername', $this->getVar('sender_name'));
		$tpl->assign('rmgs_tpl_sendermail', $this->getVar('sender_mail'));
		$tpl->assign('rmgs_tpl_destname', $this->getVar('dest_name'));
		$tpl->assign('rmgs_tpl_destmail', $this->getVar('dest_mail'));
		$tpl->assign('module_url', XOOPS_URL.'/modules/rmgs');
		$tpl->assign('page_title', $this->getVar('titulo') . ' - ' . $mc['modtitle']);
		$tpl->assign('module_name', $mc['modtitle']);
		$tpl->assign('rmgs_tpl_redirect', $this->getVar('redirect'));
		
		return $tpl->fetch($this->getVar('file'));
	}
}
?>