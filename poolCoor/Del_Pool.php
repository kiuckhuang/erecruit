<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(isset($delpools)){
	for($i=0; $i< sizeof($delpools); $i++){
		if($delpools[$i] != ""){
			del_pool($delpools[$i]);
			$poolStr .= $delpools[$i]."->";
		}
		setcookie( "delpools[$i]", "", time() - 6000);
	}
	
	$poolStr = substr($poolStr, 0, strlen($poolStr) -2);
	$msg = ereg_replace("->", "<br>\n<li>", $poolStr);
	$msg = ereg_replace("--", "  ", $msg);
	$msg = "(Message no.P1005)The following pools:<br>\n<li>".$msg."\n<br>have beendeleted successfully.";
	$link = "Pool_Management.php";
	message($msg, $link);
	exit();
}
?>