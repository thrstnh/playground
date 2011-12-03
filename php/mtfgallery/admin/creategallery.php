<?php
// Wenn der User nicht eingeloggt ist, wird eine Fehler-Msg ausgegeben
if($_SESSION['login'] == true) {
	
	echo("  <center>\n");
	echo("   Gallery anlegen<br /><br />\n");
	echo("   <br />\n");
	echo("   <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&action=create\" method=\"post\">\n");
	echo("   <table class=\"conf\">\n");
	echo("    <tr>\n");
	echo("     <td>\n");
	echo("      Name<br />\n");
	echo("     </td>\n");
	echo("     <td>\n");
	echo("      <input class=\"stdtxt\" type=\"text\" name=\"galname\"");
	if($_REQUEST["action"] == "edit") {
		echo(" value=\"". $name ."\"");
	}
	echo(">\n");
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("    <tr>\n");
	echo("     <td>\n");
	echo("      Password<br />\n");
	echo("     </td>\n");
	echo("     <td>\n");
	echo("      <input class=\"stdtxt\" type=\"password\" name=\"galpass\"");
	if($_REQUEST["action"] == "edit") {
		echo(" value=\"". $pass ."\"");
	}
	echo(">\n");
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("    <tr>\n");
	echo("     <td>\n");
	echo("      Info\n");
	echo("     </td>\n");
	echo("     <td>\n");
	echo("      <textarea class=\"stdtxa\" name=\"galinfo\">");
	if($_REQUEST["action"] == "edit") {
		echo($info);
	}
	echo("</textarea>\n");
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("    <tr>\n");
	echo("     <td>\n");
	echo("      Gallery anzeigen?\n");
	echo("     </td>\n");
	echo("     <td>\n");
	echo("      <input class=\"stdchk\" type=\"checkbox\" name=\"galshowgal\"");
//	if(isset($_REQUEST['galshowgal']) || $_REQUEST['action'] == "true") {
		echo(" checked");
//	}
	echo(">\n");
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("    <tr>\n");
	echo("     <td class=\"stdc\" colspan=\"2\">\n");
	if($_REQUEST["action"] == "edit") {
		echo("      <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Gallery updaten\">\n");
	} else {
		echo("      <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Gallery erstellen\">\n");
	}
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("   </table>\n");
	echo("   </form>\n");
	echo("  </center>\n");
}
?>
