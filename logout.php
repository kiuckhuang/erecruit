<?
setcookie("login", "", time()-3600);
setcookie("id", "", time()-3600);

header("Location: index.php\n"); 


?>
