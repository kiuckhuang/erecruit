<?
require("../fun/poolcoor_functions.inc");
if((isset($pcprofile) && checkcookie($pcprofile)) ){
	header("Location: logout.php");
	exit;
}

/*
// NYU no need LDAP
// 20020317 by kiu
function  authenticate()  {
   	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
	header("Pragma: no-cache");                                   // HTTP/1.0
   	Header("WWW-authenticate: basic realm=\"". ORG_SHORT ." Username and Password\"");
   	Header("HTTP/1.0  401  Unauthorized");
   	$REMOTE_USER = "";
   	$REMOTE_PASSWORD = "";
   	$PHP_AUTH_USER = "";
   	$PHP_AUTH_PW = "";
   
   	warning(P0027);
   	exit;
      }

$ds=ldap_connect("ldap.ust.hk"); // must be a valid LDAP server!

if(isset($PHP_AUTH_USER)  && $PHP_AUTH_USER != "" && $PHP_AUTH_PW != "")  {
  	$bind = @ldap_bind($ds, "uid=$PHP_AUTH_USER,ou=people,o=ust.hk", $PHP_AUTH_PW);
	if($bind){
		setcookie("iamust", "yes", time()+3600);
	 	$sr=ldap_search($ds,"ou=People, o=ust.hk", "uid=$PHP_AUTH_USER");
		$info = ldap_get_entries($ds, $sr);
		
		$lastName= $info[0]["sn"][0];
		$firstName= $info[0]["givenname"][0];
		$email=$info[0]["mail"][0];
		
		ldap_close($ds);
		 
		
	}else{
		authenticate();
		exit();
	}
}else{		
  	authenticate();
}
*/
setcookie("iamust", "yes", time()+3600);
$title="Pool Coordinator Login";
head($title);


?>
 <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle">e-Recruit <i><b><font color="#996600">Pool Coordinator</font></b></i> 
              Log In
              <hr noshade align="center" width="98%" size="1">
            </div>
          </div>
          <form method="POST" action="Check_Login.php">
             
	    <font class="normal">  
	    <table border="0" width="26%" align="center">
              <tr> 
                <td width="12%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Login:</font></span></td>
                <td width="88%"> 
                  <input type="text" name="loginName" size="20" value="">
                </td>
              </tr>
              <tr> 
                <td width="12%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Password:</font> 
                  </span></td>
                <td width="88%"> 
                  <input type="password" name="password" size="20">
                </td>
              </tr>
              <tr> 
                <td colspan="2"> 
                  <div align="right"> 
                    <input type="submit" value="Log In" name="logon">
                    <input type="reset" value="Reset" name="reset">
                  </div>
                </td>
              </tr>
            </table>
          </form>
          <p class="normal" align="center">If you have forgotten your password, please 
            contact the System Administrator at <a href="mailto:<? echo ADMIN_MAIL; ?>"><? echo ADMIN_MAIL; ?></a><br>
          </p>

<?




foot();
?>

