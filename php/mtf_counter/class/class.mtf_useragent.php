<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_Useragent {
	var $intID;
	var $strUseragent;
	var $intDateadd;
	
	function MTF_Useragent() {
		$this->intID = 0;
		$this->strUseragent = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_USERAGENT
				. " (`useragent`, `dateadd`) "
				. "VALUES ("
				. " '". $this->strUseragent ."', UNIX_TIMESTAMP()"
				. ")";

		mysql_query($SQL) or die("Fehler in MTF_Useragent->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_USERAGENT
				. " WHERE 1 ";
				
		if(strlen($this->strUseragent) > 0)
			$SQL .= " AND useragent = '". $this->strUseragent ."'";
			
		$Result = mysql_query($SQL) or die("Fehler in MTF_Useragent->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($uaobj = mysql_fetch_object($Result)) {
				$t_objMTF_Useragent = new MTF_Useragent();
				$t_objMTF_Useragent->intID = $uaobj->id;
				$t_objMTF_Useragent->strUseragent = $uaobj->useragent;
				$t_objMTF_Useragent->intDateadd = $uaobj->dateadd;
				$t_objMTF_UseragentArray[$i] = $t_objMTF_Useragent;
				$i++;
			}
			return $t_objMTF_UseragentArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_USERAGENT
				. " WHERE 1 ";
				
		if(strlen($this->strUseragent) > 0)
			$SQL .= " AND useragent = '". $this->strUseragent ."'";
			
		$SQL .= " LIMIT 0, 1";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_Useragent->read()");
		if(mysql_num_rows($Result) > 0) {
			$uaobj = mysql_fetch_object($Result);
			$this->intID = $uaobj->id;
			$this->strUseragent = $uaobj->useragent;
			$this->intDateadd = $uaobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
