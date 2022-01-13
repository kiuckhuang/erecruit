<?
include("../fun/poolcoor_functions.inc");
if(isset($sendtocouse) && $sendtocouse == "Send to Course Instructor"){
	send_course_detail($courseidstr);
	exit;
}

if(isset($gotocourse) && $gotocourse == "Go to Course Management"){
	header("Location: PM_Courses.php");
	exit;
}



$title = "Add Course Confirmation";


head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
  <?
		
		$where = "index.php||Log on->Pool_Management.php||".$poolstr." Pool Management->PM_Courses.php||Courses->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
?>
                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
<?
	
	show_course_layout($courseidstr);

foot();
?>
