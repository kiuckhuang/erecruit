<?
include("../fun/admin_functions.inc");

if(!checkdate($month, $day, $year)){
	warning(S0037);
}
else{
	save_semesterday($year, $month, $day);
	$link = "Subject_Management.php";
	message(S0038, $link);
}



?>