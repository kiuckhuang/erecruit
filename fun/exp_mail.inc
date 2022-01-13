<?
if (!defined("_PHPDB_ABSTRACT_LAYER")) {
  define("_PHPDB_ABSTRACT_LAYER", 1 );
}

require("../fun/errmsg.inc");
function mail_newexp($expid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");	
	//Get the details of experiment
	$query = "select title, experimenters, description, sessions from experiment where id = '$expid'";	
	$rs = $db->query($query);
	$rs->firstRow();
	$sessions = $rs->fields[sessions];
	$title = $rs->fields[title];
	$description  = $rs->fields[description];
	$experimenters  = $rs->fields[experimenters];
	
	//Get the details of experimenter
	$exps = explode("->", $experimenters);
	$query = "select firstName, lastName, email from experimenter where loginName='$exps[0]'";
	$rs = $db->query($query);
	$rs->firstRow();	
	$expname  = $rs->fields[firstName]." ".$rs->fields[lastName];
	$expemail = $rs->fields[email];
	for($i=1; $i< sizeof($exps); $i++){
		if($i==(sizeof($exps)-1))
			$expnames .= $exps[$i];		
		else
			$expnames .= $exps[$i].", ";
	}
	if ($expnames!=""){
	
	}
	else{
		$expnames = $expname;
	}
	//Get the details of session
	$query = "select * from session where id like '$expid%'";
	$rs = $db->query($query);
	$rs->firstRow();
	$num_sess = $rs->getNumOfRows();      
	for($i=1; $i<= $num_sess; $i++){
        	$rs->moveRow($i - 1);
        	$sessiontitle = $rs->fields[title];
        	$fromdate = $rs->fields[fromdate];
        	$duration = $rs->fields[durationEnd];
               	$venue = $rs->fields[venue];
        	$reward = $rs->fields[reward];
        	$quota = $rs->fields[quota];        	
        	     	
        	$year = substr($fromdate, 0, 4);
        	$month = substr($fromdate, 4, 2);
        	$date = substr($fromdate, 6, 2);
        	$hour = substr($fromdate, 8, 2);
        	$min = substr($fromdate, 10, 2);
            	$rewardtype = explode("->", $reward);            	
            	$duration = explode("-", $duration);             	            	
            	
        	if ($rewardtype[0] == "money"){
        		$reward = "Money : ".$rewardtype[1]." amount of ".$rewardtype[2]." will be given to each participant.";
		}
		else if ($rewardtype[0] == "credit"){
			$reward = "Credit : ".$rewardtype[1]." number of ".$rewardtype[2]." will be given to each participant.";
		}
		else if ($rewardtype[0] == "creditmoney"){
			$reward = $rewardtype[1]." amount of ".$rewardtype[2]." and ".strtolower($rewardtype[3])." number of ".$rewardtype[4]." credit(s) will be given to each participant.";
		}
		$session_details = $session_details."
$sessiontitle :
Date: 			$date/$month/$year
Time:			$hour:$min
Approximate Duration: 	$duration[0] day(s) $duration[1] hour(s) $duration[2] minute(s)
Venue:			$venue
Reward:			$reward	
Quota:			$quota
";
	}

	
	
	//Create the Mailing List
	$query = "select target from experiment where id = '$expid'";
	$rs = $db->query($query);
	$rs->firstRow();
	$target = $rs->fields[target];
	$cont_target = $target;
	$target = explode("->", $target);

	if ($target[0] == "open"){
		$query = "select DISTINCT email from mailinglist_public";
		$rs = $db->query($query);
		$num = $rs->getNumOfRows();      
        	for($i=0; $i< $num; $i++){
        		$rs->moveRow($i);
        		if($i != $num-1){
        			$subjectmail .= $rs->fields[email].",";
				}else{
					$subjectmail .= $rs->fields[email];
				}
		}
	}else if ($target[0] == "pool"){
		$query = "select DISTINCT email from mailinglist_course";
		$rs = $db->query($query);
		$num = $rs->getNumOfRows();      
        	for($i=0; $i< $num; $i++){
        		$rs->moveRow($i);
        		if($i != $num-1){
        			$subjectmail .= $rs->fields[email].",";
				}else{
					$subjectmail .= $rs->fields[email];
				}
		}
	}else if ($target[0] == "course") {
	$query = "select DISTINCT email from mailinglist_course where course='$target[1]'";

		$rs = $db->query($query);
		$num = $rs->getNumOfRows();      
        	for($i=0; $i< $num; $i++){
        		$rs->moveRow($i);
        		if($i != $num-1){
        			$subjectmail .= $rs->fields[email].",";
				}else{
					$subjectmail .= $rs->fields[email];
				}
		}
	}

	$mailinglistURL = RECRUIT_URL ."mailinglist.php";
	$recruitURL = RECRUIT_URL;

	$message = "A new experiment has been added to e-Recruit. The details are:";
	$message2 = "You have added a new experiment to e-Recruit. The details are:";
	$msg_var ="
Experiment ID:		$expid
Experiment Title:	$title
Experimenter(s):	$expnames
Description:		
$description


***Below are the details of each session of the experiment***
".$session_details;
	$msg_end ="
To unsubscribe any e-Recruit mailing lists, please go to 
$mailinglistURL

To sign up for this experiment, please visit $recruitURL

Regards,
System Administrator";

$msg_end2 ="

Regards,
System Administrator";


	$subject = "Message from e-Recruit: Upcoming Experiment";
	$message = $message.$msg_var.$msg_end;
	$message2 = $message2.$msg_var.$msg_end2;
	
	
	mail(ADMIN_MAIL, "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: ".ADMIN_MAIL."\nX-Mailer: PHP/".phpversion()."\nBcc: ".$subjectmail);
	sleep(1);
	mail($expemail, "$subject", "$message2", "From: ".ADMIN_MAIL."\nReply-To: ".ADMIN_MAIL."\nX-Mailer: PHP/".phpversion());
	sleep(1);	
	
}

