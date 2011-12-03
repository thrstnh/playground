<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
 
// Konstanten fuer die DB-Verbindung
define("MTF_DBHOST", "localhost");
define("MTF_DBUSER", "");
define("MTF_DBPASS", "");
define("MTF_DBNAME", "");

// Counterpath ist der Pfad zum Verzeichnis, wo der
// Counter gespeichert ist bzw. entpackt ist
// Wichtig ist der / am Ende!
define("COUNTERPATH", "modules/mtf_counter/");

// Tabellen:
define("TBL_RELOAD", "mtfc_reload");
define("TBL_USERAGENT", "mtfc_useragent");
define("TBL_USER", "mtfc_user");
define("TBL_SITE", "mtfc_site");
define("TBL_REFERER", "mtfc_referer");
define("TBL_QUERYS", "mtfc_querys");
define("TBL_OS", "mtfc_os");
define("TBL_LANG", "mtfc_lang");
define("TBL_BROWSER", "mtfc_browser");
define("TBL_ACCLANG", "mtfc_acclang");
define("TBL_SCREEN", "mtfc_screen");


// Die "Online-Benutzer" koennen nicht wirklich ermittelt werden,
// da es mit dem HTTP-Protokoll nicht moeglich ist festzustellen,
// ob sich der User noch auf der Webseite befindet. Man kann
// hoechstens abschaetzen, wie lange der User Online ist bis
// zum naechsten Reload. Bei einem Reload wird die Zeit
// der letzten Besuchs auf die aktuelle Zeit gesetzt und
// es wird dann die Anzahl der Benutzer aus der DB ausgelesen
// die innerhalb der letzten X Sekunden zumindest einen
// Reload gemacht hat. Die X Sekunden muessen hier angegeben
// werden
// Default: 60
define("ONLINETIME", 60);
?>
