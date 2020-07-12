<?php
/********************************************************************
* $Id: images_functions.php 2 2006-12-11 20:49:07Z BitC3R0 $  *
* ----------------------------------------------------------------  *
* RMSOFT Gallery System 2.0                                         *
* Sistema Avanzado de Galeras                                      *
* CopyRight  2005 - 2006. Red Mxico Soft                          *
* http://www.redmexico.com.mx                                       *
* http://www.xoops-mexico.net                                       *
*                                                                   *
* This program is free software; you can redistribute it and/or     *
* modify it under the terms of the GNU General Public License as    *
* published by the Free Software Foundation; either version 2 of    *
* the License, or (at your option) any later version.               *
*                                                                   *
* This program is distributed in the hope that it will be useful,   *
* but WITHOUT ANY WARRANTY; without even the implied warranty of    *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the      *
* GNU General Public License for more details.                      *
*                                                                   *
* You should have received a copy of the GNU General Public         *
* License along with this program; if not, write to the Free        *
* Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,    *
* MA 02111-1307 USA                                                 *
*                                                                   *
* ----------------------------------------------------------------  *
* images_functions.php: Manejo de palabras clave                    *
* ----------------------------------------------------------------  *
* @copyright:  2005 - 2006. BitC3R0.                               *
* @autor: BitC3R0                                                   *
* @paquete: RMSOFT GS v2.0                                          *
* @version: 0.1.3                                                   *
* @modificado: 22/12/2005 07:07:03 p.m.                             *
********************************************************************/


/**
 * Permite redimensionar una imgen
 * a un tamao dado
 * Es necesario contar con la extension GD2 de PHP
 */
function rmgsImageResize($source,$target,$width, $height){
      //calculamos la altura proporcional
      $datos = getimagesize($source);
      if ($datos[0] >= $datos[1]){
	  	$ratio = ($datos[0] / $width);
		$height = round($datos[1] / $ratio);
	  } else {
	  	$ratio = ($datos[1] / $height);
		$width = round($datos[0] / $ratio);
	  }
	  $type = strrchr($target, ".");
	  $type = strtolower($type);
	  
	  if ($width >= $datos[0] && $height >= $datos[1]){
	  	if ($source != $target){
			copy($source, $target);
			return;
		}
	  }
	  
      // esta ser la nueva imagen reescalada
      $thumb = imagecreatetruecolor($width,$height);
	  switch ($type){
	  	case '.jpg':
			$img = imagecreatefromjpeg($source);
			break;
		case '.gif':
			$img = imagecreatefromgif($source);
			break;
		case '.png':
			$img = imagecreatefrompng($source);
			break;
	  }
      // con esta funcin la reescalamos
      imagecopyresampled ($thumb, $img, 0, 0, 0, 0, $width, $height, $datos[0], $datos[1]);
      // la guardamos con el nombre y en el lugar que nos interesa.
	  switch ($type){
	  	case '.jpg':
      		imagejpeg($thumb,$target,80);
			break;
		case '.gif':
			imagegif($thumb,$target,80);
			break;
		case '.png':
			imagepng($thumb,$target);
			break;
	  }
	  
}

/**
 * Redimensionar una imgen a un ancho especifico
 */
function rmgsResizeWidth($source,$target,$width){
      //calculamos la altura proporcional
    $datos = getimagesize($source);
	$ratio = ($datos[0] / $width);
	$height = round($datos[1] / $ratio);
		
	$type = strrchr($target, ".");
	$type = strtolower($type);
	  
	if ($width >= $datos[0] && $height >= $datos[1]){
		if ($source != $target){
			copy($source, $target);
			return;
		}
	 }
	  
      // esta ser la nueva imagen reescalada
      $thumb = imagecreatetruecolor($width,$height);
	  switch ($type){
	  	case '.jpg':
			$img = imagecreatefromjpeg($source);
			break;
		case '.gif':
			$img = imagecreatefromgif($source);
			break;
		case '.png':
			$img = imagecreatefrompng($source);
			break;
	  }
      // con esta funcin la reescalamos
      imagecopyresampled ($thumb, $img, 0, 0, 0, 0, $width, $height, $datos[0], $datos[1]);
      // la guardamos con el nombre y en el lugar que nos interesa.
	  switch ($type){
	  	case '.jpg':
      		imagejpeg($thumb,$target,80);
			break;
		case '.gif':
			imagegif($thumb,$target,80);
			break;
		case '.png':
			imagepng($thumb,$target,80);
			break;
	  }
	  
}

/**
 * Crea multiples formatos de archivos
 * @param string $dir Directorio para almacenar las imgenes
 * @param string $filename Nombre del archivo existente
 */
