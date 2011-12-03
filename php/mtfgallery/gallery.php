<?php
session_start();
include("class/class.mtf_mysql.php");
include("class/class.mtf_gallery.php");
include("class/class.mtf_imagetype.php");
include("class/class.mtf_image.php");
include("class/class.mtf_imgcomment.php");
include("conf.php");
include("const/const.php");
include("const/const.thumb.php");

// Datenbankobjekt erstellen
$mtf_mysqldb = new mtf_mysqldb();
// 
$mtf_gallery = new mtf_gallery();
// mit der Datenbank verbinden
$dblink = $mtf_mysqldb->mtf_connect();

// Order By setzen
if(isset($_REQUEST['orderby'])) {
	$OrderBy = $_REQUEST['orderby'];
} else {
	$OrderBy = CONF_ORDERBY;
}

// Sort setzen
if(isset($_REQUEST['sort'])) {
	$Sort = $_REQUEST['sort'];
} else {
	$Sort = CONF_SORT;
}


echo("<html>\n");
echo(" <head>\n");
echo("  <title>". CONF_TITLE ."</title>\n");
echo("  <link rel=\"stylesheet\" type=\"text/css\" href=\"". CONF_CSS ."\">\n");
echo("  <meta name=\"Keywords\" content=\"". CONF_KEYWORDS ."\">\n");
echo("  <meta name=\"description\" content=\"". CONF_DESCRIPTION ."\">\n");
echo("  <SCRIPT TYPE=\"text/javascript\">\n");
echo("  <!--\n");
echo("   function popup(mylink, windowname) {\n");
echo("    if (! window.focus)return true;\n");
echo("     var href;\n");
echo("    if (typeof(mylink) == 'string')\n");
echo("     href=mylink;\n");
echo("    else\n");
echo("     href=mylink.href;\n");
echo("    window.open(href, windowname, 'width=700,height=600,scrollbars=yes');\n");
echo("    return false;\n");
echo("   }\n");
echo("  //-->\\n");
echo("  </SCRIPT>\n");
echo(" </head>\n");
echo(" <body>\n");
echo("  <center>\n");
echo("   <br />\n");

//---------------------------------------------
// Begin: Maintable
//---------------------------------------------
echo("   <table class=\"index\">\n");
echo("    <tr>\n");
//---------------------------------------------
// Begin: KOPFZEILE
//---------------------------------------------
echo("     <td colspan=\"2\" class=\"head\">\n");
echo("      <table class=\"std\">\n");
echo("       <tr>\n");
echo("        <td>\n");
echo("         <a href=\"". CONF_HOMEPAGE ."\"\ target=\"_homepage\" title=\"". CONF_HOMEPAGE ."\">\n");
echo("         ". CONF_HOMEPAGE ."\n");
echo("         </a>\n");
echo("         |\n");
echo("         <a href=\"". $PHP_SELF ."?\">\n");
echo("          Index\n");
echo("         </a>\n");
echo("         |\n");
echo("         <a href=\"admin.php\" target=\"_admin\" onclick=\"return popup(this, '')\">\n");
echo("          Admin\n");
echo("         </a>\n");
echo("         |\n");
echo("          Statistik\n");
echo("         |\n");
echo("          Info\n");
echo("        </td>\n");
echo("        <td class=\"stdr\">\n");
echo("         ". date("d.m.Y, H:i:s") ."\n");
echo("        </td>\n");
echo("       </tr>\n");
echo("      </table>\n");
echo("     </td>\n");
//---------------------------------------------
// End: KOPFZEILE
//---------------------------------------------
//echo("    </tr>\n");
//echo("    <tr>\n");
//echo("     <td class=\"banner\" colspan=\"2px\">\n");
//echo("      <img src=\"style/std/banner.png\" border=\"0px\">\n");
//echo("     </td>\n");
//echo("    </tr>\n");
//-------------------------------------
// Begin: MENUE
//-------------------------------------
echo("    <tr>\n");
echo("     <td class=\"menu\">\n");

// Gallery-Liste
// Gallerys aus der DB lesen
$SQL = "SELECT * FROM ". TABLEPREFIX ."gallery WHERE showgal = 'true' ORDER BY name ASC";
$Result = mysql_query($SQL);

