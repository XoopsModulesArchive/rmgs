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

define('_RMGS_PHOTOS','Fotos:');
define('_RMGS_YOURPHOTOS','Mis Imágenes');
define('_RMGS_UPLOAD','Subir');
define('_RMGS_POPULARS','Populares');
define('_RMGS_BESTVOTE','Mejor Votadas');
define('_RMGS_SEARCH','Buscar');
define('_RMGS_QUOTA','Usado <strong>%s</strong> de <strong>%s</strong>.');
define('_RMGS_ALL_PHOTOS','Todas las Imágenes');
define('_RMGS_BY','Por:');
define('_RMGS_LASTIMAGES','Ultimas <strong>%s</strong> Imágenes');
define('_RMGS_CATEGOS','Categorías');
define('_RMGS_SUBCATEGOS','SubCategorías');
define('_RMGS_IMGCOUNT','Imágenes: <strong>%s</strong>');
define('_RMGS_SINCE','Desde:');
define('_RMGS_GOTO','Ir a:');
define('_RMGS_NOALLOWED','Lo siento, no tienes permiso para ingresar a esta sección.');
define('_RMGS_PAG','Página:');
define('_RMGS_RESULTS','Resultados por Página:');
define('_RMGS_NOCAT','No seleccionaste una categoría.');
define('_RMGS_CATEGO_NOTFOUND','No se encontró la categoría especificada');
define('_RMGS_WELCOME','¡Hola %s!');
define('_RMGS_NOIMG','No se ha especificado una imágen para mostrar.');
define('_RMGS_IMG_NOTFOUND','No se encontró la imágen especificada');
define('_RMGS_INVALID_METHOD','Acción no permitida');
define('_RMGS_IMG','Imágen');
define('_RMGS_FAVORITES','Mis Favoritos');
define('_RMGS_FINDIMAGE','Encuentra una imágen:');
define('_RMGS_POPULARKEY','Búsquedas populares');
define('_RMGS_UPLOAD_HOME','Publicar Imágenes');
define('_RMGS_FAVS_HOME','Mis Favoritos');
define('_RMGS_TOTAL_POINTS','%s Puntos');

