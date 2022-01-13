<?
require("../fun/subject_functions.inc");
if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

	$Loginstr = split("-", $subjectprofile);
	$loginName = $Loginstr[0];

function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $mail;
	global $loginName,$password,$retypepassword;
	$title = "Change Password";
	
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
              
	      <form method="POST" name="form" >
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Your Desired 
                      <font color="#000099">e-Recruit</font> Login Name :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <? echo $loginName;?>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal"> Your old password:
                      </td>
                    <td width="56%"> 
                      <input type="password" name="oldpassword" value="<? echo $oldpassword;?>">
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Your Desired New Password (min. 
                      4 characters) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="password" name="password" value="<? echo $password;?>">
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal"> Retype New Password 
                      : </td>
                    <td width="56%"> 
                      <input type="password" name="retypepassword" value="<? echo $retypepassword;?>">
                    </td>
                  </tr>
                  
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
<?	foot_menu();
	foot();
}
?>

<?
function Confrimation(){
	$title="Change Password Confirmation";
	global $subjectprofile,$mail;
	global $PHP_SELF;
	global $isNon;
	global $loginName,$oldpassword,$password,$retypepassword;
	$Login = split("-", $subjectprofile);
	$loginName = $Login[0];
	
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
              <? 
              	$newpassword = $password;
              	$cryptpassword = crypt($newpassword);
              	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "UPDATE subject SET password = '$cryptpassword' WHERE loginName = '$loginName'";
		$rs = $db->query($query);
		$query = "select firstName, lastName, email from subject where loginName = '$loginName'";
		$rs = $db->query($query);
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$email = $rs->fields[email];
		mail_subject_changepd($firstName,$lastName,$loginName,$password,$email);
		$rs->close();		
		$db->close();	/*	optional	*/              
              ?>
              
	      <div align="left" class="normal"><br>
                Your account password has been changed. Please login again using the new password. 
              </div>
              <form method="POST" name="form" action="<?if(is_ust()){ echo 'logon.php'; } else { echo 'logon_nonust.php'; } ?>">

                <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <!--
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Your <font color="#000099">e-Recruit</font> 
                      Login Name :</td>
                    <td width="56%" bgcolor="ffffcc"><? echo $loginName;?> </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal"> Your Password :</td>
                    <td width="56%"><? echo $newpassword;?> </td>
                  </tr>
		-->
                  <tr> 
                    <td width="44%" class="tablerow">&nbsp;</td>
                    <td width="56%"> 
                      <div align="right"> 
                        <input type="submit" name="enter" value="Log in again">
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
	warning(W0004); exit;
}
if(!isset($subjectprofile)){
	warningx("Sorry, <a href='index.php'>Log in</a> first!");exit;
}
if(isset($oldpassword)){
        $db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select password from subject where loginName = '$loginName' ";
	$rs = $db->query($query);
	$dbpassword = $rs->fields[password];
	$numOfRows = $rs->getNumOfRows();
	$returnpassword = crypt($oldpassword,substr($dbpassword,0,2));
	$rs->close();		
	$db->close();	/*	optional	*/
	if ( $dbpassword != $returnpassword ){
		warning("This old password is wrong. Please type it again.");
		exit;
	}              	
}
if($submit == "Submit"){
	if($loginName == ""){ warningx(W0006); exit; }
	if(strlen($password) < 4 ){ warningx(W0012); exit; }
	if($password == ""){ warningx(W0013); exit; }
	if($retypepassword == ""){ warningx(W0014); exit; }
	if($password != $retypepassword ){ warningx(W0015); exit; }
	if(0){
		warningx(W0022); exit;
	}
	else{
		Confrimation();
	}
}else{
	content($title);
}
	
	


?>