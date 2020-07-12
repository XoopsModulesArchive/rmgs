<?php
/*******************************************************************
* $Id: xoops_version.php 2 2006-12-11 20:49:07Z BitC3R0 $   *
* --------------------------------------------------------------   *
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
* --------------------------------------------------------------   *
* xoops_version.php:                                               *
* Archivo configurador del modulo                                  *
* --------------------------------------------------------------   *
* @copyright:  2005 - 2006. BiteC3R0.                             *
* @autor: BiteC3R0                                                 *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 1.9.1                                                  *
* @modificado: 26/12/2005 06:51:39 p.m.                            *
*******************************************************************/

$modversion['name'] = _MI_RMGS_NAME;
$modversion['version'] = 2.0;
$modversion['description'] = _MI_RMGS_DESC;
$modversion['author'] = "(BitC3R0) http://www.redmexico.com.mx";
$modversion['credits'] = "BitC3R0 - Red Mxico Soft";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = "rmgs";
$modversion['iconbig'] = "images/rmgs.png";
$modversion['iconsmall'] = "images/rmgssmall.png";

// Archivo SQL
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_RMGS_USR1;
$modversion['sub'][1]['url'] = "mypics.php";
$modversion['sub'][2]['name'] = _MI_RMGS_USR2;
$modversion['sub'][2]['url'] = "upload.php";
$modversion['sub'][3]['name'] = _MI_RMGS_USR3;
$modversion['sub'][3]['url'] = "images.php";
$modversion['sub'][4]['name'] = _MI_RMGS_USR4;
$modversion['sub'][4]['url'] = "favs.php";

$modversion['templates'][1]['file'] = 'rmgs_index.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'rmgs_categos.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'rmgs_view.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'rmgs_favorites.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'rmgs_create_postal.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'rmgs_upload.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'rmgs_mypics.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'rmgs_edit.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = 'rmgs_images.html';
$modversion['templates'][9]['description'] = '';
$modversion['templates'][10]['file'] = 'rmgs_keys.html';
$modversion['templates'][10]['description'] = '';
$modversion['templates'][11]['file'] = 'rmgs_sizes.html';
$modversion['templates'][11]['description'] = '';

// Tablas del Mdulo
$modversion['tables'][0] = "rmgs_categos";
$modversion['tables'][1] = "rmgs_favorites";
$modversion['tables'][2] = "rmgs_groups";
$modversion['tables'][3] = "rmgs_imglink";
$modversion['tables'][4] = "rmgs_imgs";
$modversion['tables'][5] = "rmgs_keylink";
$modversion['tables'][6] = "rmgs_keys";
$modversion['tables'][7] = "rmgs_sizes";
$modversion['tables'][8] = "rmgs_users";
$modversion['tables'][9] = "rmgs_votes";
$modversion['tables'][10] = "rmgs_writes";
$modversion['tables'][11] = "rmgs_postales";

// Administracin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Bloque para imgenes aleatorias
$modversion['blocks'][1]['file'] = "rmgs_bk_random.php";
$modversion['blocks'][1]['name'] = _MI_RMGS_RANDOMBK;
$modversion['blocks'][1]['description'] = '';
$modversion['blocks'][1]['show_func'] = "rmgs_bk_random_images";
$modversion['blocks'][1]['edit_func'] = "rmgs_bk_random_images_edit";
$modversion['blocks'][1]['template'] = 'rmgs_bk_random.html';
$modversion['blocks'][1]['options'] = '4|2';

// Bloque para mostrar imgenes recientes
$modversion['blocks'][2]['file'] = "rmgs_bk_recents.php";
$modversion['blocks'][2]['name'] = _MI_RMGS_BKRECENTS;
$modversion['blocks'][2]['description'] = '';
$modversion['blocks'][2]['show_func'] = "rmgs_bk_recents";
$modversion['blocks'][2]['edit_func'] = "rmgs_bk_recents_edit";
$modversion['blocks'][2]['template'] = 'rmgs_bk_recents.html';
$modversion['blocks'][2]['options'] = '4|2';

// Bloque para mostrar imgenes populares
$modversion['blocks'][3]['file'] = "rmgs_bk_severals.php";
$modversion['blocks'][3]['name'] = _MI_RMGS_BKPOPULARS;
$modversion['blocks'][3]['description'] = '';
$modversion['blocks'][3]['show_func'] = "rmgs_bk_populars";
$modversion['blocks'][3]['edit_func'] = "rmgs_bk_populars_edit";
$modversion['blocks'][3]['template'] = 'rmgs_bk_populars.html';
$modversion['blocks'][3]['options'] = '4|2';

