<?php
class MTF_Image {
	// ID vom Bild
	var $intID = 0;
	// Name
	var $strName = "";
	// Pfad zum OriginalBild
	var $strPathOriginal = "";
	// Pfad zum Resized Bild
	var $strPathResized = "";
	// Pfad zum Thumb Bild
	var $strPathThumb = "";
	// GalleryID
	var $intGalleryID = 0;
	// ToolTipText
	var $strTitle = "";
	// Alternativer Text
	var $strAltText = "";
	// Breite vom Original Bild
	var $intWidthOriginal = 0;
	// Breite vom Resized Bild
	var $intWidthResized = 0;
	// Breite vom Thumb
	var $intWidthThumb = 0;
	// Hoehe vom Original Bild
	var $intHeightOriginal = 0;
	// Hoehe vom Resized Bild
	var $intHeightResized = 0;
	// Hoehe vom Thumb
	var $intHeightThumb = 0;
	// Groesse vom Original
	var $intSizeOriginal = 0;
	// Groesse vom Resized
	var $intSizeResized = 0;
	// Groesse vom Thumb
	var $intSizeThumb = 0;
	// TypeID
	var $intTypeID = 0;
	// Bild anzeigen?
	var $bolShowImg = "true";
	// Views
	var $intViews = 0;
	// Comment
	var $strComment = "";
	// Dateadd
	var $intDateadd = 0;
	// Creator
	var $intCreator = 0;
	// Datechange
	var $intDatechange = 0;
	// Changer
	var $intChanger = 0;
	
	/**
	 * Sucht die nächste ID fuer die jeweilige Gallery und gibt diese zurueck
	 * @version 02.03.2005
	 */
	function getNextImageID ($p_GalleryID) {
		$this->intGalleryID = $p_GalleryID;
		$SQL = "SELECT COUNT(id) AS id "
				. " FROM ". TABLEPREFIX ."img";// WHERE galleryid = ". $this->intGalleryID;
		$ID = mysql_fetch_object(mysql_query($SQL));
		$ID = ($ID->id+1);
		return $ID;
	}
	
	function getImageByID ($p_intID) {
		$SQL = "SELECT * FROM ". TABLEPREFIX ."img WHERE id = ". $p_intID;
		$t_objImage = mysql_fetch_object(mysql_query($SQL));
		$this->intID = $t_objImage->id;
		$this->strName = $t_objImage->name;
		$this->strPathOriginal = $t_objImage->pathoriginal;
		$this->strPathResized = $t_objImage->pathresized;
		$this->strPathThumb = $t_objImage->paththumb;
		$this->intGalleryID = $t_objImage->galleryid;
		$this->strTitle = $t_objImage->title;
		$this->strAltText = $t_objImage->alttext;
		$this->intWidthOriginal = $t_objImage->widthoriginal;
		$this->intHeightOriginal = $t_objImage->heightoriginal;
		$this->intWidthResized = $t_objImage->widthresized;
		$this->intHeightResized = $t_objImage->heightresized;
		$this->intWidthThumb = $t_objImage->widththumb;
		$this->intHeightThumb = $t_objImage->heightthumb;
		$this->intSizeOriginal = $t_objImage->sizeoriginal;
		$this->intSizeResized = $t_objImage->sizeresized;
		$this->intSizeThumb = $t_objImage->sizethumb;
		$this->intTypeID = $t_objImage->typeid;
		$this->bolShowImg = $t_objImage->showimg;
		$this->intViews = $t_objImage->views;
		$this->strComment = $t_objImage->comment;
		$this->intDateAdd = $t_objImage->dateadd;
		$this->intCreator = $t_objImage->creator;
		$this->intDateChange = $t_objImage->datechange;
		$this->intChanger = $t_objImage->changer;
		return $this;
	}
	
	function AddView ($p_intID) {
		$SQL = "SELECT views FROM ". TABLEPREFIX ."img WHERE id = ". $p_intID;
		$Views = mysql_fetch_object(mysql_query($SQL));
		$SQL = "UPDATE ". TABLEPREFIX ."img "
			." SET views = ($Views->views + 1)"
			." WHERE id = ". $p_intID;
		mysql_query($SQL);
	}
	
	function write () {
		$SQL = "INSERT INTO ". TABLEPREFIX ."img "
			." (name, "
			."  pathoriginal, "
			."  pathresized, "
			."  paththumb, "
			."  galleryid, "
			."  title, "
			."  alttext, "
			."  widthoriginal, "
			."  heightoriginal, "
			."  widthresized, "
			."  heightresized, "
			."  widththumb, "
			."  heightthumb, "
			."  sizeoriginal, "
			."  sizeresized, "
			."  sizethumb, "
			."  typeid, "
			."  showimg, "
			."  views, "
			."  comment, "
			."  dateadd, "
			."  creator) "
			."VALUES"
			." ('$this->strName', " 
			."  '$this->strPathOriginal', " 
			."  '$this->strPathResized', " 
			."  '$this->strPathThumb', " 
			."   $this->intGalleryID, " 
			."  '$this->strTitle', " 
			."  '$this->strAltText', " 
			."   $this->intWidthOriginal, " 
			."   $this->intHeightOriginal, " 
			."   $this->intWidthResized, " 
			."   $this->intHeightResized, " 
			."   $this->intWidthThumb, " 
			."   $this->intHeightThumb, " 
			."   $this->intSizeOriginal, " 
			."   $this->intSizeResized, " 
			."   $this->intSizeThumb, " 
			."   $this->intTypeID, " 
			."  '$this->bolShowImg', " 
			."   $this->intViews, "
			."  '$this->strComment', "  
			."   UNIX_TIMESTAMP(), "
			."   $this->intCreator)"; 
		mysql_query($SQL) OR DIE(mysql_error());
	}
	
