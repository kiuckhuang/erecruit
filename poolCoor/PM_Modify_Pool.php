<?
include("../fun/poolcoor_functions.inc");
checkLogin();
$title="Modify Pool";

head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 

	       <?
		$where = "index.php||Log on->Pool_Management.php||$poolname Pool Management->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?>

                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">

             
 <?
add_pool_layout($poolname, $pool);
foot_link();
?>