function mail_delexp($expid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");	
	//Get the details of experiment
	$query = "select title, experimenters, description, sessions from experiment where id = '$expid'";	
	$rs = $db->query($query);
	$rs->firstRow();
	$sessions = $rs->fields[sessions];
	$title = $rs->fields[title];
	$description  = $rs->fields[description];
	$experimenters  = $rs->fields[experimenters];
	
	//Get the details of experimenter
	$exps = explode("->", $experimenters);
	$query = "select firstName, lastName, email from experimenter where loginName='$exps[0]'";
	$rs = $db->query($query);
	$rs->firstRow();	
	$expname  = $rs->fields[lastName]." ".$rs->fields[firstName];
	$expemail = $rs->fields[email];
	for($i=1; $i< sizeof($exps); $i++){
		$expnames .= $exps[$i];
	}	
	$expnames = $expnames;

	
	//Create the Mailing List
	$query = "select DISTINCT loginName from waitingList where sessionid like '$expid%'";
	$rs = $db->query($query);     	
	$num = $rs->getNumOfRows();      
        for($i=0; $i< $num; $i++){
        	$rs->moveRow($i);     
        	$loginName = $rs->fields[loginName];   	
        	$query = "select email from subject where loginName='$loginName'";
        	$rs1 = $db->query($query);
			$this_email = $rs1->fields[email];        	        	 	
        	if($i != $num-1){
        		$subjectmail .= $this_email.",";
			}else{
				$subjectmail .= $this_email.",".$expemail;
			}
	}

	$message = "This email is to notify you about the CANCELLATION of the following experiment:";
	$msg_var ="
Experiment ID:		$expid
Experiment Title:	$title
Experimenter(s):	$expnames
Description:		$description
Sessions:		$sessions
";
	$subject = "Message from e-Recruit: Cancellation of Experiment";
	$message = $message.$msg_var;
	

	mail($subjectmail, "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: ".ADMIN_MAIL."\nX-Mailer: PHP/".phpversion());
	sleep(1);
}



