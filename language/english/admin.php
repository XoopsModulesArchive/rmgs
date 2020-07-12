<?php
/*******************************************************************
* $Id: admin.php 2 2006-12-11 20:49:07Z BitC3R0 $            *
* -----------------------------------------------------            *
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
* -----------------------------------------------------            *
* admin.php:                                                       *
* Lenguage espaol para el administrador                           *
* -----------------------------------------------------            *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.0                                                  *
* @modificado: 17/12/2005 10:26:26 a.m.                            *
*******************************************************************/

define('_AS_RMGS_DELETE','Delete');
define('_AS_RMGS_IMAGES','Images');
define('_AS_RMGS_EDIT','Edit');
define('_AS_RMGS_SEND','Submit');
define('_AS_RMGS_CANCEL','Cancel');
define('_AS_RMGS_SELECT','Select...');
define('_AS_RMGS_CATEGOS','Categories');
define('_AS_RMGS_NEWCATEGO','New Category');
define('_AS_RMGS_UPLOAD','Upload Images');
define('_AS_RMGS_SETS','Albumes');
define('_AS_RMGS_POSTALS','Postcards');
define('_AS_RMGS_USERS','Users');
define('_AS_RMGS_FIELDREQUIRED','The field %s must be completed');
define('_AS_RMGS_FIELDUNIQUE','The next fields must be uniques:<br /> <strong>%s</strong>');
define('_AS_RMGS_ERRDB','An error happened while doing this action:<br /><br />%s');
define('_AS_RMGS_BACK','Back');
define('_AM_RMDP_GOPAGE', 'Page: ');
define('_AM_RMDP_PAGELOC', 'Page <strong>%s</strong> of <strong>%s</strong>');
define('_AS_RMGS_OPTIONL','Options');

