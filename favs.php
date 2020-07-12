<?php
/*******************************************************************
* $Id: favs.php 2 2006-12-11 20:49:07Z BitC3R0 $             *
* ----------------------------------------------------             *
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
* ----------------------------------------------------             *
* favs.php:                                                        *
* Archivo que permite agregar, eliminar o modificar una            *
* imgen de los "favoritos" de un usuario especfico.              *
* ----------------------------------------------------             *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.2                                                  *
* @modificado: 24/02/2006 12:25:13 p.m.                            *
*******************************************************************/
$rmgs_location = 'favoritos';
include 'header.php';

/**
 * Verificamos que el usuario haya ingresado
 * de lo contrario no podr ver sus favoritos
 */
if (!is_object($xoopsUser)){
	redirect_header(XOOPS_URL.'/user.php', 1, _RMGS_NOALLOWED);
	die();
}

/**
 * Cargamos la URL de retorno
 */
$return = isset($_GET['ret']) ? $_GET['ret'] : (isset($_POST['ret']) ? $_POST['ret'] : '');
if ($return!=''){ $return = base64_decode($return); }

$op = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : '');

switch ($op){
	case 'add':
		$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
		if ($id<=0){
			if ($return!=''){ 
				header('location: '.$return); die(); 
			} else {
				header('location: '.XOOPS_URL.'/modules/rmgs'); die(); 
			}
		}
		
		$user = new GSUser($xoopsUser->getVar('uid'), true, $mc['quota'] * 1024 * 1024);
		if ($user->addFavorite($id)){
			header('location: favs.php?ret='.base64_encode($return));
			die();
		} else {
			redirect_header("favs.php?ret=".base64_encode($return), 2, $user->errors());
			die();
		}
		
		break;
	case 'del':
		$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
		if ($id<=0){
			if ($return!=''){ 
				header('location: '.$return); die(); 
			} else {
				header('location: '.XOOPS_URL.'/modules/rmgs'); die(); 
			}
		}
		$user = new GSUser($xoopsUser->getVar('uid'), true, $mc['quota'] * 1024 * 1024);
		if ($user->deleteFavorite($id)){
			header('location: favs.php?ret='.base64_encode($return));
			die();
		} else {
			redirect_header("favs.php?ret=".base64_encode($return), 2, $user->errors());
			die();
		}
		
		break;
	default:
		/**
		 * Mostramos la lista de favoritos existentes
		 */
		include_once 'include/search.func.php';
		include_once 'include/categos.func.php';
		
		/**
		 * Establecemos los resultados por pagina
		 */
		$user = new GSUser($xoopsUser->getVar('uid'), true, $mc['quota'] * 1024 * 1024);
		rmgsSetResults($user);
		rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
		/**
 		* Obtenemos las imgenes de la categora
 		*/
		rmgsSearchInFavorites($xoopsUser->getVar('uid'), $_SESSION['rmgs_results']);
		
		$xoopsOption['template_main'] = "rmgs_favorites.html";
		
		rmgsMakeNav();
		/**
		 * Creamos el campo select de las categorias
		 */
		rmgsMakeCategoSelect();
		/**
		 * Barra de Localizacin
		 */
		$location = "<strong>::</strong> <a href='".XOOPS_URL."/modules/rmgs/'>$mc[modtitle]</a> ";
		$location .= "<img src='images/arrow.gif' align='absmiddle' border='0' /> ";
		$location .= "<a href='favs.php'>"._RMGS_FAVORITES."</a>";
		$tpl->assign('location_bar', $location);
		/**
		 * Creamos la nevegacin de resultados
		 */
		for($i=$mc['columns'];$i<=($mc['columns'] * 6);$i += $mc['columns']){
			if ($i==$_SESSION['rmgs_results']){
				$tpl->append('results', array('num'=>$i, 'selected'=>true));
			} else {
				$tpl->append('results', array('num'=>$i, 'selected'=>false));
			}
		}
		$tpl->assign('columns', $mc['columns']);
		$tpl->assign('colw', (int)(100 / $mc['columns']));
		$xoopsTpl->assign('lang_by', _RMGS_BY);
		$xoopsTpl->assign('lang_since', _RMGS_SINCE);
		$tpl->assign('lang_resxpag',_RMGS_RESULTS);
		$xoopsTpl->assign('title_favorites', _RMGS_FAVORITES);
		if ($return!=''){
			$tpl->assign('lang_back',_RMGS_PREV_PAGE);
			$tpl->assign('return', $return);
			$tpl->assign('return_encode', base64_encode($return));
		}
}

include 'footer.php';
?>

