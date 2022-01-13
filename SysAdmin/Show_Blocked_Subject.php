<?
include("../fun/admin_functions.inc");
if(isset($sendmail) && $sendmail=="Send Mail"){
	sendmail("subject");
}
$title = "Blocked Subjects List";
head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Home->Subject_Management.php||Subject Management->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?>
                  	
                  
                  
                </tr>
              </table>
              <hr noshade align="center" width="98%" size="1">
              <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
              <input type="hidden" name="type" value="<? echo $type; ?>">
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td width="10%" class="tablecolumn">Select</td>
                    <td width="20%" class="tablecolumn" bgcolor="#000099">First Name(s)</td>
                    <td width="15%" class="tablecolumn">Last Name</td>
                    <td width="10%" class="tablecolumn">Sex</td>
                    <td width="10%" class="tablecolumn">Phone</td>
                    <td width="20%" class="tablecolumn">Email</td>
                    <td width="15%" class="tablecolumn">*<? echo ORG_SHORT; ?> Subjects?</td>
                  </tr>
                  <?
                  	//$conditionStr = $showsub1."->".$showsub2."->".$showsub3."->".$showsub4."->".$showsub5."->".$submit;
                  	$conditionStr = $type."->".$submit;
                  	$no = show_blocked_subjects($conditionStr);
                  	if($no <= 0){
                  	?>
                  	<tr>
    				<td width="100%" colspan="7">No Subject Found</td>
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
                        <input type="submit" name="submit" value="Select All Participant(s)">
                      </div>
                    </td>
                  </tr>
                </table>
                
              <hr width="98%" size="1" noshade align="center">
              
                <?
mail_form("subject");
?>

              </form>
              <p class="notes"><i>* Information of sex and phone for <? echo ORG_SHORT; ?>
subjects is given by subjects. All information for non-<? echo ORG_SHORT; ?> subjects is
provided by subjects.</i></p>
 <?
foot();
?>
