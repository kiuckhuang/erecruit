<?
/*
if ( $postchoosepool == "on"){ setcookie("choosepool","on",time() + 3600); setcookie("pool",$postpool,time() + 3600);}else{ setcookie("choosepool",$choosepool,time() + 3600); setcookie("pool",$pool,time() + 3600);}//setcookie("pool","",time() - 3600);}//if ( $postchoosepool == "on" && $postchoosepool != $choosepool ){ setcookie("choosepool","on",time() + 3600); }else{ setcookie("choosepool","on",time() - 3600); setcookie("pool",$pool,time() - 3600);}
if ( $postchoosecourse == "on"){ setcookie("choosecourse","on",time() + 3600); setcookie("course",$postcourse,time() + 3600);}else{ setcookie("choosecourse",$choosecourse,time() + 3600); setcookie("course",$course,time() + 3600);}//setcookie("course","",time() - 3600);}//if ( $postchoosecourse == "on" && $postchoosecourse != $choosecourse ){ setcookie("choosecourse","on",time() + 3600); }else{ setcookie("choosecourse","on",time() - 3600);  setcookie("course",$course,time() - 3600);}
if ( $postchooseopen == "on"){ setcookie("chooseopen","on",time() + 3600); }else{ setcookie("chooseopen",$chooseopen,time() + 3600); }//if ( $postchooseopen == "on" && $postchooseopen != $chooseopen) setcookie("chooseopen","on",time() + 3600); else{ setcookie("chooseopen","on",time() - 3600); }
*/
header("Location: upcomingexp_expdetails.php");
?>