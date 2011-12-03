<?php
if($_SESSION['login'] == true) {
	echo("      <center>\n");
	
	$GalleryID = $_REQUEST['gallery'];
	
	if(!isset($_REQUEST['orderby'])) {
		$OrderBy = CONF_ORDERBY;
	} else {
		$OrderBy = $_REQUEST['orderby'];
	}
	
	if(!isset($_REQUEST['sort'])) {
		$Sort = CONF_SORT;
	} else {
		$Sort = $_REQUEST['sort'];
	}
	
	if($_REQUEST['action'] == "editimage") {
		$t_objMTF_Image = new MTF_Image();
		$t_objMTF_Image->getImageByID($_REQUEST['id']);
		echo("       Image bearbeiten<br />\n");
		echo("       <br />\n");
		echo("       <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] . "&id=". $_REQUEST['id'] ."&action=updateimage#". $t_objMTF_Image->intID ."\" method=\"post\">\n");
		echo("          <input type=\"hidden\" name=\"imgid\" value=\"". $t_objMTF_Image->intID ."\">\n");
		echo("        <table class=\"conf\">\n");
		echo("         <tr>\n");
		echo("          <td>\n");
		echo("           Name\n");
		echo("          </td>\n");
		echo("          <td>\n");
		echo("          <input class=\"stdtxt\" type=\"text\" name=\"imgname\" value=\"". $t_objMTF_Image->strName ."\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td>\n");
		echo("           Tooltip\n");
		echo("          </td>\n");
		echo("          <td>\n");
		echo("          <input class=\"stdtxt\" type=\"text\" name=\"imgtt\" value=\"". $t_objMTF_Image->strTitle ."\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td>\n");
		echo("           Alt\n");
		echo("          </td>\n");
		echo("          <td>\n");
		echo("          <input class=\"stdtxt\" type=\"text\" name=\"imgalt\" value=\"". $t_objMTF_Image->strAltText ."\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td>\n");
		echo("           Views\n");
		echo("          </td>\n");
		echo("          <td>\n");
		echo("          <input class=\"stdtxt\" type=\"text\" name=\"imgviews\" value=\"". $t_objMTF_Image->intViews ."\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td>\n");
		echo("           Comment\n");
		echo("          </td>\n");
		echo("          <td>\n");
		echo("           <textarea class=\"stdtxa\" name=\"imgcomment\">". $t_objMTF_Image->strComment ."</textarea>\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td colspan=\"2\" class=\"stdc\">\n");
		echo("           <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Update\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("        </table>\n");
		echo("       </form>\n");
		echo("      <br /><br />\n");	
	} else {
	

		$SQL = "SELECT * FROM ". TABLEPREFIX ."gallery WHERE id = ". $GalleryID;
		$Gallery = mysql_fetch_object(mysql_query($SQL));
		
		echo("       Gallery bearbeiten<br />\n");
		echo("       <br />\n");
		echo("       <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] . "&action=updategal\" method=\"post\">\n");
		echo("       <table class=\"std\">\n");
		echo("        <tr>\n");
		echo("         <td class=\"std\">\n");
		echo("          Name<br />\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          <input class=\"stdtxt\" type=\"text\" name=\"galname\" value=\"". $Gallery->name ."\">\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("        <tr>\n");
		echo("         <td class=\"std\">\n");
		echo("          Info\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          <textarea class=\"stdtxa\" name=\"galinfo\">". $Gallery->info ."</textarea>\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("        <tr>\n");
		echo("         <td class=\"std\">\n");
		echo("          Gallery anzeigen?\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          <input class=\"stdchk\" type=\"checkbox\" name=\"galshowgal\"");
		if($Gallery->showgal == "true") {
			echo(" checked");
		}
		echo(">\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("        <tr>\n");
		echo("         <td class=\"std\" colspan=\"2\">\n");
		echo("          <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Updaten\">\n");
		echo("          <input class=\"stdbtn\" type=\"submit\" name=\"deletegallery\" value=\"Loeschen\">\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("       </table>\n");
		echo("      </form>\n");
		echo("      <br /><br />\n");
	}
	
	
	
	$ImageArray = new MTF_Image();
	$ImageArray = $ImageArray->getGalleryImages($GalleryID, "id", "DESC");
	if(isset($ImageArray) && $ImageArray != null) {
		foreach($ImageArray as $t_objImage) {
			if($t_objImage->bolShowImg == 'true') {
				$ImageShow = " checked";
			} else {
				$ImageShow = "";
			}
			$t_objMTF_GalleryUser = new MTF_GalleryUser();
			$t_objMTF_GalleryUser->intID = $t_objImage->intCreator;
			$t_objMTF_GalleryUser->getUserByID();
			$t_objMTF_Gallery = new MTF_Gallery();
			$t_objMTF_Gallery = $t_objMTF_Gallery->getGalleryByID($t_objImage->intGalleryID);
			echo("      <a name=\"". $t_objImage->intID ."\"> </a>\n");
			echo("       <br />\n");
			echo("      <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] ."&id=". $t_objImage->intID ."#". $t_objImage->intID ."\" method=\"post\">\n");
			echo("       <table class=\"mngimg\">\n");
			echo("        <tr>\n");
			echo("         <td  colspan=\"5\" class=\"stdl\">\n");
			
			// TOP
			echo("          <a href=\"#top\">\n");
			echo("           <img src=\"style/std/top.png\" border=\"0px\" alt=\"Top\" title=\"Top\">\n");
			echo("          </a>\n");
			// Bild editieren
			echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] ."&id=". $t_objImage->intID ."&action=editimage\">\n");
			echo("           <img src=\"style/std/edit.png\" border=\"0px\" alt=\"Edit\" title=\"Dieses Bild bearbeiten\">\n");
			echo("          </a>\n");
			// Bild anzeigen 1/0
			if($t_objImage->bolShowImg == "true") {
				$t_strShowIMG = "style/std/display_on.png";
				$t_strShowTT = "Dieses Bild nichtmehr in der Gallery anzeigen.";
				$t_strShowValue = "false";
			} else {
				$t_strShowIMG = "style/std/display_off.png";
				$t_strShowTT = "Dieses Bild wieder in der Gallery anzeigen.";
				$t_strShowValue = "true";
			}
			echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] ."&id=". $t_objImage->intID ."&action=showimg&value=". $t_strShowValue ."#". $t_objImage->intID ."\">\n");
			echo("           <img src=\"". $t_strShowIMG ."\" border=\"0px\" alt=\"". $t_strShowTT ."\" title=\"". $t_strShowTT ."\">\n");
			echo("          </a>\n");
			// Bild als Index setzen
			if($t_objMTF_Gallery->intIndexImgID == $t_objImage->intID) {
				echo("           <img src=\"style/std/setindex_dis.png\" border=\"0px\" alt=\"SetIndex\" title=\"Dieses Bild ist das Gallery-Index Bild\">\n");
			} else {
				echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] ."&id=". $t_objImage->intID ."&action=setindex#". $t_objImage->intID ."\">\n");
				echo("           <img src=\"style/std/setindex.png\" border=\"0px\" alt=\"SetIndex\" title=\"Dieses Bild als Gallery-Index setzen\">\n");
				echo("          </a>\n");
			}
			
			//90 grad links
			echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] ."&id=". $t_objImage->intID ."&action=rotateleft#". $t_objImage->intID ."\">\n");
			echo("           <img src=\"style/std/rotate_left.png\" border=\"0px\" alt=\"90 Grad Links\" title=\"Dieses Bild 90 Grad linksrum drehen\">\n");
			echo("          </a>\n");
			//90 grad rechts
			echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] ."&id=". $t_objImage->intID ."&action=rotateright#". $t_objImage->intID ."\">\n");
			echo("           <img src=\"style/std/rotate_right.png\" border=\"0px\" alt=\"90 Grad Rechts\" title=\"Dieses Bild 90 Grad rechtsrum drehen\">\n");
			echo("          </a>\n");
			
			
			// Bild loeschen
			echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] ."&id=". $t_objImage->intID ."&action=deleteimage#". $t_objImage->intID ."\">\n");
			echo("           <img src=\"style/std/delete.png\" border=\"0px\" alt=\"Delete\" title=\"Dieses Bild l&ouml;schen\">\n");
			echo("          </a>\n");
			// Original loeschen
			if(strlen($t_objImage->strPathOriginal) > 0) {
				echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] ."&id=". $t_objImage->intID ."&action=deleteoriginalimage#". $t_objImage->intID ."\">\n");
				echo("           <img src=\"style/std/delete_original.png\" border=\"0px\" alt=\"Delete\" title=\"Das Original-Bild l&ouml;schen\">\n");
				echo("          </a>\n");
			} else {
				echo("           <img src=\"style/std/delete_original_dis.png\" border=\"0px\" alt=\"Delete\" title=\"Kein Original-Bild vorhanden\">\n");
			}
			
			
			echo("          | ID:". $t_objImage->intID ." | Views: ". $t_objImage->intViews ."\n");
			echo("         </td>\n");;
			echo("        </tr>\n");
			echo("        <tr>\n");
			echo("         <td rowspan=\"5\" class=\"std\">\n");
			echo("          <a href=\"viewimg.php?gallery=". $GalleryID ."&img=". $t_objImage->intID ."&orderby=". $OrderBy ."&sort=". $Sort ."\" target=\"_viewimg\" onclick=\"return popup(this, '')\">\n");
			echo("           <img src=\"". $t_objImage->strPathThumb ."\" alt=\"Das Bild kann leider nicht angezeigt werden!\" title=\"". $t_objImage->strTitle ."\" border=\"0px\">\n");
			echo("          </a>\n");
			echo("         </td>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          Name\n");
			echo("         </td>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          ". $t_objImage->strName ."\n");
			echo("         </td>\n");
			echo("        </tr>\n");
			echo("        <tr>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          ToolTip\n");
			echo("         </td>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          ". $t_objImage->strTitle ."\n");
			echo("         </td>\n");
			echo("        </tr>\n");
			echo("        <tr>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          Alt\n");
			echo("         </td>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          ". $t_objImage->strAltText ."\n");
			echo("         </td>\n");
			echo("        </tr>\n");
			echo("        <tr>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          Hinzugef&uuml;gt am\n");
			echo("         </td>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          ". date("d.m.Y, H:i", $t_objImage->intDateAdd) ."\n");
			echo("         </td>\n");
			echo("        </tr>\n");
			echo("        <tr>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          Hinzugef&uuml;gt von\n");
			echo("         </td>\n");
			echo("         <td class=\"stdl\">\n");
			echo("          ". $t_objMTF_GalleryUser->strName ."\n");
			echo("         </td>\n");
			echo("        </tr>\n");
			echo("       </table>\n");
			echo("       </form>\n");
		}
	}
	echo("      </center>\n");
}
?>
