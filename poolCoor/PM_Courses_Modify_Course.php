<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(!isset($pool))
	warning(P0021);
	
$title="Modify Course";
$poolstr = ereg_replace("--", "  ", $pool);
head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Log on->Pool_Management.php||$poolname Pool Management->PM_Courses.php||Manage Course(s): $poolstr Pool->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?>


                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
<?
	$modify= ereg_replace("_", " ", $modifycourseid);
	
	//$signup = "yes";
	add_course_layout($modify, "", "send");

foot_link();
?>
