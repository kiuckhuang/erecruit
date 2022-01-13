<?
require("../fun/exp_functions.inc");

checkLogin();


//#### Error 3 ####
if(trim($exptitle)==""){	
	warning(T0029);
}

if(trim($otherexp)==""){	
	warning(T0101);
}

if($preRequisite == "yes" && !isset($modify)){
	if(trim($pre2) =="" && trim($pre5) ==""){		
		warning(T0030);
	}
	
		
	if(trim($pre2) != ""){
		$expIDs = explode(",",trim($pre2));
		for($i=0; $i< sizeof($expIDs); $i++){
			if(!expid($expIDs[$i])){
				//T0031
				$wn=T0031."<br>ExperimentID: <font color=\"FF0000\">$expIDs[$i]</font> does not exist!<br>Please input the correct ID\n";
				warning($wn);
			}
		}
	}
	
			
	if(trim($pre5) != ""){
		$expIDs = explode(",",trim($pre5));
		for($i=0; $i< sizeof($expIDs); $i++){
			if(!expid($expIDs[$i])){
				//T0032
				$wn= T0032."<br>ExperimentID: $expIDs[$i] does not exist.<br>Please the input correct ID";
				warning($wn);
			}
		}
	}
	$preRequisite .= "->$pre1";
	$preRequisite .= "->$pre2";
	$preRequisite .= "->$pre3";
	$preRequisite .= "->$pre4";
	$preRequisite .= "->$pre5";
	
}

if($mode=="choose"){
	warning(T0033);
	exit();
}

//  ###################### OLD Step 1 Error Checking #############

if($target=="course" ){
	if($course=="choose" || $course==""){
		warning(T0034);
		exit();
	}
	else{	
			$target .="->".$course;
	}

}
if($target=="pool" ){
	if($pool=="choose" || $pool==""){
		warning(T0035);
		exit();
	}
	else{
		$target .="->".$pool;
	}

}

//  ###################### OLD Step 1 Error Checking #############


// ##################### Step 1 Error Checking######################
/*
	if($target=="course" ){
		if($course=="choose" || $course==""){
			warning("Please choose one course!");
			exit();
		}
		elseif ($course_signupcode==""){
			warning("Please fill in Signup Code!");
			exit();
		}
		else{
			
			if (Signupcode_Match($course_signupcode, $target, $course)){				
			
				$target .="->".$course;
				//message("Step 1 Finished!", "Add_Experiment.php");				
				//exit();
			}
			else{
				warning("Your signup code is invalid!");				
				exit();
			}
		}
	
	}


	if($target=="pool" ){
		if($pool=="choose" || $pool==""){
			warning("Please choose one pool!");
			exit();
		}
		else{
			$target .="->".$pool;
		}
	
	}
*/
// #################### Step 1 End Error Checking#######################



$otherexp = ereg_replace(",", "->", $otherexp);

$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
$experimenters = "$loginName"."->"."$otherexp";



if(!isset($modify)){
$query = "VALUES( 
	'$exptitle',
	'$description',
	'$experimenters',
	'$mode',
	'$sessions',
	'$software',
	'$preRequisite',
	'$target',
	'$category')";

$newexpid = addExperiment($query);
	setcookie( "expid", $newexpid, time()+3600); 
	$msg ="T0037<br>The Experiment has been added. The ID is <font color=\"#FF0000\">$newexpid </font><br>\n";
	
	$msg .= "An experiment may contain many sessions. Subjects can only view the information of this experiment after <font color=\"#FF0000\">ALL</font> session information has been input to e-Recruit.<br>\n";
	
	$msg .= "Please click <a href=\"Add_Session.php\"><img src=\"images/but_ok.gif\" align=\"absmiddle\"  border=\"0\"></a> to add session(s).";

	message_nobut($msg, "Add_Session.php");
	exit();
	
}

else{
$query = "$exptitle||_>$description||_>$experimenters||_>$software||_>$category";
	$condition = "$expid"."->"."$loginName";
			
	if(!checkexpid($condition)){
		warning(T0036);
		exit();	
	}
	if ($sendmail=="on"){
		mail_modexp($expid);
	}
	updateExperiment($query, $expid);
	message(T0038."<br>The Experiment has been updated. The ID is: $expid", "Experimenter_Administration.php");
	exit();
	
}


/*
$otherexp
$exptitle
$mode
$sessions=1
$software
$pre1=have not
$pre2=
$pre3=and
$pre4=have not
$pre5=
$preRequisite=no
$description=
$target=open
$course=choose
$pool=Choose
$Submit=Add
*/
?>