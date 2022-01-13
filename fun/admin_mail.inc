<?
function send_experimenter_detail($loginName, $password){
	
		global $db;
		
		$query = "SELECT * FROM experimenter Where loginName='$loginName'";
		$rs = $db->query($query);
	
		$rs->firstRow();
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		//$password = $rs->fields[password];
		$sid = $rs->fields[sid];
		$phone = $rs->fields[phone];
		$email = $rs->fields[email];
		$remarks = $rs->fields[remarks];
		$instructor = $rs->fields[instructor];
		$hkust = $rs->fields[hkust];
	
	

$msg = "Dear Experimenter,

The following is your e-Recruit Experimenter account information:
	
	Login Name:		$loginName
	Password  :		$password
	First Name(s):		$firstName
	Last Name :		$lastName
	Staff/Student ID:	$sid
	Phone No:		$phone
	Email Address:		$email
	".ORG_SHORT." Experimenter?	$hkust
	Remarks:		$remarks
	

Regards,
System Administrator";

	$subject = "Message from e-Recruit: Your e-Recruit Experimenter Account Information";
if($email != "")
	adminMail($email, "$subject", "$msg");
	$link = "Experimenter_Management.php";
	message(S0041, $link);
	exit();
}


function send_course_detail($courseidstr){
	global $db;
	global $PHP_SELF;
	
	list($courseID, $year, $semester) = explode("--", $courseidstr);
	$query = "SELECT * FROM course where courseID='$courseID' and year='$year' and semester='$semester'";
	$rs = $db->query($query);
	$rs->firstRow();
	$courseID = $rs->fields[courseID];
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$email = $rs->fields[email];
	$signUpCode = $rs->fields[signUpCode];
	$authcode = $rs->fields[authcode];
	$year = $rs->fields[year];
	$semester = $rs->fields[semester];
$msg = "Dear Instructor,

Your course $courseID has been included in the course experiment list
for this semester.

We have the following for your course:
	
	Course Name:			$courseID
	Year:				$year
	Semester:			$semester
	First Name(s):			$firstName
	Last Name :			$lastName
	Email Address:			$email
	Course Sign Up Code:		$signUpCode
	Course Authorization Code:	$authcode
	
Please inform your students about the sign up code. Only students
with this sign up code can sign up for experiments under this course.

If an expermenter other than you want to add an experiment under your course 
in e-Recruit, you may want to inform him/her about the Course Authorization 
Code. 
	

Regards,
System Administrator";

$subject = "Message from e-Recruit: Your Course Information";
if($email != "")
	adminMail($email, "$subject", "$msg");
	$link = "System_Management.php";
	
	message(S0041, $link);
	exit();
}




function course_ack($firstname, $lastname, $coursecode, $email){
$msg = "Dear Experimenter,

We have received your request to add a course into e-Recruit.
Below is the information you have submitted:
	
	First Name(s):		$firstname
	Last Name :		$lastname
	Course Code:		$coursecode
	Email Address:		$email

You will receive your course sign up code and authorization code
in a day or two.


Regards,
System Administrator";

	$subject = "Message from e-Recruit: Your Experimenter Account";
if($email != "")
	adminMail($email, "$subject", "$msg");
	$link = "Experimenter_Management.php";
	message(S0041, $link);
	exit();
}



// send mail to sysadmin about end of semester day

function ack_semesterday(){
	global $db;
	$query = "select unix_timestamp(max(date)) as maxdate from endsemesterdate"; 
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	$rs->firstRow();
	$maxdate = $rs->fields[maxdate];
	
	if(time() > $maxdate){
		
		$msg = "Dear Administrator,
This is to remind to change the end of semester date 
as the last end of semester date has passed.

";
		$subject = "Change the end of semester date";

		adminMail(ADMIN_MAIL, "$subject", "$msg");
	}
}


