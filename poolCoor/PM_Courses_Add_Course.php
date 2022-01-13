<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(!isset($pool))
	warning(P0021);
$poolstr = ereg_replace("--", "  ", $pool);	
$title="Add Course";

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
	//$modify= "CPEG111";
	add_course_layout($modify, "", "");

foot_link();
?>