// Bloque para mostrar imgenes mejor votadas
$modversion['blocks'][4]['file'] = "rmgs_bk_severals.php";
$modversion['blocks'][4]['name'] = _MI_RMGS_BKVOTED;
$modversion['blocks'][4]['description'] = '';
$modversion['blocks'][4]['show_func'] = "rmgs_bk_voted";
$modversion['blocks'][4]['edit_func'] = "rmgs_bk_voted_edit";
$modversion['blocks'][4]['template'] = 'rmgs_bk_voted.html';
$modversion['blocks'][4]['options'] = '4|1';

// Bloque para mostrar las categoras
$modversion['blocks'][5]['file'] = "rmgs_bk_severals.php";
$modversion['blocks'][5]['name'] = _MI_RMGS_BKCATS;
$modversion['blocks'][5]['description'] = '';
$modversion['blocks'][5]['show_func'] = "rmgs_bk_categos";
$modversion['blocks'][5]['edit_func'] = "";
$modversion['blocks'][5]['template'] = 'rmgs_bk_categos.html';
$modversion['blocks'][5]['options'] = '';

// Opcion para configurar el formato de fecha
$modversion['config'][1]['name'] = 'format_date';
$modversion['config'][1]['title'] = '_MI_RMGS_FDATE';
$modversion['config'][1]['description'] = '';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = "d/m/Y";

// Opcion para configurar el titulo del modulo
$modversion['config'][2]['name'] = 'modtitle';
$modversion['config'][2]['title'] = '_MI_RMGS_MODTITLE';
$modversion['config'][2]['description'] = '';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = "RMSOFT GS v2.0";

// Cantidad de Imgenes a subir de una sola vez
$modversion['config'][3]['name'] = 'uploads_cant';
$modversion['config'][3]['title'] = '_MI_RMGS_UPLOADSQ';
$modversion['config'][3]['description'] = '';
$modversion['config'][3]['formtype'] = 'select';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 5;
$modversion['config'][3]['options'] = array('1'=>1,'5'=>5,'10'=>10,'16'=>16,'20'=>20);

// Directorio para almacena imgenes
$modversion['config'][4]['name'] = 'storedir';
$modversion['config'][4]['title'] = '_MI_RMGS_STOREDIR';
$modversion['config'][4]['description'] = '_MI_RMGS_STOREDIRDESC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = XOOPS_ROOT_PATH."/uploads";

// Directorio para almacena imgenes
$modversion['config'][5]['name'] = 'quota';
$modversion['config'][5]['title'] = '_MI_RMGS_QUOTA';
$modversion['config'][5]['description'] = '_MI_RMGS_QUOTADESC';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = 3;

// Tamao de las imgenes grandes
$modversion['config'][6]['name'] = 'imgwidth';
$modversion['config'][6]['title'] = '_MI_RMGS_IMGWIDTH';
$modversion['config'][6]['description'] = '';
$modversion['config'][6]['formtype'] = 'textbox';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = 400;

// Tamao de las imgenes grandes
$modversion['config'][7]['name'] = 'imgheight';
$modversion['config'][7]['title'] = '_MI_RMGS_IMGHEIGHT';
$modversion['config'][7]['description'] = '';
$modversion['config'][7]['formtype'] = 'textbox';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['default'] = 400;

// Tamao de imgenes pequeas
$modversion['config'][8]['name'] = 'thwidth';
$modversion['config'][8]['title'] = '_MI_RMGS_THWIDTH';
$modversion['config'][8]['description'] = '';
$modversion['config'][8]['formtype'] = 'textbox';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 100;

// Tamao de imgenes pequeas
$modversion['config'][9]['name'] = 'thheight';
$modversion['config'][9]['title'] = '_MI_RMGS_THHEIGHT';
$modversion['config'][9]['description'] = '';
$modversion['config'][9]['formtype'] = 'textbox';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 100;

// Activar otros formatos
$modversion['config'][10]['name'] = 'othersizes';
$modversion['config'][10]['title'] = '_MI_RMGS_ACTIVEOTHER';
$modversion['config'][10]['description'] = '_MI_RMGS_ACTIVEOTHER_DESC';
$modversion['config'][10]['formtype'] = 'yesno';
$modversion['config'][10]['valuetype'] = 'int';
$modversion['config'][10]['default'] = 0;

// Activar almacenamiento local de otros tamaños
$modversion['config'][11]['name'] = 'sizes_local';
$modversion['config'][11]['title'] = '_MI_RMGS_OTHERLOCAL';
$modversion['config'][11]['description'] = '';
$modversion['config'][11]['formtype'] = 'yesno';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 0;