function rmgsMakeFormats($dir, $filename){
      global $xoopsModuleConfig;
      
      if ($xoopsModuleConfig['othersizes']==0){ return; }
      if ($xoopsModuleConfig['sizes']==''){ return; }
      if (!file_exists($dir . $filename)){ return; }
      
      $sizes = explode("|", $xoopsModuleConfig['sizes']);
      $img_data = getimagesize($dir . $filename);
      $ext = strrchr($filename, ".");
      $filename = str_replace($ext, "", $filename);
      
      foreach ($sizes as $k){
            if ($img_data[0] >= $k){
                  rmgsImageResize($dir . $filename . $ext, $dir . 'sizes/' . $filename . '_'.$k . $ext, $k);
            }
      }
      
}

/**
 * Obtiene la imgen anterior o posterior
 * a una imgen especificada y devuelve un
 * array con la informacin de la imgen
 *
 * @param int $id Identificador de la imagen
 * @param int $catego Identificador de la categora
 * @param int $q (0) Anterior o (1) Posterior
 * @return array
 */
function rmgsPrevNext($id, $catego, $q=0, $auto=true){
	global $db;
	
	$tcat = $db->prefix('rmgs_imglink');
	$timg = $db->prefix('rmgs_imgs');
	
	$sql = "SELECT $tcat.*, $timg.* FROM $tcat, $timg WHERE ";
	if ($q==0){
		$sql .= "$tcat.id_img>'$id' AND $tcat.id_cat='$catego' AND $timg.id_img=$tcat.id_img ORDER BY $tcat.id_img ASC LIMIT 0, 1";
	}else{
		$sql .= "$tcat.id_img<'$id' AND $tcat.id_cat='$catego' AND $timg.id_img=$tcat.id_img ORDER BY $tcat.id_img DESC LIMIT 0, 1";
	}
	$result = $db->query($sql);
	if ($db->getRowsNum($result)>0){
		$row = $db->fetchArray($result);
		return $row;
	}
	$sql = "SELECT $tcat.*, $timg.* FROM $tcat, $timg WHERE $tcat.id_cat='$catego' AND $timg.id_img=$tcat.id_img";
	if ($q==0){
		$sql .= " ORDER BY $tcat.id_img ASC LIMIT 0,1"; 
	} else {
		$sql .= " ORDER BY $tcat.id_img DESC LIMIT 0, 1";
	}
	$result = $db->query($sql);
	if ($db->getRowsNum($result)<=0){ return; }
	$row = $db->fetchArray($result);
	return $row;
	
}

/**
 * Funcin para crear y obtener las imgenes de la pgina principal
 * Obtiene de la base de datos las imgenes que tengan x accesos
 * Crea nuevos formatos de imgenes y los guarda para mostrarse
 * nicamente en la pgina inicial del mdulo
 *
 * @returns int Identificiador de la imgen
 */
function rmgsGetHomeImage(){
	global $mc, $db;
	
	$dir = rmgsAddSlash($mc['storedir']);
	if (!file_exists($dir . 'config')){
		$fecha = '';
	} else {
		$file = fopen($dir . 'config', 'r');
		$fecha = fread($file, filesize($dir . 'config'));
		fclose($file);
	}
	
	$timg = $db->prefix("rmgs_imgs");
	/**
	 * Si la ultima fecha de actualizacin tieme mas de 
	 * los dias configurados entonces cargamos las nuevas
	 * imgenes y creamos nuevas para la pagina inicial
	 */
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM $timg WHERE home='1'"));
	if ($fecha < (time() - (86400 * $mc['home_update'])) || $num<=0){
		$fecha = time();
		$file = fopen($dir . 'config', 'w');
		fwrite($file, $fecha);
		fclose($file);
		
		if (!is_dir($dir . 'homes')){ mkdir($dir . 'homes', 0777); }
		
		$sql = "SELECT id_img,file,idu FROM $timg WHERE descargas>='$mc[home_access]'";

		$result = $db->query($sql);

		$xv = str_replace("XOOPS ", '',XOOPS_VERSION);
		$x22 = false;
		if (substr($xv, 2, 1)=='2'){ $x22 = true; $field = 'loginname'; } else { $field = 'uname'; }
		
		/**
		 * Comprobamos que se encuentre alguna imágen
		 */
		if ($db->getRowsNum($result)<=0){
			$sql = "SELECT id_img,file,idu FROM $timg ORDER BY RAND() LIMIT 0,1";
			$result = $db->query($sql);
			if ($db->getRowsNum($result)==1){
				$row = $db->fetchArray($result);
				$user = new GSUser($row['idu']);
				//rmgsImageResize($dir . $user->getVar($field) . '/' . $row['file'],$dir . 'homes/' . $user->getVar($field).$row['file'],$mc['home_width'],$mc['home_width']);
				resize_then_crop($dir . $user->getVar($field) . '/' . $row['file'],$dir . 'homes/' . $user->getVar($field).$row['file'],$mc['home_width'],$mc['home_width'],255,255,255);
				$db->queryF("UPDATE $timg SET `home`='1' WHERE id_img='$row[id_img]'");
			}
		}
		/**
		 * Redimensionamos las imgenes
		 */
		while ($row = $db->fetchArray($result)){
			$user = new GSUser($row['idu']);
			if (file_exists($dir . 'homes/' . $user->getVar($field).$row['file'])){ continue; }
			//rmgsImageResize($dir . $user->getVar($field) . '/' . $row['file'],$dir . 'homes/' . $user->getVar($field).$row['file'],$mc['home_width'],$mc['home_width']);
			resize_then_crop($dir . $user->getVar($field) . '/' . $row['file'],$dir . 'homes/' . $user->getVar($field).$row['file'],$mc['home_width'],$mc['home_width'],255,255,255);
		}
		
		/**
		 * Activamos al inicio las imgenes que aun no hayan
		 * sido activadas
		 */
		$db->queryF("UPDATE $timg SET `home`='1' WHERE descargas>='$mc[home_access]' AND `home`='0'");

	}
	
	/**
	 * Obtenemos una imgen aleatoria para el inicio
	 */
	if ($num<=0){ return; }
	$item = rand(0, $num - 1);
	
	list($id) = $db->fetchRow($db->query("SELECT id_img FROM $timg WHERE home='1' LIMIT $item,1"));
	return $id;
}

