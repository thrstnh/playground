<?php
include("conf.php");


class mtf_mysqldb {
	var $link;
	var $hostname = DBHOST;
	var $dbname = DBNAME;
	var $username = DBUSER;
	var $userpass = DBPASS;

	function mtf_connect() {
		$this->link = mysql_connect($this->hostname, $this->username, $this->userpass) or die("Die Verbindung zur Datenbank konnte nicht hergestellt werden!");
		mysql_select_db($this->dbname) or die("Die Datenbank ist fehlerhaft oder nicht vorhanden!");
		return $this->link;
	}

	function mtf_close() {
		mysql_close($this->link) or die("Die Verbindung mit der MySQL-Datenbank konnte nicht beendet werden!");
	}
}
?>
