<?php
/***********************************************************************
* $Id: modinfo.php 2 2006-12-11 20:49:07Z BitC3R0 $              *
* -------------------------------------------------------              *
* RMSOFT Gallery System 2.0                                            *
* Sistema Avanzado de Galerías                                         *
* CopyRight (c) 2005 - 2006. Red Mxico Soft                           *
* http://www.redmexico.com.mx                                          *
* http://www.xoops-mexico.net                                          *
*                                                                      *
* This program is free software; you can redistribute it and/or        *
* modify it under the terms of the GNU General Public License as       *
* published by the Free Software Foundation; either version 2 of       *
* the License, or (at your option) any later version.                  *
*                                                                      *
* This program is distributed in the hope that it will be useful,      *
* but WITHOUT ANY WARRANTY; without even the implied warranty of       *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the         *
* GNU General Public License for more details.                         *
*                                                                      *
* You should have received a copy of the GNU General Public            *
* License along with this program; if not, write to the Free           *
* Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,       *
* MA 02111-1307 USA                                                    *
*                                                                      *
* -------------------------------------------------------              *
* modinfo.php: Archivo en lenguaje espaol para la informacin bsica  *
* del mdulo                                                           *
* -------------------------------------------------------              *
* @copyright:  2005 - 2006. BitC3R0.                                  *
* @autor: BitC3R0                                                      *
* @paquete: Archivo PHP                                                *
* @version: 0.1.0                                                      *
* @modificado: 16/12/2005 03:42:07 p.m.                                *
***********************************************************************/

define('_MI_RMGS_NAME','RMSOFT GS 2.0');
define('_MI_RMGS_DESC','Advanced Gallery and Albumes On Line System');

// Menu del Administrador
define('_MI_RMGS_ADM1','Current Status');
define('_MI_RMGS_ADM2','Categories');
define('_MI_RMGS_ADM3','New Category');
define('_MI_RMGS_ADM4','Upload Images');
define('_MI_RMGS_ADM5','Users');
define('_MI_RMGS_ADM6','Postals');

// Menu de Usuarios
define('_MI_RMGS_USR1','My Images');
define('_MI_RMGS_USR2','Upload Images');
define('_MI_RMGS_USR3','Search Images');
define('_MI_RMGS_USR4','Bookmarks');

// Configuración
define('_MI_RMGS_FDATE','Date Format:');
define('_MI_RMGS_MODTITLE','Module Title:');
define('_MI_RMGS_UPLOADSQ','Images Number to Upload at the same time:');
define('_MI_RMGS_STOREDIR','Directory to Store Images:');
define('_MI_RMGS_STOREDIRDESC',"<span style='font-size: 10px;'>The directory must have writting permissions. If you change this direcotory after creating images you must copy the previous directory content to this for a proper functionality.</span>");
define('_MI_RMGS_QUOTA','Starting store quota for users:');
define('_MI_RMGS_QUOTADESC',"<span style='font-size: 10px;'>Specify in MB. Is possible to modify this value for every user later.</span>");
define('_MI_RMGS_IMGWIDTH','Image Width:');
define('_MI_RMGS_IMGHEIGHT','Image Height:');
define('_MI_RMGS_THWIDTH','Thumbs Width:');
define('_MI_RMGS_THHEIGHT','Thumbs Height:');
define('_MI_RMGS_ACTIVEOTHER','Enable other images formats::');
define('_MI_RMGS_ACTIVEOTHER_DESC','<span style="font-size: 10px;">Enable fields to provide other image formats.</span>');
define('_MI_RMGS_OTHERLOCAL','Allow local storing of other formats files:');
define('_MI_RMGS_OTHERSIZESLIMIT','Different format sizes:');
define('_MI_RMGS_MINKEY','Minimum length of the tags:');
define('_MI_RMGS_MAXKEY','Maximum Length of the tags:');
define('_MI_RMGS_THUMSINDEX','Thumbnails in the homepage:');
define('_MI_RMGS_CATNEWDAYS','Days to consider a category as new');
define('_MI_RMGS_COLUMNS','Columns number of the galeries:');
define('_MI_RMGS_IMGASNEW','Days to consider an image as new:');
define('_MI_RMGS_IMGASUPDATE','Days to consider an image as updated:');
define('_MI_RMGS_ALLOWUPLOAD','Enable image uploading:');
define('_MI_RMGS_ALLOWSETS','Allow albums creation:');
define('_MI_RMGS_ALLOWPOSTAL','Enable Postcards:');
define('_MI_RMGS_VOTEANONY','Allow anonimous users votes:');
define('_MI_RMGS_POSTALDAYS','Days a postcar will stay in the data base');
define('_MI_RMGS_POSTALANONYM','Allow anonimous users send postcards:');
define('_MI_RMGS_EDITOR','Editor type:');
define('_MI_RMGS_MAILPOSTAL','Email Postcards send:');
define('_MI_RMGS_MAILPOSTAL_DESC','This email will appear in the mail the recipient will receive.');
define('_MI_RMGS_HOMEACCESS','Minimum access to present an image in the module homepage:');
define('_MI_RMGS_HOMEWIDTH','Homepage Images Width:');
define('_MI_RMGS_HOMEUPDATE','Days to generate Homepage images:');
define('_MI_RMGS_POPULAR','Access to consider an image as popular:');
define('_MI_RMGS_BESTVOTES','Number of votes to consider an image withiin the best voted:');
define('_MI_RMGS_BESTVOTES_DESC','When an image reach that votes will be listed within the best voted images');

// Editores
define("_MI_RMGS_FORM_COMPACT","Compact");
define("_MI_RMGS_FORM_DHTML","DHTML");
define("_MI_RMGS_FORM_SPAW","Spaw Editor");
define("_MI_RMGS_FORM_HTMLAREA","HtmlArea Editor");
define("_MI_RMGS_FORM_FCK","FCK Editor");
define("_MI_RMGS_FORM_KOIVI","Koivi Editor");

// Bloques
define('_MI_RMGS_RANDOMBK','Random Image');
define('_MI_RMGS_BKRECENTS','Recent Images');

define('_MI_RMGS_BKREC_IMAGES','Show Images:');
define('_MI_RMGS_BKPOPULARS','Popular Images');
define('_MI_RMGS_BKVOTED','Best Voted');
define('_MI_RMGS_BKCATS','Categories');

//Added by Kaotik
define('_MI_RMGS_RANDOMIMGBK','Random Images:');
define('_MI_RMGS_BKCOL_NUMBER','Columns Number:');
?>