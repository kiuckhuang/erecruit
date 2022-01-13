<?
require("../fun/subject_functions.inc");
if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

	$Loginstr = split("-", $subjectprofile);
	$loginName = $Loginstr[0];
function altcol($i){
	if ($i==1){echo "bgcolor=\"ffffcc\"";}
}

function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $mail,$firstName,$lastName;
	global $loginName,$question,$answer,$sex,$phone,$email,$subscribe;
	$title = "Change Personal Information";
	
	$Loginstr = split("-", $subjectprofile);
	$loginName = $Loginstr[0];
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT loginName,password,firstName,lastName,stuID,sex,phone,email,subscribe FROM subject WHERE loginName = '$loginName'";
	$rs = $db->query($query);
	$loginName = $rs->fields[loginName];
	//$question = $rs->fields[question];
	$stuID = $rs->fields[stuID];
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$sex = $rs->fields[sex];
	$phone = $rs->fields[phone];
	$email = $rs->fields[email];
	$subscribe = $rs->fields[subscribe];
	
	$rs->close();		
	$db->close();
	
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
                <? $i=1;?>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal">Your Desired 
                      <font color="#000099">e-Recruit</font> Login Name :</td>
                    <td width="56%"> 
                      <? echo $loginName;?>
                    </td>
                  </tr>
                  <? if(is_ust()){?>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal">Your Student/Staff ID:</td>
                    <td width="56%"> 
                      <? echo $stuID;?>
                      <input type="hidden" name="stuID" value="<? echo $stuID;?>">
                    </td>
                  </tr>
		  <? }?>
                  <!--
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
                    <td width="44%" class="normal"> Hint Question if You Forget 
                      Password :</td>
                    <td width="56%"> 
                      <input type="text" name="question" value="<? echo $question;?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Answer to 
                      Hint Question :</td>
                    <td width="56%" bgcolor="ffffcc">
                      <input type="text" name="answer"  value="<? echo $answer;?>">
                    </td>
                  </tr>
                  -->
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> First Name(s) (e.g. Tai Man)
                      : </td>
                    <td width="56%" class="normal">

                      <input type="text" name="firstName" value="<? echo $firstName;?>">

                    </td>
                  </tr>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> Last Name (e.g. Chan) 
                      :</td>
                    <td width="56%" class="normal">

                      <input type="text" name="lastName" value="<? echo $lastName;?>">

                    </td>
                  </tr>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> Sex :</td>
                    <td width="56%"> 
                      <select name="sex">
                      	<option value="-1">Pls choose one!</option>
                        <option <? if ($sex == "M") echo "selected"; ?> value="M">Male</option>
                        <option <? if ($sex == "F") echo "selected"; ?>value="F">Female</option>
                      </select>
                    </td>
                  </tr>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> Phone No(s) (e.g. 97467834,23334433) 
                      :</td>
                    <td width="56%"> 
                      <input type="text" name="phone" value="<? if ($phone == 0){ echo "No Phone number."; }else{ echo $phone;} ?>">
                    </td>
                  </tr>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> Email Address (e.g. abc@def.com)
                      : </td>
                    <td width="56%" class="normal">
                       <input type="text" name="email" value="<? echo $email;?>">
                    </td>
                  </tr>
                  <!--
                  <tr> 
                    <td colspan="2" class="normal">Do you want to receive information of upcoming experiments from e-Recruit? Please uncheck the box if you do not want to.
                    <input type="hidden" name="subscribe" value="<? echo $subscribe;?>">
                      <input type="checkbox" name="subscribe" <? if ($subscribe == "Y") echo "checked"; ?>>
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
<?	foot_menu();
	foot();
}
?>

