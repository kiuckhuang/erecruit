<?
require("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

$title="Template";

function content($title){
	global $expprofile;
	global $PHP_SELF;
	global $isNon;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->logon_nonust.php||Log on(for non ".ORG_SHORT." participants)->createacc_nonust.php||Create Account(for HKUST students/staff)->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where"); ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">

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

if(isset($subjectprofile)){
	if(false){
		/*
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
		*/
	}
	else{
		content($title);
	}
}else{
	warning("Sorry,  Login first!");
}
?>