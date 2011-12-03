<?php
session_start();
include("class/class.mtf_mysql.php");
include("class/class.mtf_gallery.php");
include("class/class.mtf_galuser.php");
include("class/class.mtf_imagetype.php");
include("class/class.mtf_image.php");
include("class/class.mtf_imgcomment.php");
include("functions.php");
include("conf.php");
include("const/const.php");
include("const/const.view.php");
include("const/const.thumb.php");

// Datenbankobjekt erstellen
$mtf_mysqldb = new mtf_mysqldb();
// mit der Datenbank verbinden
$dblink = $mtf_mysqldb->mtf_connect();

// Gallery-Objekt erstellen
$mtf_gallery = new mtf_gallery();

// Imageverzeichnis
$strGalleryImageRoot = "gallerys/";

// Ausloggen
if($_REQUEST['action'] == "logout") {
	$_SESSION['login'] = false;
	$_SESSION['userid'] = "0";
	$_SESSION['admin'] = false;
	session_destroy();
}

// Wenn der User nicht eingeloggt ist 
// und die action login ist...
if($_SESSION['login'] != true 
		|| $_REQUEST['action'] == "login") {
	// Login-Formular anzeigen
	include("admin/login.php");
}

// Wenn der User eingeloggt ist...
if($_SESSION['login'] == true) {
	
	//-----------------------------------------------------------
	// Gallery anlegen
	//-----------------------------------------------------------
	// Wenn die action create ist... 
	if($_REQUEST["action"] == "create") {
		//--------------------------
		// Variablen
		//--------------------------
		// Gallery Objekt zum anlegen der Gallery		
		$t_objMTF_Gallery = new mtf_gallery();
		// Name der Gallery
		$t_strGalleryName = "";
		// Info zur Gallery
		$t_strGalleryInfo = "";
		// Gallery anzeigen?
		$t_bolShowGallery = "";
		// GalleryOrdner
		$t_strGalleryDir = "";
		// GalleryOrdner erfolgreich erstellt?
		$t_bolGalleryDirCreated = false;
		// GalleryOriginalOrdner erfolgreich erstellt?
		$t_bolGalleryOriginalDirCreated = false;
		// GalleryThumbOrdner erfolgreich erstellt?
		$t_bolGalleryThumbDirCreated = false;
		
		// Der GalleryName muss mindestens vorhanden sein,
		// damit die Gallery erstellt werden kann.
		if(isset($_REQUEST['galname']) && $_REQUEST['galname'] != null) {
			
			// Name der Gallery
			$t_strGalleryName = $_REQUEST['galname'];
			// Info zur Gallery
			$t_strGalleryInfo = $_REQUEST['galinfo'];
			// Password fuer die Gallery?
			$t_strGalleryPassword = $_REQUEST['galpass'];
			// Gallery anzeigen?
			if(isset($_REQUEST['galshowgal'])) {
				$t_bolShowGallery = "true";
			} else {
				$t_bolShowGallery = "false";
			}
			
			$t_objMTF_Gallery->createGallery($t_strGalleryName, $t_strGalleryInfo, $t_bolShowGallery, $t_strGalleryPassword);
			
			// FTP
			// erstellen der Ordner per FTP, falls die FTP-Daten vorhanden sind 
			if(FTPHOST != null && FTPUSER != null && FTPPASS != null) {
				$FTPconnID = ftp_connect(FTPHOST); 
				$LoginResult = ftp_login($FTPconnID, FTPUSER, FTPPASS);
			}
			
			// Die GalleryID holen
			$t_intNextGalleryID = $t_objMTF_Gallery->getNextGalleryID();
			if(!isset($t_intNextGalleryID) || $t_intNextGalleryID == "0") {
				$t_intNextGalleryID = "1";
			}
			
			// GalleryOrdnerName
			$t_strGalleryDir = $strGalleryImageRoot . $t_intNextGalleryID;
			
			//
			$RootDir = CONF_GALDIR . $strGalleryImageRoot;
				
			// FTP
			// erstellen der Ordner per FTP
			if(FTPHOST != null && FTPUSER != null && FTPPASS != null) {
				// Hauptordner
				$FTPPath =  CONF_GALDIR . $t_strGalleryDir;
				$CMD_chmod = "CHMOD 0777 ". $FTPPath;
				ftp_mkdir($FTPconnID, $FTPPath);
				$t_bolGalleryDirCreated = ftp_site($FTPconnID, $CMD_chmod);
				
				// Ordner fuer das Original
				$FTPPath =  CONF_GALDIR . $t_strGalleryDir ."/original";
				$CMD_chmod = "CHMOD 0777 ". $FTPPath;
				ftp_mkdir($FTPconnID, $FTPPath);
				$t_bolGalleryOriginalDirCreated = ftp_site($FTPconnID, $CMD_chmod);
	
				// Ordner fuer die Thumbs
				$FTPPath =  CONF_GALDIR . $t_strGalleryDir ."/thumb";
				$CMD_chmod = "CHMOD 0777 ". $FTPPath;
				ftp_mkdir($FTPconnID, $FTPPath);
				$t_bolGalleryThumbDirCreated = ftp_site($FTPconnID, $CMD_chmod);
			} 
			// Ordner durch PHP erstellen
			else {
				// Hauptordner
				$Path = $t_strGalleryDir;
				$t_bolGalleryDirCreated = mkdir($Path, 0777);

				// Order fuer das Original
				$Path = $t_strGalleryDir ."/original";
				$t_bolGalleryOriginalDirCreated = mkdir($Path, 0777);

				// Ordner fuer die Thumbs
				$Path = $t_strGalleryDir ."/thumb";
				$t_bolGalleryThumbDirCreated = mkdir($Path, 0777);
			}
			
			// Falls per FTP die Ordner erstellt wurden, Verbindung beenden
			if(FTPHOST != null && FTPUSER != null && FTPPASS != null) {
				ftp_close($FTPconnID);
			}
			
			if($t_bolGalleryDirCreated != true
					|| $t_bolGalleryOriginalDirCreated != true
					|| $t_bolGalleryThumbDirCreated != true) {
				$SQL = "DELETE FROM ". TABLEPREFIX ."gallery WHERE id = ". $t_intNextGalleryID;
				mysql_query($SQL);
			}
		}
		// Wenn der GalleryName nicht vorhanden ist... 
		else {
			echo("<b>Das Feld 'Name' muss ausgef&uuml;llt sein!<br />\n");
		}
	}

	//-----------------------------------------------------
	// Gallery updaten
	//-----------------------------------------------------
	if(isset($_REQUEST['gallery']) && $_REQUEST["action"] == "updategal") {
		if(isset($_REQUEST['galname']) && $_REQUEST["galname"] != null) {
			//--------------------------
			// Variablen
			//--------------------------
			// Gallery Objekt zum anlegen der Gallery		
			$t_objMTF_Gallery = new mtf_gallery();
			
			// ID der Gallery
			$t_intGalleryID = $_REQUEST['gallery'];
			// Name der Gallery
			$t_strGalleryName = $_REQUEST["galname"];
			// Info zur Gallery
			$t_strGalleryInfo = $_REQUEST["galinfo"];
			// Password fuer die Gallery?
			$t_strGalleryPassword = $_REQUEST['galpass'];
			// Gallery anzeigen?
			if(isset($_REQUEST['galshowgal'])) {
				$t_bolShowGal = "true";
			} else {
				$t_bolShowGal = "false";
			}

			// Gallery updaten
			$t_objMTF_Gallery->updateGallery($t_intGalleryID, $t_strGalleryName, $t_strGalleryInfo, $t_bolShowGal, $t_strGalleryPassword);
		}
	}



	//---------------------
	// Upload....
	//---------------------
	if($_REQUEST["action"] == "upload") {
		if(isset($_REQUEST['imggallery']) && $_REQUEST['imggallery'] != null) {
			// Image-Objekt
			$t_objMTF_Image = new MTF_Image();
			// ImageType-Objekt
			$t_objMTF_ImageType = new MTF_ImageType();
			// ID der Gallery
			$t_intGalleryID = $_REQUEST["imggallery"];
			// 
			$t_strGalleryDir = $strGalleryImageRoot . $t_intGalleryID;
	
			// Die Bilder und Daten auslesen, in die Datenbank
			// einfügen und speichern im Gallery-Verzeichnis
			for($i=0; $i<CONF_UPLOADSPTIME; $i++) {
				if(isset($_FILES['img'. $i]) and ! $_FILES['img'. $i]['error']) {
						
					// Die letzte ID auslesen
					$t_intNewImageID = $t_objMTF_Image->getNextImageID($t_intGalleryID);
					// Wenn die Anzahl vorhanden ist...
					if(!isset($t_intNewImageID) || $t_intNewImageID == null) {
						// Die neue ID ist 1
						$t_intNewImageID = "1";
					} 
					
					// In der DB suchen, ob der Typ schon eingetragen ist...
					$t_objMTF_ImageType->getImageTypeByName($_FILES['img'. $i]['type']);
							
					// Wenn der Typ noch nicht eingetragen ist,
					// wird er hinzugefuegt, sonst sind die
					// entsprechenden Daten nun in dem ImageType-Objekt
					if($t_objMTF_ImageType->intID <= 0 
							|| $t_objMTF_ImageType->strName == null) {	
						$t_objMTF_ImageType->write($_FILES['img'. $i]['type']);
						$t_objMTF_ImageType->getImageTypeByName($_FILES['img'. $i]['type']);							
					}			
					
					// Neuer Name für die Datei ist img+ID+EXTENSION
					$t_objMTF_Image->strName = "image_" . $t_intNewImageID .".". $t_objMTF_ImageType->strExtension;
					$t_objMTF_Image->strTitle = $t_objMTF_Image->strName;
					$t_objMTF_Image->strAltText = $t_objMTF_Image->strName; 
					
					// Wenn das original gespeichert werden soll...					
					if(CONF_SAVEORIGINAL == "true") {
						$t_objMTF_Image->strPathOriginal = $strGalleryImageRoot . $t_intGalleryID . "/original/" . $t_objMTF_Image->strName;
					}
					$t_objMTF_Image->strPathResized = $strGalleryImageRoot . $t_intGalleryID . "/" . $t_objMTF_Image->strName;
					$t_objMTF_Image->strPathThumb = $strGalleryImageRoot . $t_intGalleryID . "/thumb/" . $t_objMTF_Image->strName;
					// OriginalBild
					if(CONF_SAVEORIGINAL == "true") {
						// Groesse des Originals
						$t_arrSizeOriginal = getimagesize($_FILES['img'. $i]['tmp_name']);
						$t_objMTF_Image->intWidthOriginal = $t_arrSizeOriginal[0];
						$t_objMTF_Image->intHeightOriginal = $t_arrSizeOriginal[1];					
						mtf_ImgResize($_FILES['img'. $i]['tmp_name'], 
									$t_objMTF_Image->strPathOriginal, 
									$_FILES['img'. $i]['type'], 
									$t_objMTF_Image->intWidthOriginal,
									CONF_IMAGEQUALITY);
						$t_objMTF_Image->intSizeOriginal = filesize($t_objMTF_Image->strPathOriginal);	
					}
					// Resized
					mtf_ImgResize($_FILES['img'. $i]['tmp_name'], 
									$t_objMTF_Image->strPathResized, 
									$_FILES['img'. $i]['type'], 
									CONF_IMAGESIZE,
									CONF_IMAGEQUALITY);
					// Thumb
					mtf_ImgResize($_FILES['img'. $i]['tmp_name'], 
									$t_objMTF_Image->strPathThumb, 
									$_FILES['img'. $i]['type'], 
									CONF_THUMBSIZE,
									CONF_IMAGEQUALITY);
					

					$t_arrSizeResized = getimagesize($t_objMTF_Image->strPathResized);
					$t_arrSizeThumb = getimagesize($t_objMTF_Image->strPathThumb);
					
					$t_objMTF_Image->strName = $_FILES['img'. $i]['name'];
					$t_objMTF_Image->strTitle = $_FILES['img'. $i]['name'];
					$t_objMTF_Image->strAltText = $_FILES['img'. $i]['name']; 	
					$t_objMTF_Image->intWidthResized = $t_arrSizeResized[0];
					$t_objMTF_Image->intHeightResized = $t_arrSizeResized[1];
					$t_objMTF_Image->intWidthThumb = $t_arrSizeThumb[0];
					$t_objMTF_Image->intHeightThumb = $t_arrSizeThumb[1];
					$t_objMTF_Image->intSizeResized = filesize($t_objMTF_Image->strPathResized);
					$t_objMTF_Image->intSizeThumb = filesize($t_objMTF_Image->strPathThumb);
					$t_objMTF_Image->intTypeID = $t_objMTF_ImageType->intID;
					$t_objMTF_Image->intCreator = $_SESSION['userid'];
					$t_objMTF_Image->bolShowImg = "true";
					$t_objMTF_Image->intViews = "0";
					$t_objMTF_Image->write();
				}
			}
		}
	}
	
	//------------------------
	// 90 Grad links drehen
	//------------------------
	if($_REQUEST['action'] == "rotateleft") {
		MTF_Rotate($_REQUEST['id'], 90);
	}
	
	//------------------------
	// 90 Grad rechts drehen
	//------------------------
	if($_REQUEST['action'] == "rotateright") {
		MTF_Rotate($_REQUEST['id'], -90);
	}

	//------------------------
	// Delete Image
	//------------------------
	if($_REQUEST['action'] == "deleteimage") {	
		$ImageID = $_REQUEST["id"];
		$t_objMTF_Image = new MTF_Image();
		$t_objMTF_Image->getImageByID($ImageID);
		

		$t_bolResizedDeleted = unlink($t_objMTF_Image->strPathResized);
		if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
			$t_bolOriginalDeleted = unlink($t_objMTF_Image->strPathOriginal);
		} else {
			$t_bolOriginalDeleted = true;
		}
		$t_bolThumbDeleted = unlink($t_objMTF_Image->strPathThumb);
		
		// In der DB löschen
		if($t_bolResizedDeleted
				&& $t_bolOriginalDeleted
				&& $t_bolThumbDeleted) {
			$SQL = "DELETE FROM ". TABLEPREFIX ."img WHERE id = $ImageID";
			mysql_query($SQL);
		}
	}
	
	//------------------------
	// Delete Original Image
	//------------------------
	if($_REQUEST['action'] == "deleteoriginalimage") {	
		$ImageID = $_REQUEST["id"];
		$t_objMTF_Image = new MTF_Image();
		$t_objMTF_Image->getImageByID($ImageID);
		
		if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
			$t_bolOriginalDeleted = unlink($t_objMTF_Image->strPathOriginal);
		} else {
			$t_bolOriginalDeleted = true;
		}
		
		// In der DB löschen
		if($t_bolOriginalDeleted) {
			$SQL = "UPDATE ". TABLEPREFIX ."img "
					." SET pathoriginal = NULL, "
					."  pathoriginal = NULL, "
					."  widthoriginal = 0, "
					."  heightoriginal = 0, "
					."  sizeoriginal = 0, "
					."  changer = ". $_SESSION['userid'] .","
					."  datechange = UNIX_TIMESTAMP()"
					." WHERE id = $ImageID";
			mysql_query($SQL) or die("Das Originalbild konnte nicht gel&ouml;scht werden!");
		}
	}
	
	
	//------------------------
	// Delete Gallery
	//------------------------
	if(isset($_REQUEST['deletegallery'])) {	
		$GalleryID = $_REQUEST["gallery"];
		$Path = $strGalleryImageRoot . $GalleryID."/";
		
		$t_bolDirDeleted = rmdirr($Path);
		
		// In der DB löschen
		if($t_bolDirDeleted) {
			$SQL = "DELETE FROM ". TABLEPREFIX ."img WHERE galleryid = ". $GalleryID;
			mysql_query($SQL);
			$SQL = "DELETE FROM ". TABLEPREFIX ."gallery WHERE id = ". $GalleryID;
			mysql_query($SQL);
		}
	}

	//------------------------
	// Update Image
	//------------------------
	if($_REQUEST['action'] == "updateimage") {
		$t_objMTF_Image = new MTF_Image();
		$t_objMTF_Image->getImageByID($_REQUEST['imgid']);
		
		$t_objMTF_Image->strName = $_REQUEST['imgname'];
		$t_objMTF_Image->strTitle = $_REQUEST['imgtt'];
		$t_objMTF_Image->strAltText = $_REQUEST['imgalt'];
		$t_objMTF_Image->intViews = $_REQUEST['imgviews'];
		$t_objMTF_Image->strComment = $_REQUEST['imgcomment'];
		
		if($t_objMTF_Image->intID > 0
				&& strlen($t_objMTF_Image->strName) > 0) {	
			$t_objMTF_Image->update();
		} else {
			echo("Das Feld 'Name' muss ausgef&uuml;llt sein!");
		}
	}
	
	//------------------------
	// SetIndexIMG
	//------------------------
	if($_REQUEST['action'] == "setindex") {
		$ImageID = $_REQUEST["id"];
		$GalleryID = $_REQUEST['gallery'];

		// Wenn die ImageID vorhanden ist...
		if(isset($ImageID) && $ImageID != null
				&& isset($GalleryID) && $GalleryID != null) {
			
			$SQL = "UPDATE ". TABLEPREFIX ."gallery "
				." SET"
				."  indeximg = ". $ImageID .", "
				."  changer = ". $_SESSION['userid'] .", "
				."  datechange = UNIX_TIMESTAMP() "
				." WHERE id = ". $GalleryID;
			mysql_query($SQL) or die("Das Index-Bild konnte nicht gesetzt werden!");
		} else {
			// TODO FEHLER!
		}
	}
	
	//------------------------
	// Image anzeigen / nicht anzeigen
	//------------------------
	if($_REQUEST['action'] == "showimg") {
		$ImageID = $_REQUEST["id"];
		if($_REQUEST['value'] == "true") {
			$bolValue = "true";
		} else {
			$bolValue = "false";
		}
			 
		// Wenn die ImageID vorhanden ist...
		if(isset($ImageID) && $ImageID != null) {
			
			$SQL = "UPDATE ". TABLEPREFIX ."img "
				." SET"
				."  showimg = '". $bolValue ."', "
				."  changer = ". $_SESSION['userid'] .", "
				."  datechange = UNIX_TIMESTAMP() "
				." WHERE id = ". $ImageID;
			mysql_query($SQL) or die("Die Einstellung konnte nicht ge&auml;ndert werden!");
		} else {
			// TODO FEHLER!
		}
	}

	//------------------------
	// Update Config
	//------------------------
	if($_REQUEST['action'] == "updateconf") {
		if(isset($_REQUEST['confshowsortbar'])) {
			$ConfShowSortBar = "true";
		} else {
			$ConfShowSortBar = "false";
		}
		if(isset($_REQUEST['confsaveoriginal'])) {
			$ConfSaveOriginal = "true";
		} else {
			$ConfSaveOriginal = "false";
		}
		$ConfArr = array(
			"CONF_GALDIR" => $_REQUEST['confgaldir'],
			"CONF_IMGPSITE" => $_REQUEST['confimgpsite'],
			"CONF_IMGPROW" => $_REQUEST['confimgprow'],
			"CONF_UPLOADSPTIME" => $_REQUEST['confuploadsptime'],
			"CONF_IMGBORDER" => $_REQUEST['confimgborder'],
			"CONF_SORT" => $_REQUEST['confsort'],
			"CONF_ORDERBY" => $_REQUEST['conforderby'],
			"CONF_TITLE" => $_REQUEST['conftitle'],
			"CONF_HOMEPAGE" => $_REQUEST['confhp'],
			"CONF_KEYWORDS" => $_REQUEST['confkeywords'],
			"CONF_DESCRIPTION" => $_REQUEST['confdescription'],
			"CONF_THUMBSIZE" => $_REQUEST['confthumbsize'],
			"CONF_IMAGESIZE" => $_REQUEST['confimgsize'],
			"CONF_SHOWSORTBAR" => $ConfShowSortBar,
			"CONF_SAVEORIGINAL" => $ConfSaveOriginal,
			"CONF_CSS" => $_REQUEST['confcss'],
			"CONF_IMAGEQUALITY" => $_REQUEST['confimgquality']);

		$ConfFile = fopen("const/const.php", "w");
		fputs($ConfFile, "<?php\n");
		fputs($ConfFile, "// DON'T CHANGE THIS FILE!'\n");
		fputs($ConfFile, "// DIESE DATEI ERSTELLT SICH SELBST NEU!'\n");
		foreach($ConfArr as $key => $value) {
			fputs($ConfFile, "define(\"". $key ."\", \"". $value ."\");\n");
		}
		fputs($ConfFile, "?>\n");
		fclose($ConfFile);
//		header("Location: ". $PHP_SELF ."?site=". $_REQUEST['site'] ."&action=updateconf\"");
	}
	
	//------------------------
	// Update View
	//------------------------
	if($_REQUEST['action'] == "updateview") {
		$t_bolViewImgXfX = "false";
		$t_bolButtonBar = "false";
		$t_bolGalleryName = "false";
		$t_bolName = "false";
		$t_bolFileSize = "false";
		$t_bolImgSize = "false";
		$t_bolVisits = "false";
		$t_bolInfo = "false";
		$t_bolCommentBanner = "false";
		$t_bolComments = "false";
		$t_bolAddComment = "false";
		if(isset($_REQUEST['imgxfx'])) {
			$t_bolViewImgXfX = "true";
		}
		if(isset($_REQUEST['buttonbar'])) {
			$t_bolButtonBar = "true";
		}
		if(isset($_REQUEST['imggalleryname'])) {
			$t_bolGalleryName = "true";
		}
		if(isset($_REQUEST['name'])) {
			$t_bolName = "true";
		}
		if(isset($_REQUEST['filesize'])) {
			$t_bolFileSize = "true";
		}
		if(isset($_REQUEST['imgsize'])) {
			$t_bolImgSize = "true";
		}
		if(isset($_REQUEST['visits'])) {
			$t_bolVisits = "true";
		}
		if(isset($_REQUEST['info'])) {
			$t_bolInfo = "true";
		}
		if(isset($_REQUEST['commentbanner'])) {
			$t_bolCommentBanner = "true";
		}
		if(isset($_REQUEST['comments'])) {
			$t_bolComments = "true";
		}
		if(isset($_REQUEST['addcomment'])) {
			$t_bolAddComment = "true";
		}
		$ViewArr = array(
			"VIEWIMGXFX" => $t_bolViewImgXfX,
			"VIEWBUTTONBAR" => $t_bolButtonBar,
			"VIEWGALLERYNAME" => $t_bolGalleryName,
			"VIEWNAME" => $t_bolName,
			"VIEWFILESIZE" => $t_bolFileSize,
			"VIEWIMGSIZE" => $t_bolImgSize,
			"VIEWVISITS" => $t_bolVisits,
			"VIEWINFO" => $t_bolInfo,
			"VIEWCOMMENTBANNER" => $t_bolCommentBanner,
			"VIEWCOMMENTS" => $t_bolComments,
			"VIEWADDCOMMENT" => $t_bolAddComment);

		$ViewFile = fopen("const/const.view.php", "w");
		fputs($ViewFile, "<?php\n");
		fputs($ViewFile, "// DON'T CHANGE THIS FILE!'\n");
		fputs($ViewFile, "// DIESE DATEI ERSTELLT SICH SELBST NEU!'\n");
		foreach($ViewArr as $key => $value) {
			fputs($ViewFile, "define(\"". $key ."\", \"". $value ."\");\n");
		}
		fputs($ViewFile, "?>\n");
		fclose($ViewFile);
//		header("Location: ". $PHP_SELF ."?site=". $_REQUEST['site'] ."&action=updateview\"");
	}
	
	
	//------------------------
	// Update Thumb
	//------------------------
	if($_REQUEST['action'] == "updatethumb") {
		$t_bolThumbName = "false";
		$t_bolThumbViews = "false";
		$t_bolThumbSize = "false";
		if(isset($_REQUEST['thumbname'])) {
			$t_bolThumbName = "true";
		}
		if(isset($_REQUEST['thumbviews'])) {
			$t_bolThumbViews = "true";
		}
		if(isset($_REQUEST['thumbsize'])) {
			$t_bolThumbSize = "true";
		}
		$ThumbArr = array(
			"THUMB_SHOW_NAME" => $t_bolThumbName,
			"THUMB_SHOW_VIEWS" => $t_bolThumbViews,
			"THUMB_SHOW_SIZE" => $t_bolThumbSize);

		$ThumbFile = fopen("const/const.thumb.php", "w");
		fputs($ThumbFile, "<?php\n");
		fputs($ThumbFile, "// DON'T CHANGE THIS FILE!'\n");
		fputs($ThumbFile, "// DIESE DATEI ERSTELLT SICH SELBST NEU!'\n");
		foreach($ThumbArr as $key => $value) {
			fputs($ThumbFile, "define(\"". $key ."\", \"". $value ."\");\n");
		}
		fputs($ThumbFile, "?>\n");
		fclose($ThumbFile);
//		header("Location: ". $PHP_SELF ."?site=". $_REQUEST['site'] ."&action=updatethumb\"");
	}
	
	//------------------------
	// User hinzufuegen
	//------------------------
	if($_REQUEST['action'] == "adduser") {
		$t_objMTF_GalleryUser = new MTF_GalleryUser();
			
		if(strlen($_REQUEST['txtusername']) > 0) {
			$t_objMTF_GalleryUser->strName = $_REQUEST['txtusername'];
		}
		if(strlen($_REQUEST['txtuserpass']) > 0) {
			$t_objMTF_GalleryUser->strPassword = $_REQUEST['txtuserpass'];
		}
		if(strlen($_REQUEST['txtuseremail']) > 0) {
			$t_objMTF_GalleryUser->strEMail = $_REQUEST['txtuseremail'];
		}
		if(strlen($_REQUEST['txtuserhp']) > 0) {
			$t_objMTF_GalleryUser->strHomepage = $_REQUEST['txtuserhp'];
		}
		if(strlen($_REQUEST['txausercomment']) > 0) {
			$t_objMTF_GalleryUser->strComment = $_REQUEST['txausercomment'];
		}    
		if(isset($_REQUEST['chkuseradmin'])) {
			$t_objMTF_GalleryUser->bolAdmin = true;
		} else {
			$t_objMTF_GalleryUser->bolAdmin = false;
		}
		
		if(strlen($t_objMTF_GalleryUser->strName) > 0
				&& strlen($t_objMTF_GalleryUser->strPassword) > 0) {
			$t_objMTF_GalleryUser->write();
		} else {
			echo("Die Felder 'Name' und 'Password' m&uuml;ssen ausgef&uuml;lt sein!");
		}
	}	
	//------------------------
	// User update
	//------------------------
	if($_REQUEST['action'] == "updateuser") {
		$t_objMTF_GalleryUser = new MTF_GalleryUser();
		if(strlen($_REQUEST['hiduserid']) > 0) {
			$t_objMTF_GalleryUser->intID = $_REQUEST['hiduserid'];
		}
		if(strlen($_REQUEST['txtusername']) > 0) {
			$t_objMTF_GalleryUser->strName = $_REQUEST['txtusername'];
		}
//		if(strlen($_REQUEST['txtuserpass']) > 0) {
//			$t_objMTF_GalleryUser->strPassword = $_REQUEST['txtuserpass'];
//		}
		if(strlen($_REQUEST['txtuseremail']) > 0) {
			$t_objMTF_GalleryUser->strEMail = $_REQUEST['txtuseremail'];
		}
		if(strlen($_REQUEST['txtuserhp']) > 0) {
			$t_objMTF_GalleryUser->strHomepage = $_REQUEST['txtuserhp'];
		}
		if(strlen($_REQUEST['txausercomment']) > 0) {
			$t_objMTF_GalleryUser->strComment = $_REQUEST['txausercomment'];
		}    
		if(isset($_REQUEST['chkuseradmin'])) {
			$t_objMTF_GalleryUser->bolAdmin = true;
		} else {
			$t_objMTF_GalleryUser->bolAdmin = false;
		}
		
		if(strlen($t_objMTF_GalleryUser->strName) > 0
				&& $t_objMTF_GalleryUser->intID > 0) {
			$t_objMTF_GalleryUser->update();
		} else {
			echo("Das Feld 'Name' muss ausgef&uuml;lt sein!");
		}
	}	
	//------------------------
	// User update pass
	//------------------------
	if($_REQUEST['action'] == "updatepass") {
		$t_objMTF_GalleryUser = new MTF_GalleryUser();
		if(strlen($_REQUEST['hiduserid']) > 0) {
			$t_objMTF_GalleryUser->intID = $_REQUEST['user'];
			$t_objMTF_GalleryUser->getUserByID();
		}
		if(strlen($_REQUEST['txtpassold']) > 0) {
			$t_objMTF_GalleryUser->strPassword = $_REQUEST['txtpassold'];
		}
		if(strlen($_REQUEST['txtpassnew1']) > 0) {
			$strPassNew1 = $_REQUEST['txtpassnew1'];
		}
		if(strlen($_REQUEST['txtpassnew2']) > 0) {
			$strPassNew2 = $_REQUEST['txtpassnew2'];
		}
		
		if($t_objMTF_GalleryUser->checkPassword()) {
			if($strPassNew1 == $strPassNew2) {
				$t_objMTF_GalleryUser->strPassword = $strPassNew1;
				$t_objMTF_GalleryUser->updatePassword();
			} else {
				echo("Das neue Password stimmt nicht &uuml;berein!");
			}
		} else {
			echo("Das alte Password war falsch!");
		}
	}	
	
	//------------------------
	// User loeschen
	//------------------------
	if($_REQUEST['action'] == "deleteuser") {
		$t_objMTF_GalleryUser = new MTF_GalleryUser();
		$t_objMTF_GalleryUser->intID = $_REQUEST['user'];	
		
		
		$t_objMTF_GalleryUser->delete();
	}
	








	echo("<html>\n");
	echo(" <head>\n");
	echo("  <title>Matflasch's Image Gallery</title>\n");
	echo("  <link rel=\"stylesheet\" type=\"text/css\" href=\"". CONF_CSS ."\">\n");
	echo("  <SCRIPT TYPE=\"text/javascript\">\n");
	echo("  <!--\n");
	echo("   function popup(mylink, windowname) {\n");
	echo("    if (! window.focus)return true;\n");
	echo("     var href;\n");
	echo("    if (typeof(mylink) == 'string')\n");
	echo("     href=mylink;\n");
	echo("    else\n");
	echo("     href=mylink.href;\n");
	echo("    window.open(href, windowname, 'width=700,height=530,scrollbars=yes');\n");
	echo("    return false;\n");
	echo("   }\n");
	echo("  //-->\n");
	echo("  </SCRIPT>\n");
	echo(" </head>\n");
	echo(" <body>\n");
	echo("  <a name=\"top\"> </a>\n");
	echo("  <center>\n");
	echo("   <br />\n");
	echo("   <table class=\"admin\">\n");
	echo("    <tr>\n");
	echo("     <td class=\"menu\">\n");
	$SQL = "SELECT * FROM ". TABLEPREFIX ."galuser WHERE id = " . $_SESSION['userid'];
	$User = mysql_fetch_object(mysql_query($SQL));
	echo("      Angemeldet als: ". $User->name ."\n");
	echo("      <br />\n");
	echo("      <br />\n");
	echo("      <ul>\n");
	echo("       <li>\n");
	echo("        <a href=\"". $PHP_SELF ."?\">\n");
	echo("         Index\n");
	echo("        </a>\n");
	echo("       </li>\n");
	echo("       <li>\n");
	echo("        <a href=\"". $PHP_SELF ."?site=create\">\n");
	echo("         Gallery anlegen<br />\n");
	echo("        </a>\n");
	echo("       </li>\n");
	echo("       <li>\n");
	echo("        <a href=\"". $PHP_SELF ."?site=upload\">\n");
	echo("         Bilder raufladen<br />\n");
	echo("        </a>\n");
	echo("       </li>\n");
