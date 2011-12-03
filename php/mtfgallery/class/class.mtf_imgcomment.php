<?php
class MTF_ImageComment {
	var $intID = 0;
	var $strTitle = "";
	var $strComment = "";
	var $strAuthor = "";
	var $strMail = "";
	var $strWWW = "";
	var $intImageID = 0;
	var $intGalleryID = 0;
	var $strSessionID = "";
	var $intDateadd = 0;
	var $intDatechange = 0;
	
	function write() {
		$SQL = "INSERT INTO ". TABLEPREFIX ."imgcomment "
				." (title, "
				."  commentvalue, "
				."  author, "
				."  email, "
				."  www, "
				."  imgid, "
				."  galleryid, "
				."  sessionid, "
				."  dateadd, "
				."  datechange) "
				."VALUES "
				." ('$this->strTitle', "
				." '$this->strComment', "
				." '$this->strAuthor', "
				." '$this->strMail', "
				." '$this->strWWW', "
				."  $this->intImageID, "
				."  $this->intGalleryID, "
				." '$this->strSessionID', "
				."  UNIX_TIMESTAMP(), "
				."  0)";
		mysql_query($SQL) or die("Fehler beim Eintragen des Comment!");
	}
	
	function getImageComments($p_intImageID) {
		$SQL = "SELECT * FROM ". TABLEPREFIX ."imgcomment "
				." WHERE imgid = $p_intImageID";
		$Result = mysql_query($SQL) or die("Die Comments zu dem Bild konnten nicht ausgelesen werden!");
		$i = 0;
		// Kommentare zu dem Bild in ein Array packen und zurueckgeben
		while($imgcomment = mysql_fetch_object($Result)) {
			$t_objImageComment = new MTF_ImageComment();
			$t_objImageComment->intID = $imgcomment->id;
			$t_objImageComment->strTitle = $imgcomment->title;
			$t_objImageComment->strComment = $imgcomment->commentvalue;
			$t_objImageComment->strAuthor = $imgcomment->author;
			$t_objImageComment->strMail = $imgcomment->email;
			$t_objImageComment->strWWW = $imgcomment->www;
			$t_objImageComment->intImageID = $imgcomment->imgid;
			$t_objImageComment->intGalleryID = $imgcomment->galleryid;
			$t_objImageComment->strSessionID = $imgcomment->sessionid;
			$t_objImageComment->intDateadd = $imgcomment->dateadd;
			$t_objImageComment->intDatechange = $imgcomment->datechange;
			$t_objReturnImageComment[$i] = $t_objImageComment;
			$i++;
		}
		return $t_objReturnImageComment;
	}
	
	function checkLastComment($p_intImageID, $p_strSessionID) {
		$t_bolReturn = false;
		$SQL = "SELECT * FROM ". TABLEPREFIX ."imgcomment "
				." WHERE imgid = $p_intImageID "
				." ORDER BY id DESC LIMIT 0, 1";
		$t_objLastComment = mysql_fetch_object(mysql_query($SQL));
		if($t_objLastComment != null) {
			if($t_objLastComment->sessionid == $p_strSessionID) {
				$t_bolReturn = false;
			} else {
				$t_bolReturn = true;
			}
		} else {
			$t_bolReturn = true;
		}
		return $t_bolReturn;
	}
	
	function getLastXComments($p_intAnzahl) {
		$SQL = "SELECT * FROM ". TABLEPREFIX ."imgcomment "
				." ORDER BY id DESC LIMIT 0, $p_intAnzahl";
		$Result = mysql_query($SQL) or die("Die letzten $p_intAnzahl Comments konnten nicht ausgelesen werden!");
		$i = 0;
		// Kommentare zu dem Bild in ein Array packen und zurueckgeben
		while($imgcomment = mysql_fetch_object($Result)) {
			$t_objImageComment = new MTF_ImageComment();
			$t_objImageComment->intID = $imgcomment->id;
			$t_objImageComment->strTitle = $imgcomment->title;
			$t_objImageComment->strComment = $imgcomment->commentvalue;
			$t_objImageComment->strAuthor = $imgcomment->author;
			$t_objImageComment->strMail = $imgcomment->email;
			$t_objImageComment->strWWW = $imgcomment->www;
			$t_objImageComment->intImageID = $imgcomment->imgid;
			$t_objImageComment->intGalleryID = $imgcomment->galleryid;
			$t_objImageComment->strSessionID = $imgcomment->sessionid;
			$t_objImageComment->intDateadd = $imgcomment->dateadd;
			$t_objImageComment->intDatechange = $imgcomment->datechange;
			$t_objReturnImageComment[$i] = $t_objImageComment;
			$i++;
		}
		return $t_objReturnImageComment;
	}
	
	/**
	 * Liefert die Anzahl der Kommentare
	 * @version 11.03.2005
	 */
	function getCountComments() {
		$SQL = "SELECT COUNT(id) AS count from ". TABLEPREFIX ."imgcomment";
		$Count = mysql_fetch_object(mysql_query($SQL));
		return $Count->count;
	}
}
?>
