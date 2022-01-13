<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(!isset($pool))
	warning(P0021);

if(isset($sendmail) && $sendmail=="Send Mail"){
	sendmail("experimenter");
}


$poolstr = ereg_replace("--", "  ", $pool);	
$title="Manage Pool Experiment(s): $poolstr";

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
              <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
               
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td width="5%" class="tablecolumn">Select</td>
                    <td width="10%" class="tablecolumn">Experiment ID</td>
                    <td width="25%" class="tablecolumn">Experiment Title</td>
                    <td width="10%" class="tablecolumn">Experimenter First Name</td>
                    <td width="10%" class="tablecolumn">Experimenter Last Name</td>
                    <td width="10%" class="tablecolumn">Session</td>
                    <td width="10%" class="tablecolumn">Attendance and  Credit Records Submitted on</td>
                    <td width="20%" class="tablecolumn">Deadline for submitting Attendance and Credits Records</td>
                  </tr>
                  <?
                  	$no = show_pool_experiments($pool, $selectall);
                  	if($no<1){
                  	?>
                  	<tr>
    				<td width="100%" colspan="6">No experiment is available</td>
  			</tr>
			<?
			}
                  ?>
                  
                </table>
		<br>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td> 
                      <div align="left">
                        <input type="submit" name="selectall" value="Select All Boxes">
                      </div>
                    </td>
                  </tr>
                </table>

	                  
              <hr width="98%" size="1" noshade align="center">
<?
		mail_form("experimenter");
	
?>	
	</form>
<?
foot_link();
?>