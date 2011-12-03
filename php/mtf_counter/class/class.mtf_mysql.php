<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_Mysql {
	var $DatabaseLink;
	var $strHostName;
	var $strDatabaseName;
	var $strDatebaseUser;
	var $strDatabasePass;
	
	function MTF_Mysql() {
	}

	function connect() {
		$this->strHostName = MTF_DBHOST;
		$this->strDatabaseName = MTF_DBNAME;
		$this->strDatebaseUser = MTF_DBUSER;
		$this->strDatabasePass = MTF_DBPASS;
		$this->DatabaseLink = mysql_connect($this->strHostName, $this->strDatebaseUser, $this->strDatabasePass) or die("Die Verbindung zur Datenbank konnte nicht hergestellt werden!");
		mysql_select_db($this->strDatabaseName) or die("Die Datenbank ist fehlerhaft oder nicht vorhanden!");
		return $this->DatabaseLink;
	}
	
	function connectWith($p_strDBHost, $p_strDBName, $p_strDBUser, $p_strDBPass) {
		$this->strHostName = $p_strDBHost;
		$this->strDatabaseName = $p_strDBName;
		$this->strDatebaseUser = $p_strDBUser;
		$this->strDatabasePass = $p_strDBPass;
		$this->DatabaseLink = mysql_connect($this->strHostName, $this->strDatebaseUser, $this->strDatabasePass) or die("Die Verbindung zur Datenbank konnte nicht hergestellt werden!");
		mysql_select_db($this->strDatabaseName) or die("Die Datenbank ist fehlerhaft oder nicht vorhanden!");
		return $this->DatabaseLink;
	}

	function close() {
		mysql_close($this->DatabaseLink) or die("Die Verbindung mit der MySQL-Datenbank konnte nicht beendet werden!");
	}
}
?>