// function to get emails and session ids to remind the subjects to attend the session 
function attend_session(){
	global $db;
	$tstamp = time() + 24*3600;
	/*$query = "select id, quota, unix_timestamp(fromdate) as fdate from session 
	where year(fromdate)=year(from_unixtime(unix_timestamp(now()) + 24*3600)) 
	and month(fromdate) = month(from_unixtime(unix_timestamp(now()) + 24*3600)) 
	and dayofmonth(fromdate)=dayofmonth(from_unixtime(unix_timestamp(now()) + 24*3600))";
	*/
	
	$query = "select id, quota, unix_timestamp(fromdate) as fdate from session where 
( 
year(fromdate)=year(from_unixtime(unix_timestamp(now()) + 24*3600)) 
and month(fromdate) = month(from_unixtime(unix_timestamp(now()) + 24*3600)) 
and dayofmonth(fromdate)=dayofmonth(from_unixtime(unix_timestamp(now()) + 24*3600)) 
) or ( 

	( 
	year(dateCreated )=year(from_unixtime(unix_timestamp(now()) - 24*3600)) 
	and month(dateCreated ) = month(from_unixtime(unix_timestamp(now()) - 24*3600)) 
	and dayofmonth(dateCreated )=dayofmonth(from_unixtime(unix_timestamp(now()) - 24*3600)) 
	) and ( 
	year(fromdate)=year(from_unixtime(unix_timestamp(now()) )) 
	and month(fromdate) = month(from_unixtime(unix_timestamp(now()) )) 
	and dayofmonth(fromdate)=dayofmonth(from_unixtime(unix_timestamp(now()) )) 
	) 
) ";
	
//	echo $query ."<br>\n";
	
	$rs = $db->query($query);
	$nRows = $rs->getNumOfRows();
	for($i=0; $i < $nRows; $i++){
		$loginNames = "";
		$rs->moveRow($i);
		$sessionid = $rs->fields[id];
		
		/* now check whether the experiement is enabled or not */
		
		$expid = substr($sessionid, 0, 8);
		$enablequery = "select count(id) as total from experiment where id=$expid and enable='y'";
		$rs2 = $db->query($enablequery);
		$nRows2 = $rs2->getNumOfRows();
		
		// the experiment is enabled
		if($nRows2){
			
			$quota = $rs->fields[quota];
			$fdate = $rs->fields[fdate];
			$query3 = "SELECT distinct loginName FROM waitingList where sessionid=$sessionid order by signOn asc LIMIT 0, $quota";
			$rs3 = $db->query($query3);
			$nRows3 = $rs3->getNumOfRows();
			for($j=0; $j < $nRows3; $j++){
				$rs3->moveRow($j);
				$loginName = $rs3->fields[loginName];
				$loginNames .= $loginName."','";
			}
			$loginNames = substr($loginNames, 0, strlen($loginNames)-3);
			$query4 = "select email from subject where loginName in ('$loginNames')";
			$rs4 = $db->query($query4);
			$nRows4 = $rs4->getNumOfRows();
			for($k=0; $k < $nRows4; $k++){
				$rs4->moveRow($k);
				$email = $rs4->fields[email];
				$emails .= $email.",";
			}
			$emails = substr($emails, 0, strlen($emails)-1);
			attend_session_mail($sessionid, $fdate,$emails);
		}
		
	}
}

		
// function to send the mail remind subject to attend the exp
function attend_session_mail($sessionid, $fdate, $emails){
	$fromdate = date("l jS of F Y h:i:s A", $fdate);
	$msg = "Dear experiment participants,

This is to remind you to attend the session : $sessionid
that you have signed up.  It will start on $fromdate.

Regards,
System Administrator";

	$subject = "Message from e-Recruit: Reminder to Attend Experiment";
if($emails != "")
	adminMail($emails, "$subject", "$msg");
	exit;
}

/* This the send mail wrapper function for adminstrator emmails */
function adminMail($emails, $subject, $msg, $bcc=""){
	mail($emails, "$subject", "$msg", "From: ".ADMIN_MAIL_WITH_NAME."\nReply-To: ".ADMIN_MAIL_WITH_NAME.$bcc."\nX-Mailer: PHP/".phpversion());
	sleep(1);
}

?>