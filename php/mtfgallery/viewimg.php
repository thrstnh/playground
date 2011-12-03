<?php
session_start();
include("class/class.mtf_mysql.php");
include("class/class.mtf_gallery.php");
include("class/class.mtf_imagetype.php");
include("class/class.mtf_image.php");
include("class/class.mtf_imgcomment.php");
include("conf.php");
include("const/const.php");
include("const/const.view.php");


// Datenbankobjekt erstellen
$mtf_mysqldb = new mtf_mysqldb();
// mit der Datenbank verbinden
$dblink = $mtf_mysqldb->mtf_connect();

if($_REQUEST['img'] != null) {
	$ImageID = $_REQUEST['img'];
	if(isset($_REQUEST['orderby'])) {
		$OrderBy = $_REQUEST['orderby'];
	} else {
		$OrderBy = CONF_ORDERBY;
	}
	if(isset($_REQUEST['sort'])) {
		$Sort = $_REQUEST['sort'];
	} else {
		$Sort = CONF_SORT;
	}
	
	$t_objMTF_Image = new MTF_Image();
	$t_objMTF_Image->getImageByID($ImageID);
	if($_REQUEST['slideshow'] == "on") {
		$bolSlideshow = true;
	} else {
		$bolSlideshow = false;
	}
		
	
	// HTML Head
	echo("<html>\n");
	echo(" <head>\n");
	echo("  <title>". CONF_TITLE ."</title>\n");
	echo("  <link rel=\"stylesheet\" type=\"text/css\" href=\"".CONF_CSS ."\">\n");
	$SQL = "SELECT * FROM ". TABLEPREFIX ."img WHERE galleryid = ". $t_objMTF_Image->intGalleryID ." ORDER BY ". $OrderBy ." DESC";
	$LastImage = mysql_fetch_object(mysql_query($SQL));
	if($t_objMTF_Image->intID != $LastImage->id) {
		if($bolSlideshow) {
			$SQL = "SELECT * FROM ". TABLEPREFIX ."img WHERE galleryid = ". $t_objMTF_Image->intGalleryID ." AND id > ". $_REQUEST['img'] ." ORDER BY ". $OrderBy ." LIMIT 0, 2";
			$NextImage = mysql_fetch_object(mysql_query($SQL));
			$NextImage = mysql_fetch_object(mysql_query($SQL));
			echo("  <meta http-equiv=\"refresh\" content=\"6; URL=". $PHP_SELF ."?img=". $NextImage->id ."&orderby=". $OrderBy ."&sort=". $Sort ."&slideshow=". $_REQUEST['slideshow'] ."\">\n");
		}
		$bolLastImage = false;
	} else {
		$bolLastImage = true;
	}
	echo(" </head>\n");
	echo(" <body>\n");
	echo("  <center>\n");
		
	
	//------------------------------------------
	// Comment hinzufuegen
	//------------------------------------------
	if($_REQUEST['action'] == "addcomment") {
		$t_bolInsertComment = true;
		$t_bolAuthor = false;
		$t_bolComment = false;
		$t_objMTF_ImageComment = new MTF_ImageComment();
		$t_objMTF_ImageComment->intImageID = $t_objMTF_Image->intID;
		$t_objMTF_ImageComment->intGalleryID = $t_objMTF_Image->intGalleryID;
		$t_objMTF_ImageComment->strSessionID = session_id();
		
		$t_bolInsertComment = $t_objMTF_ImageComment->checkLastComment($t_objMTF_Image->intID, session_id());
		if($_REQUEST['commenttitle'] != null) {
			$t_objMTF_ImageComment->strTitle = $_REQUEST['commenttitle'];	
		} 
//		else {
//			$t_bolInsertComment = false;
//		}
		if($_REQUEST['commentauthor'] != null) {
			$t_objMTF_ImageComment->strAuthor = $_REQUEST['commentauthor'];
			$t_bolAuthor = true;
		} else {
			$t_bolInsertComment = false;
			
		}
		if($_REQUEST['commentemail'] != null) {
			$t_objMTF_ImageComment->strMail = $_REQUEST['commentemail'];
		} 
//		else {
//			$t_bolInsertComment = false;
//		}
		if($_REQUEST['commentwww'] != null) {
			$t_objMTF_ImageComment->strWWW = $_REQUEST['commentwww'];
		} 
//		else {
//			$t_bolInsertComment = false;
//		}
		if($_REQUEST['commenttext'] != null) {
			$t_objMTF_ImageComment->strComment = $_REQUEST['commenttext'];
			$t_bolComment = true;
		} else {
			$t_bolInsertComment = false;
		}
		if($t_bolAuthor == true
				&& $t_bolComment == true) {
			if($t_bolInsertComment == true) {
				$t_objMTF_ImageComment->write();
			} else {
				echo("   <font class=\"errormsg\">Flood-Protection!</font><br /><br />\n");
			}	
		}
		
		if(!$t_bolAuthor) {
			echo("   <font class=\"errormsg\">Das Feld 'Author' muss ausgef&uuml;llt sein!!</font><br />\n");
		}
		if(!$t_bolComment) {
			echo("   <font class=\"errormsg\">Das Feld 'Comment' muss ausgef&uuml;llt sein!!</font><br /><br />\n");
		}	
	} else {
		// View erhoehen
		$t_objMTF_Image->AddView($t_objMTF_Image->intID);
	}
	echo("   <div class=\"toolbox\">\n");
	if($bolSlideshow) {
		$slideshow = "off";
		$SlideTT = "Slideshow deaktivieren";
		$SlideIMG = "style/std/slide_off.png";
	} else {
		$slideshow = "on";
		$SlideTT = "Slideshow aktivieren";
		$SlideIMG = "style/std/slide_on.png";
	}
	echo("    <table width=\"96%\">\n");
	echo("     <tr>\n");
	echo("      <td class=\"stdr\">\n");
	if(!$bolLastImage) {
		echo("       <a href=\"". $PHP_SELF ."?img=". ($_REQUEST['img']) ."&orderby=". $OrderBy ."&sort=". $Sort ."&slideshow=". $slideshow ."\" method=\"post\">\n");
		echo("        <img src=\"". $SlideIMG ."\" border=\"0px\" alt=\"". $SlideTT ."\" title=\"". $SlideTT ."\">\n");
		echo("       </a>\n");
	} else {
		echo("        <img src=\"style/std/slide_dis.png\" border=\"0px\" alt=\"Letztes Bild der Gallery\" title=\"Letztes Bild der Gallery\">\n");
	}
	echo("      </td>\n");
	echo("     </tr>\n");	
	
	
	// Die Nr. des Bildes auslesen
	$i=1;
	$SQL = "SELECT * FROM ". TABLEPREFIX ."img WHERE galleryid = ". $t_objMTF_Image->intGalleryID ." ORDER BY ". $OrderBy ." ". $Sort;
	$Result = mysql_query($SQL);
	$Nr = "";
	while($ImageNr = mysql_fetch_object($Result)) {
		if($t_objMTF_Image->strPathResized == $ImageNr->pathresized) {
			$Nr = $i;
		}
		$i++;
	}
	// Anzahl der Bilder in der Gallery auslesen
	$SQL = "SELECT COUNT(id) as count FROM ". TABLEPREFIX ."img WHERE galleryid = ". $t_objMTF_Image->intGalleryID ." ORDER BY ". $OrderBy ." ". $Sort;
	$Count = mysql_fetch_object(mysql_query($SQL));
	if(VIEWIMGXFX == "true") {
		echo("     <tr>\n");
		echo("      <td class=\"stdc\">\n");
		// Ausgabe von BILD X / X
		echo("       <img src=\"style/std/image.gif\" border=\"0px\" alt=\"Bild\">\n");
		$t_strNr = "$Nr";
		$strlen = strlen($t_strNr);
		for($i=0; $i<$strlen; $i++) {
			printf("       <img src=\"style/std/".$t_strNr[$i].".gif\" border=\"0px\" alt=\"".$t_strNr[$i]."\">\n");
		}
		echo("       <img src=\"style/std/from.gif\" border=\"0px\" alt=\"/\">\n");
		$t_strCount = "$Count->count";
		$strlen = strlen($t_strCount);
		for($i=0; $i<$strlen; $i++) {
			printf("       <img src=\"style/std/".$t_strCount[$i].".gif\" border=\"0px\" alt=\"".$t_strCount[$i]."\">\n");
		}	
		echo("      </td>\n");
		echo("     </tr>\n");
	}
	
	if(VIEWBUTTONBAR == "true") {
		echo("     <tr>\n");
		echo("      <td class=\"stdc\">\n");
		//---------------------------------------------------------
		// Zum ersten Bild der Gallery
		//---------------------------------------------------------
		$SQL = "SELECT * FROM ". TABLEPREFIX ."img WHERE galleryid = ". $t_objMTF_Image->intGalleryID ." ORDER BY ". $OrderBy ." ASC";
		$FirstImage = mysql_fetch_object(mysql_query($SQL));
		if($Nr > 1) {
			echo("       <a href=\"". $PHP_SELF ."?img=". $FirstImage->id ."&orderby=". $OrderBy ."&sort=". $Sort ."\" title=\"Zum ersten Bild der Gallery\">\n");
		}
		echo("        <img src=\"style/std/first.png\" border=\"0px\">\n");
		if($Nr > 1) {
			echo("       </a>\n");
		}
		
		//---------------------------------------------------------
		// Ein Bild zurueck
		//---------------------------------------------------------
		if($Nr > 1) {
			$SQL = "SELECT id FROM ". TABLEPREFIX ."img WHERE galleryid = ". $t_objMTF_Image->intGalleryID ." AND id < ". $_REQUEST['img'] ." ORDER BY ". $OrderBy ." DESC LIMIT 0, 2";
			$NextImage = mysql_fetch_object(mysql_query($SQL));
			$NextImage = mysql_fetch_object(mysql_query($SQL));
			echo("       <a href=\"". $PHP_SELF ."?img=". $NextImage->id ."&orderby=". $OrderBy ."&sort=". $Sort ."\" title=\"Ein Bild zur&uuml;ck\">\n");
		}
		echo("        <img src=\"style/std/back.png\" border=\"0px\">\n");
		if($Nr > 1) {
			echo("       </a>\n");
		}
	
		//---------------------------------------------------------
		// Fenster schliessen
		//---------------------------------------------------------
		echo("       <a href=\"javascript:window.close();\" title=\"Fenster schliessen\">\n");
		echo("        <img src=\"style/std/exit.png\" border=\"0px\">\n");
		echo("       </a>\n");
	
		//---------------------------------------------------------
		// Zum naechsten Bild der Gallery
		//---------------------------------------------------------
		if($Nr < $Count->count) {
			$SQL = "SELECT id FROM ". TABLEPREFIX ."img WHERE galleryid = ". $t_objMTF_Image->intGalleryID ." AND id > ". $_REQUEST['img'] ." ORDER BY ". $OrderBy ." LIMIT 0, 2";
			$NextImage = mysql_fetch_object(mysql_query($SQL));
			$NextImage = mysql_fetch_object(mysql_query($SQL));
			echo("       <a href=\"". $PHP_SELF ."?img=". $NextImage->id ."&orderby=". $OrderBy ."&sort=". $Sort ."\" title=\"N&auml;chstes Bild\">\n");
		}
		echo("        <img src=\"style/std/next.png\" border=\"0px\">\n");
		if($Nr < $Count->count) {
			echo("       </a>\n");
		}
	
		//---------------------------------------------------------
		// Zum letzten Bild der Gallery
		//---------------------------------------------------------
		$SQL = "SELECT id FROM ". TABLEPREFIX ."img WHERE galleryid = ". $t_objMTF_Image->intGalleryID ." ORDER BY ". $OrderBy ." DESC";
		$LastImage = mysql_fetch_object(mysql_query($SQL));
		if($Nr < $Count->count) {
			echo("       <a href=\"". $PHP_SELF ."?img=". $LastImage->id ."&orderby=". $OrderBy ."&sort=". $Sort ."\" title=\"Zum letzten Bild der Gallery\">\n");
		}
		echo("        <img src=\"style/std/last.png\" border=\"0px\">\n");
		if($Nr < $Count->count) {
			echo("       </a>\n");
		}
		echo("      </td>\n");
		echo("     </tr>\n");
	}
	echo("    </table>\n");
	echo("   </div>\n");
	echo("   <br />\n");

	// Wenn das OriginalBild angezeigt werden soll und vorhanden ist...
	if(strlen($t_objMTF_Image->strPathOriginal) > 0) {
		echo("   <a href=\"". $t_objMTF_Image->strPathOriginal ."\" target=\"_fullsize\">\n");
	}
	echo("   <img src=\"". $t_objMTF_Image->strPathResized ."\" alt=\"". $t_objMTF_Image->strAltText ."\" title=\"". $t_objMTF_Image->strTitle ."\" width=\"". $t_objMTF_Image->intWidthResized ."\" height=\"". $t_objMTF_Image->intHeightResized ."\" border=\"". CONF_IMGBORDER ."px\">\n");
	if(CONF_SAVEORIGINAL == "true") {
		echo("   </a>\n");
	}
	echo("   <br />\n");
	echo("   <br />\n");
	if(VIEWGALLERYNAME == "true"
		|| VIEWNAME == "true"
		|| VIEWFILESIZE == "true"
		|| VIEWIMGSIZE == "true"
		|| VIEWVISITS == "true"
		|| VIEWINFO == "true") {
		echo("   <div class=\"infobox\">\n");
		echo("    <table>\n");
		if(VIEWGALLERYNAME == "true") {
			echo("     <tr>\n");
			echo("      <td>\n");
			echo("       Gallery:\n");
			echo("      </td>\n");
			echo("      <td>\n");
			$t_objMTF_Gallery = new MTF_Gallery();
			$t_objMTF_Gallery->getGalleryByID($t_objMTF_Image->intGalleryID);
			echo("       ". $t_objMTF_Gallery->strName ."<br />\n");
			echo("      </td>\n");
			echo("     </tr>\n");
		}
		if(VIEWNAME == "true") {
			echo("     <tr>\n");
			echo("      <td>\n");
			echo("       Name:\n");
			echo("      </td>\n");
			echo("      <td>\n");
			echo("       ". $t_objMTF_Image->strName ."<br />\n");
			echo("      </td>\n");
			echo("     </tr>\n");
		}
		if(VIEWFILESIZE == "true") {
			echo("     <tr>\n");
			echo("      <td>\n");
			echo("       File Size:\n");
			echo("      </td>\n");
			echo("      <td>\n");
			echo("       ". round($t_objMTF_Image->intSizeResized / 1024) ." kb<br />\n");
			echo("      </td>\n");
			echo("     </tr>\n");
		}
		if(VIEWIMGSIZE == "true") {
			echo("     <tr>\n");
			echo("      <td>\n");
			echo("       Image SIze:\n");
			echo("      </td>\n");
			echo("      <td>\n");
			echo("       ". $t_objMTF_Image->intWidthResized ." x ". $t_objMTF_Image->intHeightResized ." pixel<br />\n");
			echo("      </td>\n");
			echo("     </tr>\n");
		}
		if(VIEWVISITS == "true") {
			echo("     <tr>\n");
			echo("      <td>\n");
			echo("       Views:\n");
			echo("      </td>\n");
			echo("      <td>\n");
			echo("       ". $t_objMTF_Image->intViews ."<br />\n");
			echo("      </td>\n");
			echo("     </tr>\n");
		}
		if(VIEWINFO == "true") {
			echo("     <tr>\n");
			echo("      <td>\n");
			echo("       Info:\n");
			echo("      </td>\n");
			echo("      <td>\n");
			echo("       ". $t_objMTF_Image->strComment ."<br />\n");
			echo("      </td>\n");
			echo("     </tr>\n");
		}
		echo("    </table>\n");
		echo("   </div>\n");
	}
	echo("   <br />\n");
	if(VIEWCOMMENTBANNER == "true") {
		echo("   <div class=\"commenthead\">\n");
		echo("    Kommentare\n");
		echo("   </div>\n");
		echo("   <br />\n");
	}
	if(VIEWCOMMENTS == "true") {
		$t_objMTF_ImageCommentArray = new MTF_ImageComment();
		$t_objMTF_ImageCommentArray = $t_objMTF_ImageCommentArray->getImageComments($t_objMTF_Image->intID);
		if($t_objMTF_ImageCommentArray != null) {
			foreach($t_objMTF_ImageCommentArray as $t_objMTF_ImageComment) {
				echo("   <div class=\"comment\">\n");
				// eMail mit JS ausgeben wegen SPAM
				echo("    <script type=\"text/javascript\">\n");
	 			echo("     <!--\n");
	  			echo("      document.write('<');\n");
	  			echo("      document.write('a hr');\n");
	  			echo("      document.write('ef=');\n");
	  			echo("      document.write('ma');\n");
	  			echo("      document.write('i');\n");
	  			echo("      document.write('lto:');\n");
	  			$intMailLength = strlen($t_objMTF_ImageComment->strMail);
	  			$intMailPosted = 0;
	  			while($intMailPosted <= $intMailLength) {
	  				// Zufallsstartwert festlegebn
					srand(microtime()*1000000);
					// Zufallszahl ermitteln
					$RandomNr = rand($intMailPosted, $intMailLength);
					$t_MailPart = substr($t_objMTF_ImageComment->strMail, $intMailPosted, $RandomNr);
	  				echo("      document.write('". $t_MailPart ."');\n");
	  				$intMailPosted += $RandomNr;
	  			}
	  			echo("      document.write('>". $t_objMTF_ImageComment->strAuthor ."</');\n");
	  			echo("      document.write('a>');\n");
	 			echo("     //-->\n");
				echo("    </script>\n"); 
				echo("    <a href=\"". $t_objMTF_ImageComment->strWWW ."\" target=\"www\" alt=\"". $t_objMTF_ImageComment->strWWW ."\" title=\"". $t_objMTF_ImageComment->strWWW ."\">\n");
				echo("     <img src=\"style/std/homepage.gif\" border=\"0px\" alt=\"". $t_objMTF_ImageComment->strWWW ."\" title=\"". $t_objMTF_ImageComment->strWWW ."\">\n");
				echo("    </a>\n");
				echo("    ". date("d.m.Y, H:i", $t_objMTF_ImageComment->intDateadd) ."\n");
				echo("    <br />\n");
				echo("    <hr />\n");
				echo("    <b>". $t_objMTF_ImageComment->strTitle ."</b><br /><br />\n");
				echo("    ". nl2br($t_objMTF_ImageComment->strComment)  ."\n");
				echo("   </div>\n");
				echo("   <br />\n");
			}
		}
	}
	if(VIEWADDCOMMENT == "true") {
		echo("   <div class=\"comment\">\n");
		echo("    <form action=\"". $PHP_SELF ."?gallery=". $t_objMTF_Image->intGalleryID ."&img=". $t_objMTF_Image->intID ."&orderby=". $OrderBy ."&sort=". $Sort ."&action=addcomment\" method=\"post\">\n");
		echo("    <table>\n");
		echo("     <tr>\n");
		echo("      <td colspan=\"2\">\n");
		echo("       Comment hinzuf&uuml;gen:<br />\n");
		echo("      </td>\n");
		echo("     </tr>\n");
		echo("     <tr>\n");
		echo("      <td>\n");
		echo("       Titel:\n");
		echo("      </td>\n");
		echo("      <td>\n");
		echo("       <input class=\"stdtxt\" type=\"text\" name=\"commenttitle\"><br />\n");
		echo("      </td>\n");
		echo("     </tr>\n");
		echo("     <tr>\n");
		echo("      <td>\n");
		echo("       Author:\n");
		echo("      </td>\n");
		echo("      <td>\n");
		echo("       <input class=\"stdtxt\" type=\"text\" name=\"commentauthor\"><br />\n");
		echo("      </td>\n");
		echo("     </tr>\n");
		echo("     <tr>\n");
		echo("      <td>\n");
		echo("       eMail:\n");
		echo("      </td>\n");
		echo("      <td>\n");
		echo("       <input class=\"stdtxt\" type=\"text\" name=\"commentemail\"><br />\n");
		echo("      </td>\n");
		echo("     </tr>\n");
		echo("     <tr>\n");
		echo("      <td>\n");
		echo("       Webseite:\n");
		echo("      </td>\n");
		echo("      <td>\n");
		echo("       <input class=\"stdtxt\" type=\"text\" name=\"commentwww\"><br />\n");
		echo("      </td>\n");
		echo("     </tr>\n");
		echo("     <tr>\n");
		echo("      <td>\n");
		echo("       Comment:\n");
		echo("      </td>\n");
		echo("      <td>\n");
		echo("       <textarea class=\"stdtxa\" name=\"commenttext\"></textarea><br />\n");
		echo("      </td>\n");
		echo("     </tr>\n");
		echo("     <tr>\n");
		echo("      <td>\n");
		echo("      </td>\n");
		echo("      <td class=\"stdc\">\n");
		echo("       <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Hinzufuegen\">\n");
		echo("      </td>\n");
		echo("     </tr>\n");
		echo("    </table>\n");
		echo("    </form>\n");
		echo("   </div>\n");
	}
	echo("   <br />\n");
	echo("   <br />\n");
} else {
	echo("<html>\n");
	echo(" <head>\n");
	echo("  <title>". CONF_TITLE ."</title>\n");
	echo("  <link rel=\"stylesheet\" type=\"text/css\" href=\"".CONF_CSS ."\">\n");
	echo(" </head>\n");
	echo(" <body>\n");
	echo("  <center>\n");
	echo("Error: Keine Image-ID vorhanden.....\n");
}
echo("  </center>\n");
echo(" </body>\n");
echo("</html>\n");
$mtf_mysqldb->mtf_close();
?>
