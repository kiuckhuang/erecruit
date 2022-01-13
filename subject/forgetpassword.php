<?
require("../fun/subject_functions.inc");
if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

//	$Loginstr = split("-", $subjectprofile);
//	$loginName = $Loginstr[0];

function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $mail;
	global $loginName,$password,$retypepassword;
	$title = " New Password Request";
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<? 		
 		$where = "index.php||Log In->";
		$where .= basename($PHP_SELF)."||".$title;
		position("$where");
 		 ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
	      <form method="POST" name="form" action="<? echo $PHP_SELF;?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                  	Please enter the information below. We will send your login and a new password to your email account. 

                  </tr>
<? if (is_ust()) { ?>
                    <tr>
                    <td width="44%" class="normal" bgcolor="ffffcc">
                    <? echo ORG_SHORT; ?> email:
                    </td>
                    <td width="56%" bgcolor="ffffcc">
                    <input type="text" name="email" value="<? echo $email; ?>">
                    </td>
		    </tr>
		    <tr>
                    <td width="44%" class="normal" bgcolor="ffffcc">
                    Student ID/ Staff ID:
                    </td>
                    <td width="56%" bgcolor="ffffcc">
                    <input type="text" name="stuID" value="<? echo $stuID; ?>">
                    </td>
                    </tr>
<? } else { ?> 
		    <tr>
		    <td width="44%" class="normal" bgcolor="ffffcc">
		    email:
		    </td>
                    <td width="56%" bgcolor="ffffcc">
                    <input type="text" name="email" value="<? echo $email; ?>">
                    </td>
                    </tr>
<? } ?>
                  <!--
                  <tr> 
                    <td width="44%" class="normal"> Your Desired New Password (min. 
                      4 characters) :</td>
                    <td width="56%"> 
                      <input type="password" name="password" value="<? echo $password;?>">
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Retype New Password 
                      : </td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="password" name="retypepassword" value="<? echo $retypepassword;?>">
                    </td>
                  </tr>
                  -->
                  <tr> 
                    <td width="44%" class="tablerow">&nbsp;</td>
                    <td width="56%"> 
                      <div align="right"> 
                        <input type="submit" name="submit" value="Submit">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>
                </form>
<?
	foot();
}
?>

<?
function question_answer(){
	
	global $subjectprofile,$mail;
	global $PHP_SELF;
	global $isNon;
	global $loginName;
	
	$title=" Forget Password";
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<? 
 		$where = "index.php||Log In->";
		$where .= basename($PHP_SELF)."||".$title;
		position("$where");
		 ?>
              </table>
              <hr noshade align="center" width="98%" size="1">
              <? /*
              	//$newpassword = $password;
              	//$cryptpassword = crypt($password);
              	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "select question, answer, email from subject where loginName = '$loginName' ";
		$rs = $db->query($query);
		$question = $rs->fields[question];
		//$answerindb = $rs->fields[answer];
		$email = $rs->fields[email];
		$rs->close();		
		$db->close();	
		*/
              ?>
              
	      <div align="left" class="normal"><br>
                A new password has been given to you. Please check your email for the new password.
              </div>
              <form method="POST" name="form" action="logon.php">

                <table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Your <font color="#000099">e-Recruit</font> 
                      Login Name :</td>
                    <td width="56%" bgcolor="ffffcc"><? echo $loginName;?> </td>
                    <input type="hidden" name="loginName" value="<? echo $loginName;?>">
                  </tr>
                  <!--
                  <tr> 
                    <td width="44%" class="normal"> Your Question :</td>
                    <td width="56%"><? echo $question;?> </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Your Answer :</td>
                    <td width="56%">
                    <input type="text" name="answer" value="<? echo $answer;?>">
                    </td>
                  </tr>
                  -->
                  <!--// if ($answer == $answerindb){ $right = 1; }-->
                  <!--//else{  $right = 0; } ?>-->
                  <!--<input type="hidden" name="right" value="<? echo $right;?>">-->
                  <tr> 
                    <td width="44%" class="tablerow">&nbsp;</td>
                    <td width="56%"> 
                      <div align="right"> 
                        <input type="submit" name="Log_on_again" value="Log in again">
                      </div>
                    </td>
                  </tr>
                </table>

                </form>
<?
	foot();
}
?>

<!----------------------- Main ---------------------------->
<?
if($loginName == "guest"){
	warning_backtocreateacc("Sorry, you cannot sign up with the guest login name. Please create an e-Recruit account to sign up for experiments."); exit;
}
if(isset($email)){
	if (!is_exist_email($email)){
		warningx(W0048);
		exit;
	}
}
if(is_ust() && isset($stuID)){
	if (!is_exist_stuID($stuID)){
		warningx(W0049);
		exit;
	}
}
if($submit == "Submit"){
	//if($password == ""){ warning("Please type in Password!!"); exit; }
	//if($retypepassword == ""){ warning("Please type in Retyped Password!!"); exit; }
	//if($password != $retypepassword ){ warning("Password and Retyped Password are not match!!"); exit; }
	if(0){
		warningx(W0033); exit;
	}
	else{
		$loginName = return_loginName($email);
		if ($loginName == "error"){
		    warningx("error");
			warningx(W0050); exit;
		}
		else if($loginName == "error_no_loginName"){
			warningx(W0050); exit;
		}
		else {
		question_answer();
		//using email to find loginName
		mail_subjects_forgetpassword($loginName);
		//warning("The password is set and the new password is sent to your email account. Thank you."); exit;
		}
	}

}
/*
elseif ( $ok == "Ok" && isset($answer)){
	        $db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "select email from subject where loginName = '$loginName' and answer = '$answer'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		//$question = $rs->fields[question];
		//$answerindb = $rs->fields[answer];
		$email = $rs->fields[email];
		$rs->close();		
		$db->close();
	
		if ( $numOfRows == 1 ){
			mail_subjects_forgetpassword($loginName);
			warning("The password is set and the new password is sent to your email account."); exit;
		}
		else { 
			warning("If you also forget the answer, please sent the mail to <a href=\"mailto:sysadmin@recruit.bm.ust.hk\"> sysadmin@recruit.bm.ust.hk </a>"); exit;
		}
		
}
*/
else{
	content($title);
}
	
	


?>