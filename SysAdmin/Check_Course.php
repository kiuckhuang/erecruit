<?
include("../fun/admin_functions.inc");

if(isset($sendtocouse) && $sendtocouse == "Send to Course Instructor"){
	send_course_detail("$course--$year--$semester");
	
	exit;
}


if($submit =="Add" && course_exist("$course--$year--$semester", $pool)){
	warning(S0007);
	exit();
}

if($course == ""){
	warning(S0008);
	exit();
}

if($firstName ==""){
	warning(S0009);
	exit();
}

if($lastName == ""){
	warning(S0010);
	exit();
}

if($email ==""){
	warning(S0011);
	exit();
}

if(isset($signUpCode) && $signUpCode == ""){
	warning(S0012);
	exit();
}


if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)) {
		
		warning(S0013);
		exit();
}

if($authcode == ""){
	warning(S0014);
	exit();
}

if(!eregi("^[0-9]{6}", $authcode)){
	warning(S0015);
	exit();
}


if($submit=="Modify"){
	$submit = urldecode($courseID);
}

$addStr = $course."->".$firstName."->".$lastName."->".$email."->".$signUpCode."->".$authcode."->".$pool."->".$submit."->".$semester."->".$year;

if(add_course($addStr)){

	if(isset($courseID)){
		$title = "Update";
	}else{
		$title = "Add";
	}	
	$para = eregi_replace(" ", "+", "courseidstr=$course--$year--$semester");
	header("Location: Add_Course_Confirmation.php?$para");
	exit;

}

?>
