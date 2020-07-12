<?php
/*******************************************************************
* $Id: vote.php 2 2006-12-11 20:49:07Z BitC3R0 $             *
* ----------------------------------------------------             *
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
* ----------------------------------------------------             *
* vote.php:                                                        *
* Archivo para realizar votos por la imagenes                      *
* ----------------------------------------------------             *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.1                                                  *
* @modificado: 28/12/2005 09:34:27 p.m.                            *
*******************************************************************/
$rmgs_location = 'votos';
include 'header.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$voto = isset($_GET['voto']) ? $_GET['voto'] : 0;

if ($id<=0){ 
	echo "<script type='text/javascript'><!-- window.close(); --></script>";
	die();
}

if ($voto<=0){
	echo "<script type='text/javascript'><!-- window.close(); --></script>";
	die();
}

/**
* Comprobamos si el usuario tiene permisos para votar
**/
if ($xoopsUser == '' && !$xoopsModuleConfig['anovote']){
	rmgsWriteMsgVote(_RMGS_CANNOT);
	die();
}

if ($xoopsUser == ''){ $vote_user = 0; } else { $vote_user = $xoopsUser->getVar('uid'); }

/**
 * Comprobamos que exista la imagen
 */
$image = new GSImage($id);

if (!$image->getVar('found')){
	rmgsWriteMsgVote(_RMGS_IMG_NOTFOUND);
	die();
}

/**
* Comprobamos que un usuario no vote dos veces
* por la misma imágen
**/
include('include/rmgs_votes.php');
if ($vote_user == 0){
	/**
	* Si es un usuario anónimo comprobamos que haya transcurrido
	* un dia desde su último voto
	**/
	if (rmgsVoteToday($id)){
		rmgsWriteMsgVote(_RMGS_ONEVOTEDAY);
		die();
	}
	/**
	* Asignamos el voto a la descarga seleccionada
	**/
	if (rmgsSetVoteAnonym($id, $voto)){
		rmgsWriteMsgVote(_RMGS_VOTE_THX);
		die();
	} else {
		rmgsWriteMsgVote(_RMGS_VOTE_ERR);
		die();
	}
} else {
	/**
	* Si el usuario esta registrado impedimos que
	* vote dos veces por el mismo recurso
	**/
	if (rmgsUserVoted($id, $vote_user)){
		rmgsWriteMsgVote(_RMGS_NOVOTE_TWICE);
		die();
	}
	
	/**
	* Agregamos el voto a la descarga
	**/
	if (rmgsSetVote($id, $vote_user, $voto)){
		rmgsWriteMsgVote(_RMGS_VOTE_THX);
		die();
	} else {
		rmgsWriteMsgVote(_RMGS_VOTE_ERR . "<br>". $db->error());
		die();
	}

}
?>

