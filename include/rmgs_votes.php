<?php
/*******************************************************************
* $Id: rmgs_votes.php 2 2006-12-11 20:49:07Z BitC3R0 $       *
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
* rmgs_votes.php:                                                  *
* Funciones para manejar votos de los usuarios                     *
* ----------------------------------------------------------       *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.1                                                  *
* @modificado: 29/12/2005 12:57:09 p.m.                            *
*******************************************************************/

/**
* Determina si un usuario anonimo ha votado
* el día de hoy un recurso
* 
* @param int $id = Id de la imágen
* @return boolean
**/
function rmgsVoteToday($id){
	global $db;
	
	if ($id<=0){ return false; }
	$ip = getenv("REMOTE_ADDR");
	// Obtenemos el tiempo de hace 24 horas
	$yest = time() - 86400;
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix('rmgs_votes')." WHERE id_img='$id' AND ip='$ip' AND fecha > $yest"));
	if ($num<=0){ 
		return false; 
	} else {
		return true;
	}
	
}

/**
 * Almacena el voto del usuario anónimo e incrementa las estadísticas
 * ---------------------------------------------
 * @param int $id Identificador de la imágen
 * @param int $rate Valor del voto a registrar
 * @return boolean True si todo se realizo con exito
 **/
function rmgsSetVoteAnonym($id, $rate){
	global $db;
	
	$ip = getenv("REMOTE_ADDR");
	$fecha = time();
	$db->queryF("INSERT INTO ".$db->prefix('rmgs_votes')." (`id_img`,`uid`,`ip`,`fecha`)
			VALUES ('$id','0','$ip','$fecha') ;");
	
	if ($db->error() != ''){
		return false;
	}
	
	$db->queryF("UPDATE ".$db->prefix('rmgs_imgs')." SET `votos`=votos+1, `rating`=rating+$rate
		WHERE id_img='$id'");
		
	if ($db->error() != ''){
		return false;
	}
	
	return true;
		
}

/**
 * Almacena el voto de un usuario registrado
 * ------------------------------------------
 * @param int $id Identificador de la imágen
 * @param int $uid Identificador del usuario
 * @param int $rate Voto asignado
 * @return boolean True si todo se realizo con existo
 **/
function rmgsSetVote($id, $uid, $rate){
	global $db;
	
	$ip = getenv("REMOTE_ADDR");
	$fecha = time();
	$db->queryF("INSERT INTO ".$db->prefix('rmgs_votes')." (`id_img`,`uid`,`ip`,`fecha`)
			VALUES ('$id','$uid','$ip','$fecha') ;");
	
	if ($db->error() != ''){
		return false;
	}
	
	$db->queryF("UPDATE ".$db->prefix('rmgs_imgs')." SET `votos`=votos+1, `rating`=rating+$rate
		WHERE id_img='$id'");
		
	if ($db->error() != ''){
		return false;
	}
	
	return true;
	
}

/**
 * Comprueba si un usuario ha votado por un recurso
 * @param int $id Identificador de la imagen
 * @param int $uid Identificador del usuario
 **/
function rmgsUserVoted($id, $uid){
	global $db;
	
	if ($id<=0 || $uid<=0){ return false; }
	
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix('rmgs_votes')." WHERE id_img='$id' AND uid='$uid'"));
	if ($num<=0){ return false; } else { return true; }
}

/**
 * Escribe un mensaje de salida en la página
 */
function rmgsWriteMsgVote($msg){
	echo "<html><head><title>"._RMGS_TITPAGE."</title></head>
		  <body style='margin: 0px; background-color: #f5f5f5;'>
		  <div style='padding: 4px; border: 1px solid #CCCCCC; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; text-align: center; vertical-align: middle; width: 100%; height: 100px;'>
			<strong>".$msg."</strong><br /><br />
			<input style='font-size: 10px; border: 1px solid #CCCCCC;' type='button' name='close' value='"._RMGS_CLOSEW."' onclick='javascript: window.close();' />
		  </div></body></html>";
}
?>

