<?
require("../fun/subject_functions.inc");
$subjectprofile = "$loginName"."-"."$password";
if (!isset($loginName) || $loginName == ""){
	warningx(W0006);
	exit;
}
if (!isset($password) || $password == ""){
	warning(W0013);
	exit;
}
if (is_ust())
{
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
	if ($loginName == "guest" && $password == "guest")
	{
		$cookie_val = $subjectprofile;
		setcookie( "subjectprofile", $cookie_val, time()+3600*24*10);
		header("Location: upcomingexp.php");
	}	
	elseif (UST_Login($subjectprofile))
	{	
		$cookie_val = $subjectprofile;
		setcookie( "subjectprofile", $cookie_val, time()+3600*24*10);
		header("Location: upcomingexp.php");
	}
	elseif (!is_vaild_account($loginName))
	{
		warningx(W0043);	
		exit();
	}
	elseif (!is_correct_passwd($subjectprofile))
	{	
		warningx(W0043);	
		exit();
	}else{
	    $tempmsg = "";//$tempmsg = "\$subjectprofile = ".$subjectprofile." \$mail = ".$mail." \$PHP_AUTH_USER = ".$PHP_AUTH_USER."<BR>";
	    //for testing login in
		$msg = $tempmsg."Your e-Recruit login does not match with your ". ORG_SHORT." login.<br>"
		."At the time you created an e-Recruit account, that account<br>"
		."have been linked with your ". ORG_SHORT ." user name. So whenever <br>"
		."you enter e-Recruit again with your ". ORG_SHORT ." login, you have <br>"
		."to login with the same e-Recruit account. <br>"
		."Please login again with the appropriate e-Recruit account. <br>";
		warningx($msg);
		exit();
	}
}else{
	if ($loginName = "guest" && $password == "guest")
	{	
		$isnon = "non";
		$md5str = MD5( TIME() );
		$isnon = "$isnon-$md5str";
		setcookie( "isust", $isnon, time()+3600);
		$cookie_val = $subjectprofile;
		setcookie( "subjectprofile", $cookie_val, time()+3600);
		header("Location: upcomingexp.php");
	}
	elseif(isLogin($subjectprofile))
	{	
		$isnon = "non";
		$md5str = MD5( TIME() );
		$cookie_val = "$subjectprofile"."-"."$md5str";
		setcookie( "subjectprofile", $cookie_val, time()+3600);
		setcookie( "isust", $isnon, time()+3600);
		header("Location: upcomingexp.php");
	}else{
		warning(W0034);
	}
}
?>