// Gallerys in einer Liste ausgeben
while($Obj = mysql_fetch_object($Result)) {
	$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."img WHERE galleryid = $Obj->id AND showimg = 'true'";
	$ObjCount = mysql_fetch_object(mysql_query($SQL));
	echo("        <a href=\"". $PHP_SELF ."?gallery=". $Obj->id ."&page=0&orderby=". $OrderBy ."&sort=". $Sort ."\">\n");
	echo("         - ". $Obj->name ." (". $ObjCount->count .")\n");
	echo("        </a>\n");
	echo("        <br />\n");
}

echo("      <br />\n");
echo("      <br />\n");
echo("      <hr />\n");

// Random Image
echo("      <center>\n");
$RandomImg = new MTF_Image();
$RandomImg = $RandomImg->getRandomImage();
if($RandomImg != null) {
	echo("      Random Image:<br />\n");
	echo("      <a href=\"viewimg.php?gallery=". $RandomImg->galleryid ."&img=". $RandomImg->id ."&orderby=". $OrderBy ."&sort=". $Sort ."\" target=\"_viewimg\" onclick=\"return popup(this, '')\">\n");
	echo("       <img src=\"". $RandomImg->paththumb ."\" alt=\"". $RandomImg->alttext ."\" title=\"". $RandomImg->title ."\" border=\"0px\" width=\"". $RandomImg->widththumb ."px\" height=\"". $RandomImg->heightthumb ."px\">\n");
	echo("       <br />\n");
	echo("        ". $RandomImg->name ."\n");
	echo("       <br />\n");
	echo("        Views: ". $RandomImg->views ."\n");
	echo("        <br />\n");
	echo("        (". round($RandomImg->sizeresized / 1024) ." kb)\n");
	echo("      </a>\n");
	echo("      <br />\n");
	echo("      <hr />\n");
}

// Top viewed Image
$TopViewImg = new MTF_Image();
$TopViewImg = $TopViewImg->getTopViewdImage();
if($TopViewImg != null) {
	echo("      Top viewed image:<br />\n");
	echo("      <a href=\"viewimg.php?gallery=". $TopViewImg->galleryid ."&img=". $TopViewImg->id ."&orderby=". $OrderBy ."&sort=". $Sort ."\" target=\"_viewimg\" onclick=\"return popup(this, '')\">\n");
	echo("       <img src=\"". $TopViewImg->paththumb ."\" alt=\"". $TopViewImg->alttext ."\" title=\"". $TopViewImg->title ."\" border=\"0px\" width=\"". $TopViewImg->widththumb ."px\" height=\"". $TopViewImg->heightthumb ."px\">\n");
	echo("        <br />\n");
	echo("        ". $TopViewImg->name ."\n");
	echo("        <br />\n");
	echo("        Views: ". $TopViewImg->views ."\n");
	echo("        <br />\n");
	echo("        (". round($TopViewImg->sizeresized / 1024) ." kb)\n");
	echo("      </a>\n");
	echo("      <br />\n");
	echo("      <hr />\n");
}

echo("      Letzten 5 Comments:<br />\n");
$t_objMTF_ImageComment_Arr = new MTF_ImageComment();
$t_objMTF_ImageComment_Arr = $t_objMTF_ImageComment_Arr->getLastXComments(5);
if($t_objMTF_ImageComment_Arr != null) {
	foreach($t_objMTF_ImageComment_Arr as $t_objMTF_ImageComment_Last3) {
		echo("      <a class=\"image\" href=\"viewimg.php?gallery=". $t_objMTF_ImageComment_Last3->intGalleryID ."&img=". $t_objMTF_ImageComment_Last3->intImageID ."&orderby=id&sort=ASC\" target=\"_viewimg\" onclick=\"return popup(this, '')\">\n");
		echo("       ". $t_objMTF_ImageComment_Last3->strAuthor ." am ". date("d.m.Y, H:i", $t_objMTF_ImageComment_Last3->intDateadd) ."<br />\n");
		echo("      </a>\n");
	}
} 
echo("      </center>\n");

//-------------------------------------
// End: MENUE
//-------------------------------------
echo("     </td>\n");
echo("     <td class=\"main\">\n");
echo("      <center>\n");
//-------------------------------------
// Begin: MAIN
//-------------------------------------

