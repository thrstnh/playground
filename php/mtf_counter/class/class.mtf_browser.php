<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_Browser {
	var $intID;
	var $strBrowserName;
	var $strBrowserVersion;
	var $intDateadd;
	
	function MTF_Browser() {
		$this->intID = 0;
		$this->strBrowserName = "";
		$this->strBrowserVersion = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_BROWSER 
				. " (`name`, `version`, `dateadd`) "
				. "VALUES ("
				. " '". $this->strBrowserName ."', '". $this->strBrowserVersion."', UNIX_TIMESTAMP()"
				. ")";
		mysql_query($SQL) or die("Fehler in MTF_Browser->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_BROWSER
				. " WHERE 1 ";
				
		if(strlen($this->strBrowserName) > 0)
			$SQL .= " AND name = '". $this->strBrowserName ."'";
			
		if(strlen($this->strBrowserVersion) > 0)
			$SQL .= " AND version = '". $this->strBrowserVersion ."'";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_Browser->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($browserobj = mysql_fetch_object($Result)) {
				$t_objMTF_Browser = new MTF_Browser();
				$t_objMTF_Browser->intID = $browserobj->id;
				$t_objMTF_Browser->strBrowserName = $browserobj->name;
				$t_objMTF_Browser->strBrowserVersion = $browserobj->version;
				$t_objMTF_Browser->intDateadd = $browserobj->dateadd;
				$t_objMTF_BrowserArray[$i] = $t_objMTF_Browser;
				$i++;
			}
			return $t_objMTF_BrowserArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_BROWSER
				. " WHERE 1 ";
				
		if(strlen($this->strBrowserName) > 0)
			$SQL .= " AND name = '". $this->strBrowserName ."'";
			
		if(strlen($this->strBrowserVersion) > 0)
			$SQL .= " AND version = '". $this->strBrowserVersion ."'";
			
		$SQL .= " LIMIT 0, 1";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_Browser->read()");
		if(mysql_num_rows($Result) > 0) {
			$browserobj = mysql_fetch_object($Result);
			$this->intID = $browserobj->id;
			$this->strBrowserName = $browserobj->name;
			$this->strBrowserVersion = $browserobj->version;
			$this->intDateadd = $browserobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
