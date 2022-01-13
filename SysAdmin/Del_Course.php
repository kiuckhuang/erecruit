<?
include("../fun/admin_functions.inc");

if(isset($courseStr) && trim($courseStr)!=""){
	$courseStr = urldecode($courseStr);
	$courses= explode("->", $courseStr);
	for($i=0; $i < sizeof($courses); $i++){
		del_course($courses[$i]);
	}
	$msg = ereg_replace("->", "<br>\n<li>", $courseStr);
	$msg = "(Message no.S1002)<br>\nThe following courses:<br>\n<li>".$msg."\n<br>have been deleted successfully.";
	$link = "System_Management.php";
	message($msg, $link);
	exit();
}
?>