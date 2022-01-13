<?
$title="Create Account(for ".ORG_SHORT." students/staff)";

include("../fun/subject_functions.inc");		

$loginStr = "$loginName"."\t"."$password";
$login_var = explode("-", $expprofile);
if(!isset($loginName))
	$loginName = $login_var[0];



function content($title){
	global $expprofile;
	global $PHP_SELF;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<? 
 		$where = "index.php||Log In->logon_nonust.php||Log on(for non ".ORG_SHORT." participants)->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
 		 ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
	      <form name="form1" >
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Your Desired 
                      <font color="#000099">e-Recruit</font> Login Name :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="loginname" value=" ">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Your Desired Password (min. 
                      4 characters) :</td>
                    <td width="56%"> 
                      <input type="password" name="password">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Retype Password 
                      : </td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="password" name="retypepassword">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Hint Question if You Forget 
                      Password :</td>
                    <td width="56%"> 
                      <input type="text" name="hintquestion" value=" ">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Answer to 
                      Hint Question :</td>
                    <td width="56%" bgcolor="ffffcc">
                      <input type="text" name="hintanswer" value=" ">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> First Name(s) (e.g. Tai Man) 
                      : </td>
                    <td width="56%" class="normal">
                      <input type="text" name="firstname" size="12" value=" ">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Last Name 
                      (e.g. Chan ) :</td>
                    <td width="56%" bgcolor="ffffcc" class="normal">
                      <input type="text" name="lastname" size="12" value=" ">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Sex :</td>
                    <td width="56%"> 
                      <select name="select">
                        <option>Male</option>
                        <option>Female</option>
                      </select>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Phone No(s) 
                      (e.g. 97123456, 23821234) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="phoneno" value=" ">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Email Address (e.g. abc@def.com) 
                      : </td>
                    <td width="56%" class="normal">
                      <input type="text" name="email" size="12" value=" ">
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="2" class="normal"> 
                      <input type="checkbox" name="subscribe" value="checkbox" checked>
                      I want to subscribe to your mail list</td>
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
<?
	foot();
}
?>

<?
  //-------------main-----------
content($title);
  //----------------------------
?>

<?
/*
if(isset($expprofile) && checkcookie($expprofile) ){
	if(isset($radio)){
		$condition = "$radio"."->"."$loginName";
			
		if(!checkexpid($condition)){
			warning("This experiment is not belong to you!");
			exit();	
		}
		
		
		if($adminaction== "View/Modify Experiment"){
			header("Location: ./View-Modify_Experiment.php?expid=$radio");
			exit();
		}
		else if($adminaction== "Delete Experiment"){
			header("Location: ./Delete_Exp.php?expid=$radio");
			exit();
		}
		else if($adminaction=="Session Management"){
			header("Location: ./Session_Management/index.php?expid=$radio");
			exit();
		}
		else{
			echo "testing";
			exit();
		}
	}
	else{
		content($title);
	}
}else{
	warning("Sorry,  Login first!");
}
	
	

*/
?>