function mail_modsess($expid, $sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");	
	//Get the details of experiment
	$query = "select title, experimenters, description, sessions, mode from experiment where id = '$expid'";	
	$rs = $db->query($query);
	$rs->firstRow();
	$sessions = $rs->fields[sessions];
	$title = $rs->fields[title];
	$description  = $rs->fields[description];
	$experimenters  = $rs->fields[experimenters];
	//Used to determine the mail receipient
	$expmode = $rs->fields[mode];
	
	//Get the details of experimenter
	$exps = explode("->", $experimenters);
	$query = "select firstName, lastName, email from experimenter where loginName='$exps[0]'";
	$rs = $db->query($query);
	$rs->firstRow();	
	$expname  = $rs->fields[firstName]." ".$rs->fields[lastName];
	$expemail = $rs->fields[email];
	for($i=1; $i< sizeof($exps); $i++){
		$expnames .= $exps[$i];
	}	

	$expnames = $expnames;
	
	
	//Get the details of session
	$query = "select * from session where id=$sessionid";
	$rs = $db->query($query);
	$rs->firstRow();
	$sessiontitle = $rs->fields[title];
        $fromdate = $rs->fields[fromdate];
        $duration = $rs->fields[durationEnd];
      	$venue = $rs->fields[venue];
       	$reward = $rs->fields[reward];
       	$duration = $rs->fields[durationEnd];
       	$quota = $rs->fields[quota];
       	$description = $rs->fields[description];
       		     	
       	$year = substr($fromdate, 0, 4);
       	$month = substr($fromdate, 4, 2);
       	$date = substr($fromdate, 6, 2);
       	$hour = substr($fromdate, 8, 2);
       	$min = substr($fromdate, 10, 2);       	       	     	       	
   	$rewardtype = explode("->", $reward);
   	$duration = explode("-", $duration);
       	if ($rewardtype[0] == "money"){
       		$reward = "Money : ".$rewardtype[1]." amount of ".$rewardtype[2]." will be given.";
	}
	else if ($rewardtype[0] == "credit"){
		$reward = "Credit : ".$rewardtype[1]." number of ".$rewardtype[2]." will be given.";
	}
	else if ($rewardtype[0] == "creditmoney"){
		$reward = $rewardtype[1]." amount of ".$rewardtype[2]."[money] and ".$rewardtype[3]." number of ".$rewardtype[4]."[credit(s)] will be given.";
	}
	
	
	$session_details = "
$sessiontitle :
Date: 			$date/$month/$year
Time:			$hour:$min
Approximate Duration: 	$duration[0] day(s) $duration[1] hour(s) $duration[2] minute(s)
Venue:			$venue
Reward:			$reward	
Quota:			$quota
";



	$query = "select DISTINCT loginName from waitingList where sessionid=$sessionid";
	$rs = $db->query($query);     	
	$num = $rs->getNumOfRows();      
        for($i=0; $i< $num; $i++){
        	$rs->moveRow($i);     
        	$loginName = $rs->fields[loginName];   	
        	$query = "select email from subject where loginName='$loginName'";
        	$rs1 = $db->query($query);
		$this_email = $rs1->fields[email];        	        	 	
        	if($i != $num-1)
        		$subjectmail .= $this_email.",";
		else
			$subjectmail .= $this_email.",".$expemail;
	}

	$message = "This email is to notify you the amendments of the following experiment that you have signed up. The updated details are:";	
	$msg_var ="
Experiment ID:		$expid
Experiment Title:	$title
Experimenter(s):	$expnames
Description:		$description
".$session_details;
	
	$subject = "Message from e-Recruit: Modification of Experiment Details";
	$message = $message.$msg_var;
	mail($subjectmail, "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: ".ADMIN_MAIL."\nX-Mailer: PHP/".phpversion());
	sleep(1);
}


