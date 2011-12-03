<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
include("conf.php");
if($_REQUEST['action'] == "install") {
	
	include("class/class.mtf_mysql.php");
	$t_objMTF_Mysql = new MTF_Mysql();
	$t_objMTF_Mysql->connectWith($_REQUEST['dbhost'], $_REQUEST['dbname'], $_REQUEST['dbuser'], $_REQUEST['dbpass']);
	
	// AccLang
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tblacclang'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tblacclang'] ."` ( ";
  	$SQL .= "`id` int(11) NOT NULL auto_increment,";
  	$SQL .= "`acclang` varchar(255) NOT NULL default '',";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0',";
  	$SQL .= "PRIMARY KEY  (`id`)";
	$SQL .= ") TYPE=MyISAM;";
	mysql_query($SQL) OR die($_REQUEST['tblacclang'] ." konnte nicht erstellt werden!". mysql_error());
	
	// Browser
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tblbrowser'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tblbrowser'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`name` varchar(255) NOT NULL default '', ";
  	$SQL .= "`version` varchar(255) NOT NULL default '', ";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM; ";
	mysql_query($SQL) OR die($_REQUEST['tblbrowser'] ." konnte nicht erstellt werden!");

	// Lang
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tbllang'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tbllang'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`lang` char(2) NOT NULL default '', ";
  	$SQL .= "`country` varchar(255) NOT NULL default '',";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM;";
	mysql_query($SQL) OR die($_REQUEST['tbllang'] ." konnte nicht erstellt werden!");

	// OS
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tblos'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tblos'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`os` varchar(255) NOT NULL default '', ";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM; ";
	mysql_query($SQL) OR die($_REQUEST['tblos'] ." konnte nicht erstellt werden!");
	
	// QueryS
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tblquerystring'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tblquerystring'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`querys` varchar(255) NOT NULL default '', ";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM; ";
	mysql_query($SQL) OR die($_REQUEST['tblquerystring'] ." konnte nicht erstellt werden!");
	
	// Referer
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tblreferer'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tblreferer'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`referer` varchar(255) NOT NULL default '', ";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM; ";
	mysql_query($SQL) OR die($_REQUEST['tblreferer'] ." konnte nicht erstellt werden!");
	
	// Reload
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tblreload'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tblreload'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`siteid` int(10) NOT NULL default '0', ";
  	$SQL .= "`querysid` int(10) NOT NULL default '0', ";
  	$SQL .= "`userid` int(10) NOT NULL default '0', ";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM;";
	mysql_query($SQL) OR die($_REQUEST['tblreload'] ." konnte nicht erstellt werden!");
	
	
	// Screen
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tblscreen'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tblscreen'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`screenx` int(5) NOT NULL default '0', ";
  	$SQL .= "`screeny` int(5) NOT NULL default '0', ";
  	$SQL .= "`coldepth` int(5) NOT NULL default '0', ";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM;";
	mysql_query($SQL) OR die($_REQUEST['tblscreen'] ." konnte nicht erstellt werden!");
	
	// Site
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tblsite'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tblsite'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`site` varchar(255) NOT NULL default '', ";
  	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM;";
	mysql_query($SQL) OR die($_REQUEST['tblsite'] ." konnte nicht erstellt werden!");
	
	// User
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tbluser'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tbluser'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`ip` varchar(15) NOT NULL default '', ";
  	$SQL .= "`host` varchar(255) NOT NULL default '', ";
  	$SQL .= "`sessid` varchar(255) NOT NULL default '', ";
  	$SQL .= "`useragentid` int(10) NOT NULL default '0', ";
  	$SQL .= "`refererid` int(10) NOT NULL default '0', ";
  	$SQL .= "`browserid` int(10) NOT NULL default '0', ";
  	$SQL .= "`langid` int(10) NOT NULL default '0', ";
  	$SQL .= "`osid` int(10) NOT NULL default '0', ";
  	$SQL .= "`acclangid` int(10) NOT NULL default '0', ";
  	$SQL .= "`js` set('true','false') NOT NULL default '', ";
  	$SQL .= "`screenid` int(10) NOT NULL default '0', ";
  	$SQL .= "`visit` int(10) NOT NULL default '0', ";
  	$SQL .= "`lastvisit` int(10) NOT NULL default '0', ";
  	$SQL .= "`reloads` int(10) NOT NULL default '0', ";
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM;";
	mysql_query($SQL) OR die($_REQUEST['tbluser'] ." konnte nicht erstellt werden!");
	
	// Useragent
	$SQL = "DROP TABLE IF EXISTS `". $_REQUEST['tbluseragent'] ."`";
	mysql_query($SQL) OR die(mysql_error());
	$SQL = "CREATE TABLE `". $_REQUEST['tbluseragent'] ."` ( ";
  	$SQL .= "`id` int(10) NOT NULL auto_increment, ";
  	$SQL .= "`useragent` varchar(255) NOT NULL default '', ";
	$SQL .= "`dateadd` int(10) NOT NULL default '0', ";	
  	$SQL .= "PRIMARY KEY  (`id`) ";
	$SQL .= ") TYPE=MyISAM;";
	mysql_query($SQL) OR die($_REQUEST['tbluseragent'] ." konnte nicht erstellt werden!");
	
	$t_objMTF_Mysql->close();