//Author Alan Reddan Silverarm Solutions
//Date 27/01/2005
//Function that works well with images.
//It takes the image and reduces its size to best fit. i.e If you have an image
//that is 200 X 100 and you want a thumbnail of 75 X 50,
//it first resizes the image to 100 X 50
//and then takes out a portion 75 X 50 from then center of the input image.
//So loads of image information is retained.
//The corollary also holds if your input image is 100 X 200
//it first resizes image to 75 X 150 and then takes out a
//portion 75 X 75 from the centre
// The advantage here is that function decides on whether
//resize is by width or height itself.
//it also decides whether to use the height or the width as the base start point
//in the case that athumbnail is rectangular

function resize_then_crop( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,$red,$green,$blue)
{
	// Get new dimensions
	list($width, $height) = getimagesize($filein);
	$new_width = $width * $percent;
	$new_height = $height * $percent;

	if(preg_match("/.jpg/i", "$filein")){
		$format = 'image/jpeg';
   	}
   	if (preg_match("/.gif/i", "$filein")){
		$format = 'image/gif';
	}
   	if(preg_match("/.png/i", "$filein")){
		$format = 'image/png';
	}
  
	switch($format){
    	case 'image/jpeg':
        	$image = imagecreatefromjpeg($filein);
           	break;
        case 'image/gif';
           	$image = imagecreatefromgif($filein);
           	break;
        case 'image/png':
           	$image = imagecreatefrompng($filein);
           	break;
	}

	$width = $imagethumbsize_w ;
	$height = $imagethumbsize_h ;
	list($width_orig, $height_orig) = getimagesize($filein);

	if ($width_orig < $height_orig) {
  		$height = ($imagethumbsize_w / $width_orig) * $height_orig;
	} else {
   		$width = ($imagethumbsize_h / $height_orig) * $width_orig;
	}

	if ($width < $imagethumbsize_w){
		//if the width is smaller than supplied thumbnail size
		$width = $imagethumbsize_w;
		$height = ($imagethumbsize_w/ $width_orig) * $height_orig;;
	}

	if ($height < $imagethumbsize_h){
		$height = $imagethumbsize_h;
		$width = ($imagethumbsize_h / $height_orig) * $width_orig;
	}

	$thumb = imagecreatetruecolor($width , $height); 
	$bgcolor = imagecolorallocate($thumb, $red, $green, $blue); 
	ImageFilledRectangle($thumb, 0, 0, $width, $height, $bgcolor);
	imagealphablending($thumb, true);

	imagecopyresampled($thumb, $image, 0, 0, 0, 0,
	$width, $height, $width_orig, $height_orig);
	$thumb2 = imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);
	// true color for best quality
	$bgcolor = imagecolorallocate($thumb2, $red, $green, $blue); 
	ImageFilledRectangle($thumb2, 0, 0,
	$imagethumbsize_w , $imagethumbsize_h , $white);
	imagealphablending($thumb2, true);

	$w1 =($width/2) - ($imagethumbsize_w/2);
	$h1 = ($height/2) - ($imagethumbsize_h/2);

	imagecopyresampled($thumb2, $thumb, 0,0, $w1, $h1,
	$imagethumbsize_w , $imagethumbsize_h ,$imagethumbsize_w, $imagethumbsize_h);

	// Output
	//header('Content-type: image/gif');
	//imagegif($thumb); //output to browser first image when testing

	switch($format){
    	case 'image/jpeg':
        	imagejpeg($thumb2, $fileout);
           	break;
        case 'image/gif';
           	imagegif($thumb2, $fileout);
           	break;
        case 'image/png':
           imagepng($thumb2, $fileout);
           	break;
	} //write to file
	//header('Content-type: image/gif');
	//imagegif($thumb2); //output to browser
}
?>
