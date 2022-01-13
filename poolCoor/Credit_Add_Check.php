<?
include("../fun/poolcoor_functions.inc");
checkLogin();                 
if($firstName==""){
	warning(P0008);
	exit();
}

if($lastName==""){
	warning(P0009);
	exit();
}


if($email==""){
	warning(P0010);
	exit();
}

if($submit != "Add"){
	$submit = $id; 
}


add_student($firstName, $lastName, $email, $submit, $courseID, $pool);
$link = "PM_Courses_Credits_Students_Earned.php";
message("(Message no.P1002)Student with First Name: $firstName successfully added", $link);

?>


	
