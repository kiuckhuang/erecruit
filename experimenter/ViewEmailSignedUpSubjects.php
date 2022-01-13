<?
require("../fun/exp_functions.inc");
checkLogin();

if(!checkexpid(substr($sessionid, 0, 8))){
	warning(T0073);
	exit();	
}
$cookie_var = split("-", $expprofile);
	$loginName = $cookie_var[0];
$myname = show_experimenter_name($loginName);
$mymail = show_experimenter_email($loginName);
 
if(isset($sendmail) && $sendmail=="Send Mail"){
	//echo "total=".$total."<br>";
	$countselected = 0;

	$ccmail = explode(",", $cc);
				
	for($i = 0; $i< sizeof($ccmail); $i++){
		if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $ccmail[i]) && trim($ccmail[i]) !="") {
  			warning(T0083);
		}
		if(trim($ccmail[$i]) !=""){
			$countselected++;
			mail("$ccmail[$i]", "$subject", "$message", "From: \"$myname\"<$mymail>\nReply-To: \"$myname\"<$mymail>\nX-Mailer: PHP/".phpversion());
			sleep(0.5);
		}
	}


	if(isset($total) && $total >= 0 ){
		for($i=0; $i<$total; $i++){
			//echo "checkbox0=".$checkbox0."<br>";
			if(${checkbox.$i} == "on"){
				$email = ${email.$i};  
				$countselected++;
				/*
				for ($z=0; $z<count($email); $z++){
					echo $email[$z];
				}
				*/
				mail("$email", "$subject", "$message", "From: \"$myname\"<$mymail>\nReply-To: \"$myname\"<$mymail>\nX-Mailer: PHP/".phpversion());
				sleep(0.5);
			}
			
		}
		if ($countselected == 0){
			warning(T0088);
			exit();
		}
		else{
			$link = $PHP_SELF;
			message(T0089, $link);
			exit();
		}
	}
	else{
		warning(T0088);
		exit();
	}
	
	
}

if($plaintext!="yes"){
	$title="View & Email Signed Up Subjects";
}
else{
	$title="View & Email Signed Up Subjects (Plain HTML)";
}
head($title);

?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
            <?
              $where="index.php||Log In->Experimenter_Administration.php||Experimenter Administration->Session_Management.php||Session Management->";
                $where .= basename($PHP_SELF)."||".$title;
                position("$where");
                
             ?>
            </tr>
          </table>
        </div>
      </div>
      <div v:shape="_x0000_s3074" class="O"> 
        <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
          <hr noshade align="center" width="98%" size="1">
          <? if($plaintext!="yes"){ ?>	  
          <form method="post" action="<? echo $PHP_SELF; ?>">
          <div align="left">
          Number of subjects signed up: <? echo show_num_enrolled($sessionid); ?>
          <br>
	  Number of subjects in the waiting list: <? echo show_num_waiting($sessionid); ?>
	  </div>	  
            <table width="100%" cellpadding="2" cellspacing="0" border="1" bordercolordark="#CCCCCC" bordercolorlight="#CCCCCC" bordercolor="#CCCCCC">
              <tr valign="top"> 
                <td width="12%" class="tablecolumn" bgcolor="#000099">Select</td>
                <td width="18%" class="tablecolumn" bgcolor="#000099">First Name(s)</td>
                <td width="18%" class="tablecolumn" bgcolor="#000099">Last Name</td>
                <td width="12%" class="tablecolumn" bgcolor="#000099">Sex</td>
                <td width="12%" class="tablecolumn" bgcolor="#000099">Phone</td>
                <td width="21%" class="tablecolumn" bgcolor="#000099">Email</td>
                <td width="7%" class="tablecolumn" bgcolor="#000099">Waiting List?</td>
                <td width="7%" class="tablecolumn" bgcolor="#000099"><? echo ORG_SHORT; ?> <font color=red>*</font> subjects?</td>
              </tr>
          <? } ?>
                <?
              	list_all_signed_subject($sessionid, $selectall, $plaintext);
              	?>
         <? if($plaintext!="yes"){ ?>	  	
            </table>
            <table width="100%">
              <tr>
                <td> 
                  <div align="left">
                    <input type="submit" name="selectall" value="Select All Participant(s)">
                  </div>
                </td>
                <td>
                  <div align="right">
                    <a href="ViewEmailSignedUpSubjects.php?plaintext=yes" target="_blank" class="normal" >Plain Text</a>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="normal"> 
                   <font color=red>*</font> Information of sex and phone for <? echo ORG_SHORT; ?> subjects was provided by subjects. <br>
                   All information for non-<? echo ORG_SHORT; ?> subjects are provided by subjects.
                   
                </td>
              </tr>
            </table>
            <br>
               <table width="100%" cellpadding="3" bordercolor="#CCCCCC" border="0" cellspacing="0">
                  <tr bgcolor="ffffcc">
                    <td colspan="2" class="normal">To send an email to subject(s),
                      click the box(es) next to their names, then click &quot;Send Mail&quot;.</td>
                  </tr>
                  <tr>
                  <td width="13%" class="tablerow">From :</td>
                    <td width="87%">
                      <font class="normal"><? echo $myname; ?></font>
                     </td>
                  </tr>
                    <sub
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
                      <input type="submit" name="sendmail" value="Send Mail"  onClick="alert('Sending each mail will take about ONE second to complete.');return true;">
                    </td>
                  </tr>
                </table>
                </form>
	<? } ?>                
<?
foot_menu();
foot();
?>
