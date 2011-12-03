<?php
/**
 * @author Thorsten Hillebrand
 * @version 03.04.2005
 */
session_start();
include("conf.php");
include("class/class.mtf_mysql.php");
include("class/class.mtf_user.php");
include("class/class.mtf_screen.php");
$t_objMTF_Mysql = new MTF_Mysql();
$t_objMTF_Mysql->connect();

$t_objMTF_User = new MTF_User();
$t_objMTF_User->strSessionID = session_id();
$t_objMTF_User->strgOrderBy = $t_objMTF_User->OB_ID;
$t_objMTF_User->strgFrom = 0;
$t_objMTF_User->strgLimit = 10;
$t_objMTF_User->read_one_Object();

// Screen
$t_objMTF_Screen = new MTF_Screen();
$t_objMTF_Screen->intScreenWidth = $_REQUEST['swidth'];
$t_objMTF_Screen->intScreenHeight = $_REQUEST['sheight'];
$t_objMTF_Screen->intColorDepth = $_REQUEST['coldepth'];
if($t_objMTF_Screen->intScreenWidth > 0
			&& $t_objMTF_Screen->intScreenHeight > 0
			&& $t_objMTF_Screen->intColorDepth > 0) {
	if($t_objMTF_Screen->read_one_Object() == null) {
		$t_objMTF_Screen->write();
		$t_objMTF_Screen->read_one_Object();
	}
} else {
	$t_objMTF_Screen->intID = 0;
}
$t_objMTF_User->intScreenID = $t_objMTF_Screen->intID; 

// JS
if($_REQUEST['js'] == "y") {
	$t_objMTF_User->bolJavaScript = "true";
} else {
	$t_objMTF_User->bolJavaScript = "false";
}

// UpdateUser
$t_objMTF_User->update();
$t_objMTF_Mysql->close();
?>