// Medidas de otros formatos
$modversion['config'][12]['name'] = 'sizes';
$modversion['config'][12]['title'] = '_MI_RMGS_OTHERSIZESLIMIT';
$modversion['config'][12]['description'] = '';
$modversion['config'][12]['formtype'] = 'select';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 3;
$modversion['config'][12]['options'] = array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'10'=>10,'15'=>15,'20'=>20);

// Longitud mnima de las palabras clave
$modversion['config'][13]['name'] = 'minkey';
$modversion['config'][13]['title'] = '_MI_RMGS_MINKEY';
$modversion['config'][13]['description'] = '';
$modversion['config'][13]['formtype'] = 'textbox';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = '4';

// Langitud maxima de las palabras clave
$modversion['config'][14]['name'] = 'maxkey';
$modversion['config'][14]['title'] = '_MI_RMGS_MAXKEY';
$modversion['config'][14]['description'] = '';
$modversion['config'][14]['formtype'] = 'textbox';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = '20';

// Numero de imgenes mostradas en la pgina principal
$modversion['config'][15]['name'] = 'thshome';
$modversion['config'][15]['title'] = '_MI_RMGS_THUMSINDEX';
$modversion['config'][15]['description'] = '';
$modversion['config'][15]['formtype'] = 'select';
$modversion['config'][15]['valuetype'] = 'int';
$modversion['config'][15]['default'] = '10';
$modversion['config'][15]['options'] = array('3'=>3,'6'=>6,'9'=>9,'12'=>12,'15'=>15,'18'=>18);

// Das para considerar categorias como nuevas
$modversion['config'][16]['name'] = 'catnew_days';
$modversion['config'][16]['title'] = '_MI_RMGS_CATNEWDAYS';
$modversion['config'][16]['description'] = '';
$modversion['config'][16]['formtype'] = 'textbox';
$modversion['config'][16]['valuetype'] = 'text';
$modversion['config'][16]['default'] = '10';

// Columnas para la navegacin de imgenes
$modversion['config'][17]['name'] = 'columns';
$modversion['config'][17]['title'] = '_MI_RMGS_COLUMNS';
$modversion['config'][17]['description'] = '';
$modversion['config'][17]['formtype'] = 'textbox';
$modversion['config'][17]['valuetype'] = 'text';
$modversion['config'][17]['default'] = '3';

// Dias para considerar una imgen como nueva
$modversion['config'][18]['name'] = 'newimage';
$modversion['config'][18]['title'] = '_MI_RMGS_IMGASNEW';
$modversion['config'][18]['description'] = '';
$modversion['config'][18]['formtype'] = 'textbox';
$modversion['config'][18]['valuetype'] = 'text';
$modversion['config'][18]['default'] = '10';

// Dias para considerar una imgen como nueva
$modversion['config'][19]['name'] = 'updateimage';
$modversion['config'][19]['title'] = '_MI_RMGS_IMGASUPDATE';
$modversion['config'][19]['description'] = '';
$modversion['config'][19]['formtype'] = 'textbox';
$modversion['config'][19]['valuetype'] = 'text';
$modversion['config'][19]['default'] = '10';

// Permitir carga de imgenes
$modversion['config'][20]['name'] = 'upload';
$modversion['config'][20]['title'] = '_MI_RMGS_ALLOWUPLOAD';
$modversion['config'][20]['description'] = '';
$modversion['config'][20]['formtype'] = 'yesno';
$modversion['config'][20]['valuetype'] = 'int';
$modversion['config'][20]['default'] = 1;

// Permitir creacin y manejo de lbumes
$modversion['config'][21]['name'] = 'sets';
$modversion['config'][21]['title'] = '_MI_RMGS_ALLOWSETS';
$modversion['config'][21]['description'] = '';
$modversion['config'][21]['formtype'] = 'yesno';
$modversion['config'][21]['valuetype'] = 'int';
$modversion['config'][21]['default'] = 1;

// Permitir votos de usuarios annimos
$modversion['config'][22]['name'] = 'anovote';
$modversion['config'][22]['title'] = '_MI_RMGS_VOTEANONY';
$modversion['config'][22]['description'] = '';
$modversion['config'][22]['formtype'] = 'yesno';
$modversion['config'][22]['valuetype'] = 'int';
$modversion['config'][22]['default'] = 1;

// Permitir envo de postales
$modversion['config'][23]['name'] = 'postal';
$modversion['config'][23]['title'] = '_MI_RMGS_ALLOWPOSTAL';
$modversion['config'][23]['description'] = '';
$modversion['config'][23]['formtype'] = 'yesno';
$modversion['config'][23]['valuetype'] = 'int';
$modversion['config'][23]['default'] = 1;

