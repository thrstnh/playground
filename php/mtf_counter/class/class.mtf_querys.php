<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_QueryString {
	var $intID;
	var $strQueryString;
	var $intDateadd;
	
	function MTF_QueryString() {
		$this->intID = 0;
		$this->strQueryString = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_QUERYS
				. " (`querys`, `dateadd`) "
				. "VALUES ("
				. " '". $this->strQueryString ."', UNIX_TIMESTAMP()"
				. ")";
		mysql_query($SQL) or die("Fehler in MTF_QueryString->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_QUERYS
				. " WHERE 1 ";
				
		if(strlen($this->strQueryString) > 0)
			$SQL .= " AND querys = '". $this->strQueryString ."'";
			
		$Result = mysql_query($SQL) or die("Fehler in MTF_QueryString->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($querysobj = mysql_fetch_object($Result)) {
				$t_objMTF_QueryString = new MTF_QueryString();
				$t_objMTF_QueryString->intID = $querysobj->id;
				$t_objMTF_QueryString->strQueryString = $querysobj->querys;
				$t_objMTF_QueryString->intDateadd = $querysobj->dateadd;
				$t_objMTF_QueryStringArray[$i] = $t_objMTF_QueryString;
				$i++;
			}
			return $t_objMTF_QueryStringArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_QUERYS
				. " WHERE 1 ";
				
		if(strlen($this->strQueryString) > 0)
			$SQL .= " AND querys = '". $this->strQueryString ."'";
			
		$SQL .= " LIMIT 0, 1";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_QueryString->read()");
		if(mysql_num_rows($Result) > 0) {
			$querysobj = mysql_fetch_object($Result);
			$this->intID = $querysobj->id;
			$this->strQueryString = $querysobj->querys;
			$this->intDateadd = $querysobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
