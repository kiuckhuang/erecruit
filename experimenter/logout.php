<?
setcookie("expprofile", "$login", time()-6000);
setcookie( "expid", $expid, time()-3600); 
setcookie( "sessionid", $sessionid, time()-3600); 
setcookie("iamust", "yes", time()-3600);
header("Location: ../index.php"); 
exit();
?>