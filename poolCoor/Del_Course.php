<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(isset($delcourses)){
	for($i=0; $i< sizeof($delcourses); $i++){
		if($delcourses[$i] != ""){
			del_course($delcourses[$i]);
			$courseStr .= $delcourses[$i]."->";
		}
		setcookie( "delcourses[$i]", "", time() - 6000);
	}
	
	$courseStr = substr($courseStr, 0, strlen($courseStr) -2);
	$msg = ereg_replace("->", "<br>\n<li>", $courseStr);
	$msg = ereg_replace("--", "  ", $msg);
	$msg = "(Message no.P1003)The following courses:<br>\n<li>".$msg."\n<br>have been deleted successfully.";
	$link = "PM_Courses.php";
	message($msg, $link);
	exit();
}
?>