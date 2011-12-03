<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_User {
	var $intID;
	var $strIP;
	var $strHost;
	var $strSessionID;
	var $intUseragentID;
	var $intRefererID;
	var $intBrowserID;
	var $intLanguageID;
	var $intOperationSystemID;
	var $intAcceptLanguageID;
	var $intScreenID;
	var $bolJavaScript;
	var $intVisit;
	var $intLastVisit;
	var $intReloads;
	
	// Steuerungen
	var $strgIntOrderBy;
	var $strgIntLimit;
	var $strgIntFrom;
	
	var $OB_ID;
	var $OB_SESSID;
	
	function MTF_User() {
		// Variablen
		$this->intID = 0;
		$this->strIP = "";
		$this->strHost = "";
		$this->strSessionID = "";
		$this->intUseragentID = 0;
		$this->intRefererID = 0;
		$this->intBrowserID = 0;
		$this->intLanguageID = 0;
		$this->intOperationSystemID = 0;
		$this->intAcceptLanguageID = 0;
		$this->intScreenID = 0;
		$this->bolJavaScript = "false";
		$this->intVisit = 0;
		$this->intLastVisit = 0;
		$this->intReloads = 0;
		
		// Sortierungen
		$this->OB_ID = "id";
		$this->OB_SESSID = "sessid";
		
		// Steuerungszeichen
		$this->strgOrderBy = $this->OB_ID;
		$this->strgFrom = 0;
		$this->strgLimit = 0;
		
	}
	
	function write() {
		
		$SQL = "INSERT INTO ". TBL_USER
				." ( `ip`, `host`, `sessid`, "
				."   `useragentid`, `refererid`, `browserid`, "
				."   `langid`, `osid`, `acclangid`, `screenid`,"
				."   `js`, `visit`, `lastvisit`, `reloads`) "
				." VALUES ("
				. "'". $this->strIP ."', '". $this->strHost ."', '". $this->strSessionID ."',"
				. "'". $this->intUseragentID ."', '". $this->intRefererID ."', '". $this->intBrowserID ."',"
				. "'". $this->intLanguageID ."', '". $this->intOperationSystemID ."', '". $this->intAcceptLanguageID ."', '". $this->intScreenID ."',"
				. "'". $this->bolJavaScript ."', '". $this->intVisit ."', '". $this->intLastVisit ."', '". $this->intReloads ."'"
				. ")";
		mysql_query($SQL) or die("Fehler in write bei MTF_User");
		return true;
	}
	
	function update() {
		$SQL = "UPDATE ". TBL_USER
				. " SET "
				. "  `ip` = '". $this->strIP ."', "
				. "  `host` = '". $this->strHost ."', "
				. "  `sessid` = '". $this->strSessionID ."', "
				. "  `useragentid` = '". $this->intUseragentID ."', "
				. "  `refererid` = '". $this->intRefererID ."', "
				. "  `browserid` = '". $this->intBrowserID ."', "
				. "  `langid` = '". $this->intLanguageID ."', "
				. "  `osid` = '". $this->intOperationSystemID ."', "
				. "  `acclangid` = '". $this->intAcceptLanguageID ."', "
				. "  `screenid` = '". $this->intScreenID ."', "
				. "  `js` = '". $this->bolJavaScript ."', "
				. "  `visit` = '". $this->intVisit ."', "
				. "  `lastvisit` = '". $this->intLastVisit ."', "
				. "  `reloads` = '". $this->intReloads ."' "
				. " WHERE id = '". $this->intID ."'";
		mysql_query($SQL) or die("Fehler in MTF_User->addReload()");
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_USER
				." WHERE 1 ";
				
		// Nach der ID suchen
		if($this->intID > 0)
			$SQL .= "AND id = '". $this->intID ."'";
			
		// Nach der SessionID suchen
		if(strlen($this->strSessionID) > 0)
			$SQL .= "AND sessid = '". $this->strSessionID ."'";
						
		if(strlen($this->strgOrderBy) > 0) 
			$SQL .= " ORDER BY ". $this->strgOrderBy;
			
		if($this->strgLimit > 0) 
			$SQL .= " LIMIT ". $this->strgFrom .", ". $this->strgLimit;
			
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$i = 0;
			while($userobj = mysql_fetch_object($Result)) {
				$t_objMTF_User = new MTF_User();
				$t_objMTF_User->intID = $userobj->id;
				$t_objMTF_User->strIP = $userobj->ip;
				$t_objArrMTF_User[$i] = $t_objMTF_User;
				$i++;
			}
			return $t_objArrMTF_User;
		} else {
			return false;
		}
	}
	
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_USER
				." WHERE 1 ";
				
		// Nach der ID suchen
		if($this->intID > 0)
			$SQL .= "AND id = '". $this->intID ."'";
			
		// Nach der SessionID suchen
		if(strlen($this->strSessionID) > 0)
			$SQL .= "AND sessid = '". $this->strSessionID ."'";
			
		if(strlen($this->strgOrderBy) > 0) 
			$SQL .= " ORDER BY ". $this->strgOrderBy;
			
		if($this->strgLimit > 0) 
			$SQL .= " LIMIT 0, 1";
			
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$userobj = mysql_fetch_object($Result);
			$this->intID = $userobj->id;
			$this->strIP = $userobj->ip;
			$this->strHost = $userobj->host;
			$this->strSessionID = $userobj->sessid;
			$this->intUseragentID = $userobj->useragentid;
			$this->intRefererID = $userobj->refererid;
			$this->intBrowserID = $userobj->browserid;
			$this->intLanguageID = $userobj->langid;
			$this->intOperationSystemID = $userobj->osid;
			$this->intAcceptLanguageID = $userobj->acclangid;
			$this->intScreenID = $userobj->screenid;
			$this->bolJavaScript = $userobj->js;
			$this->intVisit = $userobj->visit;
			$this->intLastVisit = $userobj->lastvisit;
			$this->intReloads = $userobj->reloads;
			return $this;
		} else {
			return null;
		}
	}
}
?>
