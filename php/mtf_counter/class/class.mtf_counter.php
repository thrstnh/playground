<?php
/**
 * @author Thorsten Hillebrand
 * @version 01.04.2005
 * 
 * Diese Klasse zählt die Reloads und Visits.
 * Mit dieser Klasse koennen auch die Visits ausgegeben werden.
 */
class MTF_Counter {
	var $strStyleDir;
	var $strImageExtension;
		
	/**
	 * Konstruktor
	 */
	function MTF_Counter() {
		$this->strStyleDir = "";
		$this->strImageExtension = "";
	}
	
	/**
	 * Einen Visit zaehlen
	 */
	function Visit() {
		// Benutzerinformationen werden ausgelesen
		$t_objMTF_Userinfo = new MTF_Userinfo();
		
		// User-Objekt erstellen und
		// nach der SessionID suchen
		$t_objMTF_User = new MTF_User();
		$t_objMTF_User->strSessionID = session_id();
		$t_objMTF_User->strgOrderBy = $t_objMTF_User->OB_ID;
		$t_objMTF_User->strgFrom = 0;
		$t_objMTF_User->strgLimit = 10;
		
		// Wenn der User noch nicht eingetragen war,
		// wird er eingetragen....
		if($t_objMTF_User->read_one_Object() == null) {
			// Useragent!
			$t_objMTF_Useragent = new MTF_Useragent();
			$t_objMTF_Useragent->strUseragent = $t_objMTF_Userinfo->strHTTP_USER_AGENT;
			if($t_objMTF_Useragent->read_one_Object() == null) {
				$t_objMTF_Useragent->write();
				$t_objMTF_Useragent->read_one_Object();
			}
			// Referer
			$t_objMTF_Referer = new MTF_Referer();
			$t_objMTF_Referer->strReferer = $t_objMTF_Userinfo->strHTTP_REFERER;
			if($t_objMTF_Referer->read_one_Object() == null) {
				$t_objMTF_Referer->write();
				$t_objMTF_Referer->read_one_Object();
			}
			// Browser
			$t_objMTF_Browser = new MTF_Browser();
			$t_objMTF_Browser->strBrowserName = $t_objMTF_Userinfo->strBrowser;
			$t_objMTF_Browser->strBrowserVersion = $t_objMTF_Userinfo->strBrowserVersion;
			if($t_objMTF_Browser->read_one_Object() == null) {
				$t_objMTF_Browser->write();
				$t_objMTF_Browser->read_one_Object();
			}
			// Lang
			$t_objMTF_Lang = new MTF_Lang();
			$t_objMTF_Lang->strLanguage = $t_objMTF_Userinfo->strLanguage;
			$t_objMTF_Lang->strCountry = $t_objMTF_Userinfo->strCountry;
			if($t_objMTF_Lang->read_one_Object() == null) {
				$t_objMTF_Lang->write();
				$t_objMTF_Lang->read_one_Object();
			}
			// OS
			$t_objMTF_OS = new MTF_OS();
			$t_objMTF_OS->strOperatingSystem = $t_objMTF_Userinfo->strOperatingSystem;
			if($t_objMTF_OS->read_one_Object() == null) {
				$t_objMTF_OS->write();
				$t_objMTF_OS->read_one_Object();
			}
			// AccLang
			$t_objMTF_AcceptLanguage = new MTF_AcceptLanguage();
			$t_objMTF_AcceptLanguage->strAcceptLanguage = $t_objMTF_Userinfo->strHTTP_ACCEPT_LANGUAGE; 
			if($t_objMTF_AcceptLanguage->read_one_Object() == null) {
				$t_objMTF_AcceptLanguage->write();
				$t_objMTF_AcceptLanguage->read_one_Object();
			} 
			
			// IDs werden gesetzt
			$t_objMTF_User->strIP = $t_objMTF_Userinfo->strREMOVE_ADDR;
			$t_objMTF_User->strHost = $t_objMTF_Userinfo->strREMOVE_ADDR;
			$t_objMTF_User->strSessionID = $t_objMTF_Userinfo->strSESSION_ID;
			$t_objMTF_User->intUseragentID = $t_objMTF_Useragent->intID;
			$t_objMTF_User->intRefererID = $t_objMTF_Referer->intID;
			$t_objMTF_User->intBrowserID = $t_objMTF_Browser->intID;
			$t_objMTF_User->intLanguageID = $t_objMTF_Lang->intID;
			$t_objMTF_User->intOperationSystemID = $t_objMTF_OS->intID;
			$t_objMTF_User->intAcceptLanguageID = $t_objMTF_AcceptLanguage->intID;
			$t_objMTF_User->intVisit = date("U");
			$t_objMTF_User->intLastVisit = date("U");
			$t_objMTF_User->intReloads = 1;
			
			// Datensatz wird eingetragen
			$t_objMTF_User->write();
			
			// Daten werden jetzt wieder ausgelesen, inkl. ID)
			$t_objMTF_User->read_one_Object();
			
			// AddInfo
			printf("<script language=\"javascript1.2\">\n");
			printf(" <!--\n");
		    printf("  swidth=screen.width;\n");
		    printf("  sheight=screen.height;\n");
		    printf("  navigator.appName!=\"Netscape\"?scoldepth=screen.colorDepth:scoldepth=screen.pixelDepth;\n");
		  	printf(" //-->\n");
			printf("</script>\n");
			printf("<script language=\"javascript\">\n");
		  	printf(" <!--\n");
		    printf("  document.write(\"<script type=\\\"text/javascript\\\" src=\\\"". COUNTERPATH ."addinfo.php?&js=y&swidth=\" + swidth + \"&sheight=\" + sheight + \"&coldepth=\" + scoldepth +\");\\\"></script>\");\n");
		  	printf(" //-->\n");
			printf("</script>\n");
			printf("<noscript>\n");
			printf(" <img height=1 width=1 alt=\"\" src=\"". COUNTERPATH ."addinfo.php?js=n\">;\n");
			printf("</noscript>\n");
		}
		// Wenn der Benutzer schon eingetragen ist... 
		else {
			// Reloads für den User erhöhen
			$t_objMTF_User->intReloads++;
			// LastVisit auf das aktuelle Datum setzen
			$t_objMTF_User->intLastVisit = date("U");
			// Updaten
			$t_objMTF_User->update();
		}
	}
	
