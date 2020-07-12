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

define('_AS_RMGS_DELETE','Eliminar');
define('_AS_RMGS_IMAGES','Imágenes');
define('_AS_RMGS_EDIT','Editar');
define('_AS_RMGS_SEND','Enviar');
define('_AS_RMGS_CANCEL','Cancelar');
define('_AS_RMGS_SELECT','Seleccionar...');
define('_AS_RMGS_CATEGOS','Categorías');
define('_AS_RMGS_NEWCATEGO','Nueva Categoría');
define('_AS_RMGS_UPLOAD','Subir Imágenes');
define('_AS_RMGS_SETS','Albumes');
define('_AS_RMGS_POSTALS','Postales');
define('_AS_RMGS_USERS','Usuarios');
define('_AS_RMGS_FIELDREQUIRED','El campo %s no puede estar vacío');
define('_AS_RMGS_FIELDUNIQUE','Los siguientes campos deben ser únicos:<br /> <strong>%s</strong>');
define('_AS_RMGS_ERRDB','Ocurrió un error al realizar esta acción:<br /><br />%s');
define('_AS_RMGS_BACK','Volver');
define('_AM_RMDP_GOPAGE', 'Página: ');
define('_AM_RMDP_PAGELOC', 'Página <strong>%s</strong> de <strong>%s</strong>');
define('_AS_RMGS_OPTIONL','Opciones');

