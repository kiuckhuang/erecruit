<?
require("../fun/subject_functions.inc");
/*
if ($lastName == ""){
      warning("Cookies cannot be set in your browser. Please use another computer or browser."
              ." Necscape 4.x or 6 is recommended");
   	exit();
}
*/
$isusttemp = split("-",$isust);
/*
if(is_ust())  {
	setcookie("isust", "non", time()+1000);
	$REMOTE_USER = "";
   	$REMOTE_PASSWORD = "";
   	$PHP_AUTH_USER = "";
   	$PHP_AUTH_PW = "";
}
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
   
   	//echo  "You  must  enter  a  valid  ". ORG_SHORT ." login  ID  and  password  to  access  this  resource\n";
   	warning("You  must  enter  a  valid  ". ORG_SHORT ." login  ID  and  password  to  access  this  resource\n");
   	
   	exit;
      }

$ds=ldap_connect("ldap.ust.hk"); // must be a valid LDAP server!

if(isset($PHP_AUTH_USER)  && $PHP_AUTH_USER != "" && $PHP_AUTH_PW != "")  {
  	$bind = @ldap_bind($ds, "uid=$PHP_AUTH_USER,ou=people,o=ust.hk", $PHP_AUTH_PW);
	if($bind){
		$sr=ldap_search($ds,"ou=People, o=ust.hk", "uid=$PHP_AUTH_USER");
		$info = ldap_get_entries($ds, $sr);
		$firstName= $info[0]["givenname"][0];
		$lastName= $info[0]["sn"][0];		
		$mail = $info[0]["mail"][0];
		setcookie( "firstName", $firstName, time()+3600);
		setcookie( "lastName", $lastName, time()+3600);
		setcookie( "mail", $mail, time()+3600);
		
		
		$isnon = "is";
		$md5str = MD5( TIME() );
		//$loginName = "";
		//$password = "";
		$cookie_val = "$isnon-$md5str";
		setcookie( "isust", $cookie_val, time()+3600);
		//header("Location: logon.php");
		ldap_close($ds);
		 
		
	}else{
		authenticate();
		exit();
	}
}else{		
  	authenticate();
}
*/

//if (is_ust())$isNon = "";
//else { $isNon = "Non-"; }
$isNon = "";
$title=" Log In (for ".$isNon.ORG_SHORT." Student/Staff)";

//$loginStr = "$loginName"."\t"."$password";
//$login_var = explode("-", $expprofile);
//if(!isset($loginName))
//	$loginName = $login_var[0];

function content($title){
	global $subjectprofile, $firstName, $lastName, $mail;
	global $PHP_SELF;
	global $isnon;
	global $isNon;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td> 
 		<?
 		$where = "index.php||Log In->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where"); ?>
		</td>
		<td>
 		<? if (is_ust()){ //echo "<a href=\"logout.php\">";?>
 		<!-- <img src="images/but_logout.gif" border="0" align="absmiddle"></a>-->
 		<?}?>
 		</td>
 		</tr>
                
              </table>
              <hr noshade align="center" width="98%" size="1">
              
              
                                <br>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="ffffcc"> 
                      <td height="39"> 
                        <div class="normal">
                          <div align="center">Welcome, <? echo $lastName." ".$firstName; ?>! Have you created an <font color="#000099">e-Recruit</font> 
                            account? If not, please click 
                            <a href="Create_Account.php"><img src="images/but_create.gif" border="0" align="absmiddle"></a><br>
                            (If you are not <? echo $lastName." ".$firstName; ?>, please close the browser and enter e-Recruit again.)<br>
                            To visit our system without creating a new account, 
                            please type "guest" in both of the blanks below. <BR> For bugs and suggestions, please direct them to <? echo BUG_MAIL_WITH_LINK; ?>.                            
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                  
                </div>

              </div>

              <div v:shape="_x0000_s3074" class="O"><div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;

mso-kinsoku-overflow:1" class="pagetitle"><hr noshade align="center" width="98%" size="1">
                </div>
              </div>

              <form method="POST" action="login_member.php">

                <!--webbot bot="SaveResults"

  U-File="C:\My Documents\ERECRUIT\_private\form_results.txt"

  S-Format="TEXT/CSV" S-Label-Fields="TRUE" --> <span class="tablerow"></span> 

                <table border="0" width="53%" align="center">
                  <tr> 
                    <td width="50%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">e-Recruit 
                      Login Name:</font></span></td>
                    <td width="50%"> 
                      <div align="right">
                        <input type="text" name="loginName" size="20" value="">
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="50%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">
                      Password:</font> </span></td>
                    <td width="50%"> 
                      <div align="right">
                        <input type="password" name="password" size="20">
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td> 
                      
                    </td>
                    <td> 
                      <div align="right">
                        <input type="submit" value="Log in" name="logon">
                        <input type="reset" value="Reset" name="reset">
                      </div>
                    </td>
                  </tr>
                  </table>

              </form>
<p align="center" class="tablerow">
  <a href="../mailinglist.php">Upcoming Experiments Notifications</a>
  <br><a href="forgetpassword.php">Forgotten Your Password?</a>
<!--
  <br><a href="changeITSCac.php">Change <? echo ORG_SHORT; ?> Login Name</a>
-->
</p>
<?
	foot();
}
?>

<?
  //-------------main-----------
//content($title);
  //----------------------------
?>

<?

if(is_ust()){	
	content($title);
}else{
	content($title);
}
	
	


?>
