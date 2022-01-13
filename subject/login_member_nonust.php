<?
require("../fun/subject_functions.inc");
$subjectprofile = "$loginName"."-"."$password";
/*
if (0)
{
	if ($loginName = "guest" && $password == "guest")
	{
		$cookie_val = $subjectprofile;
		setcookie( "subjectprofile", $cookie_val, time()+3600);
		header("Location: upcomingexp.php");
	}
	if (UST_Login($subjectprofile))
	{	
		$cookie_val = $subjectprofile;
		setcookie( "subjectprofile", $cookie_val, time()+3600);
		header("Location: upcomingexp.php");
	}else{
		$msg = "Your e-Recruit login does not match with your ". ORG_SHORT ." login.<br>"
		."At the time you created an e-Recruit account, that account<br>"
		."have been linked with your ". ORG_SHORT ." user name. So whenever <br>"
		."you enter e-Recruit again with your ". ORG_SHORT ." login, you have <br>"
		."to login with the same e-Recruit account. <br>"
		."Please login again with the appropriate e-Recruit account. <br>";
		warning($msg);
		exit;
	}
	*/
//}else{
	if ($loginName == "guest" && $password == "guest")
	{	
		$isnon = "non";
		$md5str = MD5( TIME() );
		$isnon = "$isnon-$md5str";
		setcookie( "isust", $isnon, time()+3600);
		$cookie_val = $subjectprofile;
		setcookie( "subjectprofile", $cookie_val, time()+3600);
		header("Location: upcomingexp.php");
	}
	//This will check this subject is blocked or not
	if (is_blocking($subjectprofile) || IS_BLOCKING_SUBJECT){
		if ( is_ust() ) {
			$msg = W0045.W0046;
		} else {
			$msg = W0045;
		}
		warningx($msg);
		exit();
	}
	if (is_UST_account($subjectprofile))
	{
		setcookie("subjectprofile",$clear, time() - 3600 );
		setcookie("isust",$clear, time() - 3600 );
		setcookie("mail",$clear, time() - 3600 );
		setcookie("firstName",$clear, time() - 3600 );
		setcookie("lastName",$clear, time() - 3600 );
		setcookie("REMOTE_USER",$clear, time() - 3600 );
		setcookie("REMOTE_PASSWORD",$clear, time() - 3600 );
		setcookie("PHP_AUTH_USER",$clear, time() - 3600 );
		setcookie("PHP_AUTH_PW",$clear, time() - 3600 );
		$msg = "Please use ".ORG_SHORT." Students/Staff gateway to log in e-Recruit.";
		warning_backtohome($msg);
		exit;
	}
	if(is_nonust_Login($subjectprofile))
	{	
		$isnon = "non";
		$md5str = MD5( TIME() );
		$cookie_val = "$subjectprofile"."-"."$md5str";
		setcookie( "subjectprofile", $cookie_val, time()+3600);
		setcookie( "isust", $isnon, time()+3600);
		header("Location: upcomingexp.php");
	}
	else{
		warningx(W0034);
		exit;
	}
//}
?>
