<?
$REMOTE_USER = "";
$REMOTE_PASSWORD = "";
$PHP_AUTH_USER = "";
$PHP_AUTH_PW = "";
$clear = "";
setcookie("subjectprofile",$clear, time() + 3600 );
setcookie("isust",$clear, time() + 3600 );
setcookie("mail",$clear, time() + 3600 );
setcookie("firstName",$clear, time() + 3600 );
setcookie("lastName",$clear, time() + 3600 );
setcookie("REMOTE_USER",$clear, time() - 3600 );
setcookie("REMOTE_PASSWORD",$clear, time() - 3600 );
setcookie("PHP_AUTH_USER",$clear, time() - 3600 );
setcookie("PHP_AUTH_PW",$clear, time() - 3600 );
header("Location: index.php");
?>