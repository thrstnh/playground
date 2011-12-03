<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_Reload {
	var $intID;
	var $intUserID;
	var $intSiteID;
	var $intQueryStringID;
	var $intDateadd;
	
	function MTF_Useragent() {
		$this->intID = 0;
		$this->strUseragent = "";
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_RELOAD
				. " (`userid`, `siteid`, `querysid`, `dateadd`) "
				. "VALUES ("
				. " '". $this->intUserID ."', "
				. " '". $this->intSiteID ."', "
				. " '". $this->intQueryStringID ."', "
				. " UNIX_TIMESTAMP()"
				. ")";

		mysql_query($SQL) or die("Fehler in MTF_Reload->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_RELOAD
				. " WHERE 1 ";
		
		if($this->intID > 0)
			$SQL .= " AND id = '". $this->intID ."'";
				
		if($this->intUserID > 0)
			$SQL .= " AND userid = '". $this->intUserID ."'";
			
		if($this->intSiteID > 0)
			$SQL .= " AND siteid = '". $this->intSiteID ."'";
		
		if($this->intQueryStringID > 0)
			$SQL .= " AND querysid = '". $this->intQueryStringID ."'";
			
		$Result = mysql_query($SQL) or die("Fehler in MTF_Reload->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($reloadobj = mysql_fetch_object($Result)) {
				$t_objMTF_Reload = new MTF_Reload();
				$t_objMTF_Reload->intID = $reloadobj->id;
				$t_objMTF_Reload->intUserID = $reloadobj->userid;
				$t_objMTF_Reload->intSiteID = $reloadobj->siteid;
				$t_objMTF_Reload->intQueryStringID = $reloadobj->querysid;
				$t_objMTF_Reload->intDateadd = $reloadobj->dateadd;
				$t_objMTF_ReloadArray[$i] = $t_objMTF_Reload;
				$i++;
			}
			return $t_objMTF_ReloadArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_RELOAD
				. " WHERE 1 ";
				
		if($this->intID > 0)
			$SQL .= " AND id = '". $this->intID ."'";
				
		if($this->intUserID > 0)
			$SQL .= " AND userid = '". $this->intUserID ."'";
			
		if($this->intSiteID > 0)
			$SQL .= " AND siteid = '". $this->intSiteID ."'";
		
		if($this->intQueryStringID > 0)
			$SQL .= " AND querysid = '". $this->intQueryStringID ."'";
			
		$SQL .= " LIMIT 0, 1";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_Reload->read()");
		if(mysql_num_rows($Result) > 0) {
			$reloadobj = mysql_fetch_object($Result);
			$this->intID = $uaobj->id;
			$this->intUserID = $reloadobj->userid;
			$this->intSiteID = $reloadobj->siteid;
			$this->intQueryStringID = $reloadobj->querysid;
			$this->intDateadd = $reloadobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
