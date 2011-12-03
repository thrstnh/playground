<?php
// Erstellt: 26.02.2005
// Ersteller: Thorsten Hillebrand
// Resize Function
function mtf_ImgResize($p_Picture, $p_NewPicture, $p_ImageType, $p_SizeInPixel, $p_ImageQuality){
	// Pfad zum OriginalBild
	$OriginalPicture = $p_Picture;
	// Pfad zum neuen Bild
	$DestPicture = $p_NewPicture;
	// Ressource vom Bild
	$handle = "";
	// OriginalBreite
	$OriginalSizeX = "";
	// OriginalHoehe
	$OriginalSizeY = "";
	// Maximale neue Groesse
	$MaxSize = "";
	// Minimale neue Groesse
	$MinSize = "";
	// Groesse in Pixel
	$SizeInPixel = "";
	// Proportionale Rate
	$Rate = "";
	// Neue Breite
	$NewSizeX = "";
	// Neue Hoehe
	$NewSizeY = "";
	// Temporaeres Bild
	$TmpPic = "";
	// Image Typ
	$ImageType = "";
	

	// Wenn die Groesse in Pixel nicht uebergeben
	// wurde, wird 100 als Standard gesetzt
	if(!isset($p_SizeInPixel)) {
		$SizeInPixel = "100";
	} else {
		$SizeInPixel = $p_SizeInPixel;
	}
	
	// ImageTyp
	$ImageType = $p_ImageType;
	
	// Entscheiden, welcher Typ es ist und eine
	// Ressource ID zum bearbeiten erstellen
	// JPEG
	if($ImageType == "image/jpeg") {
		$handle = @imagecreatefromjpeg($OriginalPicture);
	} 
	// PNG
	else if($ImageType == "image/png") {
		$handle = @imagecreatefrompng($OriginalPicture);
	} 
	// GIF
	else if($ImageType == "image/gif") {
		$handle = @imagecreatefromgif($OriginalPicture);
	}
	
	// Original Breite
	$OriginalSizeX = imagesx($handle);
	// Original Hoehe
	$OriginalSizeY = imagesy($handle);

	// Wenn die Original Breite groesser ist als die Original Hoehe...
	if($OriginalSizeX > $OriginalSizeY){
		// 
		$MaxSize = $OriginalSizeX;
		$MinSize = $OriginalSizeY;
	}      
	// Wenn die Original Breite kleiner oder gleich der Original Hoehe ist...
	if($OriginalSizeX <= $OriginalSizeY){                               
		//
		$MaxSize = $OriginalSizeY;
		$MinSize = $OriginalSizeX;
	}

	// Proportionale Rate berechnen
	$Rate = $MaxSize / $SizeInPixel;
	// Die neue Breite proportional setzen
	$NewSizeX = $OriginalSizeX / $Rate;
	// Die neue Breite proportional setzen
	$NewSizeY = $OriginalSizeY / $Rate;
		
	// Wenn die neue Breite groesser ist als die original Breite...
	if($NewSizeX > $OriginalSizeX) {
		// werden Breite und Hoehe vom original
		// Bild verwendet
		$NewSizeX = $OriginalSizeX;
		$NewSizeY = $OriginalSizeY;
	}

	// Die neuen Groessen abrunden
	$NewSizeX = ceil($NewSizeX);
	$NewSizeY = ceil($NewSizeY);

	// Tmp Bild zum resizen erstellen
	$TmpPic = imageCreatetruecolor($NewSizeX, $NewSizeY);

	// Das Bild resizen
	imagecopyresampled($TmpPic, $handle, 0, 0, 0, 0, $NewSizeX, $NewSizeY, $OriginalSizeX, $OriginalSizeY);
	
	// Das Bild zum Zielpfad kopieren
	// JPG
	if($ImageType == "image/jpeg") {
		imagejpeg($TmpPic, $DestPicture, $p_ImageQuality);
	} 
	// PNG
	else if($ImageType == "image/png") {
		imagepng($TmpPic, $DestPicture, $p_ImageQuality);
	} 
	// GIF
	else if($ImageType == "image/gif") {
		imagegif($TmpPic, $DestPicture, $p_ImageQuality);
	}

	// Die Tmp Daten loeschen um den Speicher freizugeben
	imagedestroy($handle);
	imagedestroy($TmpPic);
}

