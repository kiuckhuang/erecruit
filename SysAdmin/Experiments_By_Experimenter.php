<?
include("../fun/admin_functions.inc");
$title = "Experiments Created by Experimenter";
head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 
		<?
		
		$where = "index.php||Home->Experimenter_Management.php||Experimenter Management->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
                ?>
                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
<?

	
	$no = show_experiments_of_experimenter("$loginName");
	if($no <= 0 ){
	?>
        <tr>
    		<td width="100%" colspan="6">No Experiment available</td>
  	</tr>


	<?
}
?>

 </table>

<?
foot();
?>