	/**
	 * Einen Reload zaehlen
	 */
	function Reload() {
		// Benutzerinformationen werden ausgelesen
		$t_objMTF_Userinfo = new MTF_Userinfo();
		$t_objMTF_User = new MTF_User();
		$t_objMTF_User->strSessionID = session_id();
		$t_objMTF_User->strgOrderBy = $t_objMTF_User->OB_ID;
		$t_objMTF_User->strgFrom = 0;
		$t_objMTF_User->strgLimit = 10;
		$t_objMTF_User->read_one_Object();
				
		
		// Site
		$t_objMTF_Site = new MTF_Site();
		$t_objMTF_Site->strSite = $t_objMTF_Userinfo->strPHP_SELF;
		if(strlen($t_objMTF_Site->strSite) > 0) {
			if($t_objMTF_Site->read_one_Object() == null) {
				$t_objMTF_Site->write();
				$t_objMTF_Site->read_one_Object();
			}
		}
		
		// QueryString
		$t_objMTF_QueryString = new MTF_QueryString();
		$t_objMTF_QueryString->strQueryString = $t_objMTF_Userinfo->strQUERY_STRING;
		if(strlen($t_objMTF_QueryString->strQueryString) > 0) {
			if($t_objMTF_QueryString->read_one_Object() == null) {
				$t_objMTF_QueryString->write();
				$t_objMTF_QueryString->read_one_Object();
			}
		}
		
		// Reload eintragen
		$t_objMTF_Reload = new MTF_Reload();
		$t_objMTF_Reload->intUserID = $t_objMTF_User->intID;
		$t_objMTF_Reload->intSiteID = $t_objMTF_Site->intID;
		$t_objMTF_Reload->intQueryStringID = $t_objMTF_QueryString->intID;
		$t_objMTF_Reload->intDateadd = date("U");
		$t_objMTF_Reload->write();
	}
	
	/**
	 * Besucher heute
	 */
	function VisitsToday() {
		$start = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$stop = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE visit BETWEEN ". $start ." AND ". $stop;
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	  
	 }
	 