switch ($rmgs_location){
	case 'details':
		define('_RMGS_DTITLE','Título:');
		define('_RMGS_DVOTES','Votos:');
		define('_RMGS_DDOWNS','Accesos:');
		define('_RMGS_DRATE','Rating:');
		define('_RMGS_DPOP','Popularidad:');
		define('_RMGS_DVOTE','Votar');
		define('_RMGS_PREV','Anterior');
		define('_RMGS_NEXT','Siguiente');
		define('_RMGS_AVAILABLE_SIZES','Otros Formatos:');
		define('_RMGS_KEYS','Claves');
		define('_RMGS_SIZES','Formatos');
		define('_RMGS_BELONG_TO','Categorías');
		break;
	case 'votos':
		define('_RMGS_CANNOT','Lo siento, no tienes autorizacin para votar');
		define('_RMGS_ONEVOTEDAY','Solo puedes votar una vez por da');
		define('_RMGS_CLOSEW','Cerrar Ventana');
		define('_RMGS_VOTE_THX','Gracias por tu voto');
		define('_RMGS_VOTE_ERR','No se pudo registrar tu voto debido a un error. Por favor vuleve a intentarlo.');
		define('_RMGS_NOVOTE_TWICE','No puedes votar dos veces por el mismo recurso');
		define('_RMGS_TITPAGE','Votaciones');
		break;
	case 'favoritos':
		define('_RMGS_PREV_PAGE','Volver');
		break;
	case 'postales':
		define('_RMGS_CREATE_POSTAL','Crear Postal');
		define('_RMGS_NAME_DEST','Nombre del Destinatario:');
		define('_RMGS_DEST_EMAIL','Email del Destinatario:');
		define('_RMGS_TITLE_POSTAL','Ttulo de la Postal:');
		define('_RMGS_POSTAL_CONTENT','Mensaje de la Postal:');
		define('_RMGS_STEMPLATE','Apariencia:');
		define('_RMGS_YOUR_NAME','Tu Nombre:');
		define('_RMGS_YOUR_MAIL','Tu Email:');
		define('_RMGS_PREVIEW','Previsualizar');
		define('_RMGS_ERRTITLE','No has escrito un titulo para esta postal');
		define('_RMGS_ERRTEXT','No has escrito un mensaje para la postal');
		define('_RMGS_ERRNAMEDEST','No has escrito el nombre del destinatario');
		define('_RMGS_ERRMAILDEST','No has escrito el email del destinatario');
		define('_RMGS_ERRNAME','No has escrito tu nombre');
		define('_RMGS_ERREMAIL','No has escrito tu email');
		define('_RMGS_ERRTPL','Debes elegir un diseo para esta postal');
		define('_RMGS_POSTALSENT','Se ha enviado la postal a <strong>%s</strong> correctamente');
		define('_RMGS_ERRSENT','Ocurri un error al intentar enviar esta postal. Por favor vuelve a intentarlo');
		define('_RMGS_POSTALRECEIVE','Has recibido una postal en %s');
		define('_RMGS_NOEXISTS','No existe la postal especificada');
		break;
	case 'uploads':
		define('_RMGS_UPLOAD_IMAGES','Subir Imágenes');
		define('_RMGS_UPLOADTIP','Selecciona las Imágenes en tu disco duro para subir. Asigna palabras claves a las Imágenes.<br /><br />Las palabras claves permiten realizar bsquedas en RMSOFT Gallery System 2.0.');
		define('_RMGS_KEYWORDS','Palabras Clave:*');
		define('_RMGS_KEYSPACE','Separar con espacios cada palabra');
		define('_RMGS_SELECT_CATEGO','Categorías:*');
		define('_RMGS_UPLOAD_OK','Imágenes creadas correctamente');
		
		define('_RMGS_ERR_KEYS','Por favor especifica algunas palabras para la bsqueda de estas Imágenes');
		define('_RMGS_ERR_CATS','Por favor selecciona al menos una categoría para estas Imágenes');
		define('_RMGS_ERR_IMAGES','No hay Imágenes que cargar');
		define('_RMGS_ERR_ALLOWCATS','No tienes autorizacin para cargar Imágenes en alguna(s) categoria(s) seleccionada(s)');
		define('_RMGS_ERR_QUOTA','Lo sentimos, has alcanzado el lmite de almacenamiento de tu cuenta.');
		break;
	case 'misimagenes':
		define('_RMGS_MYPICS_TOTAL','Mis Imágenes: <em><strong>%s</strong> Imágenes</em>');
		define('_RMGS_DELETE','Eliminar');
		define('_RMGS_EDIT','Editar');
		define('_RMGS_OKDELETE','Imágen eliminada correctamente');
		define('_RMGS_NOUSER','¡No tienes autorización para realizar esta acción!');
		define('_RMGS_CONFIRMDEL','Realmente deseas eliminar este elemento?');
		define('_RMGS_ERRID','No especificaste una imágen para editar');
		define('_RMGS_ERRIMAGE','No se encontró la imágen especificada');
		define('_RMGS_ERRSIZE','No se encontró el tamaño especificado');
		define('_RMGS_ERRFILE','No especificaste un archivo');
		define('_RMGS_ERRUPLOAD','Ocurrió un error al cargar la imágen. Por favor vuelve a intentarlo.');
		define('_RMGS_EDITOK','Imágen modificada correctamente');
		define('_RMGS_ERRONDB','Ocurrió un error al intentar almacenar los datos de la imágen. Por favor vuelve a intentarlo.');
		// Forumulario
		define('_RMGS_EDIT_TITLE','Editando "%s"');
		define('_RMGS_IMGTITLE','Titulo:');
		define('_RMGS_IMGFILE','Archivo:');
		define('_RMGS_IMGFILE_DESC','Si especificas un nuevo archivo el archivo anterior ser eliminado.');
		define('_RMGS_IMGCYR_FILE','Archivo Actual:');
		define('_RMGS_KEYWORDS','Palabras Clave:*');
		define('_RMGS_SELECT_CATEGO','Categorías:*');
		define('_RMGS_DDOWNS','Accesos:');
		define('_RMGS_SIZES','Formatos');
		define('_RMGS_SIZES_TITLE','Otros Formatos');
		define('_RMGS_FORM_TITLE','Nuevo Formato');
		define('_RMGS_FFILE', 'Archivo (Local):');
		define('_RMGS_FFILE_URL', 'Archivo (URL):');
		define('_RMGS_LOCAL','Local');
		define('_RMGS_REMOTE','Remoto');
		define('_RMGS_RETURN','Regresar');
		break;
	case 'imagenes':
		define('_RMGS_TITLE_ALL','Explorando todas las Imágenes');
		define('_RMGS_TITLE_POPULAR','Las Mas populares');
		define('_RMGS_TITLE_VOTES','Las Mejor Votadas');
		define('_RMGS_TITLE_USER','Imágenes de %s');
		define('_RMGS_TITLE_KEYS','Resultados para "%s"');
		define('_RMGS_SHOWING','Mostrando <strong>%s</strong> a <strong>%s</strong> de <strong>%s</strong> Imágenes');
		define('_RMGS_ERR_KEYS','No has especificado una palabra para la bsqueda');
		break;
}

?>