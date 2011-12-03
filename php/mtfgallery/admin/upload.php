<?php
if($_SESSION['login'] == true) {
	echo(" <center>\n");
	echo("  Bilder raufladen.");
	echo(" <br /><br />\n");
	echo("  <form action=\"" . $PHP_SELF . "?site=". $_REQUEST['site'] ."&action=upload\" method=\"post\" enctype=\"multipart/form-data\">\n");
//	echo("  <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1000000\">\n");
	echo("   Gallery: \n");
	echo("   <select class=\"stdcmb\" name=\"imggallery\">\n");
	$SQL = "SELECT * FROM ". TABLEPREFIX ."gallery ORDER BY name ASC";
	$Result = mysql_query($SQL);
	while($Obj = mysql_fetch_object($Result)) {
		echo("    <option value=\"". $Obj->id ."\"");
		if($Obj->id == $_REQUEST['imggallery']) {
			echo(" selected");
		}
		echo(">". $Obj->name ."</option>\n");
	}
	echo("   </select>\n");
	echo("  <br />\n");
	echo("  <br />\n");
	echo("  <table class=\"conf\">\n");
	for($i=0; $i<CONF_UPLOADSPTIME; $i++) {
	//	echo("  <table border=\"1px\">\n");
		echo("   <tr>\n");
		echo("    <td>\n");
		echo("     #" . ($i+1) . ":\n");
		echo("    </td>\n");
		echo("    <td>\n");
		echo("     <input type=\"file\" size=55 name=\"img" . $i . "\" class=\"upload\">\n");
		echo("    </td>\n");
		echo("   </tr>\n");
	}
	echo("  </table>\n");
	echo("  <br />\n");
	echo("  <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Raufladen...\">\n");
	echo("  </form>\n");
	echo(" </center>\n");
}
?>