function mail_modexp($expid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");	
	//Get the details of experiment
	$query = "select title, experimenters, description, sessions from experiment where id = '$expid'";	
	$rs = $db->query($query);
	$rs->firstRow();	
	$title = $rs->fields[title];
	$description  = $rs->fields[description];
	$experimenters  = $rs->fields[experimenters];
	
	//Get the details of experimenter
	$exps = explode("->", $experimenters);
	$query = "select firstName, lastName, email from experimenter where loginName='$exps[0]'";
	$rs = $db->query($query);
	$rs->firstRow();	
	$expname  = $rs->fields[firstName]." ".$rs->fields[lastName];
	$expemail = $rs->fields[email];
	for($i=1; $i< sizeof($exps); $i++){
		$expnames .= $exps[$i];
	}	

	$expnames = $expnames;
	
	//Create the Mailing List
	//for one, all, open, we will email to all subjects in waiting list
	$query = "select DISTINCT loginName from waitingList where sessionid like '$expid%'";
	$rs = $db->query($query);     	
	$num = $rs->getNumOfRows();      
        for($i=0; $i< $num; $i++){
        	$rs->moveRow($i);     
        	$loginName = $rs->fields[loginName];   	
        	//echo $loginName;
        	$query = "select email from subject where loginName='$loginName'";
        	$rs1 = $db->query($query);
		$this_email = $rs1->fields[email];        	        	 	
        	if($i != $num-1)
        		$subjectmail .= $this_email.",";
		else
			$subjectmail .= $this_email;
	}

	$message = "This email is to notify you the amendments of the following experiment that you have signed up. The updated details are:";	
	$msg_var ="
Experiment ID:		$expid
Experiment Title:	$title
Experimenter(s):	$expnames
Description:		
$description
";
	
	$subject = "Message from e-Recruit: Modification of Experiment Details";
	$message = $message.$msg_var;
	mail($expemail, "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: ".ADMIN_MAIL."\nX-Mailer: PHP/".phpversion()."\nBcc: ".$subjectmail);
	sleep(1);
}


function hkust_experimenter_ack($firstname, $lastname, $email, $sid, $phone, $remarks){
if($remarks == ""){
	$remarks ="Nil";
}
if($phone == ""){
	$phone ="Nil";
}


$msg = "
We have received your request to set up an experimenter account in e-Recruit.
Below is the information you have submitted:
	
	First Name(s):		$firstname
	Last Name :		$lastname
	Email Address:		$email
	Staff/Student ID:	$sid
	Phone No:		$phone
	Remarks:		$remarks

You will receive your login name and password in three days if your application is successful.	

Regards,
System Administrator";

	$subject = "Message from e-Recruit: Your Experimenter Account";
if($email != "")
{
	mail($email, "$subject", "$msg", "From: ".ADMIN_MAIL_WITH_NAME."\nReply-To: ".ADMIN_MAIL_WITH_NAME."\nX-Mailer: PHP/".phpversion());
	sleep(1);
}
	mail(ADMIN_MAIL, "$subject", "$msg", "From: ".ADMIN_MAIL."\nReply-To: ".ADMIN_MAIL."\nX-Mailer: PHP/".phpversion());
	sleep(1);
	
	$link = "../";
	message(T0098, $link);
	exit();
}

function nonhkust_experimenter_ack($firstname, $lastname, $email, $phone, $remarks){
if($remarks == ""){
	$remarks ="Nil";
}
if($phone == ""){
	$phone ="Nil";
}


$msg = "
We have received your request to set up an experimenter account in e-Recruit.
Below is the information you submitted:
	
	First Name(s):		$firstname
	Last Name :		$lastname
	Email Address:		$email
	Phone No:		$phone
	Remarks:		$remarks
	
You will receive your login name and password in three days if your application is successful.

Regards,
System Administrator";

	$subject = "Message from e-Recruit: Your Experimenter Account";
if($email != "")
	mail($email, "$subject", "$msg", "From: ".ADMIN_MAIL_WITH_NAME."\nReply-To: ".ADMIN_MAIL_WITH_NAME."\nX-Mailer: PHP/".phpversion());
	sleep(1);
	$link = "../";
	message(T0098, $link);
	exit();
}
?>