?>	
<html>
 <head>
  <title>http://www.matflasch.de :: MTF_Counter</title>
   <style type="text/css">
  	<!--
	  	body, div {
			background-color: #EAEAEA;
			margin: 0px;
			padding: 0px;
			font-size: 10px;
			text-decoration: none;
			font-family: monospace;
			font-weight: normal;
			color: #000000;
		}

		.title {
			margin-top: 0px;
			margin-left: 0px;
			margin-right: 0px;
			padding: 5px;
			text-align: center;
			font-size: 24px;
		}
		
		.head {
			padding: 5px;
			text-align: left;
			font-size: 10px;
			background-color: #EAEAEA;
			width: 500px;
		}
  	//-->
  </style>
 </head>
 <body>
  <center>
  <div class="title">
   MTF_Counter
  </div>
  
  <div class="head">
   Die Tabellen wurden erfolgreich erstellt!<br />
   L&ouml;sche bitte nun die install.php!
  </div>
	
<?php
} else {
?> 



<html>
 <head>
  <title>http://www.matflasch.de :: MTF_Counter</title>
   <style type="text/css">
  	<!--
	  	body, div {
			background-color: #EAEAEA;
			margin: 0px;
			padding: 0px;
			font-size: 10px;
			text-decoration: none;
			font-family: monospace;
			font-weight: normal;
			color: #000000;
		}

		table, td {
			padding: 2px;
			text-align: left;
			font-size: 10px;
			text-decoration: none;
			font-family: monospace;
			font-weight: normal;
			color: #000000;
		}
		
		td.name {
			width: 100px;
		}
		
		td.value {
			width: 120px;
			text-align: right;
		}
		
		td.valueerror {
			width: 120px;
			text-align: right;
			background-color: #FF0000;
		}

		.title {
			margin-top: 0px;
			margin-left: 0px;
			margin-right: 0px;
			padding: 5px;
			text-align: center;
			font-size: 24px;
		}
		
		.head {
			padding: 5px;
			text-align: left;
			font-size: 10px;
			background-color: #EAEAEA;
			width: 500px;
		}
		
		.hinweis {
			padding: 5px;
			text-align: left;
			font-size: 18px;
			font-weight: bold;
			background-color: #EAEAEA;
			width: 500px;
		}
		
		.submit {
			padding: 5px;
			text-align: right;
			font-size: 12px;
			background-color: #EAEAEA;
			width: 500px;
		}
		
		input.submit {
			width: 140px;
			border: 1px solid #000000;
			font-size: 10px;
			padding: 1px;
		}
  	//-->
  </style>
 </head>
 <body>
  <center>
  <div class="title">
   MTF_Counter
  </div>
 
  <div class="head">
   F&uuml;r die Installation des MTF_Counter m&uuml;ssen die Daten in der conf.php Datei ausgef&uuml;llt sein.<br />
   Die Daten f&uuml;r die Datenbankverbindung musste du selbst eintragen.<br />
   Die Tabellennamen k&ouml;nnen in der conf.php eingetragen werden, somit ist eine Installation von
   x-beliebig vielen MTF_Counter Systemen innerhalb der selben Datenbank m&ouml;glich.<br />
   <br />
   Das Passwort wird im Klartext angezeigt, damit noch einmal kontrolliert werden kann, ob
   es richtig eingetragen wurde.<br />
   Die Daten werden nur angezeigt. Falls die Daten teilweise nicht richtig sind, m&uuml;ssen diese in der conf.php
   bearbeitet werden und anschliessend kann diese Seite neu geladen werden. Die Daten werden dann automatisch
   &uuml;bernommen.<br />
   </div>
   <div class="hinweis">
    Achtung: Die Tabellen werden, sofern schon vorhanden, &uuml;berschrieben!
   </div>
   <div class="hinweis">
   Aus Sicherheitsgr&uuml;nden sollte die install.php Datei nach der Installation gel&ouml;scht werden!
   </div>
 
  <br />
  <br />
  <br />
  <form action="install.php?action=install" method="post">
  <div class="head">
   <b>Datenbank-Verbindung:</b><br />
   <table>
    <tr>
     <td class="name">Datenbank-Host:</td>
     <td class="<?php if(strlen(MTF_DBHOST) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="dbhost" value="<?php echo MTF_DBHOST; ?>"><?php echo MTF_DBHOST; ?></td>
    </tr>
    <tr>
     <td class="name">Datenbank-Name:</td>
     <td class="<?php if(strlen(MTF_DBNAME) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="dbname" value="<?php echo MTF_DBNAME; ?>"><?php echo MTF_DBNAME; ?></td>
    </tr>
    <tr>
     <td class="name">Datenbank-Benutzer</td>
     <td class="<?php if(strlen(MTF_DBUSER) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="dbuser" value="<?php echo MTF_DBUSER; ?>"><?php echo MTF_DBUSER; ?></td>
    </tr>
    <tr>
     <td class="name">Datenbank-Password</td>
     <td class="<?php if(strlen(MTF_DBPASS) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="dbpass" value="<?php echo MTF_DBPASS; ?>"><?php echo MTF_DBPASS; ?></td>
    </tr>
   </table>
  </div>
  
  <div class="head">
   <b>Tabellennamen</b><br />
   <table>
    <tr>
     <td class="name">Reload:</td>
     <td class="<?php if(strlen(TBL_RELOAD) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tblreload" value="<?php echo TBL_RELOAD; ?>"><?php echo TBL_RELOAD; ?></td>
    </tr>
    <tr>
     <td class="name">Useragent:</td>
     <td class="<?php if(strlen(TBL_USERAGENT) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tbluseragent" value="<?php echo TBL_USERAGENT; ?>"><?php echo TBL_USERAGENT; ?></td>
    </tr>
    <tr>
     <td class="name">User:</td>
     <td class="<?php if(strlen(TBL_USER) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tbluser" value="<?php echo TBL_USER; ?>"><?php echo TBL_USER; ?></td>
    </tr>
    <tr>
     <td class="name">Site:</td>
     <td class="<?php if(strlen(TBL_SITE) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tblsite" value="<?php echo TBL_SITE; ?>"><?php echo TBL_SITE; ?></td>
    </tr>
    <tr>
     <td class="name">Referer:</td>
     <td class="<?php if(strlen(TBL_REFERER) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tblreferer" value="<?php echo TBL_REFERER; ?>"><?php echo TBL_REFERER; ?></td>
    </tr>
    <tr>
     <td class="name">QueryString:</td>
     <td class="<?php if(strlen(TBL_QUERYS) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tblquerystring" value="<?php echo TBL_QUERYS; ?>"><?php echo TBL_QUERYS; ?></td>
    </tr>
    <tr>
     <td class="name">OS:</td>
     <td class="<?php if(strlen(TBL_OS) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tblos" value="<?php echo TBL_OS; ?>"><?php echo TBL_OS; ?></td>
    </tr>
    <tr>
     <td class="name">Lang:</td>
     <td class="<?php if(strlen(TBL_LANG) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tbllang" value="<?php echo TBL_LANG; ?>"><?php echo TBL_LANG; ?></td>
    </tr>
    <tr>
     <td class="name">Browser:</td>
     <td class="<?php if(strlen(TBL_BROWSER) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tblbrowser" value="<?php echo TBL_BROWSER; ?>"><?php echo TBL_BROWSER; ?></td>
    </tr>
    <tr>
     <td class="name">Acclang:</td>
     <td class="<?php if(strlen(TBL_ACCLANG) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tblacclang" value="<?php echo TBL_ACCLANG; ?>"><?php echo TBL_ACCLANG; ?></td>
    </tr>
    <tr>
     <td class="name">Screen:</td>
     <td class="<?php if(strlen(TBL_SCREEN) <= 0) { echo "valueerror";} else { echo "value"; }?>"><input type="hidden" name="tblscreen" value="<?php echo TBL_SCREEN; ?>"><?php echo TBL_SCREEN; ?></td>
    </tr>
   </table>
   <input class="submit" type="submit" name="submit" value="Installieren"></td>
  </div>
<?
}
?>
  </center>
  </form>
 </body>
</html>
