<?php
/*******************************************************************
* $Id: menu.php 2 2006-12-11 20:49:07Z BitC3R0 $             *
* ----------------------------------------------------             *
* RMSOFT Gallery System 2.0                                        *
* Sistema Avanzado de Galerías                                     *
* CopyRight (c) 2005 - 2006. Red México Soft                       *
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
* menu.php: Items del Menu                                         *
* ----------------------------------------------------             *
* @copyright: © 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: Archivo PHP                                            *
* @version: 0.1.0                                                  *
* @modificado: 16/12/2005 04:08:00 p.m.                            *
*******************************************************************/

$adminmenu[0]['title'] = _MI_RMGS_ADM1;
$adminmenu[0]['link'] = "admin/index.php";
$adminmenu[0]['icon'] = "images/state.png";
$adminmenu[1]['title'] = _MI_RMGS_ADM2;
$adminmenu[1]['link'] = "admin/categos.php";
$adminmenu[1]['icon'] = "images/categos.png";
$adminmenu[2]['title'] = _MI_RMGS_ADM3;
$adminmenu[2]['link'] = "admin/categos.php?op=new";
$adminmenu[2]['icon'] = "images/categosnew.png";
$adminmenu[3]['title'] = _MI_RMGS_ADM4;
$adminmenu[3]['link'] = "admin/images.php?op=upload";
$adminmenu[3]['icon'] = "images/uploadmenu.png";
$adminmenu[4]['title'] = _MI_RMGS_ADM5;
$adminmenu[4]['link'] = "admin/users.php";
$adminmenu[4]['icon'] = "images/users.png";
$adminmenu[5]['title'] = _MI_RMGS_ADM6;
$adminmenu[5]['link'] = "admin/postals.php";
$adminmenu[5]['icon'] = "images/postal.png";
?>

