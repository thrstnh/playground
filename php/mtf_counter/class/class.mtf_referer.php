<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_Referer {
	var $intID;
	var $strReferer;
	var $intDateadd;
	
	function MTF_Lang() {
		$this->intID = 0;
		$this->strReferer = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_REFERER
				. " (`referer`, `dateadd`) "
				. "VALUES ("
				. " '". $this->strReferer ."', UNIX_TIMESTAMP()"
				. ")";

		mysql_query($SQL) or die("Fehler in MTF_Referer->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_REFERER
				. " WHERE 1 ";
				
		if(strlen($this->strReferer) > 0)
			$SQL .= " AND referer = '". $this->strReferer ."'";
			
		$Result = mysql_query($SQL) or die("Fehler in MTF_Referer->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($refererobj = mysql_fetch_object($Result)) {
				$t_objMTF_Referer = new MTF_Referer();
				$t_objMTF_Referer->intID = $refererobj->id;
				$t_objMTF_Referer->strReferer = $refererobj->referer;
				$t_objMTF_Referer->intDateadd = $refererobj->dateadd;
				$t_objMTF_RefererArray[$i] = $t_objMTF_Referer;
				$i++;
			}
			return $t_objMTF_RefererArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_REFERER
				. " WHERE 1 ";
				
		if(strlen($this->strReferer) > 0)
			$SQL .= " AND referer = '". $this->strReferer ."'";
			
		$SQL .= " LIMIT 0, 1";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_Referer->read()");
		if(mysql_num_rows($Result) > 0) {
			$refererobj = mysql_fetch_object($Result);
			$this->intID = $refererobj->id;
			$this->strReferer = $refererobj->referer;
			$this->intDateadd = $refererobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
