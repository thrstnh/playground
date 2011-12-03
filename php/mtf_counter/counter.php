<?php
session_start();
// session_start(); erzeugt die eindeutige Session-ID

// Hier muessen noch die Pfade zu den Dateien angepasst werden.
// Wenn der Counter-Ordner sich z.B. vom Webhost-Rootverzeichnis
// in /modules/mtf_counter/ befindet, dann muessen die Pfade so
// angepasst werden:
// z.B. include("/modules/mtf_counter/conf.php");
include($_SERVER["DOCUMENT_ROOT"] . "conf.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_userinfo.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_user.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_counter.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_acclang.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_browser.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_lang.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_os.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_querys.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_referer.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_useragent.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_site.php");
include($_SERVER["DOCUMENT_ROOT"] . "class/class.mtf_reload.php");


// Die folgenden 2 Anweisungen stellen die Datenbankverbindung
// her. Wenn die Datenbankverbindung sowieso schon vorhanden ist,
// dann koennen die Zeilen auskommentiert werden.
//-----
// Erstellt eine Instanz des Datenbank-Objekts
$t_objMTF_Mysql = new MTF_Mysql();
// Stellt die Verbindung mit der Datenbank her
// (Benutzt werden die Daten aus der conf.php
//  Datei, die im Counter-Verzeichnis liegt.)
$t_objMTF_Mysql->connect();

// Erstellt eine Instanz des Counters
$t_objMTF_Counter = new MTF_Counter();
// Zaehlt die Besucher
$t_objMTF_Counter->Visit();
// Zaehlt die Reloads
$t_objMTF_Counter->Reload();
?>
