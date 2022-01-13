<?
include("../fun/exp_functions.inc");
if(isset($send) && $send=="Send"){
	if(trim($firstName) == ""){
		warning(T0080);
		exit();
	}
	if(trim($lastName) == ""){
		warning(T0081);
		exit();
	}
	if(trim($email) == ""){
		warning(T0082);
		exit();
	}
	if(!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)){
		warning(T0083);
		exit();
	}
	nonhkust_experimenter_ack($firstName, $lastName, $email, $phone, $remarks);
	/*
	$subject = "Your e-Recruit Experimenter Account";
	$msg = "We have received your request to set up an experimenter account on e-Recruit. Below is the information you submitted:\n\n";
	$msg .= "\t\tFirst Name: $firstName\n";
	$msg .= "\t\tlast Name: $lastName\n";
	$msg .= "\t\tE-Mail: $email\n";
	if(trim($phone) !="")
	$msg .= "\t\tPhone No.: $phone\n";
	
	if(trim($remarks) !="")
	$msg .= "\t\tRemarks: $remarks\n";
	
	$msg .= "\n\nRegards,\n". ADMIN_MAIL_WITH_NAME;
	
	$m = new email ($subject, $msg, $firstName." ".$lastName , $email, ADMIN_MAIL, $email);
	$m->send();
	$link = "../";
	message("Your request has been successfully sent to the System Administrator.", $link);
	*/
	exit();	
}

$title = "Experimenter Register!";
head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 

                  <td class="pagetitle" colspan="2">
                    <div align="center">Create <font color="#996600"><b>Experimenter </b></font>Account</div>
                  </td>

                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
              <div align="left" class="normal"><br>
                Please fill in the following form and press &quot;Send&quot;. You will receive a login name and password through e-mail in three days if your application is successful.</div>
              <form name="form1" method="post" action="<? echo "$PHP_SELF"; ?>">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">First Name(s) :
                    </td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="firstName" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Last Name :</td>
                    <td width="40%"> 
                      <input type="text" name="lastName" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc"> <font class="noteindicator"> * </font>Phone No(s) 
                      (e.g. 97123456, 23821234) :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="phone" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Email Address :</td>
                    <td width="40%"> 
                      <input type="text" name="email" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc"><font class="noteindicator"> * </font>Remarks :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="remarks" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="tablerow">&nbsp;</td>
                    <td width="40%"> 
                      <div align="right">
                        <input type="submit" name="send" value="Send">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="60%" class="notes" >' <font class="noteindicator"> * </font> ' <font class="notes">denotes optional fields.</font></td>
                    <td width="40%"> 
                    </td>
                  </tr>                    
                </table>
                
               </form>
<?

foot();
?>