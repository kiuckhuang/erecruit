<?
include("../fun/admin_functions.inc");

//header("Location: Experienced_Subjects.php");

if(isset($loginNames) && $loginNames != ""){
	$loginNames = eregi_replace(" ", "", $loginNames);
	unblock_subjects($loginNames);
}


?>