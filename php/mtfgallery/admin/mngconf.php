<?php
if($_SESSION['login'] == true) {
	echo("      <center>\n");
	echo("       <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&action=updateconf\" method=\"post\">\n");
	echo("        <table class=\"conf\">\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Titel der Gallery:<br />\n");
//	echo("           Hier kann der Titel im Browser für die Gallery festgelegt werden.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"conftitle\" value=\"". CONF_TITLE ."\"\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Homepage:<br />\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confhp\" value=\"". CONF_HOMEPAGE ."\"\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Keywords (Suchmaschine):<br />\n");
//	echo("           Hier kann der Titel im Browser für die Gallery festgelegt werden.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <textarea class=\"stdtxa\" name=\"confkeywords\">". CONF_KEYWORDS ."</textarea>\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Description (SuchmaschinenText zur Seite):<br />\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <textarea class=\"stdtxa\" name=\"confdescription\">". CONF_DESCRIPTION ."</textarea>\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Gallery-Verzeichnis:<br />");
//	echo("           Hier muss das Verzeichnis eingetragen werden, in dem\n");
//	echo("           die Gallery liegt. Wenn die Gallery z.B. vom Hauptverzeichnis\n");
//	echo("           aus im Ordner 'gallery' liegt, dann muss hier '/gallery/'\n");
//	echo("           eingetragen werden.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confgaldir\" value=\"". CONF_GALDIR ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Pfad zur CSS-Datei:<br />\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confcss\" value=\"". CONF_CSS ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Bilder pro Seite:<br />\n");
//	echo("           Wieviele Bilder auf jeder Seite angezeigt werden sollen.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confimgpsite\" value=\"". CONF_IMGPSITE ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Upload-Anzahl:<br />\n");
//	echo("           Die Anzahl der Bilder, die auf einmal hochgeladen werden können.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confuploadsptime\" value=\"". CONF_UPLOADSPTIME ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Bilder pro Zeile<br />\n");
//	echo("           Die Anzahl der Bilder, die pro Reihe nebeneinander angezeigt werden sollen.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confimgprow\" value=\"". CONF_IMGPROW ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Bilder-Rahmen:<br />\n");
//	echo("           Wie breit der Rahmen der Bilder sein soll.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confimgborder\" value=\"". CONF_IMGBORDER ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Sortierreihenfolge:<br />\n");
//	echo("           Sollen die Bilder aufsteigend oder absteigend als Standard\n");
//	echo("           angezeigt werden?\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <select class=\"stdcmb\" name=\"confsort\" size=\"1\">\n");
	echo("            <option");
	if(SORT == "ASC") {
		echo(" selected");
	}
	echo(">ASC</option>\n");
	echo("            <option");
	if(SORT == "DESC") {
		echo(" selected");
	}
	echo(">DESC</option>\n");
	echo("           </select>\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Sortieren nach...:<br />\n");
//	echo("           Wonach sollen die Bilder sortiert werden.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <select class=\"stdcmb\" name=\"conforderby\" size=\"1\">\n");
	echo("            <option");
	if(CONF_ORDERBY == "id") {
		echo(" selected");
	}
	echo(">id</option>\n");
	echo("            <option");
	if(CONF_ORDERBY == "name") {
		echo(" selected");
	}
	echo(">name</option>\n");
	echo("            <option");
	if(CONF_ORDERBY == "typeid") {
		echo(" selected");
	}
	echo(">typeid</option>\n");
	echo("            <option");
	if(CONF_ORDERBY == "dateadd") {
		echo(" selected");
	}
	echo(">dateadd</option>\n");
	echo("           </select>\n");

	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Thumbnail-Groesse:<br />\n");
//	echo("           Hier kann die Groesse der Bilder festgelegt werden. Hier\n");
//	echo("           handelt es sich um die Vorschaubilder.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confthumbsize\" value=\"". CONF_THUMBSIZE ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Bilder-Groesse:<br />\n");
//	echo("           Wie gross sollen die Bilder beim Ansehen sein?\n");
	echo("          </td>\n");
	echo("          <td>\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confimgsize\" value=\"". CONF_IMAGESIZE ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Bild-Qualitaet:<br />\n");
	echo("          </td>\n");
	echo("          <td>\n");
	echo("           <input class=\"stdtxt\" type=\"text\" name=\"confimgquality\" value=\"". CONF_IMAGEQUALITY ."\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Sortbar anzeigen:<br />\n");
//	echo("           Soll die Leiste zum Sortieren der Bilder angezeigt werden?\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input type=\"checkbox\" name=\"confshowsortbar\"");
	if(CONF_SHOWSORTBAR == "true") {
		echo(" checked");
	}
	echo(">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"conf\">\n");
	echo("           Originalbild speichern:<br />\n");
//	echo("           Soll das Originalbild auch gespeichert werden oder nur das\n");
//	echo("           Thumbnail und das Anzeigebild?<br />\n");
//	echo("           ACHTUNG: Das Originalbild kann unter Umständen vom Speicher her\n");
//	echo("           sehr gross sein und nimmt viel Speicher, der wahrscheinlich eh schon\n");
//	echo("           knapp ist.\n");
	echo("          </td>\n");
	echo("          <td class=\"conf\">\n");
	echo("           <input type=\"checkbox\" name=\"confsaveoriginal\"");
	if(CONF_SAVEORIGINAL == "true") {
		echo(" checked");
	}
	echo(">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("         <tr>\n");
	echo("          <td class=\"stdc\" colspan=\"2\">\n");
	echo("           <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Update\">\n");
	echo("          </td>\n");
	echo("         </tr>\n");
	echo("        </table>\n");
	echo("       </form>\n");
	echo("      </center>\n");
}
?>
