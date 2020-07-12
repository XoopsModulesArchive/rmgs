<?php
/*******************************************************************
* $Id: view.php 2 2006-12-11 20:49:07Z BitC3R0 $             *
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
* view.php:                                                        *
* Mostrar imgenes y guardar sus datos                             *
* ----------------------------------------------------             *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOGT GS v2.0                                         *
* @version: 0.1.2                                                  *
* @modificado: 28/12/2005 11:57:38 a.m.                            *
*******************************************************************/

$rmgs_location = 'details';
include 'header.php';

$cat = isset($_GET['cat']) ? $_GET['cat'] : 0;
$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
$id = isset($_GET['id']) ? $_GET['id'] : 1;
$q = isset($_GET['q']) ? $_GET['q'] : 'cat';

/**
 * Comprobamos que se hayan especificado una imagen
 * y una categora validas
 */
if ($id<=0){ redirect_header("categos.php?cat=$cat&amp;pag=$pag", 1, _RMGS_NOCAT); die(); }

/**
 * comprobamos que exista la imgen
 */
$image = new GSImage($id);
if (!$image->getVar('found')){ redirect_header("categos.php?cat=$cat&amp;pag=$pag", 1, _RMGS_IMG_NOTFOUND); die(); }

if ($cat<=0){
	$categos = $image->getCategosId();
	$cat = $categos[0];
}
/**
 * Comprobamos que exista la categora
 */
$catego = new GSCategory($cat);
if (!$catego->getVar('found')){ redirect_header('./', 1, _RMGS_CATEGO_NOTFOUND); die(); }
$tpl->assign('catego', array('id'=>$catego->getVar('id'),'title'=>$catego->getVar('nombre')));
/**
 * Comprobamos que el usuario tenga acceso a la categora
 */
if (!$catego->canView($xoopsUser)){
	redirect_header('./', 1, _RMGS_NOALLOWED);
	die();
}

$tpl->assign('return', base64_encode($_SERVER['REQUEST_URI']));
/**
 * Comprobamos que la imagen pertenezca a la categora espcificada
 */
if (!in_array($cat, $image->getCategosId())){
	redirect_header("categos.php?cat=$cat&amp;pag=$pag", 1, _RMGS_INVALID_METHOD);
	die();
}

$xoopsOption['template_main'] = 'rmgs_view.html';

/**
 * Asiganamos las variables a Smarty
 */
$dir = rmgsWebDir($image->getVar('uid'));
$width = getimagesize(rmgsMakeUserDir($image->getVar('uid')) . '/' . $image->getVar('file'));
$rate = rmgsGlobalRating();
$pop = rmgsGlobalPop();
$xoopsTpl->assign('image', array('id'=>$image->getVar('id'),
		'title'=>$image->getVar('title'),
		'file'=>$image->getVar('file'),
		'date'=>date($mc['format_date'],$image->getVar('date')),
		'votes'=>$image->getVar('votes'),
		'downloads'=>$image->getVar('downloads'),
		'keys'=>$image->getVar('stringkeys', 3),
		'update'=>$image->getVar('update'),
		'dir'=>$dir,'width'=>$width[0],
		'rating'=>rmgsGraphicRating($image->getVar('rating'),$rate),
		'pop'=>rmgsGraphicPop($image->getVar('downloads'), $pop),
		'sizes'=>$image->getSizes()));
$image->plusDownloads();
$user = new GSUser($image->getVar('uid'), false);
$xoopsTpl->assign('user', array('uid'=>$user->getVar('uid'),'uname'=>$user->getVar('uname')));

rmgsMakeNav();

/**
 * Obtenemos la imgen anterior y siguiente para
 * presentarlas como vinculos de navegacin
 */
include_once XOOPS_ROOT_PATH.'/modules/rmgs/include/images_functions.php';
$prev = rmgsPrevNext($id, $cat, 0, true);
$next = rmgsPrevNext($id, $cat, 1, true);

$tpl->assign('previmg', array('id'=>$prev['id_img'],'title'=>$prev['titulo'],
		'file'=>$prev['file'],'dir'=>rmgsWebDir($prev['idu'])));

$tpl->assign('nextimg', array('id'=>$next['id_img'],'title'=>$next['titulo'],
		'file'=>$next['file'],'dir'=>rmgsWebDir($next['idu'])));

/**
 * Creamos la barra de localizacin actual
 */
$location = rmgsLocation($cat, $q) . "<strong>";
if ($image->getVar('title')==''){
	$location .= _RMGS_IMG;
} else {
	$location .= $image->getVar('title', 3);
}
$location .= "<strong>";
$tpl->assign('location_bar', $location);

/**
 * Caragamos los diferentes tamaos
 */
/*
$tpl->assign('lang_available_sizes',_RMGS_AVAILABLE_SIZES);
foreach ($image->getVar('sizes') as $k => $v){
	$tpl->append('image_sizes', array('id'=>$v['id_size'],'titulo'=>$v['titulo'],'tipo'=>$v['type']));
}

/**
 * Cargamos las claves
 */
$tpl->assign('lang_keys',_RMGS_KEYS);
$tpl->assign('lang_sizes', _RMGS_SIZES);
foreach ($image->getKeys() as $k => $v){
	$tpl->append('image_keys', array('id'=>$v['id_key'],'text'=>$v['key']));
}

/**
 * Caragamos las categoras
 */
$tpl->assign('lang_belong',_RMGS_BELONG_TO);
foreach ($image->getCategos() as $k => $v){
	$tpl->append('image_categos',array('id'=>$v['id_cat'],'nombre'=>$v['nombre']));
}

/**
 * Cargamos las cadenas de lenguaje
 */
$tpl->assign('lang_prev',_RMGS_PREV);
$tpl->assign('lang_next',_RMGS_NEXT);
$tpl->assign('lang_title',_RMGS_DTITLE);
$tpl->assign('lang_votes',_RMGS_DVOTES);
$tpl->assign('lang_downs',_RMGS_DDOWNS);
$tpl->assign('lang_rate', _RMGS_DRATE);
$tpl->assign('lang_pop', _RMGS_DPOP);
$tpl->assign('lang_by', _RMGS_BY);
if ($xoopsUser){
	if ($xoopsUser->isAdmin() || $xoopsUser->getVar('uid')==$image->getVar('uid')){
		$tpl->assign('isAdmin', 1);
	} else {
		$tpl->assign('isAdmin', 0);
	}
	$tpl->assign('isUser', 1);
} else {
	$tpl->assign('isAdmin', 0);
	$tpl->assign('isUser', 0);
}
$tpl->assign('lang_vote',_RMGS_DVOTE);
$tpl->assign('page_q',$q);

//$tpl->assign('have_sizes', ($image->getSizesCount()>0) ? 1 : 0);

include XOOPS_ROOT_PATH.'/include/comment_view.php';

include 'footer.php';
?>

