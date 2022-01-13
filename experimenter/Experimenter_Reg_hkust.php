<?
include("../fun/exp_functions.inc");
require("../fun/ldap.inc");

if(isset($send) && $send=="Send"){
	if(trim($firstName) == ""){
		warning(T0080);
		exit();
	}
	if(trim($lastName) == ""){
		warning(T0081);
		exit();
	}
	if(trim($email) == ""){
		warning(T0082);
		exit();
	}
	if(!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)){
		warning(T0083);
		exit();
	}
	if(trim($sid) == ""){
		warning(T0084);
		exit();
	}
	if(isset($sid) && !eregi("^[0-9]+$",$sid)){
		warning(T0085);
	}
	hkust_experimenter_ack($firstName, $lastName, $email, $sid, $phone, $remarks);
	exit();	
}


/* 
 //NYU do not use ldap
 //comment by Kiu @20020311
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
*/
if($REMOTE_USER != ""){
	setcookie("iamust", "yes", time()+1000);
	$ld = new LdapConn($REMOTE_USER);
	$firstName = $ld->getFirstName();
	$lastName = $ld->getLastName();
	$email = $ld->getEmail();
}


$title = "Experimenter Register!";
head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 

                  <td class="pagetitle" colspan="2">
                    <div align="center">Create <font color="#996600"><b>Experimenter </b></font>Account</div>
                  </td>

                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
              <div align="left" class="normal"><br>
                Please fill in the following form and press &quot;Send&quot;. You will receive a login name and
                password through e-mail in three days if your application is successful.</div>
              <form name="form1" method="post" action="<? echo "$PHP_SELF"; ?>">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">First Name(s) :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="hidden" name="firstName" value="<? echo $firstName; ?>">
                      <? echo $firstName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Last Name :</td>
                    <td width="40%"> 
                      <input type="hidden" name="lastName" value="<? echo $lastName; ?>"><? echo $lastName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Staff/Student 
                      ID :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="sid" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" ><font class="noteindicator"> * </font>Phone No(s) 
                      (e.g. 97123456, 23821234) :</td>
                    <td width="40%" > 
                      <input type="text" name="phone" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Email Address :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="hidden" name="email" value="<? echo $email; ?>"><? echo $email; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" ><font class="noteindicator"> * </font>Remarks :</td>
                    <td width="40%" > 
                      <input type="text" name="remarks" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="tablerow">&nbsp;</td>
                    <td width="40%"> 
                      <div align="right">
                        <input type="submit" name="send" value="Send">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                                    <tr>
                    <td width="60%" class="notes">' <font class="noteindicator"> * </font> ' <font class="notes">denotes optional fields.</font></td>
                    <td width="40%"> 
                    </td>
                  </tr>  
                </table>
                
               </form>
<?

foot();
?>