// Das que una postal permanece en la base de datos
$modversion['config'][24]['name'] = 'postaldays';
$modversion['config'][24]['title'] = '_MI_RMGS_POSTALDAYS';
$modversion['config'][24]['description'] = '';
$modversion['config'][24]['formtype'] = 'textbox';
$modversion['config'][24]['valuetype'] = 'int';
$modversion['config'][24]['default'] = 10;

// Das que una postal permanece en la base de datos
$modversion['config'][25]['name'] = 'postal_anonimo';
$modversion['config'][25]['title'] = '_MI_RMGS_POSTALANONYM';
$modversion['config'][25]['description'] = '';
$modversion['config'][25]['formtype'] = 'yesno';
$modversion['config'][25]['valuetype'] = 'int';
$modversion['config'][25]['default'] = 0;

// Tipo de Editor
$modversion['config'][26]['name'] = 'editor';
$modversion['config'][26]['title'] = '_MI_RMGS_EDITOR';
$modversion['config'][26]['description'] = '';
$modversion['config'][26]['formtype'] = 'select';
$modversion['config'][26]['valuetype'] = 'text';
$modversion['config'][26]['default'] = "dhtml";
$modversion['config'][26]['options'] = array(
											_MI_RMGS_FORM_DHTML=>'dhtml',
											_MI_RMGS_FORM_COMPACT=>'textarea',
											_MI_RMGS_FORM_SPAW=>'spaw',
											_MI_RMGS_FORM_HTMLAREA=>'htmlarea',
											_MI_RMGS_FORM_KOIVI=>'koivi',
											_MI_RMGS_FORM_FCK=>'fck'
											);
											
// Das que una postal permanece en la base de datos
$modversion['config'][27]['name'] = 'postal_mail';
$modversion['config'][27]['title'] = '_MI_RMGS_MAILPOSTAL';
$modversion['config'][27]['description'] = '_MI_RMGS_MAILPOSTAL_DESC';
$modversion['config'][27]['formtype'] = 'textbox';
$modversion['config'][27]['valuetype'] = 'text';
$modversion['config'][27]['default'] = $xoopsConfig['adminmail'];

// Imgenes en la pgina inicial del Mdulo
$modversion['config'][28]['name'] = 'home_access';
$modversion['config'][28]['title'] = '_MI_RMGS_HOMEACCESS';
$modversion['config'][28]['description'] = '';
$modversion['config'][28]['formtype'] = 'textbox';
$modversion['config'][28]['valuetype'] = 'int';
$modversion['config'][28]['default'] = 100;

$modversion['config'][29]['name'] = 'home_width';
$modversion['config'][29]['title'] = '_MI_RMGS_HOMEWIDTH';
$modversion['config'][29]['description'] = '';
$modversion['config'][29]['formtype'] = 'textbox';
$modversion['config'][29]['valuetype'] = 'int';
$modversion['config'][29]['default'] = 250;

$modversion['config'][30]['name'] = 'home_update';
$modversion['config'][30]['title'] = '_MI_RMGS_HOMEUPDATE';
$modversion['config'][30]['description'] = '';
$modversion['config'][30]['formtype'] = 'select';
$modversion['config'][30]['valuetype'] = 'int';
$modversion['config'][30]['default'] = 1;
$modversion['config'][30]['options'] = array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7);

$modversion['config'][31]['name'] = 'populars';
$modversion['config'][31]['title'] = '_MI_RMGS_POPULAR';
$modversion['config'][31]['description'] = '';
$modversion['config'][31]['formtype'] = 'textbox';
$modversion['config'][31]['valuetype'] = 'int';
$modversion['config'][31]['default'] = 100;

$modversion['config'][32]['name'] = 'bestvotes';
$modversion['config'][32]['title'] = '_MI_RMGS_BESTVOTES';
$modversion['config'][32]['description'] = '_MI_RMGS_BESTVOTES_DESC';
$modversion['config'][32]['formtype'] = 'textbox';
$modversion['config'][32]['valuetype'] = 'int';
$modversion['config'][32]['default'] = 100;

// Comentarios de las fotografas
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'id';
$modversion['comments']['pageName'] = 'view.php';
$modversion['comments']['extraParams'] = array('cid');

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/rmgs_comments.php';
$modversion['comments']['callback']['approve'] = 'rmgs_com_approve';
$modversion['comments']['callback']['update'] = 'rmgs_com_update';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/rmgs_comments.php";
$modversion['search']['func'] = "rmgs_xoops_search";
?>