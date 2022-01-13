<?
include("../fun/admin_functions.inc");
if(isset($sendmail) && $sendmail=="Send Mail"){
	if(isset($total) && $total >= 0 ){
		
		for($i=0; $i<$total; $i++){
			if($checkbox[$i] == "on"){
				$email = $email[$i];
				$ccmail = explode(",", $cc);
				
				for($i = 0; $i< sizeof($ccmail); $i++){
					if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $ccmail[$i]) && trim($ccmail[$i]) !="") {
  						warning(P0012);
					}
					if(trim($ccmail[$i]) !="")
					mail("$ccmail[$i]", "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: recruit@cebr.ust.hk\nX-Mailer: PHP/".phpversion());
				}
				
.				mail("$email", "$subject", "$message", "From: ".ADMIN_MAIL."recruit@cebr.ust.hk\nReply-To: recruit@cebr.ust.hk\nX-Mailer: PHP/".phpversion());
				
			}
			
		}
		message(P0019, $PHP_SELF);
		exit();
	}
	else{
		
		warning(P0020);
		exit();
	}
	
	
}
$title = "In/experienced Subjects";
head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Log on->home.php||System Administration->Subject_Management.php||Subject Management->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?>
                  	
                  
                  
                </tr>
              </table>
              <hr noshade align="center" width="98%" size="1">
              <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
              <table width="100%" border="0" cellpadding="3" align="center" cellspacing="0">
                <tr bgcolor="ffffcc"> 
                  <td class="normal">There is a list of subjects who 
                    <input type="text" name="showsub1" size="8" value="<? echo $showsub1; ?>">
                    
                    participated in experiment(s)<br> 
                    <input type="text" name="showsub2" size="40" value="<? echo $showsub2; ?>">
                    <input type="text" name="showsub3" size="3" value="<? echo $showsub3; ?>"><br>
                    <input type="text" name="showsub4" size="8" value="<? echo $showsub4; ?>">participated in experiment(s):<br>
                    <input type="text" name="showsub5" size="40" value="<? echo $showsub5; ?>">
                  </td>
                </tr>
              </table>
              
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td width="6%" class="tablecolumn">Select</td>
                    <td width="8%" class="tablecolumn" bgcolor="#000099">First Name(s)</td>
                    <td width="14%" class="tablecolumn">Last Name</td>
                    <td width="10%" class="tablecolumn">Sex</td>
                    <td width="12%" class="tablecolumn">Phone</td>
                    <td width="12%" class="tablecolumn">Email</td>
                  </tr>
                  <?
                  	$conditionStr = $showsub1."->".$showsub2."->".$showsub3."->".$showsub4."->".$showsub5."->".$submit;
                  	show_experienced_subjects($conditionStr);
                  ?>
                </table>
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
              
                <table width="100%" cellpadding="3" bordercolor="#CCCCCC" border="0" cellspacing="0">
                  <tr bgcolor="ffffcc"> 
                    <td colspan="2" class="normal">To send an email to subjects, 
                      click the select boxes then click &quot;Send Mail&quot;.</td>
                  </tr>
                  <tr> 
                    <td width="13%" class="tablerow">Subject :</td>
                    <td width="87%"> 
                      <input type="text" name="subject" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="13%" class="tablerow">cc:</td>
                    <td width="87%"> 
                      <input type="text" name="cc" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="13%" class="tablerow">Message:</td>
                    <td width="87%">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td colspan="2"> 
                      <textarea name="message" rows="3" cols="70" value=""></textarea>
                      <input type="submit" name="sendmail" value="Send Mail">
                    </td>
                  </tr>
                </table>
              </form>
<?
foot_link();
?>