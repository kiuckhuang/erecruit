<?
include("../fun/admin_functions.inc");


$title = "Modify Course";


head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
  <?
		$where = "index.php||Home->System_Management.php||Course Management->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
?>
                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
<?
	$modify= ereg_replace("_", " ", $courseID);
	$signup = "yes";
	add_course_layout($modify, $signup, "send");

foot();
?>
