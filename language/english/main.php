<?php
/*******************************************************************
* $Id: main.php 2 2006-12-11 20:49:07Z BitC3R0 $             *
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
* main.php:                                                        *
* Lenguaje                                                         *
* ----------------------------------------------------             *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.2.1                                                 *
* @modificado: 26/12/2005 08:37:20 p.m.                            *
*******************************************************************/

global $rmgs_location;

define('_RMGS_PHOTOS','Images:');
define('_RMGS_YOURPHOTOS','My Images');
define('_RMGS_UPLOAD','Upload');
define('_RMGS_POPULARS','Populars');
define('_RMGS_BESTVOTE','Best Vote');
define('_RMGS_SEARCH','Search');
define('_RMGS_QUOTA','Used <strong>%s</strong> out of <strong>%s</strong>.');
define('_RMGS_ALL_PHOTOS','All Images');
define('_RMGS_BY','By:');
define('_RMGS_LASTIMAGES','Last <strong>%s</strong> Images');
define('_RMGS_CATEGOS','Categories');
define('_RMGS_SUBCATEGOS','SubCategories');
define('_RMGS_IMGCOUNT','Images: <strong>%s</strong>');
define('_RMGS_SINCE','From:');
define('_RMGS_GOTO','Go to:');
define('_RMGS_NOALLOWED','Sorry, you do not have permission to enter this section.');
define('_RMGS_PAG','Page:');
define('_RMGS_RESULTS','Results by page:');
define('_RMGS_NOCAT','You did not select a category.');
define('_RMGS_CATEGO_NOTFOUND','Was not find the specified category');
define('_RMGS_WELCOME','¡Hello %s!');
define('_RMGS_NOIMG','An image has not been specified to show.');
define('_RMGS_IMG_NOTFOUND','Was not find the specified image');
define('_RMGS_INVALID_METHOD','Invalid Method');
define('_RMGS_IMG','Image');
define('_RMGS_FAVORITES','My Favorites');
define('_RMGS_FINDIMAGE','Find an image:');
define('_RMGS_POPULARKEY','Populars search');
define('_RMGS_UPLOAD_HOME','Upload images');
define('_RMGS_FAVS_HOME','My Favoritos');
define('_RMGS_TOTAL_POINTS','%s Points');