function MTF_Rotate($p_ImageID, $p_angle){
	if(isset($p_angle)) {
		$angle = $p_angle;
	} else {
		$angle = 90;
	}
	$t_objMTF_Image = new MTF_Image();
	$t_objMTF_Image->getImageByID($p_ImageID);
	if($t_objMTF_Image->intID > 0) {
		$t_objMTF_ImageType = new MTF_ImageType();
		$t_objMTF_ImageType->getImageTypeByID($t_objMTF_Image->intTypeID);
		
		// Entscheiden, welcher Typ es ist und eine
		// Ressource ID zum bearbeiten erstellen
		// JPEG
		if($t_objMTF_ImageType->strName == "image/jpeg") {
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				$handleOriginal = @imagecreatefromjpeg($t_objMTF_Image->strPathOriginal);
			}
			$handleResized = @imagecreatefromjpeg($t_objMTF_Image->strPathResized);
			$handleThumb = @imagecreatefromjpeg($t_objMTF_Image->strPathThumb);
			
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				$handleOriginal = imagerotate($handleOriginal, $angle, 0);
			}
			$handleResized = imagerotate($handleResized,$angle, 0);
			$handleThumb = imagerotate($handleThumb, $angle, 0);
			
			
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				imagejpeg($handleOriginal, $t_objMTF_Image->strPathOriginal, 100);
			}
			imagejpeg($handleResized, $t_objMTF_Image->strPathResized, 100);
			imagejpeg($handleThumb, $t_objMTF_Image->strPathThumb, 100);

			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {			
				$t_objMTF_Image->intHeightOriginal = imagesy($handleOriginal);
				$t_objMTF_Image->intWidthOriginal = imagesx($handleOriginal);
			}
			$t_objMTF_Image->intHeightResized = imagesy($handleResized);
			$t_objMTF_Image->intWidthResized = imagesx($handleResized);
			$t_objMTF_Image->intHeightThumb = imagesy($handleThumb);
			$t_objMTF_Image->intWidthThumb = imagesx($handleThumb);
			$t_objMTF_Image->update();
		} 
		// PNG
		else if($t_objMTF_ImageType->strName == "image/png") {
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				$handleOriginal = @imagecreatefrompng($t_objMTF_Image->strPathOriginal);
			}
			$handleResized = @imagecreatefrompng($t_objMTF_Image->strPathResized);
			$handleThumb = @imagecreatefrompng($t_objMTF_Image->strPathThumb);
			
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				$handleOriginal = imagerotate($handleOriginal, 90, 0);
			}
			$handleResized = imagerotate($handleResized, 90, 0);
			$handleThumb = imagerotate($handleThumb, 90, 0);
			
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				imagepng($handleOriginal, $t_objMTF_Image->strPathOriginal, 100);
			}
			imagepng($handleResized, $t_objMTF_Image->strPathResized, 100);
			imagepng($handleThumb, $t_objMTF_Image->strPathThumb, 100);
			
			$t_objMTF_Image->intHeightOriginal = imagesy($handleOriginal);
			$t_objMTF_Image->intWidthOriginal = imagesx($handleOriginal);
			$t_objMTF_Image->intHeightResized = imagesy($handleResized);
			$t_objMTF_Image->intWidthResized = imagesx($handleResized);
			$t_objMTF_Image->intHeightThumb = imagesy($handleThumb);
			$t_objMTF_Image->intWidthThumb = imagesx($handleThumb);
			$t_objMTF_Image->update();
		} 
		// GIF
		else if($t_objMTF_ImageType->strName == "image/gif") {
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				$handleOriginal = @imagecreatefromgif($t_objMTF_Image->strPathOriginal);
			}
			$handleResized = @imagecreatefromgif($t_objMTF_Image->strPathResized);
			$handleThumb = @imagecreatefromgif($t_objMTF_Image->strPathThumb);
			
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				$handleOriginal = imagerotate($handleOriginal, 90, 0);
			}
			$handleResized = imagerotate($handleResized, 90, 0);
			$handleThumb = imagerotate($handleThumb, 90, 0);
			
			if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
				imagegif($handleOriginal, $t_objMTF_Image->strPathOriginal, 100);
			}
			imagejpeg($handleResized, $t_objMTF_Image->strPathResized, 100);
			imagejpeg($handleThumb, $t_objMTF_Image->strPathThumb, 100);
			
			$t_objMTF_Image->intHeightOriginal = imagesy($handleOriginal);
			$t_objMTF_Image->intWidthOriginal = imagesx($handleOriginal);
			$t_objMTF_Image->intHeightResized = imagesy($handleResized);
			$t_objMTF_Image->intWidthResized = imagesx($handleResized);
			$t_objMTF_Image->intHeightThumb = imagesy($handleThumb);
			$t_objMTF_Image->intWidthThumb = imagesx($handleThumb);
			$t_objMTF_Image->update();
		} else {
			echo("Falscher Image Typ!");
		}
		
		if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
			imagedestroy($handleOriginal);
		}
		imagedestroy($handleResized);
		imagedestroy($handleThumb);
		
	} else {
		echo("Das Bild konnte nicht gedreht werden!");
	}
}


function rmdirr($dirname)
{
    // Sanity check
    if (!file_exists($dirname)) {
        return false;
    }
 
    // Simple delete for a file
    if (is_file($dirname)) {
        return unlink($dirname);
    }
 
    // Loop through the folder
    $dir = dir($dirname);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }
 
        // Recurse
        rmdirr("$dirname/$entry");
    }
 
    // Clean up
    $dir->close();
    return rmdir($dirname);
}

function ftp_rmdirr($dirname)
{
    // Sanity check
    if (!file_exists($dirname)) {
        return false;
    }
 
    // Simple delete for a file
    if (is_file($dirname)) {
        return unlink($dirname);
    }
 
    // Loop through the folder
    $dir = dir($dirname);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }
 
        // Recurse
        rmdirr("$dirname/$entry");
    }
 
    // Clean up
    $dir->close();
    return rmdir($dirname);
}

function ftp_rmAll($conn_id,$dst_dir)
{
  $ar_files = ftp_rawlist($conn_id, $dst_dir);
  if (is_array($ar_files)) { // makes sure there are files
   foreach ($ar_files as $st_file) { // for each file
     if (ereg("([-d][rwxst-]+).* ([0-9]) ([a-zA-Z0-9]+).* ([a-zA-Z0-9]+).* ([0-9]*) ([a-zA-Z]+[0-9: ]*[0-9]) ([0-9]{2}:[0-9]{2}) (.+)",$st_file,$regs)) {
       if (substr($regs[1],0,1)=="d") { // check if it is a directory
         ftp_rmAll($conn_id, $dst_dir."/".$regs[8]); // if so, use recursion
       } else {
         ftp_delete($conn_id, $dst_dir."/".$regs[8]); // if not, delete the file
       }
     }
   }
  }
  ftp_rmdir($conn_id, $dst_dir); // delete empty directories
}
?>
