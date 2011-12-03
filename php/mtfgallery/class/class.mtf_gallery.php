<?php
//include("../const.php");

/**
 * Beschreibung: Diese Klasse beinhaltet die
 * Daten fuer die Gallery
 * 
 * @author Thorsten Hillebrand
 * @version 02.03.2005
 */
class MTF_Gallery {
	// ID der Gallery
	var $intID;
	// Name der Gallery
	var $strName;
	// Information ueber die Gallery
	var $strInfo;
	// Soll die Gallery angezeigt werden?
	var $bolShowGal;
	// Passwort fuer die Gallery
	var $strPassword;
	// IndexIMG ID
	var $intIndexImgID;
	// Erstelldatum
	var $intDateAdd;
	// Ersteller
	var $intCreator;
	// Veraendert am
	var $intDateChange;
	// Veraenderer
	var $intChanger;

	/**
	 * Gallery erstellen
	 * @version 02.03.2005
	 */
	function createGallery($p_name, $p_info, $p_showgal, $p_password) {
		// Variablen setzen
		$this->strName = $p_name;
		$this->strInfo = $p_info;
		$this->bolShowGal = $p_showgal;
		$this->strPassword = $p_password;
		$this->intCreator = $_SESSION['userid'];
		
		// Query zusammenbauen
		$SQL = "INSERT INTO ". TABLEPREFIX ."gallery "
			. " (name, info, showgal, password, dateadd, creator) "
			. "VALUES "
			. " ('$this->strName', "
			. "  '$this->strInfo', "
			. "  '$this->bolShowGal', "
			. "  PASSWORD('$this->strPassword'), "
			. "  UNIX_TIMESTAMP(),"
			. "  $this->intCreator)";
		// Query ausfuehren
		mysql_query($SQL) OR DIE("Die Gallery konnte nicht erstellt werden!");
	}

	/**
	 * Gallery updaten
	 * @version 02.03.2005
	 */
	function updateGallery($p_id, $p_name, $p_info, $p_showgal, $p_password) {
		$this->intID = $p_id;
		$this->strName = $p_name;
		$this->strInfo = $p_info;
		$this->bolShowGal = $p_showgal;
		$this->strPassword = $p_password;
		$this->intChanger = $_SESSION['userid'];

		// Query erstellen
		$SQL = "UPDATE ". TABLEPREFIX ."gallery "
			. "SET "
			. " name = '$this->strName',"
			. " info = '$this->strInfo',"
			. " showgal = '$this->bolShowGal',"
			. " password = PASSWORD('$this->strPassword'),"
			. " datechange = UNIX_TIMESTAMP(),"
			. " changer = $this->intChanger "
			. "WHERE id = ". $this->intID;
		mysql_query($SQL) or die("Update der Gallery ist fehlgeschlagen!");
	}
	
	function getGalleryByID ($p_intID) {
		$SQL = "SELECT * FROM ". TABLEPREFIX ."gallery "
			. " WHERE id = ". $p_intID;
		$t_Gallery = mysql_fetch_object(mysql_query($SQL));
		$this->intID = $t_Gallery->id;
		$this->strName = $t_Gallery->name;
		$this->strInfo = $t_Gallery->info;
		$this->bolShowGal = $t_Gallery->showgal;
		$this->strPassword = $t_Gallery->password;
		$this->intIndexImgID = $t_Gallery->indeximg;
		$this->intDateAdd = $t_Gallery->dateadd;
		$this->intCreator = $t_Gallery->creator;
		$this->intDateChange = $t_Gallery->datechange;
		$this->intChanger = $t_Gallery->changer;
		return $this;
	}

	/**
	 * Liefert die gesamte Anzahl der Gallerien
	 * @version 02.03.2005
	 */
	function getCountGallerys() {
		$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."gallery";
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->count;
	}

	/**
	 * Liefert die gesamte Anzahl der Bilder
	 * @version 02.03.2005
	 */
	function getCountImages() {
		$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."img";
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->count;
	}

	/**
	 * Liefert die gesamte Anzahl der Views
	 * @version 02.03.2005
	 */
	function getCountViews() {
		$SQL = "SELECT SUM(views) AS views FROM ". TABLEPREFIX ."img";
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->views;
	}
	
