<?
require("../fun/subject_functions.inc");
if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

if(is_ust()){$title=" Create e-Recruit Account (for ".ORG_SHORT." Students/Staff)";}
else{ $title=" Create e-Recruit Account (for Other Participants)";}

function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $mail;
	global $firstName,$lastName;
	
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
              
<form method="POST" name="form" action="<? echo $PHP_SELF; ?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Your Desired 
                      <font color="#000099">e-Recruit</font> Login Name :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="loginName" value="<? echo $loginName;?>">
                    </td>
                  </tr>
                  <? if(is_ust()){ ?>
                  <tr> 
                    <td width="44%" class="normal"> Your Desired Password (min. 
                      4 characters) :</td>
                    <td width="56%"> 
                      <input type="password" name="password" value="<? echo $password;?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Retype Password 
                      : </td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="password" name="retypepassword" value="<? echo $retypepassword;?>">
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal">Your Student/Staff ID Number:</td>
                    <td width="56%"> 
                      <input type="text" name="stuID" value="<? echo $stuID;?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Retype Your Student/Staff ID Number:</td>
                    <td width="56%" bgcolor="ffffcc">
                      <input type="text" name="restuID"  value="<? echo $restuID;?>">
                    </td>
                  </tr>
                  <? }?>
                  <tr> 
                    <td width="44%" class="normal"> First Name(s) <? //if(!is_ust())echo "(e.g. Tai Man)"; ?>  
                      : </td>
                    <td width="56%" class="normal">
                    <? if (is_ust()){ echo $firstName; } else { ?>
                      <input type="text" name="firstName" size="12" value="<? echo $firstName;?>">
                      <?}?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Last Name <? //if(!is_ust())echo "(e.g. Chan)"; ?> 
                       :</td>
                    <td width="56%" bgcolor="ffffcc" class="normal">
                    <? if (is_ust()){ echo $lastName; } else { ?>
                      <input type="text" name="lastName" size="12" value="<? echo $lastName;?>">
                      <?}?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Sex :</td>
                    <td width="56%"> 
                      <select name="sex">
                      	<option value="-1">Pls choose one</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                      </select>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> *Phone No(s) 
                       :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="phone" value="<? echo $phone;?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Email Address <? //if(!is_ust())echo "(e.g. abc@def.com)"; ?> 
                      : </td>
                    <td width="56%" class="normal">
                    	<? if (is_ust()){ $email = $mail; echo $email; ?><input type="hidden" name="email" size="12" value="<? echo $email;?>"><?} else{ ?>
                       <input type="text" name="email" size="12" value="<? echo $email;?>"><? } ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="tablerow">* denotes optional field</td>
                    <td width="56%"> 
                      <div align="right"> 
                        <input type="submit" name="submit" value="Submit">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="2" class="normal">
<? if (is_ust()){ ?>                    
Please make sure that 
you have entered the correct Student/Staff ID as your identity will be 
verified when you arrive at the experiment venue. Later when you are no 
longer an <? echo ORG_SHORT; ?> student or staff and you still want to participate in 
e-Recruit experiments, please go to 
<? echo RECRUIT_URL; ?>subject/logon_nonust.php to create a new 
e-Recruit account at that time.
<? } else { ?>                    
Later when you become an <? echo ORG_SHORT; ?> student or staff and you want to participate in 
e-Recruit experiments, please go to 
<? echo RECRUIT_URL; ?>subject-org/logon_ust.php to create a new 
e-Recruit account at that time.
<? } ?>
                    </td>
                  </tr>  
                  <!--
                  <tr> 
                    <td colspan="2" class="normal">Do you want to receive information of upcoming experiments from e-Recruit? Please uncheck the box if you do not want to. In any case, you can discontinue this notification through the "Change Personal Inf
ormation" link below. 
                      <input type="checkbox" name="subscribe" checked>
                    </td>
                  </tr>
                  -->
                </table>
                </form>
<?
	foot();
}
?>

