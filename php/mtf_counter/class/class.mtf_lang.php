<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_Lang {
	var $intID;
	var $strLanguage;
	var $strCountry;
	var $intDateadd;
	
	function MTF_Lang() {
		$this->intID = 0;
		$this->strLanguage = "";
		$this->strCountry  = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_LANG
				. " (`lang`, `country`, `dateadd`) "
				. "VALUES ("
				. " '". $this->strLanguage ."', '". $this->strCountry ."', UNIX_TIMESTAMP()"
				. ")";
		mysql_query($SQL) or die("Fehler in MTF_Lang->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_LANG
				. " WHERE 1 ";
				
		if(strlen($this->strLanguage) > 0)
			$SQL .= " AND lang = '". $this->strLanguage ."'";
			
		if(strlen($this->strCountry) > 0)
			$SQL .= " AND country = '". $this->strCountry ."'";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_Lang->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($langobj = mysql_fetch_object($Result)) {
				$t_objMTF_Lang = new MTF_Lang();
				$t_objMTF_Lang->intID = $langobj->id;
				$t_objMTF_Lang->strLanguage = $langobj->language;
				$t_objMTF_Lang->strCountry = $langobj->country;
				$t_objMTF_Lang->intDateadd = $langobj->dateadd;
				$t_objMTF_LangArray[$i] = $t_objMTF_Lang;
				$i++;
			}
			return $t_objMTF_LangArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_LANG
				. " WHERE 1 ";
				
		if(strlen($this->strLanguage) > 0)
			$SQL .= " AND lang = '". $this->strLanguage ."'";
			
		if(strlen($this->strCountry) > 0)
			$SQL .= " AND country = '". $this->strCountry ."'";
			
		$SQL .= " LIMIT 0, 1";
				
		$Result = mysql_query($SQL) or die("Fehler in MTF_Lang->read()");
		if(mysql_num_rows($Result) > 0) {
			$langobj = mysql_fetch_object($Result);
			$this->intID = $langobj->id;
			$this->strLanguage = $langobj->language;
			$this->strCountry = $langobj->country;
			$this->intDateadd = $langobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
