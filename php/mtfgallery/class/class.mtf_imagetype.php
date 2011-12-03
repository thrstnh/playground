<?php
/**
 * Image Typen
 * @version 02.03.2005
 */
 
 class MTF_ImageType {
 	// ID
 	var $intID;
 	// Name
 	var $strName;
 	// Dateinamenerweiterung
 	var $strExtension;
 	
 	function getImageTypeByName ($p_strName) {
 		$SQL = "SELECT * "
 				. " FROM ". TABLEPREFIX ."imgtype "
 				. " WHERE name LIKE '$p_strName'";
 		$tmp_Image = mysql_fetch_object(mysql_query($SQL));
 		$this->intID = $tmp_Image->id;
 		$this->strName = $tmp_Image->name;
 		$this->strExtension = $tmp_Image->extension;
		return $this;
	}
	
	 function getImageTypeByID ($p_intID) {
 		$SQL = "SELECT * "
 				. " FROM ". TABLEPREFIX ."imgtype "
 				. " WHERE id = ". $p_intID;
 		$tmp_Image = mysql_fetch_object(mysql_query($SQL));
 		$this->intID = $tmp_Image->id;
 		$this->strName = $tmp_Image->name;
 		$this->strExtension = $tmp_Image->extension;
		return $this;
	}
	
	function write($p_strName) {
		$t_TypeArr = split("/", $p_strName);
		$t_strExtension = $t_TypeArr[1];		
		$SQL = "INSERT INTO ". TABLEPREFIX ."imgtype "
				. " (name, extension) VALUES "
				. " ('$p_strName', '$t_strExtension')";
		mysql_query($SQL) OR DIE("Der ImageType konnte nicht eingetragen werden!");
//		$tmp_Image = $this->getImageTypeByName($p_strName);
//		$this->intID = $tmp_Image->id;
// 		$this->strName = $tmp_Image->name;
// 		$this->strExtension = $tmp_Image->extension;
 		return $this;
	}
 }
?>
