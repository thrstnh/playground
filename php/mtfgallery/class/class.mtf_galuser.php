<?php
class MTF_GalleryUser {
	var $intID = 0;
	var $strName = "";
	var $strPassword = "";
	var $strEMail = "";
	var $strHomepage = "";
	var $strComment = "";
	var $bolAdmin = false;
	var $intDateadd = 0;
	
//	function getUserByID($p_intID) {
//		$SQL = "SELECT * FROM ". TABLEPREFIX ."galuser "
//				." WHERE id = ". $p_intID;
//		$t_User = mysql_fetch_object(mysql_query($SQL));
//		if($t_User != null) {
//			$t_objMTF_GalleryUser = new MTF_GalleryUser();
//			$t_objMTF_GalleryUser->intID = $t_User->id;
//			$t_objMTF_GalleryUser->strName = $t_User->name;
//			$t_objMTF_GalleryUser->strPassword = $t_User->pass;
//			$t_objMTF_GalleryUser->strEMail = $t_User->email;
//			$t_objMTF_GalleryUser->strHomepage = $t_User->homepage;
//			$t_objMTF_GalleryUser->strComment = $t_User->comment;
//			if($t_User->admin == "true") {
//				$t_objMTF_GalleryUser->bolAdmin = true;
//			}
//			$t_objMTF_GalleryUser->intdateadd = $t_User->dateadd;
//		}
//		return $t_objMTF_GalleryUser;
//	}
	
	function write() {
		if($this->bolAdmin == "true") {
			$bolAdmin = "true";
		} else {
			$bolAdmin = "false";
		}		 
		$SQL = "INSERT INTO ". TABLEPREFIX ."galuser "
			. " (name, pass, email, homepage, comment, admin, dateadd) "
			. "VALUES "
			. " ('". $this->strName ."', "
			. "  PASSWORD('". $this->strPassword ."'), "
			. "  '". $this->strEMail ."', "
			. "  '". $this->strHomepage ."', "
			. "  '". $this->strComment ."', "
			. "  '". $bolAdmin ." ', "
			. "  UNIX_TIMESTAMP())";
		mysql_query($SQL) or die("Der Benutzer konnte nicht hinzugef&uuml;gt werden! (". mysql_error() .")");
	}
	
	function delete() {
		$SQL = "DELETE FROM ". TABLEPREFIX ."galuser "
				." WHERE id = ". $this->intID;
		mysql_query($SQL) or die("Der Benutzer konnte nicht gel&ouml;scht werden! (". mysql_error() .")"); 
	}
	
	function update() {
		if($this->bolAdmin == "true") {
			$bolAdmin = "true";
		} else {
			$bolAdmin = "false";
		}
		$SQL = "UPDATE ". TABLEPREFIX ."galuser "
			. " SET name = '". $this->strName ."',"
			. "     email = '". $this->strEMail ."',"
			. "     homepage = '". $this->strHomepage ."',"
			. "     comment = '". $this->strComment ."',"
			. "     admin = '". $bolAdmin ." '"
			. " WHERE id = ". $this->intID;
		mysql_query($SQL) or die("Der Benutzerdaten konnten nicht ge&auml;ndert werden! (". mysql_error() .")");
	}
	
	function updatePassword() {
		$SQL = "UPDATE ". TABLEPREFIX ."galuser "
			. " SET pass = PASSWORD('". $this->strPassword ."') "
			. " WHERE id = ". $this->intID;
		mysql_query($SQL) or die("Das Password konnten nicht ge&auml;ndert werden! (". mysql_error() .")");
	}

	
	function getAllUsers() {
		// Wenn OrderBy nicht gesetzt ist, wird der Standardwert genommen
		// Alle Bilder der GalleryID auslesen
		$SQL = "SELECT * FROM ". TABLEPREFIX ."galuser ";
		// Array mit den Bildern
		$t_arrUser = mysql_query($SQL);
		$i = 0;
		// Alle User  in ein Array packen
		while($user = mysql_fetch_object($t_arrUser)) {
			$t_objUser->intID = $user->id;
			$t_objUser->strName = $user->name;
			$t_objUser->strPassword = $user->pass;
			$t_objUser->strEMail = $user->email;
			$t_objUser->strHomepage = $user->homepage;
			$t_objUser->strComment = $user->comment;
			if($t_objMTF_Image->admin == "true") {
				$t_objUser->bolAdmin = true;
			} else {
				$t_objUser->bolAdmin = false;
			}
			$t_objUser->intDateChange = $user->datechange;
			$t_objReturnUser[$i] = $t_objUser;
			$i++;
		}
		return $t_objReturnUser;
	}
	
	function getUserByID() {
		$SQL = "SELECT * FROM ". TABLEPREFIX ."galuser "
				." WHERE id = ". $this->intID;
		$Result = mysql_query($SQL) or die("Die Benutzerdaten konnten nicht ausgelesen werden!");
		$t_objUser = mysql_fetch_object($Result);
		$this->strName = $t_objUser->name;
		$this->strPassword = $t_objUser->pass;
		$this->strEMail = $t_objUser->email;
		$this->strHomepage = $t_objUser->homepage;
		$this->strComment = $t_objUser->comment;
		if($t_objUser->admin == "true") {
			$this->bolAdmin = true;
		} else {
			$this->bolAdmin = false;
		}
		$this->intDateadd = $t_objUser->dateadd;
		return true;
	}
	
	function checkPassword() {
		$SQL = "SELECT * FROM ". TABLEPREFIX ."galuser "
				." WHERE id = ". $this->intID ." AND pass = PASSWORD('". $this->strPassword ."')";
		$Result = mysql_query($SQL);
		if(mysql_num_rows($Result) > 0) {
			return true;
		} else {
			return false;
		}
	}
}
?>
