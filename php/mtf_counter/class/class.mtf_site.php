<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_Site {
	var $intID;
	var $strSite;
	var $intDateadd;
	
	function MTF_Site() {
		$this->intID = 0;
		$this->strSite = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_SITE
				. " (`site`, `dateadd`) "
				. "VALUES ("
				. " '". $this->strSite ."', UNIX_TIMESTAMP()"
				. ")";
		mysql_query($SQL) or die("Fehler in MTF_Site->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_SITE
				. " WHERE 1 ";
				
		if(strlen($this->strSite) > 0)
			$SQL .= " AND referer = '". $this->strSite ."'";
			
		$Result = mysql_query($SQL) or die("Fehler in MTF_Site->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($siteobj = mysql_fetch_object($Result)) {
				$t_objMTF_Site = new MTF_Site();
				$t_objMTF_Site->intID = $siteobj->id;
				$t_objMTF_Site->strSite = $siteobj->site;
				$t_objMTF_Site->intDateadd = $siteobj->dateadd;
				$t_objMTF_SiteArray[$i] = $t_objMTF_Site;
				$i++;
			}
			return $t_objMTF_SiteArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_SITE
				. " WHERE 1 ";
				
		if(strlen($this->strSite) > 0)
			$SQL .= " AND site = '". $this->strSite ."'";
			
		$SQL .= " LIMIT 0, 1";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_Site->read()");
		if(mysql_num_rows($Result) > 0) {
			$siteobj = mysql_fetch_object($Result);
			$this->intID = $siteobj->id;
			$this->strSite = $siteobj->site;
			$this->intDateadd = $siteobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
