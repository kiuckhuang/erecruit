<?
include("../fun/exp_functions.inc");
checkLogin();

if(isset($confirm)){
	if($confirm == "yes"){
		$expid = $delexpid;
		setcookie( "delexpid", $delexpid, time()- 3600);
	
		del_experiment($expid);
		mail_delexp($expid);
		$link = "Experimenter_Administration.php";
		message("T0077<br>Experimentd with IDd: $expid have been deleted successfully.\n", $link);
		exit();
	}
	else{
		setcookie( "delexpid", $delexpid, time()- 3600);
		header("Location: ./Experimenter_Administration.php");
		exit();
	}
	
}

$msg = T0078."<br>Do you really want to delete the following experiments with IDs:<br>\n<li>$delexpid";
$link = $PHP_SELF."?confirm=yes";
confirm($msg, $link);
exit();
?>