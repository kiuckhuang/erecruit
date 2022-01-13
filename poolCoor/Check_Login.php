<?
require("../fun/poolcoor_functions.inc");
//checkLogin();
$loginStr = $loginName."\t".$password;

if(Login($loginStr)){
	header("Location: ./Pool_Management.php");
	exit();
}
else{
	warning(P0013);
	exit();
}



?>