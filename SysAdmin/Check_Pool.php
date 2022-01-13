<?
include("../fun/admin_functions.inc");

if($poolname == ""){
	warning(S0016);
	exit();
}

if($firstName ==""){
	warning(S0009);
	exit();
}

if($lastName == ""){
	warning(S0010);
	exit();
}

if($loginName ==""){
	warning(S0017);
	exit();
}

if($password == ""){
	warning(S0018);
	exit();
}
if($email ==""){
	warning(S0011);
	exit();
}



if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)) {
		
		warning(S0013);
		exit();
}

$addStr = $poolname."->".$firstName."->".$lastName."->".$loginName."->".$password."->".$email."->".$submit."->".$oldpoolname."->".$oldloginname."->".$oldpassword;


if(add_pool($addStr)){

	if($submit != "Add")
		$title = "Update";
	else
		$title = "Add";
	$link = "Pool_Management.php";
	message("(Message no.S1001)<br>\nPool with name: $poolname $title has been added.", $link);


}
?>