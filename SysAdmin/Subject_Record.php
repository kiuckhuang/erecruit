<?
include("../fun/admin_functions.inc");
if(isset($sendmail) && $sendmail=="Send Mail"){
sendmail("subject");
	
}

$title = "Subject Record";
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
                <p align="left" class="normal">You have searched for the following information:</p>
                   
                  <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td class="tablecolumn">Select</td>
                    <td class="tablecolumn">First Name(s)</td>
                    <td class="tablecolumn">Last Name</td>
                    <td class="tablecolumn">Login Name</td>
                    <td class="tablecolumn">Sex</td>
                    <td class="tablecolumn">Phone</td>
                    <td class="tablecolumn">Email</td>
                    <td class="tablecolumn">SID</td>
                    <td class="tablecolumn">*<? echo ORG_SHORT; ?> Subjects?</td>
                  </tr>
                  <?	
                  	
                  	/*
                  	echo "$search<br>";
                  	echo "$firstName<br>";
                  	echo "$lastName<br>";
                  	*/
                  	if(!isset($condition)){
                  		if($search == "name"){
                  			$condition = "$search"."->"."$firstName"."->"."$lastName";
                  		}else{
                  			$condition = $email;
                  		}
                  	}
                  	//echo "$condition<br>";
                  	$no = show_subject_record($condition, $selectall);
                  	if($no == 0){
                  	?>
                  	<tr>
    				<td width="100%" colspan="9">No Subject Found</td>
  			</tr>
			<?
			}
                  ?>
                  
                </table>
                <br>
                <input type="hidden" name="condition" value="<? echo $condition; ?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input type="submit" name="selectall" value="Select All Boxes"></td>
                  </tr>
                </table>
               
              <hr width="98%" size="1" noshade align="center">
<?
mail_form("subject");
?>
              </form>
              
              <p class="notes"><i>* Information of sex and phone for <? echo ORG_SHORT; ?>
 subjects was given by subjects. All information for non-<? echo ORG_SHORT; ?> subjects was
provided by subjects.</i></p>
              
<?
foot();
?>
