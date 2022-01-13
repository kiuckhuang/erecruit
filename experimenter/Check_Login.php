<?
require("../fun/exp_functions.inc");


if(isset($nonust) && $nonust == "yes"){
	$loginStr = $loginName."\t".$password."\t".$nonust;
}
else{
	$loginStr = $loginName."\t".$password;
}


if(Login($loginStr)){
	header("Location: ./Experimenter_Administration.php");
	exit();
}
else{
	warning(T0039);
	exit();
}



?>