<?
function Confirmation(){
	global $subjectprofile,$mail;
	global $PHP_SELF;
	global $isNon;
	global $loginName,$password,$retypepassword,$stuID,$firstName,$lastName,$sex,$phone,$email,$subscribe;//,$question,$answer
	if(is_ust()){$title=" Create e-Recruit Account (for ".ORG_SHORT." Students/Staff)";}
	else{ $title=" Create e-Recruit Account (for Other Participants)";}
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<? 
 		$where = "index.php||Log In->Create_Account.php|| ".$title."->";
		$where .= basename($PHP_SELF)."||"."Confirmation";
		position("$where");
		 ?>
              </table>
              <hr noshade align="center" width="98%" size="1">
              <? 
                
		
              	if( $subscribe == "on" ) $subscribe = "Y"; else{ $subscribe = "N"; }
              	if( $phone == "" || !isset($phone) ) $phone = 0;
              	$cryptpassword = crypt($password);
              	$db = new phpDB();
              	//$db->debug = true;
		$db->connect() or die ("Can't connect to database server or select database");
		if(is_ust()){
		$query = "INSERT INTO subject (loginName,password,stuID,firstName,lastName,sex,phone,email,subscribe,hkust) values ('$loginName','$cryptpassword','$stuID','$firstName','$lastName','$sex',$phone,'$email','$subscribe','$email')";
		$rs = $db->query($query);
		}else{
		$random = MD5( TIME() );
		$randompassword = substr($random,0,8);
		$cryptpassword = crypt($randompassword);
		$query = "INSERT INTO subject (loginName,password,firstName,lastName,sex,phone,email,subscribe,hkust) values ('$loginName','$cryptpassword','$firstName','$lastName','$sex',$phone,'$email','$subscribe','0')";
		$rs = $db->query($query);
		mail_nonustsubject_newac($firstName,$lastName,$loginName,$randompassword,$email);
		}
		
		$rs->close();		
		$db->close();	/*	optional	*/              
              ?>
              
	      <div align="left" class="normal"><br>
                Your e-Recruit account has been created.  Below is the information you have submitted. Please read our <a href="./SignUpPolicy.php">Sign Up Policy</a> before you proceed.
                <? if(!is_ust()){?>
                	The password has been sent to your email account.
                <? }?>
              </div>
              <form method="POST" name="form" action="<? if(is_ust()) echo "logon.php"; else{ echo "logon_nonust.php"; } ?> ">
		<? $i=1;?>
                <table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" <? altcol($i);?>>Your <font color="#000099">e-Recruit</font> 
                      Login Name :</td>
                    <td width="56%" <? altcol($i);$i=$i*(-1);?>><? echo $loginName;?> </td>
                  </tr>
                  <? if(is_ust()){?>
                  <tr> 
                    <td width="44%" class="normal" <? altcol($i);?>> Your Student/Staff ID Number :</td>
                    <td width="56%" <? altcol($i);$i=$i*(-1);?>><? echo $stuID;?> </td>
                  </tr>          
                  <? }?>        
                  <!--
                  <tr> 
                    <td width="44%" class="normal"> Your Password :</td>
                    <td width="56%"><? echo $password;?> </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Hint Question 
                      if You Forget Password :</td>
                    <td width="56%" bgcolor="ffffcc"><? echo $question;?> </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Answer to Hint Question :</td>
                    <td width="56%"><? echo $answer;?> </td>
                  </tr>
                  -->
                  <tr> 
                    <td width="44%" class="normal" <? altcol($i);?>> First Name(s) 
                      <? //if(!is_ust())echo "(e.g. Tai Man)"; ?>: </td>
                    <td width="56%" class="normal" <? altcol($i);$i=$i*(-1);?>> 
                      <div align="left"><? echo $firstName;?></div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" <? altcol($i);?>> Last Name <? //if(!is_ust())echo "(e.g. Chan )"; ?> :</td>
                    <td width="56%" class="normal" <? altcol($i);$i=$i*(-1);?>> 
                      <div align="left"><? echo $lastName;?></div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" <? altcol($i);?>> Sex :</td>
                    <td width="56%" <? altcol($i);$i=$i*(-1);?>><? if ($sex == "M") echo "Male"; else{ echo "Female";}?> </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" <? altcol($i);?>> Phone No(s)
                      : </td>
                    <td width="56%" <? altcol($i);$i=$i*(-1);?>><? if ($phone == 0) echo "No phone no."; else echo $phone;?> </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" <? altcol($i);?>> Email Address
                      : </td>
                    <td width="56%" class="normal" <? altcol($i);$i=$i*(-1);?>> 
                      <div align="left"><? echo $email;?> </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="tablerow">&nbsp;</td>
                    <td width="56%"> 
                    </td>
                  </tr>
                </table>
Please join our <a href="../mailinglist.php">mailing list</a> to receive email notices of upcoming experiments.
<div align="right"> 
  <input type="submit" name="enter" value="Enter e-Recruit">
</div>

                </form>
<?
	foot();
}
?>
<?
function altcol($i){
	if ($i==1){echo "bgcolor=\"ffffcc\"";}
}


?>
<!----------------------- Main ---------------------------->
<?
if($submit == "Submit"){
	if($loginName == "guest"){ warningx(W0005); exit; }
	if($loginName == ""){ warningx(W0006); exit; }
	if(strstr($loginName, "-") != false || strstr($password, "-") != false)
	  warning("Your login name or password cannot contain '-'.");
	if(is_ust()){
		if(strlen($password) < 4 ){ warningx(W0012); exit; }
		if($password == ""){ warningx(W0013); exit; }
		if($retypepassword == ""){ warningx(W0014); exit; }
		if($password != $retypepassword ){ warningx(W0015); exit; }
	
		if($stuID == ""){ warningx(W0016); exit; }
		if($restuID == ""){ warningx(W0017); exit; }
		if($stuID != $restuID ){ warningx(W0018); exit; }
	}
	//if($question == ""){ warning("Please type in Question!!"); exit; }
	//if($answer == ""){ warning("Please type in Answer!!"); exit; }
	if(!is_ust()) if($firstName == ""){ warningx(W0011); exit; }
	if(!is_ust()) if($lastName == ""){ warningx(W0010); exit; }
	if($sex == "-1"){ warningx(W0009); exit; }
	if($phone != "No Phone number."){
		if($phone != "" && eregi("[^0-9]",$phone)){ warningx(W0047); exit; }
	}
	if($email == ""){ warningx(W0008); exit; }
	if(!is_ust()){if(!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)){ warningx(W0007); exit; }}
	if(!is_ust()){
		if(is_doubleemailfornonust($email)){
			warningx(W0025); exit;
		}
	}
	if(is_doubleloginName($loginName)){
		warningx(W0022); exit;
	}
	if(is_ust() && is_doublestuID($stuID)){
		warningx(W0024); exit;
	}
	if(is_checkbit_setted($mail,$stuID)){
		warningx(W0023); exit;
	}
	else{
		Confirmation();
	}
}else{
	content($title);
}
?>