	/**
	 * Liefert die Anzahl der Views per Gallery
	 * @version 12.03.2005
	 */
	function getCountViewsByID($p_intGalleryID) {
		$SQL = "SELECT SUM(views) AS views FROM ". TABLEPREFIX ."img "
				." WHERE galleryid = ". $p_intGalleryID;
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->views;
	}	

	/**
	 * Liefert die gesamte Groesse der Originale
	 * @version 02.03.2005
	 */
	function getCountSizeOriginal() {
		$SQL = "SELECT SUM(sizeoriginal) AS size FROM ". TABLEPREFIX ."img";
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->size;
	}

	/**
	 * Liefert die gesamte Groesse der Resized-Img
	 * @version 02.03.2005
	 */
	function getCountSizeResized() {
		$SQL = "SELECT SUM(sizeresized) AS size FROM ". TABLEPREFIX ."img";
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->size;
	}

	/**
	 * Liefert die gesamte Groesse der Thumb-Img
	 * @version 02.03.2005
	 */
	function getCountSizeThumb() {
		$SQL = "SELECT SUM(sizethumb) AS size FROM ". TABLEPREFIX ."img";
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->size;
	}

	/**
	 * Liefert die gesamte Groesse aller Bilder
	 * @version 02.03.2005
	 */
	function getCountSizeSum() {
		$SQL = "SELECT SUM(sizethumb) + SUM(sizeoriginal) + SUM(sizeresized) AS size FROM ". TABLEPREFIX ."img";
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->size;
	}
	
	/**
	 * Liefert die Gallery-Groesse , SUM(resized)
	 * @version 12.03.2005
	 */
	 function getCountGallerySize($p_intGalleryID) {
	 	$SQL = "SELECT SUM(sizeresized) AS size FROM ". TABLEPREFIX ."img"
	 			." WHERE galleryid = ". $p_intGalleryID;
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->size;
	 }
	
	/**
	 * Liefert die ID der naechsten Gallery
	 * @version 02.03.2005
	 */
	function getNextGalleryID() {
		$SQL = "SELECT * FROM ". TABLEPREFIX ."gallery ORDER BY id DESC LIMIT 0,1";
		$ID = mysql_fetch_object(mysql_query($SQL));
		$nextID = $ID->id;
		return $nextID;
	}
	
	/**
	 * Liefer die ID vom ersten Bild in der Gallery
	 * @version 11.03.2005
	 */
	 function getFirstImageID($p_intGalleryID) {
	 	$SQL = "SELECT id FROM ". TABLEPREFIX ."img "
	 			." WHERE galleryID = ". $p_intGalleryID ." ORDER BY id ASC LIMIT 0,1";
	 	$FirstImageID = mysql_fetch_object(mysql_query($SQL));
	 	return $FirstImageID->id;
	 }
	 
	 /**
	  * Liefert die Anzahl der nicht angezeigten bilder
	  * @version 11.03.2005
	  */
	 function getCountImagesNotShow() {
			 	$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."img "
	 			." WHERE showimg = 'false'";
	 	$Count = mysql_fetch_object(mysql_query($SQL));
	 	return $Count->count;	 		
	 }
	 
	 /**
	  * Liefert die Anzahl der angezeigten bilder
	  * @version 11.03.2005
	  */
	 function getCountImagesShow() {
			 	$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."img "
	 			." WHERE showimg = 'true'";
	 	$Count = mysql_fetch_object(mysql_query($SQL));
	 	return $Count->count;	 		
	 }
	 
	 /**
	  * Liefert die Anzahl der nicht angezeigten Gallerien
	  * @version 11.03.2005
	  */
	 function getCountGallerysNotShow() {
			 	$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."gallery "
	 			." WHERE showgal = 'false'";
	 	$Count = mysql_fetch_object(mysql_query($SQL));
	 	return $Count->count;	 		
	 }
	 
	 	 /**
	  * Liefert die Anzahl der angezeigten Gallerien
	  * @version 11.03.2005
	  */
	 function getCountGallerysShow() {
			 	$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."gallery "
	 			." WHERE showgal = 'true'";
	 	$Count = mysql_fetch_object(mysql_query($SQL));
	 	return $Count->count;	 		
	 }
}
?>
