<?php
if($_SESSION['login'] == true) {
	$t_objMTF_GalleryUser = new MTF_GalleryUser();
	
	if($_REQUEST['action'] == "edituser" && isset($_REQUEST['user'])) {
		$t_objMTF_GalleryUser->intID = $_REQUEST['user'];
		$bolEditUser = $t_objMTF_GalleryUser->getUserByID($_REQUEST['user']);
	}
	
	echo("      <center>\n");
	
	if(($_REQUEST['action'] == "changepass" || $_REQUEST['action'] == "updatepass")
				&& isset($_REQUEST['user'])) {
		$t_objMTF_GalleryUser->intID = $_REQUEST['user'];
		$t_objMTF_GalleryUser->getUserByID($_REQUEST['user']);
		echo("       <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&user=". $_REQUEST['user'] . "&action=updatepass\" method=\"post\">\n");
		echo("        <input type=\"hidden\" name=\"hiduserid\" value=\"". $t_objMTF_GalleryUser->intID ."\">\n");
		echo("        <input type=\"hidden\" name=\"txtusername\" value=\"". $t_objMTF_GalleryUser->strName ."\">\n");
		echo("        <table class=\"conf\">\n");
		echo("         <tr>\n");
		echo("          <td\">\n");
		echo("           Name\n");
		echo("          </td>\n");
		echo("          <td class=\"stdc\">\n");
		echo("           ". $t_objMTF_GalleryUser->strName ."\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td>\n");
		echo("           Altes Passwort\n");
		echo("          </td>\n");
		echo("          <td class=\"stdc\">\n");
		echo("          <input class=\"stdtxt\" type=\"password\" name=\"txtpassold\" value=\"\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td>\n");
		echo("           Neues Passwort\n");
		echo("          </td>\n");
		echo("          <td class=\"stdc\">\n");
		echo("          <input class=\"stdtxt\" type=\"password\" name=\"txtpassnew1\" value=\"\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td>\n");
		echo("           Neues Passwort wiederholen\n");
		echo("          </td>\n");
		echo("          <td class=\"stdc\">\n");
		echo("          <input class=\"stdtxt\" type=\"password\" name=\"txtpassnew2\" value=\"\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("         <tr>\n");
		echo("          <td colspan=\"2\" class=\"stdc\">\n");
		echo("           <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Update\">\n");
		echo("          </td>\n");
		echo("         </tr>\n");
		echo("        </table>\n");
		echo("       </form>\n");
	} else {
		
		
		if($bolEditUser) {
			echo("       <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] . "&action=updateuser\" method=\"post\">\n");
			echo("          <input type=\"hidden\" name=\"hiduserid\" value=\"". $t_objMTF_GalleryUser->intID ."\">\n");
		} else {
			echo("       <form action=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&gallery=". $_REQUEST['gallery'] . "&action=adduser\" method=\"post\">\n");
		}
		echo("       <table class=\"conf\">\n");
		echo("        <tr>\n");
		echo("         <td>\n");
		echo("          Name\n");
		echo("         </td>\n");
		echo("         <td>\n");
		echo("          <input class=\"stdtxt\" type=\"text\" name=\"txtusername\" value=\"". $t_objMTF_GalleryUser->strName ."\">\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		if(!$bolEditUser) {
			echo("        <tr>\n");
			echo("         <td>\n");
			echo("          Password\n");
			echo("         </td>\n");
			echo("         <td>\n");
			echo("          <input class=\"stdtxt\" type=\"password\" name=\"txtuserpass\" value=\"\">\n");
			echo("         </td>\n");
			echo("        </tr>\n");
		}
		echo("        <tr>\n");
		echo("         <td>\n");
		echo("          eMail\n");
		echo("         </td>\n");
		echo("         <td>\n");
		echo("          <input class=\"stdtxt\" type=\"text\" name=\"txtuseremail\" value=\"". $t_objMTF_GalleryUser->strEMail ."\">\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("        <tr>\n");
		echo("         <td>\n");
		echo("          Homepage\n");
		echo("         </td>\n");
		echo("         <td>\n");
		echo("          <input class=\"stdtxt\" type=\"text\" name=\"txtuserhp\" value=\"". $t_objMTF_GalleryUser->strHomepage ."\">\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("        <tr>\n");
		echo("         <td>\n");
		echo("          Comment\n");
		echo("         </td>\n");
		echo("         <td>\n");
		echo("          <textarea class=\"stdtxa\" name=\"txausercomment\">". $t_objMTF_GalleryUser->strComment ."</textarea>\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("        <tr>\n");
		echo("         <td>\n");
		echo("          Admin\n");
		echo("         </td>\n");
		echo("         <td>\n");
		if($t_objMTF_GalleryUser->bolAdmin) {
			$checked = " checked";
		}
		echo("          <input class=\"stdchk\" type=\"checkbox\" name=\"chkuseradmin\"". $checked .">\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("        <tr>\n");
		echo("         <td colspan=\"2\" class=\"stdc\">\n");
		echo("          <input class=\"stdbtn\" type=\"submit\" name=\"submit\" value=\"Hinzuf&uuml;gen\">\n");
		echo("         </td>\n");
		echo("        </tr>\n");
		echo("       </table>\n");
		echo("       </form>\n");
	}
	
	$t_objMTF_GalleryUserArray = $t_objMTF_GalleryUser->getAllUsers();
	echo("       <br /><br /><br />\n");
	echo("       <table class=\"mnguser\">\n");
	echo("        <tr>\n");
	echo("         <td class=\"std\">\n");
	echo("          ID\n");
	echo("         </td>\n");
	echo("         <td class=\"std\">\n");
	echo("          Name\n");
	echo("         </td>\n");
	echo("         <td class=\"std\">\n");
	echo("          eMail\n");
	echo("         </td>\n");
	echo("         <td class=\"std\">\n");
	echo("          Homepage\n");
	echo("         </td>\n");
	echo("         <td class=\"std\">\n");
	echo("          Comment\n");
	echo("         </td>\n");
	echo("         <td class=\"std\">\n");
	echo("          CP\n");
	echo("         </td>\n");
	echo("         <td class=\"std\">\n");
	echo("          Edit\n");
	echo("         </td>\n");
	echo("         <td class=\"std\">\n");
	echo("          Del\n");
	echo("         </td>\n");
	echo("        </tr>\n");
	foreach($t_objMTF_GalleryUserArray as $t_objUser) {
		echo("        <tr>\n");
		echo("         <td class=\"std\">\n");
		echo("          ". $t_objUser->intID ."\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          ". $t_objUser->strName ."\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          ". $t_objUser->strEMail ."\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          ". $t_objUser->strHomepage ."\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          ". $t_objUser->strComment ."\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&user=". $t_objUser->intID ."&action=changepass\">\n");
		echo("          <img src=\"style/std/changepass.png\" border=\"0px\" alt=\"Edit\" title=\"Password &auml;ndern\">\n");
		echo("          </a>\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&user=". $t_objUser->intID ."&action=edituser\">\n");
		echo("          <img src=\"style/std/edit.png\" border=\"0px\" alt=\"Edit\" title=\"Diesen User bearbeiten\">\n");
		echo("          </a>\n");
		echo("         </td>\n");
		echo("         <td class=\"std\">\n");
		echo("          <a href=\"". $PHP_SELF ."?site=". $_REQUEST['site'] ."&user=". $t_objUser->intID ."&action=deleteuser\">\n");
		echo("           <img src=\"style/std/delete.png\" border=\"0px\" alt=\"Edit\" title=\"Diesen User l&ouml;schen\">\n");
		echo("          </a>\n");
		echo("         </td>\n");
		echo("        </tr>\n");
	}
	echo("       </table>\n");
	echo("       <br /><br /><br />\n");
	echo("       </center>\n");
}
?>
