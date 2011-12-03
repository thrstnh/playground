<?php
if($_SESSION['login'] == "true") {
	echo("      <center>\n");
	echo("      View bearbeiten....<br />\n");
	echo("      <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&action=updateview\" method=\"post\">\n");
	echo("      <table class=\"conf\">\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	$checked = "";
	if(VIEWIMGXFX == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"imgxfx\"". $checked ."> Bild X/X anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWBUTTONBAR == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"buttonbar\"". $checked ."> ButtonBar anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	$checked = "";
	if(VIEWGALLERYNAME == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"imggalleryname\"". $checked ."> Gallery-Name\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWNAME == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"name\"". $checked .">Name anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWFILESIZE == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"filesize\"". $checked .">File Size anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWIMGSIZE == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"imgsize\"". $checked .">Image Size anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWVISITS == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"visits\"". $checked .">Visits anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWINFO == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"info\"". $checked .">Info anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWCOMMENTBANNER == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"commentbanner\"". $checked .">Commentbanner anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWCOMMENTS == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"comments\"". $checked .">Comments anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(VIEWADDCOMMENT == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"addcomment\"". $checked .">Add Comment anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	echo("         <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"&Uuml;bernehmen\" >\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("      </table>\n");
	echo("      </form>\n");
	echo("      </center>\n");
}
?>
