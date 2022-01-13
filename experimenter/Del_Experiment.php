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
		message(T0064."Experiments with IDs: $expid were deleted successfully\n", $link);
		exit();
	}
	else{
		setcookie( "delexpid", $delexpid, time()- 3600);
		header("Location: ./Experimenter_Administration.php");
		exit();
	}
	
}

$msg = T0065."e-Recruit will send emails to all signed-up subjects about the cancellation of this experiment. Do you really want to delete the following experiments with IDs:<br>$delexpid";
$link = $PHP_SELF."?confirm=yes";
confirm($msg, $link);
exit();
?>