//-------------------------------------------------
// Gallery-Bilder
//-------------------------------------------------
if($_REQUEST['gallery'] != null) {
	$GalleryID = $_REQUEST['gallery'];
	$Page = $_REQUEST['page'];

	//----------------------------------------------------
	// Begin: Gallery Banner
	//----------------------------------------------------
	// Gallery auslesen
	$t_objMTF_Gallery = new MTF_Gallery();
	$t_objMTF_Gallery->getGalleryByID($GalleryID);
	
	// Ersteller auslesen
	$SQL = "SELECT * FROM ". TABLEPREFIX ."galuser "
			. " WHERE id = ". $t_objMTF_Gallery->intCreator;
	$Creator = mysql_fetch_object(mysql_query($SQL));
	// Anzahl der Bilder auslesen
	$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."img "
			. " WHERE showimg = 'true' "
			. " AND galleryid = ". $t_objMTF_Gallery->intID;
	$Count = mysql_fetch_object(mysql_query($SQL));

	echo("       <div class=\"galbanner\">\n");
	echo("        <table>\n");
	echo("         <tr>\n");
	echo("          <td>\n");
	echo("           Name:\n");
	echo("          </td>\n");
	echo("          <td>\n");
	echo("           ". $t_objMTF_Gallery->strName ."\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td>\n");
	echo("           Erstellt:\n");
	echo("          </td>\n");
	echo("          <td>\n");
	echo("           ". date("d. M. Y", $t_objMTF_Gallery->intDateAdd) ." von ". $Creator->name ."\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td>\n");
	echo("           Bilder:\n");
	echo("          </td>\n");
	echo("          <td>\n");
	echo("           ". $Count->count ."\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td>\n");
	echo("           Views:\n");
	echo("          </td>\n");
	echo("          <td>\n");
	echo("           ". $t_objMTF_Gallery->getCountViewsByID($t_objMTF_Gallery->intID) ."\n");
	echo("          </td>\n");
	echo("         </tr>\n");	
	echo("         <tr>\n");
	echo("          <td>\n");
	echo("           Gallery-Groesse:\n");
	echo("          </td>\n");
	echo("          <td>\n");
	echo("           ". round($t_objMTF_Gallery->getCountGallerySize($t_objMTF_Gallery->intID)/1024) ." kb\n");
	echo("           (". round($t_objMTF_Gallery->getCountGallerySize($t_objMTF_Gallery->intID)/1024/1024) ." MB)\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td>\n");
	echo("           Info:\n");
	echo("          </td>\n");
	echo("          <td>\n");
	echo("           ". $t_objMTF_Gallery->strInfo ."\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("        </table>\n");
	echo("       </div>\n");
	//----------------------------------------------------
	// End: Gallery Banner
	//----------------------------------------------------

	// Anzahl der Seiten auslesen
	$SQL = "SELECT FLOOR((COUNT(id) / ". CONF_IMGPSITE .")) AS count "
		. "  FROM ". TABLEPREFIX ."img "
		. "  WHERE galleryid = ". $GalleryID ." "
		. "  AND showimg = 'true' "
		. "  LIMIT 0, " . CONF_IMGPSITE;
	$Count = mysql_fetch_object(mysql_query($SQL));

	// Wenn Manipulation versucht wird, MAX Seite setzen
	if($Page > $Count->count) {
		$Page = $Count->count;
	}
	//...
	if($Page < 0) {
		$Page = 0;
	}
	
	// Seite X / X
	echo("       Site ". ($Page+1) ." / ". ($Count->count+1) ."<br />\n");

	//---------------------------------------------------------
	// Zum ersten Bild der Gallery
	//---------------------------------------------------------
	if($Page > 0) {
		echo("       <a href=\"". $PHP_SELF ."?gallery=". $_REQUEST['gallery'] ."&page=1&orderby=". $OrderBy ."&sort=". $Sort ."\" title=\"Zum ersten Bild der Gallery\">\n");
		echo("        <img src=\"img/first.gif\" border=\"0px\">\n");
		echo("       </a>\n");
	} else {
		echo("       <img src=\"img/first.gif\" border=\"0px\">\n");
	}

	//---------------------------------------------------------
	// Eine Seite zurueck
	//---------------------------------------------------------
	if($Page > 0) {
		echo("       <a href=\"". $PHP_SELF ."?gallery=". $_REQUEST['gallery'] ."&page=". ($Page - 1) ."&orderby=". $OrderBy ."&sort=". $Sort ."\">\n");
		echo("        <img src=\"img/back.gif\" border=\"0px\">\n");
		echo("       </a>\n");
	} else {
		echo("       <img src=\"img/back.gif\" border=\"0px\">\n");
	}

	//---------------------------------------------------------
	// Eine Seite vor
	//---------------------------------------------------------
	if($Page < $Count->count) {
		echo("       <a href=\"". $PHP_SELF ."?gallery=". $_REQUEST['gallery'] ."&page=". ($Page + 1) ."&orderby=". $OrderBy ."&sort=". $Sort ."\">\n");
		echo("        <img src=\"img/next.gif\" border=\"0px\">\n");
		echo("       </a>\n");
	} else {
		echo("       <img src=\"img/next.gif\" border=\"0px\">\n");
	}

	//---------------------------------------------------------
	// Zur letzten Seite
	//---------------------------------------------------------
	if($Page < $Count->count) {
		echo("       <a href=\"". $PHP_SELF ."?gallery=". $_REQUEST['gallery'] ."&page=". $Count->count ."&orderby=". $OrderBy ."&sort=". $Sort ."\" title=\"Zum letzten Bild der Gallery\">\n");
		echo("        <img src=\"img/last.gif\" border=\"0px\">\n");
		echo("       </a>\n");
	} else {
		echo("       <img src=\"img/last.gif\" border=\"0px\">\n");
	}

	//---------------------------------------------------------
	// Gallery-Bilder
	//---------------------------------------------------------
	echo("       <center>\n");
	echo("       <table class=\"images\">\n");
	echo("        <tr>\n");

	$SQL = "SELECT * FROM ". TABLEPREFIX ."img "
		. " WHERE galleryid = '$GalleryID' "
		. " AND showimg = 'true' "
		. " ORDER BY ". $OrderBy ." ". $Sort ." "
		. " LIMIT ". ($Page * CONF_IMGPSITE) .", " . CONF_IMGPSITE;

	$Result = mysql_query($SQL);
	$i = 0;
	// Bilder auslesen
	while($Obj = mysql_fetch_object($Result)) {

		// Wenn die Zelle die MAX Zellen Anzahl per Reihe ist..
		if($i == CONF_IMGPROW) {
			// Zaehler zurueck setzen
			$i = 1;
			// Neue Tabellenzeile
			echo("        <tr />\n");
			echo("        <tr>\n");
		} else {
			$i++;
		}
	
		// Zelle
		echo("         <td class=\"image\">\n");
		echo("           <a class=\"image\" href=\"viewimg.php?gallery=". $GalleryID ."&img=". $Obj->id ."&orderby=". $OrderBy ."&sort=". $Sort ."\" target=\"_viewimg\" onclick=\"return popup(this, '')\">\n");
		echo("            <img src=\"". $Obj->paththumb ."\" alt=\"". $Obj->alttext ."\" title=\"". $Obj->title ."\" border=\"0px\" width=\"". $Obj->widththumb ."px\" height=\"". $Obj->heightthumb ."px\">\n");
		if(THUMB_SHOW_NAME == "true") {
			echo("            <br />\n");
			echo("            ". $Obj->name ."\n");
		}
		if(THUMB_SHOW_VIEWS == "true") {
			echo("            <br />\n");
			echo("            Views: ". $Obj->views ."\n");
		}
		if(THUMB_SHOW_SIZE == "true") {
			echo("            <br />\n");
			echo("            (". round($Obj->sizeresized / 1024) ." kb)\n");
		}
		echo("           </a>\n");
		echo("         </td>\n");
	}
	
	// Wenn es grad mitten in einer Zeile ist...
	if($i > 1 && $i != CONF_IMGPROW) {
		// Die restlichen Zellen einfuegen
		while($i <= CONF_IMGPROW) {
			echo("         <td>\n");
			echo("         </td>\n");
			$i++;
		}
	}
	echo("        </tr>\n");
	echo("       </table>\n");
	echo("       <center>\n");
} 
else {
	//---------------------------------------------------------
	// Gallery-Liste mit Thumbnail
	//---------------------------------------------------------
	//----------------------------------------------------
	// Begin: Index Banner
	//----------------------------------------------------
	$t_objMTF_Gallery_IndexBanner = new MTF_Gallery();
	$t_objMTF_ImageComment = new MTF_ImageComment();
	echo("       <div class=\"galbanner\">\n");
	echo("       Gallerien: ". $t_objMTF_Gallery_IndexBanner->getCountGallerys() ."<br />\n");
	echo("       Bilder: ". $t_objMTF_Gallery_IndexBanner->getCountImages() ."<br />\n");
	echo("       Views: ". $t_objMTF_Gallery_IndexBanner->getCountViews() ."<br />\n");
	echo("       Kommentare: ". $t_objMTF_ImageComment->getCountComments() ."<br />\n");
	echo("       </div>\n");
	//----------------------------------------------------
	// End: Gallery Banner
	//----------------------------------------------------
	
	// Wenn keine Gallery gewaehlt ist, gallerys anzeigen
	echo("      <table class=\"images\">\n");
	echo("       <tr>\n");

	$SQL = "SELECT * FROM ". TABLEPREFIX ."gallery "
			. " ORDER BY ". $OrderBy ." ". $Sort;
	$Result = mysql_query($SQL);
	$i = 0;
	// Die Daten auslesen
	while($Obj = mysql_fetch_object($Result)) {
		$GalleryID = $Obj->id;
		$t_objMTF_Gallery = new MTF_Gallery();
		$t_objMTF_Image_Thumb = new MTF_Image();
		if($Obj->indeximg > 0) {
			$t_objMTF_Image_Thumb = $t_objMTF_Image_Thumb->getImageByID($Obj->indeximg);
			if($t_objMTF_Image_Thumb->bolShowImg != "true") {
				$t_objMTF_Image_Thumb = $t_objMTF_Image_Thumb->getImageByID($t_objMTF_Gallery->getFirstImageID($GalleryID));
			}
		} else {
			$t_objMTF_Image_Thumb = $t_objMTF_Image_Thumb->getImageByID($t_objMTF_Gallery->getFirstImageID($GalleryID));
		}

		// Wenn die Zelle die MAX Zellen Anzahl per Reihe ist..
		if($i == CONF_IMGPROW) {
			// Zaehler zurueck setzen
			$i = 1;
			// Neue Tabellenzeile
			echo("       <tr />\n");
			echo("       <tr>\n");
		} else {
			$i++;
		}

		// Zelle
		echo("        <td>\n");
		echo("         <a href=\"". $PHP_SELF ."?gallery=". $GalleryID ."&page=0&orderby=". $OrderBy ."&sort=". $Sort ."\">\n");
		echo("          <img src=\"". $t_objMTF_Image_Thumb->strPathThumb ."\" alt=\"". $t_objMTF_Image_Thumb->strAltText ."\" title=\"". $t_objMTF_Image_Thumb->strTitle ."\" border=\"0px\" width=\"". $t_objMTF_Image_Thumb->intWidthThumb ."px\" height=\"". $t_objMTF_Image_Thumb->intHeightThumb ."px\"><br />\n");
		echo("          <font class=\"imgname\">". $Obj->name ."</font>\n");
		echo("          <br />\n");
		$SQL = "SELECT COUNT(id) AS count FROM ". TABLEPREFIX ."img WHERE galleryid = ". $GalleryID;
		$Count = mysql_fetch_object(mysql_query($SQL));
		echo("          <font class=\"imginfo\">Bilder: ". $Count->count ."</font>\n");
		echo("         </a>\n");
		echo("        </td>\n");
		}
				
	// Wenn es grad mitten in einer Zeile ist...
	if($i > 1 && $i != CONF_IMGPROW) {
		// Die restlichen Zellen einfuegen
		while($i <= CONF_IMGPROW) {
			echo("         <td>\n");
			echo("         </td>\n");
			$i++;
		}
	}

	echo("       </tr>\n");
	echo("      </table>\n");
}

//-------------------------------------
// End: MAIN
//-------------------------------------
echo("      <center>\n");
echo("     </td>\n");
echo("    </tr>\n");
echo("   </table>\n");
echo("   <br /><br />\n");
echo("   &copy; by Matflasch 2005 (GPL) \n");
echo("   <a href=\"http://www.matflasch.de\" target=\"_matflasch\">Matflasch.de</a>\n");
echo("   <br /><br /><br />\n");
echo("  </center>\n");
echo(" </body>\n");
echo("</html>\n");
$mtf_mysqldb->mtf_close();
?>