	function update () {
		$SQL = "UPDATE ". TABLEPREFIX ."img "
			." SET "
			."  name = '". $this->strName ."', "
			."  pathoriginal = '". $this->strPathOriginal ."', "
			."  pathresized = '". $this->strPathResized ."', "
			."  paththumb = '". $this->strPathThumb ."', "
			."  galleryid = ". $this->intGalleryID .", "
			."  title = '". $this->strTitle ."', "
			."  alttext = '". $this->strAltText ."', "
			."  widthoriginal = ". $this->intWidthOriginal .", "
			."  heightoriginal = ". $this->intHeightOriginal .", "
			."  widthresized = ". $this->intWidthResized .", "
			."  heightresized = ". $this->intHeightResized .", "
			."  widththumb = ". $this->intWidthThumb .", "
			."  heightthumb = ". $this->intHeightThumb .", "
			."  sizeoriginal = ". $this->intSizeOriginal .", "
			."  sizeresized = ". $this->intSizeResized .", "
			."  sizethumb = ". $this->intSizeThumb .", "
			."  typeid = ". $this->intTypeID .", "
			."  showimg = '". $this->bolShowImg ."', "
			."  views = ". $this->intViews .", "
			."  comment = '". $this->strComment ."', "
			."  datechange = UNIX_TIMESTAMP(), "
			."  changer = ". $_SESSION['userid']
			." WHERE id = ". $this->intID;
		mysql_query($SQL) OR DIE(mysql_error());
	}
	
	function resize () {
		
	}
	
	function getGalleryImages($p_intGalleryID, $p_strOrderyBy, $p_strSort) {
		// Wenn OrderBy nicht gesetzt ist, wird der Standardwert genommen
		if(!isset($p_strOrderBy)) {
			$p_strOrderyBy = CONF_ORDERBY;
		}
		// Wenn Sort nicht gesetzt ist, wird der Standardwert genommen
		if(!isset($p_strSort)) {
			$p_strSort = CONF_SORT;
		}
		// Alle Bilder der GalleryID auslesen
		$SQL = "SELECT * FROM ". TABLEPREFIX ."img "
					." WHERE galleryid = ". $p_intGalleryID ." "
					." ORDER BY ". $p_strOrderyBy . " "
					." ". $p_strSort;
		// Array mit den Bildern
		$t_arrImages = mysql_query($SQL);
		$i = 0;
		// Bilddaten in MTF_Image Objekt packen und die Bilder in ein Array,
		// welches dann zurueckgegeben wird
		while($img = mysql_fetch_object($t_arrImages)) {
			$t_objImage->intID = $img->id;
			$t_objImage->strName = $img->name;
			$t_objImage->strPathOriginal = $img->pathoriginal;
			$t_objImage->strPathResized = $img->pathresized;
			$t_objImage->strPathThumb = $img->paththumb;
			$t_objImage->intGalleryID = $img->galleryid;
			$t_objImage->strTitle = $img->title;
			$t_objImage->strAltText = $img->alttext;
			$t_objImage->intWidthOriginal = $img->widthoriginal;
			$t_objImage->intHeightOriginal = $img->heightoriginal;
			$t_objImage->intWidthResized = $img->widthresized;
			$t_objImage->intHeightResized = $img->heightresized;
			$t_objImage->intWidthThumb = $img->widththumb;
			$t_objImage->intHeightThumb = $img->heightthumb;
			$t_objImage->intSizeOriginal = $img->sizeoriginal;
			$t_objImage->intSizeResized = $img->sizeresized;
			$t_objImage->intSizeThumb = $img->sizethumb;
			$t_objImage->intTypeID = $img->typeid;
			$t_objImage->bolShowImg = $img->showimg;
			$t_objImage->intViews = $img->views;
			$t_objImage->strComment = $t_objMTF_Image->comment;
			$t_objImage->intDateAdd = $img->dateadd;
			$t_objImage->intCreator = $img->creator;
			$t_objImage->intDateChange = $img->datechange;
			$t_objImage->intChanger = $img->changer;
			$t_objReturnImage[$i] = $t_objImage;
			$i++;
		}
		return $t_objReturnImage;
	}
	
	function getTopViewdImage() {
		$SQL = "SELECT MAX(views) AS views FROM ". TABLEPREFIX ."img";
		$Views = mysql_fetch_object(mysql_query($SQL));
		if($Views->views != null) {
			$SQL = "SELECT * FROM ". TABLEPREFIX ."img WHERE views = ". $Views->views ." and showimg = 'true'";
			// Das Bild mit der ID auslesen
			$TopViewImg = mysql_fetch_object(mysql_query($SQL));
		}
		return $TopViewImg;
	}
	
	function getRandomImage() {
		$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."img WHERE showimg = 'true'";
		$Count = mysql_fetch_object(mysql_query($SQL));
		if($Count->count != null) {
			// Zufallsstartwert festlegebn
			srand(microtime()*1000000);
			// Zufallszahl ermitteln
			$RandomNr = rand(1, $Count->count);
			// Das Bild mit der ID auslesen
			$SQL = "SELECT id FROM ". TABLEPREFIX ."img";
			$Result = mysql_query($SQL);
			$i = 0;
			while($obj = mysql_fetch_object($Result)) {
				$arrID[$i] = $obj->id;
				$i++; 
			}
			$randomid = round($arrID[$RandomNr]);
			$SQL = "SELECT * FROM ". TABLEPREFIX ."img WHERE id = ". $randomid;
			$RandomImg = mysql_fetch_object(mysql_query($SQL));
		}
		return $RandomImg;
	}
}
?>
