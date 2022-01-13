<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(isset($names)){
	for($i=0; $i< sizeof($names); $i++){
		if($names[$i] != ""){
			credit_delelte($names[$i], $pool, $courseID);
			
			
		}
		setcookie( "names[$i]", "", time() - 6000);
	}
	
	if(isset($delnames)){
		$delnames = urldecode($delnames);
		
	}
	$msg = ereg_replace("->", "<br>\n<li>", $delnames);
	$msg = ereg_replace("--", "  ", $msg);
	$msg = "(Message no.P1004)The following subjects:<br>\n<li>".$msg."\n<br>have been deleted successfully.";
	$link = "PM_Courses_Credits_Students_Earned.php";
	message($msg, $link);
	exit();
}
?>