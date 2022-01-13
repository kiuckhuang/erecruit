<?
require("../fun/exp_functions.inc");
require("../fun/ldap.inc");
/*
if((isset($expprofile) && checkcookie($expprofile)) ){
	warning("You have logged in.<br>\nPlease <a href=\"logout.php\">log out here.<a>");
	exit();
}
*/
/* NYU do not use LDAP 
   // Comment by Kiu @20020310
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

*/
if($REMOTE_USER != ""){
	setcookie("iamust", "yes", time()+1000);
	$ld = new LdapConn($REMOTE_USER);
	$firstName = $ld->getFirstName();
	$lastName = $ld->getLastName();
	$email = $ld->getEmail();
}
$title="Log In (for ".ORG_SHORT." Students/Staff)";
head($title);


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <?
                $where="index.php||Log In->";
                $where .= basename($PHP_SELF)."||".$title;
                position("$where");
            ?>
            </tr>
          </table>
 
            </div>
          </div>
          <hr noshade align="center" width="98%" size="1">
          <form method="POST" action="Check_Login.php">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr bgcolor="ffffcc"> 
               <td > 
            <div align="center"> 
	    <font class="normal">  
	    
	    Welcome, <? echo $lastName." ".$firstName; ?>! Have you applied for an e-Recruit Experimenter account? If not, please click <a href="Experimenter_Reg_hkust.php"><img src="images/but_create.gif" align="absmiddle" border="0"></a>. Note that this page is NOT for people who want to participate in experiment. Rather this page is for those who want to recruit students.  <br>
	    (If you are not <? echo $lastName." ".$firstName; ?>, please close the browser and enter e-Recruit again.) <BR>
	    For bugs and suggestions, please direct them to <? echo BUG_MAIL_WITH_LINK; ?>.
	    </font>
	    </div>
	      </td>
	      </tr>
	  </table>
	   
	   
	    <hr noshade align="center" width="98%" size="1">
            <table border="0" width="270" align="center">
              <tr> 
                <td width="40%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Login Name:</font></span></td>
                <td width="60%"> 
                  <input type="text" name="loginName" size="20" value="">
                </td>
              </tr>
              <tr> 
                <td width="40%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Password:</font> 
                  </span></td>
                <td width="60%"> 
                  <input type="password" name="password" size="20">
                  <input type="hidden" name="ust" value="yes">
                </td>
              </tr>
              <tr> 
              <td width="40%" > </td>
                <td width="60%" > 
                  <div align="right"> 
                  
                    <input type="submit" value="Log in" name="logon">
                    <input type="reset" value="Reset" name="reset">
                  </div>
                </td>
              </tr>
            </table>
          </form>
          <p class="normal" align="center">If you have forgotten your password, please 
            contact the system administrator at <a href="mailto:<? echo ADMIN_MAIL; ?>"><? echo ADMIN_MAIL; ?></a><br>
          </p>
          
          
<?




foot();
?>

