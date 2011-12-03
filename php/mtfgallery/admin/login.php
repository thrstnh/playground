<?php
// Name und Pass pruefen...
if($_REQUEST['action'] == "login") {
	$username = $_REQUEST['lname'];
	$userpass = $_REQUEST['lpass'];
	$SQL = "SELECT * FROM ". TABLEPREFIX ."galuser WHERE name = '$username' AND pass = PASSWORD('$userpass')";
	$Obj = mysql_fetch_object(mysql_query($SQL));
	if($Obj->id != null
			&& $Obj->name != null
			&& $Obj->pass != null) {
		$_SESSION['login'] = true;
		$_SESSION['userid'] = $Obj->id;
		if($Obj->admin == "true") {
			$_SESSION['userid'] = $Obj->id;
			$_SESSION['admin'] = true;
		}
	} else {
		$_SESSION['login'] = false;
		$_SESSION['userid'] = "0";
		$_SESSION['admin'] = false;
	}
}

if($_SESSION['login'] != true) {
	echo("<html>\n");
	echo(" <head>\n");
	echo("  <title>Matflasch's Image Gallery</title>\n");
	echo("  <link rel=\"stylesheet\" type=\"text/css\" href=\"". CONF_CSS ."\">\n");
	echo(" </head>\n");
	echo(" <body>\n");
	echo("  <br /><br />\n");
	echo("  <br /><br />\n");
	echo("  <center>\n");
	echo("   <form action=\"". $PHP_SELF ."?action=login\" method=\"post\">\n");
	echo("   <table class=\"std\">\n");
	echo("    <tr>\n");
	echo("     <td class=\"std\">\n");
	echo("      Name:\n");
	echo("     </td>\n");
	echo("     <td class=\"std\">\n");
	echo("      <input class=\"stdtxt\" type=\"text\" name=\"lname\">\n");
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("    <tr>\n");
	echo("     <td class=\"std\">\n");
	echo("      Pass:\n");
	echo("     </td>\n");
	echo("     <td class=\"std\">\n");
	echo("      <input class=\"stdtxt\" type=\"password\" name=\"lpass\">\n");
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("    <tr>\n");
	echo("     <td class=\"stdc\" colspan=\"2\">\n");
	echo("      <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Login...\">\n");
	echo("     </td>\n");
	echo("    </tr>\n");
	echo("   </table>\n");
	echo("   </form>\n");
	echo("   <br />\n");
	echo("   <a href=\"javascript:window.close();\" title=\"Fenster schliessen\">\n");
	echo("    Fenster schliessen\n");
	echo("   </a>\n");
	echo("  </center>\n");
}
?>
