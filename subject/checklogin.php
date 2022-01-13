<?

require("../fun/subject_functions.inc");		


$loginStr = "$loginName"."\t"."$password";


	if(Login($loginStr)){
		header("Location: ./logon.php");
		exit();
	
	}else{
		warning("Sorry, you cannot login. ");
	}


?>