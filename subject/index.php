<?
$title="Welcome to e-Recruit";

$REMOTE_USER = "";
$REMOTE_PASSWORD = "";
$PHP_AUTH_USER = "";
$PHP_AUTH_PW = "";

require("../fun/subject_functions.inc");		

$loginStr = "$loginName"."\t"."$password";
$login_var = explode("-", $expprofile);
if(!isset($loginName))
	$loginName = $login_var[0];

function content($title){
	global $expprofile;
	global $PHP_SELF;
	//position($title);
	head($title);
?>
	<p>&nbsp;</p>
                <table width="80%" border="0" cellspacing="0" cellpadding="3" align="center" bgcolor="ffffcc">
                  <tr> 
                    <td height="2" class="normal">
                      <div align="center"><a href="../subject-org/login.php"><? echo ORG_SHORT; ?> Students/Staff (<? echo ORG_SHORT; ?> Account Login and Password Required)</a></div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="50%" class="normal">
                      <div align="center"><a href="../subject/logon_nonust.php">Other Participants</a></div>
                    </td>
                  </tr>
                </table>
	<p>&nbsp;</p>
	
<?
	foot();
}
?>

<?
content($title);
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