<?
include("../fun/admin_functions.inc");

if(isset($expStr) && trim($expStr)!=""){
	$expStr = urldecode($expStr);
	$exps= explode("->", $expStr);
	for($i=0; $i < sizeof($exps); $i++){
		delExperimenter($exps[$i]);
	}
	$msg = ereg_replace("->", "<br>\n<li>", $expStr);
	$msg = "(Message no.S1003)The following experimenters with Login Names:<br>\n<li>".$msg."\n<br>have been deleted successfully.";
	$link = "Experimenter_Management.php";
	message($msg, $link);
	exit();
}
?>