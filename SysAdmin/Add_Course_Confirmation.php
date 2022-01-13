<?
include("../fun/admin_functions.inc");
if(isset($sendtocouse) && $sendtocouse == "Send to Course Instructor"){
	send_course_detail($courseidstr);
	exit;
}

if(isset($gotocourse) && $gotocourse == "Go to Course Management"){
	header("Location: System_Management.php");
	exit;
}



$title = "Add Course Confirmation";


head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
  <?
		$where = "index.php||Home->System_Management.php||Course Management->Add_Course.php||Add Course->";
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
