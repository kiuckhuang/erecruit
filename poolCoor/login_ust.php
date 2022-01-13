<?
require("../fun/exp_functions.inc");
if((isset($pcprofile) && checkcookie($pcprofile)) ){
	warning("You have logged in.<br>\nPlease <a href=\"logout.php\">log out here.<a>");
	exit();
}


 function  authenticate()  {
   	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
	header("Pragma: no-cache");                                   // HTTP/1.0
   	Header("WWW-authenticate:  basic  realm='". ORG_SHORT ." Username and Password'");
   	Header("HTTP/1.0  401  Unauthorized");
   	$REMOTE_USER = "";
   	$REMOTE_PASSWORD = "";
   	$PHP_AUTH_USER = "";
   	$PHP_AUTH_PW = "";
   
   	echo  "You  must  enter  a  valid  ". ORG_SHORT ." login  ID  and  password  to  access  this  resource\n";
   	exit;
      }

$ds=ldap_connect("ldap.ust.hk"); // must be a valid LDAP server!

if(isset($PHP_AUTH_USER)  && $PHP_AUTH_USER != "" && $PHP_AUTH_PW != "")  {
  	$bind = @ldap_bind($ds, "uid=$PHP_AUTH_USER,ou=people,o=ust.hk", $PHP_AUTH_PW);
	if($bind){
		setcookie("iamust", "yes", time()+1000);
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

$title="Experimenter Login";
head($title);


?>
 <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle">e-Recruit <i><b><font color="#996600">Experimenter</font></b></i> 
              Log on 
              <hr noshade align="center" width="98%" size="1">
            </div>
          </div>
          <form method="POST" action="Check_Login.php">
             
	    <font class="normal">  
	    <ul>
	       <li>Welcome! <b>Have you applied for an e-Recruit Experimenter account?</b> If not, please click <a href="Experimenter_Reg_org.php"><img src="images/but_create.gif" align="absmiddle" border="0"></a></li>
	    </ul>
	    <hr noshade align="center" width="98%" size="1">
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
                    <input type="submit" value="Log on" name="logon">
                    <input type="reset" value="Reset" name="reset">
                  </div>
                </td>
              </tr>
            </table>
          </form>
          <p class="normal" align="center">If you forget your password, please 
            contact System Administrator at <a href="mailto:sysadmin@recruit.bm.ust.hk">sysadmin@recruit.bm.ust.hk</a><br>
          </p>
          <hr noshade align="center" width="98%" size="1">
          
<?




foot_link();
?>

