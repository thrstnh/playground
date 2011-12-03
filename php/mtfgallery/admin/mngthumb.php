<?php
if($_SESSION['login'] == "true") {
	echo("      <center>\n");
	echo("      Thumb bearbeiten....<br />\n");
	echo("      <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&action=updatethumb\" method=\"post\">\n");
	echo("      <table class=\"conf\">\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	$checked = "";
	if(THUMB_SHOW_NAME == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"thumbname\"". $checked ."> Name anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(THUMB_SHOW_VIEWS == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"thumbviews\"". $checked ."> Views anzeigen\n");
	echo("        </td>\n");
	echo("       </tr>\n");
	echo("       <tr>\n");
	echo("        <td>\n");
	if(THUMB_SHOW_SIZE == "true") {
		$checked = " checked";
	} else {
		$checked = "";
	}
	echo("         <input type=\"checkbox\" name=\"thumbsize\"". $checked ."> File Size anzeigen\n");
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
