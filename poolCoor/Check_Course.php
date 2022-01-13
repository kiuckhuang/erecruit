<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(isset($sendtocouse) && $sendtocouse == "Send to Course Instructor"){
	send_course_detail("$course--$year--$semester");
	
	exit;
}

if($submit =="Add" && course_exist($course."--".$year."--".$semester, $pool)){
	warning(P0006);
	exit();
}

if($course == ""){
	warning(P0007);
	exit();
}

if($firstName ==""){
	warning(P0008);
	exit();
}

if($lastName == ""){
	warning(P0009);
	exit();
}

if($email ==""){
	warning(P0010);
	exit();
}

if(isset($signUpCode) && $signUpCode == ""){
	warning(P0011);
	exit();
}

if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)) {
		
		warning(P0012);
		exit();
}

if($submit=="Modify"){
	$submit = urldecode($courseID);
	//echo $submit;
	//exit();
}

list($poolstr, $aaa, $bbb) = explode("--",$pool);
$addStr = $course."->".$firstName."->".$lastName."->".$email."->".$signUpCode."->".$pool."->".$submit."->".$semester."->".$year."->".$id;


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