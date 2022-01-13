<?
//this function will sent the mail to the non-ust subject who first time to create the account
function mail_nonustsubject_newac($firstName,$lastName,$loginName,$password,$email){
	$header = "From: ".ADMIN_MAIL_WITH_NAME."\nReply-To: ".ADMIN_MAIL_WITH_NAME."\nX-Mailer: PHP/".phpversion();
	
	$subject = "Message from e-Recruit: Your New Account Password";
	
	$message = "
Here is your new e-Recruit password. Please use it to log in e-Recruit (". RECRUIT_URL .") next time.

		Last Name:	$lastName
		First Name:	$firstName
		Login Name:	$loginName
		New Password:	$password		
";
	mail($email,$subject,$message, $header);
}

//this will sent the mail to the subject who change the password
function mail_subject_changepd($firstName,$lastName,$loginName,$password,$email){
	/*
	$message = "
Message from e-Recruit: You have changed your e-Recruit account. Please use the new password to log in e-Recruit next time.

		Last Name:	$lastName
		First Name:	$firstName
		Login Name:	$loginName
		New Password:	$password	
";
	$m = new email("Your new e-Recruit account", $message, "e-Recruit System Admin", "sysadmin@recruit.bm.ust.hk", "", "", $email, "sysadmin@recruit.bm.ust.hk");
	
	$m->send();
	*/
}

//this will sent the mail to subject who forget the password and reset the password also
function mail_subjects_forgetpassword($loginName){
	$header = "From: ".ADMIN_MAIL_WITH_NAME."\nReply-To: ".ADMIN_MAIL_WITH_NAME."\nX-Mailer: PHP/".phpversion();
	
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select firstName, lastName, email from subject where loginName = '$loginName'";
	$rs = $db->query($query);
	$rs->firstRow();
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$email  = $rs->fields[email];
	
	$random = MD5( TIME() );
	$randompassword = substr($random,0,8);
	$cryptpassword = crypt($randompassword);
	$query2 = "update subject set password = '$cryptpassword' where loginName = '$loginName'";
	$rs = $db->query($query2);
	
	$subject = "Message from e-Recruit: Your New Account Password";
	
	$message = "
Here is your new e-Recruit password. Please use it to log in e-Recruit (". RECRUIT_URL .") next time.

		Last Name:	$lastName
		First Name:	$firstName
		Login Name:	$loginName
		New Password:	$randompassword		
";
	$rs->close();
	$db->close();	
	mail($email,$subject,$message, $header);
}

//this will sent the mail to the subject who in the waiting of the session and now moved to enrolled.
function mail_subject_wait_to_enrolled($loginName,$sessionid){
	$header = "From: ".ADMIN_MAIL_WITH_NAME."\nReply-To: ".ADMIN_MAIL_WITH_NAME."\nX-Mailer: PHP/".phpversion();

	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query2 = "select firstName, lastName, email from subject where loginName = '$loginName' ";
	$rs = $db->query($query2);
	//$numOfRows = $rs->getNumOfRows();
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$email = $rs->fields[email];
	
	$expid = substr($sessionid,0,8);
	$query3 = "select title, experimenters, description from experiment where id = '$expid' ";
	$rs = $db->query($query3);
	$exptitle = $rs->fields[title];
	$experimenters = $rs->fields[experimenters];
	$description = $rs->fields[description];
	$experimenters = experimentersstr($experimenters);
	
	$query4="select title, reward, UNIX_TIMESTAMP(fromdate) as fromdate, durationEnd, venue, quota, enrolled, UNIX_TIMESTAMP(dateCreated) as dateCreated from session where id = '$sessionid'";
	$rs = $db->query($query4);
	$title = $rs->fields[title];
	$reward = $rs->fields[reward];
	$fromdate = $rs->fields[fromdate];
	$durationEnd = $rs->fields[durationEnd];
	$venue = $rs->fields[venue];
	$quota = $rs->fields[quota];
	$enrolled = $rs->fields[enrolled];
	$dateCreated = $rs->fields[dateCreated];
	
	$starttime = date("g:i a", $fromdate);
	$startdate = date("d M Y", $fromdate);
	$duration = split("-", $durationEnd);
	$Duration = $duration[0]." day(s) ".$duration[1]." hr(s) ".$duration[2]." min(s)";
	$rewardstr = rewardstr($reward);
	$subject = "Message from e-Recruit: Promotion from Waiting List to Signed-up List";
	$message = "

	 You have been promoted from the waiting list to the signed-up list. 
	 You can now attend the following experiment:

		Experiment ID:		$expid
		Experiment Title:	$exptitle
		Experimenter(s):	$experimenters
		Description:		$description
		Session Title:		$title
		Start Date:		$startdate
		Start Time:		$starttime
		Approximate Duration:	$Duration
		Venue:			$venue
		Reward:			$rewardstr
		
	You need to present a Sign up Confirmation Sheet to experimenters. Please log in e-Recruit (". RECRUIT_URL .") and go to \"My Experiments\" to print out the sheet.
	
Regards,
System Administrator
";
	mail($email,$subject,$message, $header);
	$rs->close();
	$db->close();
}



?>