switch ($rmgs_location){
	case 'details':
		define('_RMGS_DTITLE','Title:');
		define('_RMGS_DVOTES','Votes:');
		define('_RMGS_DDOWNS','Access:');
		define('_RMGS_DRATE','Rating:');
		define('_RMGS_DPOP','Popularity:');
		define('_RMGS_DVOTE','Vote');
		define('_RMGS_PREV','Previous');
		define('_RMGS_NEXT','Nest');
		define('_RMGS_AVAILABLE_SIZES','Other formats:');
		define('_RMGS_KEYS','Keys');
		define('_RMGS_SIZES','Formats');
		define('_RMGS_BELONG_TO','Categories');
		break;
	case 'votos':
		define('_RMGS_CANNOT','Sorry, you do not have permission to vote');
		define('_RMGS_ONEVOTEDAY','You can vote only once a day');
		define('_RMGS_CLOSEW','Close Windows');
		define('_RMGS_VOTE_THX','Thanks for voting');
		define('_RMGS_VOTE_ERR','Your vote can not be registered due to an error. Please try it again.');
		define('_RMGS_NOVOTE_TWICE','You can not vote twice for the same resource');
		define('_RMGS_TITPAGE','Votes');
		break;
	case 'favoritos':
		define('_RMGS_PREV_PAGE','Back to');
		break;
	case 'postales':
		define('_RMGS_CREATE_POSTAL','Create Postcard');
		define('_RMGS_NAME_DEST','Recipient Name:');
		define('_RMGS_DEST_EMAIL','Email del Destinatario:');
		define('_RMGS_TITLE_POSTAL','Postcard Title:');
		define('_RMGS_POSTAL_CONTENT','Postcard Message:');
		define('_RMGS_STEMPLATE','Skin:');
		define('_RMGS_YOUR_NAME','Your Name:');
		define('_RMGS_YOUR_MAIL','Your Email:');
		define('_RMGS_PREVIEW','Preview');
		define('_RMGS_ERRTITLE','You have not written a title for this postcard');
		define('_RMGS_ERRTEXT','You have not written a message for this postcard');
		define('_RMGS_ERRNAMEDEST','You have not written the recipient name');
		define('_RMGS_ERRMAILDEST','You have not written the recipient email');
		define('_RMGS_ERRNAME','You have not written your name');
		define('_RMGS_ERREMAIL','You have not written your email');
		define('_RMGS_ERRTPL','You must choose a design for this postcard');
		define('_RMGS_POSTALSENT','The postcard has been sent to <strong>%s</strong> correctly');
		define('_RMGS_ERRSENT','There has been an eror while sending this postcard. Please try it again');
		define('_RMGS_POSTALRECEIVE','You have received a postcard in %s');
		define('_RMGS_NOEXISTS','The specified postcard does not exist');
		break;
	case 'uploads':
		define('_RMGS_UPLOAD_IMAGES','Upload Images');
		define('_RMGS_UPLOADTIP','Select the images in your harddisc to upload. Assigns key words to the Images.<br /><br />The key words led you do searches in RMSOFT Gallery System 2.0.');
		define('_RMGS_KEYWORDS','Key Words:*');
		define('_RMGS_KEYSPACE','Separate with spaces each word');
		define('_RMGS_SELECT_CATEGO','Categories:*');
		define('_RMGS_UPLOAD_OK','Images succesfully created');
		
		define('_RMGS_ERR_KEYS','Please specify some words for the search of this images');
		define('_RMGS_ERR_CATS','Please select at least a category for this images');
		define('_RMGS_ERR_IMAGES','There are no Images to upload');
		define('_RMGS_ERR_ALLOWCATS','You do not have authorization to upload Images in some selected category(ies)');
		define('_RMGS_ERR_QUOTA','Sorry, you have reached the limit of storage of your account.');
		break;
	case 'misimagenes':
		define('_RMGS_MYPICS_TOTAL','My Images: <em><strong>%s</strong> Images</em>');
		define('_RMGS_DELETE','Delete');
		define('_RMGS_EDIT','Edit');
		define('_RMGS_OKDELETE','Image succesfully deleted');
		define('_RMGS_NOUSER','¡You do not have permission to do this action!');
		define('_RMGS_CONFIRMDEL','Do you really want to delete this element?');
		define('_RMGS_ERRID','You did not specify an image to edit');
		define('_RMGS_ERRIMAGE','the specified image was not find');
		define('_RMGS_ERRSIZE','The specified format was not find');
		define('_RMGS_ERRFILE','You did not specify a file');
		define('_RMGS_ERRUPLOAD','An error happened while uploading the image. Please try it again.');
		define('_RMGS_EDITOK','Image succesfully modified.');
		define('_RMGS_ERRONDB',"An error happened while trying to storage the image's data. Pleae try it again.");
		// Forumulario
		define('_RMGS_EDIT_TITLE','Editing "%s"');
		define('_RMGS_IMGTITLE','Title:');
		define('_RMGS_IMGFILE','File:');
		define('_RMGS_IMGFILE_DESC','if you specify a new file the previous one will be deleted.');
		define('_RMGS_IMGCYR_FILE','Current File:');
		define('_RMGS_KEYWORDS','Key Words:*');
		define('_RMGS_SELECT_CATEGO','Categories:*');
		define('_RMGS_DDOWNS','Access:');
		define('_RMGS_SIZES','Formats');
		define('_RMGS_SIZES_TITLE','Other Formats');
		define('_RMGS_FORM_TITLE','New Format');
		define('_RMGS_FFILE', 'File (Local):');
		define('_RMGS_FFILE_URL', 'File (URL):');
		define('_RMGS_LOCAL','Local');
		define('_RMGS_REMOTE','Remote');
		define('_RMGS_RETURN','Back');
		break;
	case 'imagenes':
		define('_RMGS_TITLE_ALL','Exploring all images');
		define('_RMGS_TITLE_POPULAR','Most Populars');
		define('_RMGS_TITLE_VOTES','Best Voted');
		define('_RMGS_TITLE_USER','Images of %s');
		define('_RMGS_TITLE_KEYS','"%s" Results');
		define('_RMGS_SHOWING','Showing <strong>%s</strong> to <strong>%s</strong> of <strong>%s</strong> Images');
		define('_RMGS_ERR_KEYS','You do not have specified a word for the search');
		break;
}

?>