	/**
	 * Besucher gestern
	 */
	function VisitsYesterday() {
		$start = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
		$stop = mktime(23, 59, 59, date("m"), date("d")-1, date("Y"));
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE visit BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Besucher in dieser Stunde
	  */
	 function VisitsThisHour() {
		$start = mktime(date("H"), 0, 0, date("m"), date("d"), date("Y"));
		$stop = mktime(date("H"), 59, 59, date("m"), date("d"), date("Y"));
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE visit BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	/**
	 * Besucher in dieser Woche
	 */
	function VisitsThisWeek() {		  
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE WEEK(FROM_UNIXTIME(visit),1) = WEEK(NOW(),1)";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	 /**
	  * Besucher diesen Monat
	  */
	 function VisitsThisMonth() {		  
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE MONTH(FROM_UNIXTIME(visit)) = MONTH(NOW())";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	/**
	 * Besucher in diesem Jahr
	 */
	 function VisitsThisYear() {
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE YEAR(FROM_UNIXTIME(visit)) = YEAR(NOW())";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	/**
	 * Besucher in der Minute...
	 */
	 function VisitsOnMinute($minute, $hour, $day, $month, $year) {
		$start = mktime($hour, $minute, 0, $month, $day, $year);
		$stop = mktime($hour, $minute, 59, $month, $day, $year);
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE MINUTE(FROM_UNIXTIME(visit)) = $minute AND visit BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	/**
	 * Besucher in der Stunde X
	 */
	function VisitsOnHour($hour, $day, $month, $year) {
		$start = mktime($hour, 0, 0, $month, $day, $year);
		$stop = mktime($hour, 59, 59, $month, $day, $year);
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE HOUR(FROM_UNIXTIME(visit)) = $hour AND visit BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	
	/**
	 * Besucher am Tag X
	 */ 
	function VisitsOnDay($day, $month, $year) {
		$start = mktime(0, 0, 0, $month, $day, $year);
		$stop = mktime(23, 59, 59, $month, $day, $year);
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE visit BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	 /**
	  * Besucher in der Woche X
	  */
	 function VisitsOnWeek($week, $year) {
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE WEEK(FROM_UNIXTIME(visit),1) = $week AND YEAR(FROM_UNIXTIME(visit)) = $year";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	 /**
	  * Besucher im Monat X
	  */
	 function VisitsOnMonth($month, $year) {
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE MONTH(FROM_UNIXTIME(visit)) = $month";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	 /**
	  * Besucher im Jahr X
	  */
	 function VisitsOnYear($year) {		  
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE YEAR(FROM_UNIXTIME(visit)) = $year";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	 /**
	  * Besucher gesamt
	  */
	 function VisitsTotal() {
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER;
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}
	 }
	 
	 /**
	  * Reloads heute
	  */
	 function ReloadsToday() {
		$start = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$stop = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE dateadd BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	 
	 }
	 
	 /**
	  * Reloads gestern
	  */
	 function ReloadsYesterday() {
		$start = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
		$stop = mktime(23, 59, 59, date("m"), date("d")-1, date("Y"));
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE dateadd BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	 
	 }
	 
	 /**
	  * Reloads diese Stunde
	  */
	 function ReloadsThisHour() {
		$start = mktime(date("H"), 0, 0, date("m"), date("d"), date("Y"));
		$stop = mktime(date("H"), 59, 59, date("m"), date("d"), date("Y"));
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE dateadd BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads diese Woche
	  */
	 function ReloadsThisWeek() {		  
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE WEEK(FROM_UNIXTIME(dateadd),1) = WEEK(NOW(),1)";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads diesen Monat
	  */
	 function ReloadsThisMonth() {		  
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE MONTH(FROM_UNIXTIME(dateadd)) = MONTH(NOW())";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads in diesem Jahr
	  */
	 function ReloadsThisYear() {
		$start = mktime(0, 0, 0, 1, 1, date("Y"));
		$stop = mktime(23, 59, 59, 12, 31, date("Y"));
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE YEAR(FROM_UNIXTIME(dateadd)) = YEAR(NOW())";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads in der Minute X
	  */
	 function ReloadsOnMinute($minute, $hour, $day, $month, $year) {
		$start = mktime($hour, $minute, 0, $month, $day, $year);
		$stop = mktime($hour, $minute, 59, $month, $day, $year);
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE MINUTE(FROM_UNIXTIME(dateadd)) = $minute AND ts BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads in der Stunde X
	  */
	 function ReloadsOnHour($hour, $day, $month, $year) {
		$start = mktime($hour, 0, 0, $month, $day, $year);
		$stop = mktime($hour, 59, 59, $month, $day, $year);
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE HOUR(FROM_UNIXTIME(dateadd)) = $hour AND ts BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads am Tag X
	  */
	 function ReloadsOnDay($day, $month, $year) {
		$start = mktime(0, 0, 0, $month, $day, $year);
		$stop = mktime(23, 59, 59, $month, $day, $year);
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE dateadd BETWEEN $start AND $stop";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}		
	 }
	 
	 /**
	  * Reloads in der Woche X
	  */
	 function ReloadsOnWeek($week, $year) {
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE WEEK(FROM_UNIXTIME(dateadd),1) = $week";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads im Monat X
	  */
	 function ReloadsOnMonth($month, $year) {
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE MONTH(FROM_UNIXTIME(dateadd)) = $month";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads im Jahr X
	  */
	 function ReloadsOnYear($year) {		  
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD ." WHERE YEAR(FROM_UNIXTIME(dateadd)) = $year";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 /**
	  * Reloads total
	  */
	 function ReloadsTotal() {
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_RELOAD;
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
	 function gfxOutput($p_intValue) {
		$str = "$p_intValue";
		$strlen = strlen($str);
		printf("<nobr>");
		if($strlen > 0) {
			for($i=0; $i<$strlen; $i++) {
				printf("<img src=\"".$this->strStyleDir."".$str[$i].".".$this->strImageExtension."\" border=\"0px\" alt=\"".$str[$i]."\">");
			}
		} else {
			printf("<img src=\"".$this->strStyleDir."0.".$this->strImageExtension."\" border=\"0px\" alt=\"0\">");
		}
		printf("</nobr>\n");
	 }
	 
	 /**
	  * User online..
	  */
	 function UserOnline() {
		$Timestamp = date("U");
		$stime = $Timestamp - ONLINETIME;
		$SQL = "SELECT COUNT(id) as count FROM ". TBL_USER ." WHERE lastvisit > $stime";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			$count = mysql_fetch_object($Result);
			return $count->count;  	
		} else {
			return null;
		}	
	 }
	 
}
?>
