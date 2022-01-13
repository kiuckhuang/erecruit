<?
include("../fun/admin_functions.inc");
checkLogin();
if(isset($submit) && $submit!=""){
	if($submit == "Add"){
		header("Location: Add_Experimenter.php");
	}else if($submit == "Delete"){
		for($i=0; $i<$total; $i++){
			$loginName = $loginName[$i];
			if($loginName != "" && $checkbox[$i] == "on"){
				//delExperimenter($loginName);
				$expStr .= $loginName."->";
			}
		}
		if($expStr !=""){
			$expStr = substr($expStr, 0, strlen($expStr) -2);
			//echo $expStr;
			$msg = ereg_replace("->", "<br>\n<li>", $expStr);
		
			$msg = "Do you really want to delete the following experimenter(s) with Login Name:<br>\n<li>".$msg;
			$expStr = urlencode($expStr);
			$link = "Del_Experimenter.php?expStr=$expStr";
			confirm($msg, $link);
			exit();
		}
	
		
		
	}
	else if($submit =="View/Modify Experimenter Info"){
		for($i=0; $i <$total; $i++){
			if($checkbox[$i] == "on"){
				$loginStr = "loginName=".$loginName[$i];
				header("Location: View-Modify_Experimenter_info.php?$loginStr");
				exit();
				
			}
		}
	}
	else if($submit =="View Experiments created By Experimenter"){
		for($i=0; $i <$total; $i++){
			if($checkbox[$i] == "on"){
				$loginStr = "loginName=".$loginName[$i];
				header("Location: Experiments_By_Experimenter.php?$loginStr");
				exit();
				
			}
		}
	}
	

}
	
if(isset($sendmail) && $sendmail=="Send Mail"){
	if(isset($total) && $total >= 0 ){
		for($i=0; $i<$total; $i++){
			if($checkbox[$i] == "on"){
				$email = $email[$i];
				$ccmail = explode(",", $cc);
				
				for($i = 0; $i< sizeof($ccmail); $i++){
					if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $ccmail[$i]) && trim($ccmail[$i]) !="") {
  						warning("Incorrect e-Mail format!<br>\nPlease input again.");
					}
					if(trim($ccmail[$i]) !="")
					mail("$ccmail[$i]", "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: recruit@cebr.ust.hk\nX-Mailer: PHP/".phpversion());
				}
				
				mail("$email", "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: sysadmin@erecruit.bm.ust.hk\nX-Mailer: PHP/".phpversion());
				
			}
			
		}
		message("Mail has been sent successfully.", $PHP_MYSELF);
		exit();
	}
	else{
		warning("Please select at least one experimenter.");
		exit();
	}
	
	
}

$title = "Experimenter Management";
head($title);

?>

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr>

<?
		$where = "index.php||Log on->home.php||System Administration->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
		?>
		
                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">

              <form name="experimenters" method="post" action="<? echo $PHP_SELF; ?>">

                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">

                  <tr bgcolor="#000099" valign="top">

                    <td width="6%" class="tablecolumn">Select</td>

                    <td width="8%" class="tablecolumn" bgcolor="#000099"> Name</td>

                    <td width="14%" class="tablecolumn">Instructor of <br>

                      which Course(s)?</td>

                    <td width="10%" class="tablecolumn">Login Name</td>

                    <!--
                    <td width="12%" class="tablecolumn">Password</td>
		    -->
                    <td width="12%" class="tablecolumn">Staff/Student ID</td>

                    <td width="8%" class="tablecolumn">Phone</td>

                    <td width="12%" class="tablecolumn">Email </td>

                    <td width="18%" class="tablecolumn">Remarks</td>

                  </tr>

                  <?
                  	
                  	if($submit == "Select All Box(es)")
                  		show_all_experimenters($submit);
                  	else
                  		show_all_experimenters("");
                  ?>
                </table>
               <p align="left">
                  <input type="submit" name="submit" value="Select All Box(es)">
                  <input type="submit" name="submit" value="Add">
                  <input type="submit" name="submit" value="Delete">
                  <input type="submit" name="submit" value="View/Modify Experimenter Info">
                  <input type="submit" name="submit" value="View Experiments created By Experimenter">
                </p>
                <table width="100%" cellpadding="3" bordercolor="#CCCCCC" border="0" cellspacing="0">
                  <tr bgcolor="ffffcc">
                    <td colspan="2" class="normal">To send an email to experimenter(s),
                      click the select box(es) then click &quot;Send Mail&quot;.</td>
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