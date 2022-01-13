<?
$title="Create Account(for ".ORG_SHORT." students/staff) Confirmation";

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
 		$where = "index.php||Log In->logon.php||Log on(for non ".ORG_SHORT." participants)->createacc_nonust.php||Create Account(for HKUST students/staff)->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
		 ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
	                    <div align="left" class="normal"><br>
              Account Created. We have the followings for your record.  Please read our <a href="./SignUpPolicy.php">Sign Up Policy</a> before you proceed. 
              </div>
              <form name="form1" >

                <table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Your <font color="#000099">e-Recruit</font> 
                      Login Name :</td>
                    <td width="56%" bgcolor="ffffcc">&nbsp; </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Your Password :</td>
                    <td width="56%">&nbsp; </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Hint Question 
                      if You Forget Password :</td>
                    <td width="56%" bgcolor="ffffcc">&nbsp; </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Answer to Hint Question :</td>
                    <td width="56%">&nbsp; </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> First Name(s) 
                      (e.g. Tai Man) : </td>
                    <td width="56%" class="normal" bgcolor="ffffcc"> 
                      <div align="left">Benjamin, Hak-Fung</div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Last Name (e.g. Chan ) :</td>
                    <td width="56%" class="normal"> 
                      <div align="left">Chiao </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc"> Sex :</td>
                    <td width="56%" bgcolor="ffffcc">&nbsp; </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal"> Phone No(s) (e.g. 97123456, 
                      23821234) :</td>
                    <td width="56%">&nbsp; </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="44%" class="normal"> Email Address (e.g. abc@def.com) 
                      : </td>
                    <td width="56%" class="normal"> 
                      <div align="left">hfchiao@ust.hk </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="tablerow">&nbsp;</td>
                    <td width="56%"> 
                      <div align="right"> 
                        <input type="submit" name="enter" value="Enter e-Recruit">
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