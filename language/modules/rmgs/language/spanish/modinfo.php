<?php
/***********************************************************************
* $Id: modinfo.php 2 2006-12-11 20:49:07Z BitC3R0 $              *
* -------------------------------------------------------              *
* RMSOFT Gallery System 2.0                                            *
* Sistema Avanzado de Galeras                                         *
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
define('_MI_RMGS_DESC','Sistema Avanzado de Galeras y lbumes de imágenes en lnea');

// Menu del Administrador
define('_MI_RMGS_ADM1','Estado Actual');
define('_MI_RMGS_ADM2','Categorías');
define('_MI_RMGS_ADM3','Nueva Categora');
define('_MI_RMGS_ADM4','Subir Im&aacute;genes');
define('_MI_RMGS_ADM5','Usuarios');
define('_MI_RMGS_ADM6','Postales');

// Menu de Usuarios
define('_MI_RMGS_USR1','Mis Fotos');
define('_MI_RMGS_USR2','Publicar Fotos');
define('_MI_RMGS_USR3','Buscar Fotos');
define('_MI_RMGS_USR4','Favoritos');

// Configuración
define('_MI_RMGS_FDATE','Formato de Fecha:');
define('_MI_RMGS_MODTITLE','Título del Módulo:');
define('_MI_RMGS_UPLOADSQ','Cantidad de Imágenes a Subir al mismo tiempo:');
define('_MI_RMGS_STOREDIR','Directorio para almacenar imágenes:');
define('_MI_RMGS_STOREDIRDESC',"<span style='font-size: 10px;'>El directorio debe tener permisos de escritura. Si cambias este directorio despues de haber creado imágenes debers copiar el contenido del directorio anterior a este nuevo para un correcto funcionamiento.</span>");
define('_MI_RMGS_QUOTA','Cuota inicial de almacenamiento para los usuarios:');
define('_MI_RMGS_QUOTADESC',"<span style='font-size: 10px;'>Especifique la cantidad en MB. Es posible modificar posteriormente este valor para cada usuario.</span>");
define('_MI_RMGS_IMGWIDTH','Ancho de imágenes:');
define('_MI_RMGS_IMGHEIGHT','Alto de imágenes:');
define('_MI_RMGS_THWIDTH','Ancho de Miniaturas:');
define('_MI_RMGS_THHEIGHT','Alto de Miniaturas:');
define('_MI_RMGS_ACTIVEOTHER','Activar otros tamaños de imágenes:');
define('_MI_RMGS_ACTIVEOTHER_DESC','<span style="font-size: 10px;">Activa los campos para proveer otros tamaños o formatos de una imágen</span>');
define('_MI_RMGS_OTHERLOCAL','Permitir almacenamiento local de otros tamaños:');
define('_MI_RMGS_OTHERSIZESLIMIT','Limite de tamaños diferentes:');
define('_MI_RMGS_MINKEY','Longitud mínima de las palabras clave:');
define('_MI_RMGS_MAXKEY','Longitud máxima de las palabras clave:');
define('_MI_RMGS_THUMSINDEX','Miniaturas en la página principal:');
define('_MI_RMGS_CATNEWDAYS','Días para considerar una categora como nueva');
define('_MI_RMGS_COLUMNS','Número de columnas para las galerías:');
define('_MI_RMGS_IMGASNEW','Días para considerar una imágen como nueva:');
define('_MI_RMGS_IMGASUPDATE','Días para considerar una imágen como actualizada:');
define('_MI_RMGS_ALLOWUPLOAD','Activar carga de imágenes:');
define('_MI_RMGS_ALLOWSETS','Permitir la creacin de álbumes:');
define('_MI_RMGS_ALLOWPOSTAL','Activar postales:');
define('_MI_RMGS_VOTEANONY','Permtir votos de usuarios anónimos:');
define('_MI_RMGS_POSTALDAYS','Días que una postal permanecer en la base de datos');
define('_MI_RMGS_POSTALANONYM','Permitir a los usuarios anónimos enviar postales:');
define('_MI_RMGS_EDITOR','Tipo de Editor:');
define('_MI_RMGS_MAILPOSTAL','Email de Envío de Postales:');
define('_MI_RMGS_MAILPOSTAL_DESC','Este email aparecer en el correo que recibir el destinatario.');
define('_MI_RMGS_HOMEACCESS','Accesos Mínimos para presentar una imágen en la pgina principal del mdulo:');
define('_MI_RMGS_HOMEWIDTH','Ancho de Imágenes de la Pgina Principal:');
define('_MI_RMGS_HOMEUPDATE','Días para generar imágenes de Inicio:');
define('_MI_RMGS_POPULAR','Accesos para considerar como popular una imágen:');
define('_MI_RMGS_BESTVOTES','Nmero de Votos para considerar una imágen dentro de las mejor votadas:');
define('_MI_RMGS_BESTVOTES_DESC','Cuando una imágen alcance estos votos ser listada dentro de las imágenes mejor votadas');

// Editores
define("_MI_RMGS_FORM_COMPACT","Compacto");
define("_MI_RMGS_FORM_DHTML","DHTML");
define("_MI_RMGS_FORM_SPAW","Editor Spaw");
define("_MI_RMGS_FORM_HTMLAREA","Editor HtmlArea");
define("_MI_RMGS_FORM_FCK","Editor FCK");
define("_MI_RMGS_FORM_KOIVI","Editor Koivi");

// Bloques
define('_MI_RMGS_RANDOMBK','Imágen al Azar');
define('_MI_RMGS_BKRECENTS','Imágenes Recientes');

define('_MI_RMGS_BKREC_IMAGES','Mostrar Imágenes:');
define('_MI_RMGS_BKPOPULARS','Imágenes Populares');
define('_MI_RMGS_BKVOTED','Mejor Votadas');
define('_MI_RMGS_BKCATS','Categorías');

//Added by Kaotik
define('_MI_RMGS_RANDOMIMGBK','Imágenes al Azar:');
define('_MI_RMGS_BKCOL_NUMBER','Número de Columnas:');
?>