<?php
/*******************************************************************
* $Id: categos.php 2 2006-12-11 20:49:07Z BitC3R0 $          *
* -------------------------------------------------------          *
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
* -------------------------------------------------------          *
* categos.php:                                                     *
* Control de Categoras del mdulo                                 *
* -------------------------------------------------------          *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.1                                                  *
* @modificado: 27/12/2005 03:03:52 p.m.                            *
*******************************************************************/

include 'header.php';

$xoopsOption['template_main'] = 'rmgs_categos.html';

include 'include/categos.func.php';
include 'include/search.func.php';

$xoopsTpl->assign('return', base64_encode($_SERVER['REQUEST_URI']));

$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
if ($id<=0){
	header('location: index.php');
	die();
}

/**
 * Cargamos las subcategorias
 */
getCategos($id);

$catego = new GSCategory($id);
if (!$catego->canView($xoopsUser)){
	redirect_header('index.php', 1, _RMGS_NOALLOWED);
	die();
}

$tpl->assign('catego', array('id'=>$catego->getVar('id'),'title'=>$catego->getVar('nombre'),
		'fecha'=>date($mc['format_date'],$catego->getVar('fecha')),
		'desc'=>$catego->getVar('desc', 1)));

rmgsMakeNav();

if ($xoopsUser != ''){
	$user = new GSUser($xoopsUser->getVar('uid'), false, $mc['quota'] * 1024 * 1024);
	rmgsMakeProgress($user->getUsed(), $user->getVar('limit'));
}

/**
 * Establecemos los resultados por pagina
 */
rmgsSetResults($user);
/**
 * Obtenemos las imgenes de la categora
 */
rmgsSearchInCatego($_SESSION['rmgs_results']);
/**
 * Creamos el campo select de las categorias
 */
rmgsMakeCategoSelect();

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
$xoopsTpl->assign('lang_categos', _RMGS_SUBCATEGOS);

include 'footer.php';
?>
