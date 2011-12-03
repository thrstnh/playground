<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_OS {
	var $intID;
	var $strOperatingSystem;
	var $intDateadd;
	
	function MTF_Lang() {
		$this->intID = 0;
		$this->strOperationSystem = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_OS
				. " (`os`, `dateadd`) "
				. "VALUES ("
				. " '". $this->strOperatingSystem ."', UNIX_TIMESTAMP()"
				. ")";

		mysql_query($SQL) or die("Fehler in MTF_OS->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_OS
				. " WHERE 1 ";
				
		if(strlen($this->strOperatingSystem) > 0)
			$SQL .= " AND os = '". $this->strOperatingSystem ."'";
			
		$Result = mysql_query($SQL) or die("Fehler in MTF_OS->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($osobj = mysql_fetch_object($Result)) {
				$t_objMTF_OS = new MTF_OS();
				$t_objMTF_OS->intID = $osobj->id;
				$t_objMTF_OS->strLanguage = $osobj->os;
				$t_objMTF_OS->intDateadd = $osobj->dateadd;
				$t_objMTF_OSArray[$i] = $t_objMTF_OS;
				$i++;
			}
			return $t_objMTF_OSArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_OS
				. " WHERE 1 ";
				
		if(strlen($this->strOperatingSystem) > 0)
			$SQL .= " AND os = '". $this->strOperatingSystem ."'";
			
		$SQL .= " LIMIT 0, 1";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_OS->read()");
		if(mysql_num_rows($Result) > 0) {
			$osobj = mysql_fetch_object($Result);
			$this->intID = $osobj->id;
			$this->strOperatingSystem = $osobj->os;
			$this->intDateadd = $osobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
