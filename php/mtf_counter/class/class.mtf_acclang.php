<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_AcceptLanguage {
	var $intID;
	var $strAcceptLanguage;
	var $intDateadd;
	
	function MTF_AcceptLanguage() {
		$this->intID = 0;
		$this->strAcceptLanguage = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_ACCLANG 
				. " (`acclang` , `dateadd`) "
				. "VALUES ("
				. " '". $this->strAcceptLanguage ."', UNIX_TIMESTAMP()"
				. ")";
		mysql_query($SQL) or die("Fehler in MTF_AcceptLanguage->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_ACCLANG
				. " WHERE 1 ";
		if(strlen($this->strAcceptLanguage) > 0)
			$SQL .= " AND acclang = '". $this->strAcceptLanguage ."'";
		$Result = mysql_query($SQL) or die("Fehler in MTF_AcceptLanguage->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($acclangobj = mysql_fetch_object($Result)) {
				$t_objMTF_AcceptLanguage = new MTF_AcceptLanguage();
				$t_objMTF_AcceptLanguage->intID = $acclangobj->id;
				$t_objMTF_AcceptLanguage->strAcceptLanguage = $acclangobj->acclang;
				$t_objMTF_AcceptLanguage->intDateadd = $acclangobj->dateadd;
				$t_objMTF_AcceptLanguageArray[$i] = $t_objMTF_AcceptLanguage;
				$i++;
			}
			return $t_objMTF_AcceptLanguageArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_ACCLANG
				. " WHERE 1 ";
				
		if(strlen($this->strAcceptLanguage) > 0)
			$SQL .= " AND acclang = '". $this->strAcceptLanguage ."'";
			
		$SQL .= " LIMIT 0, 1";
				
		$Result = mysql_query($SQL) or die("Fehler in MTF_AcceptLanguage->read()");
		if(mysql_num_rows($Result) > 0) {
			$acclangobj = mysql_fetch_object($Result);
			$this->intID = $acclangobj->id;
			$this->strAcceptLanguage = $acclangobj->acclang;
			$this->intDateadd = $acclangobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
