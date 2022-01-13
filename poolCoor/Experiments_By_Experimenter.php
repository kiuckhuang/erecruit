<?
include("../fun/admin_functions.inc");
checkLogin();
$title = "Experiments Created by Experimenter";
head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 
		<?
		
		$where = "index.php||Log on->home.php||System Administration->Experimenter_Management.php||Experimenter Management->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
                ?>
                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
<?

	
	show_experiments_of_experimenter("$loginName");
?>
              

              <hr width="98%" size="1" noshade align="center">

              
<?
foot_link();
?>