//	echo("       <li>\n");
//	echo("        <a href=\"". $PHP_SELF ."?site=mngcss\">\n");
//	echo("         CSS bearbeiten<br />\n");
//	echo("        </a>\n");
//	echo("       </li>\n");
	echo("       <li>\n");
	echo("        <a href=\"". $PHP_SELF ."?site=mngconf\">\n");
	echo("         Config bearbeiten<br />\n");
	echo("        </a>\n");
	echo("       </li>\n");
	echo("       <li>\n");
	echo("        <a href=\"". $PHP_SELF ."?site=mnguser\">\n");
	echo("         User bearbeiten<br />\n");
	echo("        </a>\n");
	echo("       </li>\n");
	echo("       <li>\n");
	echo("        Views:<br />\n");
	echo("        <ul>\n");
	echo("         <li>\n");
	echo("          <a href=\"". $PHP_SELF ."?site=mngview\">\n");
	echo("           Popup<br />\n");
	echo("          </a>\n");
	echo("         </li>\n");
	echo("         <li>\n");
	echo("          <a href=\"". $PHP_SELF ."?site=mngthumb\">\n");
	echo("           Thumb<br />\n");
	echo("          </a>\n");
	echo("         </li>\n");
//	echo("         <li>\n");
//	echo("           Gallery<br />\n");
//	echo("         </li>\n");
//	echo("         <li>\n");
//	echo("           Statistik<br />\n");
//	echo("         </li>\n");
	echo("        </ul>\n");
	echo("       </li>\n");
