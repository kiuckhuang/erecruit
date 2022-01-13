<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if($year == ""){
	warning(P0014);
	exit();
}

if(isset($signUpCode) && $signUpCode == ""){
	warning(P0015);
	exit();
}

if(!ereg("^[0-9a-zA-Z]{8}", $signUpCode)){
	warning(P0016);
	exit();
}


if(isset($authcode) && $authcode == ""){
	warning(P0017);
	exit();
}

if(!ereg("^[0-9]{5}", $authcode)){
	warning(P0018);
	exit();
}



$addStr = $poolname."->".$year."->".$semester."->".$signUpCode."->".$authcode."->".$message."->".$submit."->".$oldyear."->".$oldsemester."->".$deadlinedays;


if(add_pool($addStr)){

	if($submit != "Add")
		$title = "Update";
	else
		$title = "Add";
	$link = "Pool_Management.php";
	message("(Message no.P1001)Pool: $poolname $year $semester $title has been added/updated.", $link);


}
?>