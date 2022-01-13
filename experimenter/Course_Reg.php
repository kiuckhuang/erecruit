<?
include("../fun/exp_functions.inc");

if(isset($send) && $send=="Send"){
	if(trim($coursecode) == ""){
		warning(T0062);
		exit();
	}
	
	$msg = "Dear Instructor, \n\nWe have received your request of adding your course information to e-Recruit. 
We will add the following after we have verified the information:\n\n";
	$msg .= "\t\tFirst Name\t: $firstName\n";
	$msg .= "\t\tLast Name\t: $lastName\n";
	$msg .= "\t\tE-Mail\t\t: $email\n";
	$msg .= "\t\tCourse Code\t: $coursecode\n";
	$msg .= "\n\nRegards,\nSystem Administrator";
	
	$m = new email ("Message from e-Recruit: Adding Course Information to e-Recruit", $msg, "System Administrator", $email, $email , ADMIN_MAIL);
	$m->send();
	$link = "../";
	message(T0063, $link);
	exit();	
}

if(isset($PHP_AUTH_USER)  && $PHP_AUTH_USER != "" && $PHP_AUTH_PW != "" && isset($iamust) && $iamust == "yes")  {
	setcookie("iamust", "no", time()+1000);
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

  
$title="Course Instructor Register";
head($title);

?>

               
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 

                  <td class="pagetitle" colspan="2">
                    <div align="center">Send <font color="#996600"><b>Course</b></font> 
                      Information</div>
                  </td>

                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
              <div align="left" class="normal"><br>
                If any of your experiments are restricted for students from an <? echo ORG_SHORT; ?> course, please fill in the form (if you are not the course instructor, please ask him/her to do this). 
                The course intructor will receive the sign up code for the course through e-mail in a day or two. Please give it to the students. They need the code to
                sign up experiment(s) restricted to students in the course.
                </div>
              <form name="form1" method="post" action"<? echo $PHP_SELF; ?>">

                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Course Instructor 
                      First Name :</td>
                    <td width="56%" bgcolor="ffffcc" class="normal"> 
                      <input type="hidden" name="firstName" value="<? echo $firstName; ?>"><? echo $firstName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Course Instructor Last Name 
                      : </td>
                    <td width="56%" class="normal"> 
                      <input type="hidden" name="lastName" value="<? echo $lastName; ?>"><? echo $lastName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Course Code 
                      :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="coursecode" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="2" class="normal" bgcolor="ffffcc">
                    Example: <br>
                    1. MARK 111 L1 Fall 2000 or <br>
                    2. ECON 111 L1,L2,L4 Fall 2000 <font class="notes"><-- All three sessions will share the same sign up code</font>
                    </td>
                  </tr>
                  <tr>
                    <td width="44%" class="normal">Email of Course Instructor 
                      : </td>
                    <td width="56%" class="normal">
                      <input type="hidden" name="email" value="<? echo $email; ?>"><? echo $email; ?>
                    </td>
                  </tr>
                  <!--
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">System Generated 
                      Sign-up Code :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="signupcode">
                    </td>
                  </tr>
                  -->
                  <tr> 
                    <td width="44%" class="tablerow">&nbsp;</td>
                    <td width="56%"> 
                      <div align="right"> 
                        <input type="submit" name="send" value="Send">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>
                </form>

<?
foot();
?>