//	echo("       <li>\n");
//	echo("        <a href=\"". $PHP_SELF ."?site=statistik\">\n");
//	echo("         Statistik\n");
//	echo("        </a>\n");
//	echo("       </li>\n");
	echo("      </ul>\n");
	echo("      <br />\n");
	echo("      <a href=\"". $PHP_SELF ."?action=logout\">\n");
	echo("       Logout\n");
	echo("      </a>\n");
	//-------------------------------------
	// Gallery-Liste
	//-------------------------------------
	echo("      <br /><br />\n");
	echo("      Gallerien:<br />\n");
	echo("      <ul>\n");
	$SQL = "SELECT * FROM ". TABLEPREFIX ."gallery ORDER BY name ASC";
	$Result = mysql_query($SQL);
	while($Obj = mysql_fetch_object($Result)) {
		$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."img WHERE galleryid = $Obj->id";
		$ObjCount = mysql_fetch_object(mysql_query($SQL));
		echo("       <li>\n");
		echo("        <a href=\"". $PHP_SELF ."?site=mng&gallery=". $Obj->id ."\" title=\"Es sind ". $ObjCount->count ."Bilder in der Gallery\">". $Obj->name ." (". $ObjCount->count .")</a>\n");
		echo("       </li>\n");
	}
	echo("      </ul>\n");
	
	
	echo("     </td>\n");
	echo("     <td class=\"main\">\n");
	
	if($_REQUEST['site'] == "create") {
		include("admin/creategallery.php");
	}
	if($_REQUEST['site'] == "upload") {
		include("admin/upload.php");
	}
	if($_REQUEST['site'] == "mng") {
		include("admin/mnggallery.php");
	}
	if($_REQUEST['site'] == "mngconf") {
		include("admin/mngconf.php");
	}
	if($_REQUEST['site'] == "mnguser") {
		include("admin/mnguser.php");
	}
	if($_REQUEST['site'] == "mngcss") {
		include("admin/mngcss.php");
	}
	if($_REQUEST['site'] == "mngview") {
		include("admin/mngview.php");
	}
	if($_REQUEST['site'] == "mngthumb") {
		include("admin/mngthumb.php");
	}
	if($_REQUEST['site'] == "index"
			|| $_REQUEST['site'] == "statistik"
			|| $_REQUEST['site'] == ""
			|| !isset($_REQUEST['site'])) {
		include("admin/adminindex.php");
	}
	
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("   </table>\n");
	echo("   <br /><br />\n");
	echo("  </center>\n");
	echo(" </body>\n");
	echo("</html>\n");
}
$mtf_mysqldb->mtf_close();
?>
