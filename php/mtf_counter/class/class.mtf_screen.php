<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
class MTF_Screen {
	var $intID;
	var $intScreenWidth;
	var $intScreenHeight;
	var $intColorDepth;
	var $intDateadd;
	
	function MTF_Lang() {
		$this->intID = 0;
		$this->intScreenWidth = 0;
		$this->intScreenHeight = 0;
		$this->intColorDepth = 0;
		$this->intDateadd = 0;
	}
	
	function write() {
		$SQL = "INSERT INTO ". TBL_SCREEN
				. " (`screenx`, `screeny`, `coldepth`, `dateadd`) "
				. "VALUES ("
				. " '". $this->intScreenWidth ."', "
				. " '". $this->intScreenHeight ."', "
				. " '". $this->intColorDepth ."', "
				. " UNIX_TIMESTAMP()"
				. ")";

		mysql_query($SQL) or die("Fehler in MTF_Screen->write()");
		return true;
	}
	
	function read() {
		$SQL = "SELECT * FROM ". TBL_SCREEN
				. " WHERE 1 ";
				
		if($this->intScreenWidth > 0)
			$SQL .= " AND screenx = '". $this->intScreenWidth ."'";
			
		if($this->intScreenHeight > 0)
			$SQL .= " AND screeny = '". $this->intScreenHeight ."'";
			
		if($this->intColorDepth > 0)
			$SQL .= " AND coldepth = '". $this->intColorDepth ."'";
			
		$Result = mysql_query($SQL) or die("Fehler in MTF_Screen->read()");
		if(mysql_num_rows($Result) > 0) {
			$i=0;
			while($screenobj = mysql_fetch_object($Result)) {
				$t_objMTF_Screen = new MTF_Screen();
				$t_objMTF_Screen->intID = $screenobj->id;
				$t_objMTF_Screen->intScreenWidth = $screenobj->screenx;
				$t_objMTF_Screen->intScreenHeight = $screenobj->screeny;
				$t_objMTF_Screen->intColorDepth = $screenobj->coldepth;
				$t_objMTF_Screen->intDateadd = $screenobj->dateadd;
				$t_objMTF_ScreenArray[$i] = $t_objMTF_Screen;
				$i++;
			}
			return $t_objMTF_ScreenArray;
		} else {
			return null;
		}
	}
		
	function read_one_Object() {
		$SQL = "SELECT * FROM ". TBL_SCREEN
				. " WHERE 1 ";
				
		if($this->intScreenWidth > 0)
			$SQL .= " AND screenx = '". $this->intScreenWidth ."'";
			
		if($this->intScreenHeight > 0)
			$SQL .= " AND screeny = '". $this->intScreenHeight ."'";
			
		if($this->intColorDepth > 0)
			$SQL .= " AND coldepth = '". $this->intColorDepth ."'";
			
		$SQL .= " LIMIT 0, 1";
		
		$Result = mysql_query($SQL) or die("Fehler in MTF_Screen->read()");
		if(mysql_num_rows($Result) > 0) {
			$screenobj = mysql_fetch_object($Result);
			$this->intID = $screenobj->id;
			$this->intScreenWidth = $screenobj->screenx;
			$this->intScreenHeight = $screenobj->screeny;
			$this->intColorDepth = $screenobj->coldepth;
			$this->intDateadd = $screenobj->dateadd;
			return $this;
		} else {
			return null;
		}
	}
}
?>