switch (_RMGS_LOCATION){

	case 'categorias':
		define('_AS_RMGS_CATEGOSTITLE','Lista de Categorías');
		define('_AS_RMGS_NAMEL','Nombre');
		define('_AS_RMGS_DESCL','Descripci&oacute;n');
		define('_AS_RMGS_DATEL','Fecha');
		define('_AS_RMGS_IMGSINCAT','<span style="font-size: 10px;"><strong>%s</strong> Im&aacute;genes.</span>');
		
		define('_AS_RMGS_ACCESS_DESC','Solo los usuarios que pertenezcan a los grupos<br />seleccionados podrán ver esta categoría.');
		define('_AS_RMGS_ALL','Todos...');
		define('_AS_RMGS_NOBODY','Ninguno');
		define('_AS_RMGS_GROUP','Selecciona los grupos con acceso:');
		define('_AS_RMGS_WRITE','Selecciona los grupos con permisos de escritura:');
		define('_AS_RMGS_WRITEDESC','Solo los usuarios pertenecientes a los<br />grupos que selecciones podrán subir imágenes.');
		define('_AS_RMGS_FNAME','Nombre:');
		define('_AS_RMGS_FDESC','Descripci&oacute;n:');
		define('_AS_RMGS_NEWOK','Categor&iacute;a creada correctamente');
		define('_AS_RMGS_MODOK','Categor&iacute;a modificada correctamente');
		define('_AS_RMGS_NOTFOUND','No se ha encontrado la categor&iacute;a');
		define('_AS_RMGS_EDITCATEGO','Editar Categor&iacute;a');
		define('_AS_RMGS_PARENT','Categor&iacute;a Raz:');
		define('_AS_RMGS_CONFIRMDEL','Realmente deseae eliminar esta categor&iacute;a?');
		define('_AS_RMGS_DELOK','Categor&iacute;a eliminada correctamente');
		define('_AS_RMGS_ERRNAME','Por favor especifica el nombre de la categoría');
		define('_AS_RMGS_ERREXIST','Ya existe la categoría especificada');
		define('_AS_RMGS_TOTALIMGS','<strong>%s</strong> Imágenes Existentes');
		break;
		
	case 'imagenes':
	
		define('_AS_RMGS_LISTTILE','Imágenes Existentes en %s');
		define('_AS_RMGS_LIMAGE','Imágen');
		define('_AS_RMGS_LTITLE','Título');
		define('_AS_RMGS_LOCALSIZE','Local');
		define('_AS_RMGS_REMOTESIZE','Remoto');
		define('_AS_RMGS_LUSER','Usuario');
		define('_AS_RMGS_LACCES','Accesos');
		define('_AS_RMGS_LVOTES','Votos');
		define('_AS_RMGS_LOPTIONS','Opciones');
		define('_AS_RMGS_UPLOADFORM','Subir Fotos a %s');
		define('_AS_RMGS_INDISC','Selecciona las im&aacute;genes en tu disco duro y asigna palabras claves.');
		define('_AS_RMGS_KEYS',"Agregar plabras claves a esta imágenes (<span style='font-size: 10px;'>Separar con espacios</span>):");
		define('_AS_RMGS_CATEGOSP','Categorías a la que pertencen:');
		define('_AS_RMGS_IMGOK','Im&aacute;gen creada correctamente');
		define('_AS_RMGS_IMGMODOK','Im&aacute;gen modificada correctamente');
		define('_AS_RMGS_NOCATEGO','Por favor selecciona una categorías para explorar');
		define('_AS_RMGS_ERRID','No especificaste una imágen para editar');
		define('_AS_RMGS_NOIMAGE','No existe la imágen especificada');
		define('_AS_RMGS_EDITIMG','Editar Im&aacute;gen');
		define('_AS_RMGS_FTITLE','Titulo:');
		define('_AS_RMGS_FUSER','Usuario:');
		define('_AS_RMGS_FFILE','Archivo (Local):');
		define('_AS_RMGS_FFILE_URL','Archivo (URL):');
		define('_AS_RMGS_FFILETYPE','Tipo de Archivo:');
		define('_AS_RMGS_FFILEIMG','Imágen');
		define('_AS_RMGS_FFILEBIN','Descargable');
		define('_AS_RMGS_FKEYS','Palabras Clave:');
		define('_AS_RMGS_FCATEGOS','Categorías:');
		define('_AS_RMGS_FFILEDESC','Si se especifica un nuevo archivo el anterior ser eliminado.');
		define('_AS_RMGS_FAFILE','Archivo Actual:');
		define('_AS_RMGS_FOTHERS','Otros Tamaños');
		define('_AS_RMGS_ERRUPLOAD','No se pudo crear el nuevo archivo. Por favor intentalo de nuevo');
		define('_AS_RMGS_ADDSIZE','Agregar otro tamaño');
		define('_AS_RMGS_ERRTITLE','Por favor proporciona un ttulo para este elemento');
		define('_AS_RMGS_ERRFILE','Debes proporcionar el archivo para este elemento');
		define('_AS_RMGS_ERRSIZE','Especifica un elemento para eliminar');
		define('_AS_RMGS_DELELEMENT','Realmente desea eliminar este elemento?');
		define('_AS_RMGS_DELCONFIRM','Realmente deseas eliminar esta imágen?');
		define('_AS_RMGS_DELOK','Imágen eliminada correctamente.');
		break;
	
	case 'usuarios':
	
		define('_AS_RMGS_LISTTITLE','Usuarios con imágenes en el mdulo');
		define('_AS_RMGS_LUSED','Usado: %s');
		define('_AS_RMGS_USER','Usuario');
		define('_AS_RMGS_USED','Espacio Usado');
		define('_AS_RMGS_ALBUM','Albumes');
		define('_AS_RMGS_SETQUOTA','Modificar Cuota');
		define('_AS_RMGS_ACTUALQ','Cuota Actual:');
		define('_AS_RMGS_NEWQ','Nueva Cuota:');
		define('_AS_RMGS_NEWQDESC','Por favor especifica en megabytes');
		define('_AS_RMGS_ERRQUOTA','Cuota de almacenamiento no vlida. Debe ser un numero positivo.');
		define('_AS_RMGS_QUOTAOK','Cuota modificada correctamente');
		define('_AS_RMGS_CONFIRMDEL','Realmente deseas eliminar este usuario del mdulo?.<br /><br /><strong>Advertencia:</strong> Todas las imágenes y lbumes de este usuario sern eliminados tambin.');
		define('_AS_RMGS_DELOK','Usuario eliminado correctamente');
		break;
	
	case 'postales':
		define('_AS_RMGS_POSTALTITLE','Lista de Postales');
		define('_AS_RMGS_TITLE','Titulo');
		define('_AS_RMGS_FECHA','Fecha');
		define('_AS_RMGS_TEMPLATE','Plantilla');
		define('_AS_RMGS_USER','Usuario');
		define('_AS_RMGS_OPTIONS','Opciones');
		define('_AS_RMGS_ANONYM','Annimo');
		define('_AS_RMGS_NEWTPL','Nueva Plantilla');
		define('_AS_RMGS_TPLS','Plantillas');
		
		define('_AS_RMGS_TPLSLIST','Lista de Plantillas');
		define('_AS_RMGS_NOWRITE','Las plantillas no podrn ser modificadas debido a que el directorio no tiene permisos de escritura');
		define('_AS_RMGS_TPLTITLE','Título:');
		define('_AS_RMGS_TPLTEXT','Contenido:');
		define('_AS_RMGS_ERRTITLE','Por favor especifica un titulo para el archivo');
		define('_AS_RMGS_ERRTEXT','Por favor proporciona el contenido para el archivo');
		define('_AS_RMGS_ERREXIST','No existe el archivo especificado');
		define('_AS_RMGS_ERRFILEEXISTS','Ya existe un archivo con el mismo nombre');
		break;

}
?>