<?
function Confrimation(){
	$title="Change Personal Information Confirmation";
	global $subjectprofile,$mail;
	global $PHP_SELF;
	global $isNon;
	global $loginName,$password,$retypepassword,$question,$answer,$firstName,$lastName,$sex,$phone,$email,$subscribe,$stuID;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<? 
 		$where = "index.php||Log In->logon.php||Log on(for ".$isNon. ORG_SHORT ." participants)->";
		$where .= basename($PHP_SELF)."||".$title;
		position("$where");
		 ?>
              </table>
              <hr noshade align="center" width="98%" size="1">
              <? 
              	if( $subscribe == "on" ) $subscribe = "Y"; else{ $subscribe = "N"; }
              	if( $phone =="" or $phone == "No Phone number.") $phone = 0;
              	$cryptpassword = crypt($password);
              	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		if(is_ust())
		$query = "UPDATE subject SET 
		firstName = '$firstName', 
		lastName = '$lastName', 
		sex = '$sex', 
		phone = $phone, 
		subscribe = 'N' 
		WHERE loginName = '$loginName'";
		else{
		$query = "UPDATE subject SET 
		firstName = '$firstName', 
		lastName = '$lastName', 
		sex = '$sex', 
		phone = $phone, 
		email ='$email', 
		subscribe ='N' 
		WHERE loginName = '$loginName'";
		}
		$rs = $db->query($query);
		$rs->close();		
		$db->close();	/*	optional	*/              
              ?>
              
              
	                    <div align="left" class="normal"><br>
                Account Information has been changed. Thank you. We have the followings for your record. 
              </div>
              <form method="POST" name="form" action="index.php">

                <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <? $i=1;?>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal">Your <font color="#000099">e-Recruit</font> 
                      Login Name :</td>
                    <td width="56%"><? echo $loginName;?> </td>
                  </tr>
                  </tr>
                  <? if(is_ust()){?>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal">Your Student/Staff ID:</td>
                    <td width="56%"> 
                      <? echo $stuID;?>
                    </td>
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
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> First Name(s) 
                      : </td>
                    <td width="56%" class="normal"> 
                      <div align="left"><? echo $firstName;?></div>
                    </td>
                  </tr>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> Last Name :</td>
                    <td width="56%" class="normal"> 
                      <div align="left"><? echo $lastName;?></div>
                    </td>
                  </tr>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> Sex :</td>
                    <td width="56%" class="normal"><? if ($sex == "M") echo "Male"; else{ echo "Female";}?> </td>
                  </tr>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> Phone No(s)
                      :</td>
                    <td width="56%"><? if ($phone == 0){ echo "No phone number."; }else{ echo $phone; }?> </td>
                  </tr>
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="normal"> Email Address 
                      : </td>
                    <td width="56%" class="normal"> 
                      <div align="left"><? echo $email;?> </div>
                    </td>
                  </tr>
                  <!--
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td colspan="2" class="normal">
                      <input type="checkbox" name="subscribe" <? if ($subscribe == "Y") echo "checked"; ?>>
                      Do you want to receive information of upcoming experiments from e-Recruit? Please uncheck the box if you do not want to.</td>
                  </tr>
                  -->
                  <tr <? altcol($i);$i=$i*(-1);?>> 
                    <td width="44%" class="tablerow">&nbsp;</td>
                    <td width="56%"> 
                      <div align="right"> 
                        <!--<input type="submit" name="enter" value="Enter e-Recruit">-->
                      </div>
                    </td>
                  </tr>
                </table>

                </form>
<?
	foot_menu();
	foot();
}
?>
<?
/*
function is_doubleloginName($loginName){
              	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "SELECT loginName FROM subject where loginName='$loginName'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		$rs->close();		
		$db->close();	
		if ($numOfRows)
		return true;
		else{
		return false;
		}
}
*/
?>
<!----------------------- Main ---------------------------->
<?
if($loginName == "guest"){
	warningx(W0004); exit;
}
if($submit == "Submit"){
	if($loginName == ""){ warningx(W0031); exit; }
	//if($question == ""){ warning("Please type in Question!!"); exit; }
	//if($answer == ""){ warning("Please type in Answer!!"); exit; }
	if($firstName == ""){ warningx(W0011); exit; }
	if($lastName == ""){ warningx(W0010); exit; }
	if($sex == "-1"){ warningx(W0009); exit; }
	//if($phone == ""){ warning("Please type in Phone Number!!"); exit; }
	if($email == ""){ warningx(W0008); exit; }
	if($phone != "No Phone number."){
		if($phone != "" && eregi("[^0-9]",$phone)){ warningx(W0047); exit; }
	}
	if(!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)){ warning("Email Format Error<br>\nPlease re-input E-Mail with correct format"); exit; }
	if(0){
		warning("The Login Name already exists. Please choose another one."); exit;
	}
	else{
		Confrimation();
	}
}else{
	content($title);
}
	
	


?>
