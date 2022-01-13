<?
include("../fun/admin_functions.inc");

if(isset($poolStr) && trim($poolStr)!=""){
	$poolStr = urldecode($poolStr);
	$pools= explode("->", $poolStr);
	for($i=0; $i < sizeof($pools); $i++){
		del_pool($pools[$i]);
	}
	$msg = ereg_replace("->", "<br>\n<li>", $poolStr);
	$msg = ereg_replace("--", "  ", $msg);
	$msg = "(Message no.S1004)The following pools:<br>\n<li>".$msg."\n<br>have been deleted successfully.";
	$link = "Pool_Management.php";
	message($msg, $link);
	exit();
}
?>