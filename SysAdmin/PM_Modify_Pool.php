<?
include("../fun/admin_functions.inc");
	
$title="Modify Pool";

head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 

	       <?
		$where = "index.php||Home->Pool_Management.php||Subject Pool Management->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?>

                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">

             
 <?
add_pool_layout($pool);
foot();
?>