switch (_RMGS_LOCATION){

	case 'categorias':
		define('_AS_RMGS_CATEGOSTITLE','Categories List');
		define('_AS_RMGS_NAMEL','Name');
		define('_AS_RMGS_DESCL','Description');
		define('_AS_RMGS_DATEL','Date');
		define('_AS_RMGS_IMGSINCAT','<span style="font-size: 10px;"><strong>%s</strong> Images.</span>');
		
		define('_AS_RMGS_ACCESS_DESC','Only user tha belong to the selected<br />groups can see this category.');
		define('_AS_RMGS_ALL','All...');
		define('_AS_RMGS_NOBODY','No one');
		define('_AS_RMGS_GROUP','Select the groups with access:');
		define('_AS_RMGS_WRITE','Select the groups with writing permissions:');
		define('_AS_RMGS_WRITEDESC','Only the users belong to<br />groups that you selected can upload the images.');
		define('_AS_RMGS_FNAME','Name:');
		define('_AS_RMGS_FDESC','Description:');
		define('_AS_RMGS_NEWOK','Category succesfully created');
		define('_AS_RMGS_MODOK','Category succesfully modified');
		define('_AS_RMGS_NOTFOUND','The category has not been found');
		define('_AS_RMGS_EDITCATEGO','Edit Category');
		define('_AS_RMGS_PARENT','Root Category:');
		define('_AS_RMGS_CONFIRMDEL','Do you really want to delete this category?');
		define('_AS_RMGS_DELOK','Category succesfully deleted');
		define('_AS_RMGS_ERRNAME','Please specify the name of the category');
		define('_AS_RMGS_ERREXIST','The specified category already exist');
		define('_AS_RMGS_TOTALIMGS','<strong>%s</strong> Existing Images');
		break;
		
	case 'imagenes':
	
		define('_AS_RMGS_LISTTILE','Existing Images in %s');
		define('_AS_RMGS_LIMAGE','Image');
		define('_AS_RMGS_LTITLE','Title');
		define('_AS_RMGS_LOCALSIZE','Local');
		define('_AS_RMGS_REMOTESIZE','Remote');
		define('_AS_RMGS_LUSER','User');
		define('_AS_RMGS_LACCES','Access');
		define('_AS_RMGS_LVOTES','Votes');
		define('_AS_RMGS_LOPTIONS','Options');
		define('_AS_RMGS_UPLOADFORM','Upload pictures to %s');
		define('_AS_RMGS_INDISC','Select the images in your harddisc and asign some key words.');
		define('_AS_RMGS_KEYS',"Add Key word to this image (<span style='font-size: 10px;'>Separate with spaces</span>):");
		define('_AS_RMGS_CATEGOSP','Belonged Categories:');
		define('_AS_RMGS_IMGOK','Image succesfully created');
		define('_AS_RMGS_IMGMODOK','Image successfully modified');
		define('_AS_RMGS_NOCATEGO','Please select a category to explore');
		define('_AS_RMGS_ERRID','You did not specified an inage to edit');
		define('_AS_RMGS_NOIMAGE','The specified image does not exist');
		define('_AS_RMGS_EDITIMG','Edit Image');
		define('_AS_RMGS_FTITLE','Title:');
		define('_AS_RMGS_FUSER','User:');
		define('_AS_RMGS_FFILE','File (Local):');
		define('_AS_RMGS_FFILE_URL','File (URL):');
		define('_AS_RMGS_FFILETYPE','File type:');
		define('_AS_RMGS_FFILEIMG','Image');
		define('_AS_RMGS_FFILEBIN','Unloadable');
		define('_AS_RMGS_FKEYS','Key Words:');
		define('_AS_RMGS_FCATEGOS','Categories:');
		define('_AS_RMGS_FFILEDESC','If a new file is specified the previous will be deleted.');
		define('_AS_RMGS_FAFILE','Current File:');
		define('_AS_RMGS_FOTHERS','Other Formats');
		define('_AS_RMGS_ERRUPLOAD','The new file was not created. Please try it again');
		define('_AS_RMGS_ADDSIZE','Add other size');
		define('_AS_RMGS_ERRTITLE','Please add a title for this element');
		define('_AS_RMGS_ERRFILE','You must add the file for this element');
		define('_AS_RMGS_ERRSIZE','Specify an element to delete');
		define('_AS_RMGS_DELELEMENT','Do you really want to delete this element?');
		define('_AS_RMGS_DELCONFIRM','Do you really want to delete this image?');
		define('_AS_RMGS_DELOK','Image succesfully deleted.');
		break;
	
	case 'usuarios':
	
		define('_AS_RMGS_LISTTITLE','Users with images in the module');
		define('_AS_RMGS_LUSED','Used: %s');
		define('_AS_RMGS_USER','User');
		define('_AS_RMGS_USED','Used space');
		define('_AS_RMGS_ALBUM','Albums');
		define('_AS_RMGS_SETQUOTA','Modify Quota');
		define('_AS_RMGS_ACTUALQ','Current Quota:');
		define('_AS_RMGS_NEWQ','New Quota:');
		define('_AS_RMGS_NEWQDESC','Please specify in megabytes');
		define('_AS_RMGS_ERRQUOTA','Non valid storage quota. Must be a positive number.');
		define('_AS_RMGS_QUOTAOK','Quota succesfully modified');
		define('_AS_RMGS_CONFIRMDEL','Do you really want to delete this user of the module?.<br /><br /><strong>Warning:</strong> All images and albums of this user also will be deleted.');
		define('_AS_RMGS_DELOK','User succesfully deleted');
		break;
	
	case 'postales':
		define('_AS_RMGS_POSTALTITLE','Postcard List');
		define('_AS_RMGS_TITLE','Title');
		define('_AS_RMGS_FECHA','Date');
		define('_AS_RMGS_TEMPLATE','template');
		define('_AS_RMGS_USER','User');
		define('_AS_RMGS_OPTIONS','Options');
		define('_AS_RMGS_ANONYM','Anonimous');
		define('_AS_RMGS_NEWTPL','New Template');
		define('_AS_RMGS_TPLS','Templates');
		
		define('_AS_RMGS_TPLSLIST','Template List');
		define('_AS_RMGS_NOWRITE','The templates could not be modified due to the directiry has not writing permissions');
		define('_AS_RMGS_TPLTITLE','Title:');
		define('_AS_RMGS_TPLTEXT','Content:');
		define('_AS_RMGS_ERRTITLE','Please specify a title for this file');
		define('_AS_RMGS_ERRTEXT','Please add the content for this file');
		define('_AS_RMGS_ERREXIST','the specified file does not exist');
		define('_AS_RMGS_ERRFILEEXISTS','Already exist a file with the same name');
		break;

}
?>

