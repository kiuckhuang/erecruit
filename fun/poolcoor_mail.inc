<?
function send_credit_table($target){
	global $db;
	list($pool, $courseID) = explode("->", $target);

	list($poolname, $poolyear, $poolsemester) = explode("--", $pool);
	$query = "select email, firstName, lastName from poolCoordinator where pool='$poolname'";
	$rs98=$db->query($query);
	
	$poolemail = $rs98->fields[email];
	$poolfirstname = $rs98->fields[firstName];
	$poollastname = $rs98->fields[lastName];
	$poolcoorname = "$poolfirstname $poollastname";
	
	list($course, $year, $semester) = explode("--", $courseID);
	
	$query = "SELECT firstName, lastName, email FROM course where courseID='$course' and year='$year' and semester='$semester' ";
		
	$rs99 = $db->query($query);
	$rs99->firstRow();
	 	
	$firstName = $rs99->fields[firstName];
	$lastName = $rs99->fields[lastName];
	$expemail = $rs99->fields[email];

	$condition = "pool->".$pool;
	$query = "select id, loginName from credit where pool='$pool' and course='$courseID' order by id asc";

	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$id = $rs->fields[id];
		$loginName = $rs->fields[loginName];
		$query = "select sum(credit) as totalcredit from credit where loginName='$loginName'";

		$rs1 = $db->query($query);
		$totalcredit = $rs1->fields[totalcredit];
		
		$query =" select firstName, lastName, email from subject where loginName='$loginName'";

		$rs3 = $db->query($query);
		$rs3->firstRow();
		$firstName = $rs3->fields[firstName];
		$lastName = $rs3->fields[lastName];
		$email = $rs3->fields[email];

		$creditrows .=
"$firstName,$lastName,$email,$totalcredit,";
			$query = "select credit, sessionid from credit where loginName='$loginName' order by id asc";
				$rs3 = $db->query($query);
				$numOfRows2 = $rs3->getNumOfRows();
				for($j=0; $j <$numOfRows2; $j++){
					$rs3->moveRow($j);
					$credit = $rs3->fields[credit];
					$experiementid = substr($rs3->fields[sessionid], 0, 8);
					$sessionid = substr($rs3->fields[sessionid], 8, 2);
					if($sessionid+0 <10){
						$sessionid += 0;
					}
					if($sessionid == 0){
						$sessionid ="1";
					}
					 
					if($credit != 0)
					$creditrows .=
$credit."credit(s) from Exp ID ".$experiementid." Session $sessionid; ";
					
				}
			$creditrows .="\n";	
}
	
	$subject = "IMPORTANT: Credit Information for $courseID from e-Recruit";
	$message = "Dear Course Instructor:

Please do NOT delete this email.

The following is the credit information we have gathered from experimenters
in the $poolname Subject Pool. The table below contains names of students 
who have decided to assign their earned credits to your $courseID.

As a rule from the Pool, all course instructors in this Pool should assign
credits to their students based on the information below. As more experiments
will be run throughout the semester, updates of the table will be sent to you 
in the first week of each month.  The last one will be sent at the end of the
semester. You are advised to save all emails just mentioned. Though copies of
these emails will be stored in a number of other places, in the unlikely event
that e-Recruit fails and all contingent measures (i.e.,tape backup by the SBM 
technical team, etc.) do not help much, we may have to contact you for the
emails.  Thank you.

Regards,

$poolcoorname
$poolname Pool Coordinator

Below is the credit information:
First Name(s),Last Name,Email,Total Credits Earned,Credits Breakdown
$creditrows

";
	
	poolMail($expemail, "$subject", "$message", $poolemail);

}


function send_course_detail($courseidstr){
	global $db;
	global $PHP_SELF;
	global $pool;
	
	list($poolname, $poolyear, $poolsemester) = explode("--", $pool);
	$query = "select signUpCode, authcode from pool where id='$poolname' and year=$poolyear and semester='$poolsemester'";
	$rs=$db->query($query);
	$signUpCode = $rs->fields[signUpCode];
	$authcode = $rs->fields[authcode];
	
	$query = "select email, firstName, lastName from poolCoordinator where pool='$poolname'";
	$rs98=$db->query($query);
	
	$poolemail = $rs98->fields[email];
	$poolfirstname = $rs98->fields[firstName];
	$poollastname = $rs98->fields[lastName];
	$poolcoorname = "$poolfirstname $poollastname";
	
	list($courseID, $year, $semester) = explode("--", $courseidstr);
	$query = "SELECT * FROM course where courseID='$courseID' and year='$year' and semester='$semester'";
	$rs = $db->query($query);
	$rs->firstRow();
	$courseID = $rs->fields[courseID];
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$email = $rs->fields[email];
	$year = $rs->fields[year];
	$semester = $rs->fields[semester];
	
$msg = "Dear Instructor,

Your course $courseID has been included in the $poolname $poolyear $poolsemester pool.

We have the following for your course:
	
	Course Name:		$courseID
	Year:			$year
	Semester:		$semester
	First Name(s):		$firstName
	Last Name:		$lastName
	Email Address:		$email
	Pool Sign up Code:	$signUpCode
	Pool Authorization Code:$authcode
	
There are some courses being included in this pool. Students in these courses
will be given the Sign up Code. Only students with this code are able to sign 
up for experiments in this pool. Please inform your students about this code.  

If an expermenter other than you want to add an experiment in this pool in 
e-Recruit, you may want to inform him/her about the Pool Authorization Code. 
 
	

Regards,
$poolcoorname
$poolname Pool Coordinator";

$subject = "Message from e-Rrecruit: Your course has been added to $poolname $poolyear $poolsemester";
if($email != "")
	poolMail($email, "$subject", "$msg", $poolemail);
	$link = "PM_Courses.php";
	message(S0041, $link);
	exit();
}

function poolMail($email, $subject, $msg, $poolmail, $bcc=""){
	mail($email, "$subject", "$msg", "From: ".$poolemail."\nReply-To: ".$poolemail."\nX-Mailer: PHP/".phpversion());
	sleep(1);
}
?>