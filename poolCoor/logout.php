<?
setcookie("pcprofile", "", time()-60000, "/");
setcookie( "sessionid", "", time()-36000, "/"); 
setcookie("iamust", "no", time()-36000, "/");
setcookie("poolname", "yes", time()-36000, "/");
setcookie("creditstuid2", "", time()-3600, "/");
setcookie("pcprofile", "", time()-60000);
setcookie( "sessionid", "", time()-36000); 
setcookie("iamust", "no", time()-36000);
setcookie("poolname", "yes", time()-36000);
setcookie("creditstuid2", "", time()-3600);

header("Location: ./index.php"); 
exit();
?>
