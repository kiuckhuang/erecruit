<?
include("../fun/exp_functions.inc");

checkLogin();

if(!checkexpid($expid)){
	warning(T0073);
	exit();	
}
if(isset($sessionid)){
	if (!isAssignCredit($sessionid)){
		warning("The rewards type of the session you have just chosen is not in credits.");
		exit();
	}
}	

if(isset($sendinfo) && $sendinfo = "Send"){
	for($i=0; $i <$total; $i++){
		if(${checkbox.$i} == "on"){
			$loginName = ${loginName.$i};
			$credit = ${credit.$i};
			
			if($credit != ""){
				if($i < $total -1 ){
					$loginnames .= $loginName."->";
					$credits .= $credit."->";
				}else{
					$loginnames .= $loginName;
					$credits .= $credit;
				}
			}
			
			
			
		}
	}
	if($loginnames == "" || $credits == ""){
	
	}else{
		
		$login_var = explode("-", $expprofile);
		
		$exploginName = $login_var[0];		
		add_credit($loginnames, $credits, $sessionid, $exploginName); // this function will add credit and also send mail to adm
		
		$link = "Session_Management.php";
		message("Credits information has been sent to the System Administrator successfully", $link);
		exit();
		
	}
	
	
}

	

$title="Record Credits Subjects Earned";
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
          <form method="post" action="<? echo $PHP_SELF; ?>">
            <table width="100%" cellpadding="3" cellspacing="0" border="0">
              <tr> 
                <td class="normal" colspan="2">Please click the select box(es), fill in the credits earned
                box(es) and then click  
                <input type="submit" name="sendinfo" value="Send"><br>
                Information on the below table will then be sent to the system administrator. If you want to
                 make changes, please redo the above process.</td>
              </tr>
              <tr> 
                <td class="normal" width="60%" bgcolor="ffffcc">However,<font color="#000099">e-Recruit</font> 
                  will <font color="#FF0000">not</font> process any modification 
                  after this date: </td>
                <td class="tablerow" width="40%" bgcolor="ffffcc"><? pool_deadline($sessionid) ?></td>
              </tr>
            </table>
            <br>
            <table width="100%" cellpadding="2" cellspacing="0" border="1" bordercolordark="#CCCCCC" bordercolorlight="#CCCCCC" bordercolor="#CCCCCC">
              <tr valign="top"> 
                <td width="9%" class="tablecolumn" bgcolor="#000099">Select</td>
                <td width="19%" class="tablecolumn" bgcolor="#000099">First Name(s)</td>
                <td width="12%" class="tablecolumn" bgcolor="#000099">Last Name</td>
                <td width="6%" class="tablecolumn" bgcolor="#000099">Sex</td>
                <td width="10%" class="tablecolumn" bgcolor="#000099">Phone</td>
                <td width="23%" class="tablecolumn" bgcolor="#000099">Email</td>
                <td width="21%" class="tablecolumn" bgcolor="#000099">Credits Earned </td>
              </tr>
              <?
              	list_all_credit_subjects($sessionid, $selectall);
              	?>
            </table>
            <table width="100%" cellpadding="0">
              <tr valign="top"> 
                <td colspan="2"> 
                  <input type="submit" name="selectall" value="Select All Participant(s)">
                </td>
              </tr>
              <tr valign="top"> 
                <td colspan="2"> 
                  <div class="normal"> 
                    <!--
                    <div align="left">
                    </div>
                    -->
                  </div>
                </td>
              </tr>
            </table>
          </form>
          <br>
          <!--
          <table width="100%" cellpadding="3">
            <tr> 
              <td width="9%" valign="top" class="notes">Note:</td>
              <td width="91%" class="notes">A warning message will be shown to 
                those who send info to the system after the end of semester: <br>
                &quot; The information you sent will not be processed by e-Recruit 
                now because the closing date for the system to process information 
                has been passed. Please contact system administrator if needed.&quot;</td>
            </tr>
            <tr> 
              <td width="9%" valign="top" class="notes">Note: </td>
              <td width="91%" class="notes">This page will only be shown to Experimenters 
                who added an expt in MARK Subject Pool </td>
            </tr>
          </table>
          -->
<?






foot();
?>

