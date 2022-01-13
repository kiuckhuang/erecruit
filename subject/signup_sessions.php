<?
require("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

	$Loginstr = split("-", $subjectprofile);
	$loginName = $Loginstr[0];
	
	$this_exp_is = split("->",$target);
	$this_exp_is_type = $this_exp_is[0]; 
	$exp_is = split("--",$this_exp_is[1]);
	//$this_exp_is_details = $this_exp_is[1];
	//echo $target;//course->ECON 123--2000--FALL
	//echo $exp_is[0]." ".$exp_is[1]." ".$exp_is[2];
	
	if($this_exp_is_type == "pool"){
		$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query="select signUpCode from pool where id like '$exp_is[0]' and semester like '$exp_is[2]' and year like '$exp_is[1]' ";	
		$rs = $db->query($query);
		$signUpCode = $rs->fields[signUpCode];
		//warning($signUpCode);
		$numOfRows = $rs->getNumOfRows();
		$rs->close();
		$db->close();
	}
	elseif($this_exp_is_type == "course"){
		$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query="select signUpCode from course where courseID like '$exp_is[0]' and semester like '$exp_is[2]' and year like '$exp_is[1]'";
		$rs = $db->query($query);
		$signUpCode = $rs->fields[signUpCode];
		$numOfRows = $rs->getNumOfRows();
		//echo $numOfRows." ".$exp_is[0]." ".$exp_is[1]." ".$exp_is[2];
		$rs->close();
		$db->close();
	}
	
function content($headtitle){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $id,$loginName,$description,$experimenters,$mode,$sessions,$undo,$target,$signupcode,$AssignCreditsto,$preRequisite;

        global $sure_cancel;
        global $signup;
	$needaddenrolled = 0 ;
	if (!isset($description)) { $description = "No description.";}
	if ($description == "") { $description = "No description.";}
	if ($description == " ") { $description = "No description.";}
	
	$headtitle="Sign up";
		
	head($headtitle);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->upcomingexp.php||Upcoming Experiments->javascript:history.back(1)||Experiment Details->";
 		//$where = "index.php||Log In->upcomingexp.php||Upcoming Experiments->upcomingexp_expdetails.php||Experiment Details->";
		$where .= basename($PHP_SELF)."||".$headtitle;
		
		position("$where"); ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
              
              <table width="752" border="0" cellpadding="3" align="left">
                <tr><td>
                
                <!-- First Table -->
                <!--
                <table width="752" border="0" cellpadding="3" align="left">
                <tr> 
                  <td width="21%" class="normal" valign="top">Experiment ID :</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo $id ; ?></td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Experiment Description 
                    :</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo $description; ?></td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Experimenter(s) 
                    :</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo experimentersstr($experimenters); ?> 
                  </td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Prerequisites 
                   <a href="Prerequisite.php">[more]</a>:</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo preRequisitestr($preRequisite); ?> 
                  </td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Remarks : </td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow">
                  <? echo show_mode_str($mode); ?></td>
                </tr>                
                </table>
                -->
                </td></tr>
                <!-- Second Table -->
                <tr><td>
                <form method="post" action="<? echo $PHP_SELF; ?>">
                <table width="100%" cellpadding="0">
                  <tr bgcolor="ffffcc"> 
                    <td class="normal"> 
                      <div><ul><li>If status coloumn below shows "Signed Up Successfully", you need to present the <font color="ff0000" size="+1"><b>Sign Up Confirmation Sheet</b></font>
                      to experimenters. Remember to print one sheet for each session that you have signed up. Please click the session titles to print NOW <font color="ff0000">OR </font> "My Experiments" to print LATER
                      </ul>
                        
                      </div>
                    </td>
                  </tr>
                  <? if ($sure_cancel == "Yes, I want to cancel"){ ?>
                  
                  <tr bgcolor="ffffcc"> 
                    <td class="normal"> 
                      <div><ul><li>Please click <a href="upcomingexp.php">here</a> to choose other experiment(s) to sign up. 
                      </li>
                      </div>
                    </td>
                  </tr>
                  
                  <? }else{ ?>
                  <tr bgcolor="ffffcc"> 
                    <td class="normal"> 
                      <div><ul><li>If you want to cancel any sign-ups, check the boxes, then click 
                      <input type="submit" name="undo" value="Cancel">
                      </li>
                      </div>
                    </td>
                  </tr>                  
		<? }?>
                </table>
                  <input type="hidden" name="id" value="<? echo $id; ?>">
                  <input type="hidden" name="mode" value="<? echo $mode; ?>">
                  <input type="hidden" name="sessions" value="<? echo $sessions; ?>">
                  <input type="hidden" name="description" value="<? echo $description; ?>">
                  <input type="hidden" name="experimenters" value="<? echo $experimenters; ?>">
                  <input type="hidden" name="AssignCreditsto" value="<? echo $AssignCreditsto; ?>">
                  <input type="hidden" name="preRequisite" value="<? echo $preRequisite; ?>">

                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC" vspace="0" hspace="0">
                  <tr bgcolor="#000099"> 
                    <td width="6%" class="tablecolumn" valign="top">Select</td>
                    <td width="13%" class="tablecolumn" bgcolor="#000099" valign="top"> 
                      Session Title </td>
                    <td width="11%" class="tablecolumn" valign="top">Status</td>
                    <td width="9%" class="tablecolumn" valign="top">Start Date</td>
                    <td width="5%" class="tablecolumn" valign="top">Start Time</td>
                    <td width="12%" class="tablecolumn" valign="top">Approximate 
                      Duration</td>
                    <td width="6%" class="tablecolumn" valign="top">Venue</td>
                    <td width="6%" class="tablecolumn" valign="top">Quota</td>
                    <td width="8%" class="tablecolumn" valign="top">Vacancy</td>
                    <td width="8%" class="tablecolumn" valign="top">Waiting List</td>
                    <td width="16%" class="tablecolumn" valign="top">Reward <? echo $ck;?></td>
                  </tr>
                  <input type="hidden" name="target" value="<? echo $target; ?>">
                  <input type="hidden" name="signupcode" value="<? echo $signupcode; ?>">
                  <!--<input type="hidden" name="ck" value="<? echo $ck; ?>">-->
                  <!--<input type="hidden" name="ck1" value="<? echo $ck1; ?>">-->
                  <?
                	   
                // $sessions in function list_sessions_signupstage is array 
                if($mode == "All"){
                	global $ck1;
                	if (isset($ck1)) $sessions_array[1] = $ck1;
                }
                elseif($mode == "One"){
			global $ck;
                	if (isset($ck)) $sessions_array[1] = $ck;
                }
                elseif($mode == "Any"){
                	$no_of_sessions_chosen = 1;                	
                	for ( $i=1; $i<= $sessions; $i++){
                		
                		$temp = "ck".$i;
                		global $$temp;
                		if (isset($$temp)){ 
                			$sessions_array[$no_of_sessions_chosen] = $$temp;
                			$no_of_sessions_chosen ++;
                		}
                	}
                }
                else{
        	}
                  
                //$mode == "All" || "One" || "Any"
	        $db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");    
		if ($undo == "Cancel" && $sure_cancel == "Yes, I want to cancel"){//$undo, $mode, $id, $sessions, $loginName,
			if ( $mode == "All" ){
				if (is_SubjectInExp($loginName,$id)){
					//echo"\$sessions= ".$sessions."<br>";
				for ( $i=1; $i<= $sessions; $i++){
					//echo"\$i= ".$i."<br>";
					if ($i <10){
						$sessionid = $id.'0'.$i;
					}
					else{
						$sessionid = "$id"."$i";
					}
					$query1 = "select quota, enrolled from session where id = '$sessionid' ";
					$rs = $db->query($query1);
					$quota = $rs->fields[quota];
					$enrolled = $rs->fields[enrolled];					
					if ( signup_position($sessionid,$loginName) <= $quota && signup_position($sessionid,$loginName) != 0 ){
						//echo "U now in the position ".signup_position($id,$loginName)."<br>";
						$supertemp = NumOfSubjectInWaiting($sessionid,$quota);
						//echo "\$sessionid= ".$sessionid."<br>";
						//echo "\$quota= ".$quota."<br>";
						//echo "NumOfSubjectInWaiting= ".$supertemp."<br>";
						//there are two case 
						//1) there is other subject to wait this sessions
						//   need to sent the mail to that subject to alert him
						//2) there is no other subject to wait this sessions
						if( NumOfSubjectInWaiting($sessionid,$quota) >= 1 ){
							//echo "some subject wait ur session. <br>";
							//find the subject.email, subject.loginName, subject.firstName, subject.lastName
							// who at position $quota +1
							$subject_wait_loginName = find_subjectloginName_first_wait($sessionid,$quota);
							//echo "\$subject_wait_loginName".$subject_wait_loginName."<br>";
							mail_subject_wait_to_enrolled($subject_wait_loginName,$sessionid);
						}
						//	$query = "delete from waitingList where sessionid = '$id' and loginName = '$loginName'";
						//	$query2 = "delete from signupexp where expid = '$id' and loginName = '$loginName'";
						//	$rs = $db->query($query);
						//	$rs = $db->query($query2);
						
						//else{
						//echo "NO subject wait ur session. <br>";
						//no other subject wait this session
						// easy case to processed undo
						// remove this subject from the waitingList and signupexp
						// and then update the enrolled number of the session

							
						//$query3 = "select quota, enrolled from session where id = '$sessionid' ";
						//$rs = $db->query($query3);
						//$quota = $rs->fields[quota];
						//$enrolled = $rs->fields[enrolled];
					
						if ( NumOfSubjectInWaiting($sessionid,$quota) == 0 && $enrolled <= $quota && $enrolled > 0 ){
							$enrolled --;
							$query4 = "update session set enrolled = '$enrolled', fromdate = fromdate where id = '$sessionid' ";
							$rs = $db->query($query4);
						}
						$query = "delete from waitingList where sessionid = '$sessionid' and loginName = '$loginName'";
						$rs = $db->query($query);
						$query5 = "insert into cancelList (sessionid, loginName, canceltime) values ('$sessionid','$loginName',now())";
						$rs = $db->query($query5);
						//}
					}
					else {
						$query = "delete from waitingList where sessionid = '$sessionid' and loginName = '$loginName'";
						$rs = $db->query($query);
					}
					/*
					if ($i == $sessions){					
						$query2 = "delete from signupexp where expid = '$id' and loginName = '$loginName'";
						$rs = $db->query($query2);
					}
					*/
				}
					$query2 = "delete from signupexp where expid = '$id' and loginName = '$loginName'";
					$rs = $db->query($query2);
				}			
	        	}
	        	elseif ( $mode == "One" ){
		        	$expid = substr($sessions_array[1],0,8);
				//$query = "delete from waitingList where sessionid = '$sessions_array[1]' and loginName = '$loginName'";
				//$query2 = "delete from signupexp where expid = '$expid' and loginName = '$loginName'";
				//$rs = $db->query($query);
				//$rs = $db->query($query2);
			
				if (is_SubjectInList($loginName,$sessions_array[1])){
					$query1 = "select quota, enrolled from session where id = '$sessions_array[1]' ";
					$rs = $db->query($query1);
					$quota = $rs->fields[quota];
					$enrolled = $rs->fields[enrolled];					
					if ( signup_position($sessions_array[1],$loginName) <= $quota && signup_position($sessions_array[1],$loginName) != 0 ){
						//echo "U now in the position ".signup_position($sessions_array[1],$loginName)."<br>";
						$supertemp = NumOfSubjectInWaiting($id,$quota);
						//echo "\$sessionid= ".$sessionid."<br>";
						//echo "\$quota= ".$quota."<br>";
						//echo "NumOfSubjectInWaiting= ".$supertemp."<br>";
						//there are two case 
						//1) there is other subject to wait this sessions
						//   need to sent the mail to that subject to alert him
						//2) there is no other subject to wait this sessions
						if( NumOfSubjectInWaiting($sessions_array[1],$quota) >= 1 ){
						//	echo "some subject wait ur session. <br>";
							
							//find the subject.email, subject.loginName, subject.firstName, subject.lastName
							// who at position $quota +1
							$subject_wait_loginName = find_subjectloginName_first_wait($sessions_array[1],$quota);
							
							mail_subject_wait_to_enrolled($subject_wait_loginName,$sessions_array[1]);
						
						}
						//	$query = "delete from waitingList where sessionid = '$expid' and loginName = '$loginName'";
						//	$query2 = "delete from signupexp where expid = '$sessions_array[1]' and loginName = '$loginName'";
						//	$rs = $db->query($query);
						//	$rs = $db->query($query2);
						
						//else{
						//echo "NO subject wait ur session. <br>";
						//no other subject wait this session
						// easy case to processed undo
						// remove this subject from the waitingList and signupexp
						// and then update the enrolled number of the session
						
						//$query3 = "select quota, enrolled from session where id = '$sessions_array[1]' ";
						//$rs = $db->query($query3);
						//$quota = $rs->fields[quota];
						//$enrolled = $rs->fields[enrolled];
					
						if ( NumOfSubjectInWaiting($sessions_array[1],$quota) == 0 && $enrolled <= $quota && $enrolled > 0){
							$enrolled --;
							$query4 = "update session set enrolled = '$enrolled', fromdate = fromdate where id = '$sessions_array[1]' ";
							$rs = $db->query($query4);
						}
						$query = "delete from waitingList where sessionid = '$sessions_array[1]' and loginName = '$loginName'";
						$query2 = "delete from signupexp where expid = '$expid' and loginName = '$loginName'";
						$rs = $db->query($query);
						$rs = $db->query($query2);
						$query5 = "insert into cancelList (sessionid, loginName, canceltime) values ('$sessions_array[1]','$loginName',now())";
						$rs = $db->query($query5);						
						//}
					}
					else {
						$query = "delete from waitingList where sessionid = '$sessions_array[1]' and loginName = '$loginName'";
						$query2 = "delete from signupexp where expid = '$expid' and loginName = '$loginName'";
						$rs = $db->query($query);
						$rs = $db->query($query2);
						$query5 = "insert into cancelList (sessionid, loginName, canceltime) values ('$sessions_array[1]','$loginName',now())";
						$rs = $db->query($query5);						
					}
				}
				
	        	}
	        	elseif ( $mode == "Any" ){
	        		$expid = substr($sessions_array[1],0,8);
	        		
	        		//$query2 = "delete from signupexp where expid = '$expid' and loginName = '$loginName'";
	        		//$rs = $db->query($query2);
	        		
	        		for ( $i=1; $i<= count($sessions_array); $i++){
	        			if (is_SubjectInList($loginName,$sessions_array[$i])){
	        				//$query = "delete from waitingList where sessionid = '$sessions_array[$i]' and loginName = '$loginName'";
	        				//$rs = $db->query($query);
		        			$query1 = "select quota, enrolled from session where id = '$sessions_array[$i]' ";
						$rs = $db->query($query1);
						$quota = $rs->fields[quota];
						$enrolled = $rs->fields[enrolled];					
						if ( signup_position($sessions_array[$i],$loginName) <= $quota && signup_position($sessions_array[$i],$loginName) != 0 ){
							//there are two case 
							//1) there is other subject to wait this sessions
							//   need to sent the mail to that subject to alert him
							//2) there is no other subject to wait this sessions
							if( NumOfSubjectInWaiting($sessions_array[$i],$quota) >= 1 ){
								//find the subject.email, subject.loginName, subject.firstName, subject.lastName
								// who at position $quota +1
								$subject_wait_loginName = find_subjectloginName_first_wait($sessions_array[$i],$quota);
								//echo "1st wait subject ".$subject_wait_loginName."<br>";
								//echo "sessionid: ".$sessions_array[$i]."<br>";
								mail_subject_wait_to_enrolled($subject_wait_loginName,$sessions_array[$i]);
							}
		
							//	$query = "delete from waitingList where sessionid = '$sessions_array[$i]' and loginName = '$loginName'";
								//$query2 = "delete from signupexp where expid = '$expid' and loginName = '$loginName'";
							//	$rs = $db->query($query);
								//$rs = $db->query($query2);
							
							//else{
							//no other subject wait this session
							// easy case to process undo
							// remove this subject from the waitingList and signupexp
							// and then update the enrolled number of the session
							//$query = "delete from waitingList where sessionid = '$sessions_array[$i]' and loginName = '$loginName'";
							//$query2 = "delete from signupexp where expid = '$expid' and loginName = '$loginName'";
							//$rs = $db->query($query);
							//$rs = $db->query($query2);
								
							//$query3 = "select quota, enrolled from session where id = '$sessions_array[$i]' ";
							//$rs = $db->query($query3);
							//$quota = $rs->fields[quota];
							//$enrolled = $rs->fields[enrolled];
						
							if ( NumOfSubjectInWaiting($sessions_array[$i],$quota) == 0 && $enrolled <= $quota && $enrolled > 0 ){
								$enrolled --;
								$query4 = "update session set enrolled = '$enrolled', fromdate = fromdate where id = '$sessions_array[$i]' ";
								$rs = $db->query($query4);
							}
							$query = "delete from waitingList where sessionid = '$sessions_array[$i]' and loginName = '$loginName'";
							$rs = $db->query($query);
							$query5 = "insert into cancelList (sessionid, loginName, canceltime) values ('$sessions_array[$i]','$loginName',now())";
							$rs = $db->query($query5);						
							//}
						}
						else {
							$query = "delete from waitingList where sessionid = '$sessions_array[$i]' and loginName = '$loginName'";
							//$query2 = "delete from signupexp where expid = '$expid' and loginName = '$loginName'";
							$rs = $db->query($query);
							//$rs = $db->query($query2);
							$query5 = "insert into cancelList (sessionid, loginName, canceltime) values ('$sessions_array[$i]','$loginName',now())";
							$rs = $db->query($query5);						
						}	
					}
				}
				$counter = 0;
				for ( $i=1; $i<= $sessions; $i++){
					if ($i <10){
						$sessionid = "$id"."0"."$i";
					}
					else{
						$sessionid = "$id"."$i";
					}
					if (!is_SubjectInList($loginName,$sessionid)){
						$counter ++;
					}
				}
				if ( $counter == $sessions ){
					$query2 = "delete from signupexp where expid = '$id' and loginName = '$loginName'";
					$rs = $db->query($query2);
				}
		        }
	        	else { 
			}
		}
		elseif($signup == "Sign up"){
	        	if ( $mode == "All" ){
	        		if (!is_SubjectInExp($loginName,$id)){
	        			$numofsessionofexp = NumOfSessionOfExp($id);
	        			for ($i = 1; $i <= $numofsessionofexp; $i++){
	        				if ($i <10){
							$sessionid = $id.'0'.$i;
						}
						else{
							$sessionid = "$id"."$i";
						}
	        				$query = "insert into waitingList (sessionid, loginName, signOn) values ('$sessionid','$loginName',now())";
	        				$rs = $db->query($query);
	        			}
					$query2 = "insert into signupexp (expid, loginName, signOn, AssignCreditsto) values ('$id','$loginName',now(),'$AssignCreditsto')";
					$rs = $db->query($query2);
					$needaddenrolled = 1 ;
				}
				if ($needaddenrolled){
					for ( $i=1; $i<=$sessions; $i++){
						if ($i <10){
							$sessionid = $id.'0'.$i;
						}
						else{
							$sessionid = "$id"."$i";
						}
						$query3 = "select quota, enrolled from session where id = '$sessionid' ";
						$rs = $db->query($query3);
						$quota = $rs->fields[quota];
						$enrolled = $rs->fields[enrolled];
						
						if ( $enrolled < $quota ){
							$enrolled ++;
							$query4 = "update session set enrolled = '$enrolled', fromdate = fromdate where id = '$sessionid' ";
							$rs = $db->query($query4);
						}
					}
					$needaddenrolled = 0 ;
				}
								
	        	}
	        	elseif ( $mode == "One" ){
	        		if (!is_SubjectInExp($loginName,$id)){
		        		$expid = substr($sessions_array[1],0,8);
					$query = "insert into waitingList (sessionid, loginName, signOn) values ('$sessions_array[1]','$loginName',now())";
					$query2 = "insert into signupexp (expid, loginName, signOn, AssignCreditsto) values ('$expid','$loginName',now(),'$AssignCreditsto')";
					$rs = $db->query($query);
					$rs = $db->query($query2);	        	
					$needaddenrolled = 1 ;
				}
				if ($needaddenrolled){
					$query3 = "select quota, enrolled from session where id = '$sessions_array[1]' ";
					$rs = $db->query($query3);
					//$rs = $rs->firstRow();
					$quota = $rs->fields[quota];
					$enrolled = $rs->fields[enrolled];
				
					if ( $enrolled < $quota ){
						$enrolled ++;
						$query4 = "update session set enrolled = '$enrolled', fromdate = fromdate where id = '$sessions_array[1]' ";
						$rs = $db->query($query4);
					}
					$needaddenrolled = 0 ;
				}
			
	        	}
	        	elseif ( $mode == "Any" ){
	        		$expid = substr($sessions_array[1],0,8);
				$query2 = "insert into signupexp (expid, loginName, signOn, AssignCreditsto) values ('$expid','$loginName',now(),'$AssignCreditsto')";
				$rs = $db->query($query2);
	        		for ( $i=1; $i<= count($sessions_array); $i++){
	        			if (!is_SubjectInList($loginName,$sessions_array[$i])){
	        				$query = "insert into waitingList (sessionid, loginName, signOn) values ('$sessions_array[$i]','$loginName',now())";
	        				$rs = $db->query($query);
	        				$needaddenrolled = 1 ;
	        			}
	        			
	        			if ($needaddenrolled){
		        			$query3 = "select quota, enrolled from session where id = '$sessions_array[$i]' ";
						$rs = $db->query($query3);
						$quota = $rs->fields[quota];
						$enrolled = $rs->fields[enrolled];
				
						if ( $enrolled < $quota ){
							$enrolled ++;
							$query4 = "update session set enrolled = '$enrolled', fromdate = fromdate where id = '$sessions_array[$i]' ";
							$rs = $db->query($query4);
						}	
					}
					$needaddenrolled = 0;
				}
		        }
	        	else { 
			}
		
		}else{
		}

		//$rs->close();		
		$db->close();
		                                        		
                     list_sessions_signupstage($id,$loginName,$mode,$sessions_array,$sessions); 
                  ?>
                </table>
                
                
                </td></tr>
                
                <tr><td>
                
<?
	foot_menu();
	foot();

?>
		</td></tr>
              </table>

<? } ?>

<?
function are_u_sure_cancel($warningMSG="Warning!!!",$warningtitle="Warning!",$linkto="javascript:history.back(1)"){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $id,$loginName,$description,$experimenters,$mode,$sessions,$undo,$target,$signupcode,$AssignCreditsto,$preRequisite;
	global $ck1,$ck;
	if(!isset($warningMSG)){
		$warningMSG="Warning!!!";
	}	
	if(!isset($warningtitle)){
		$warningtitle="Warning!";
	}
	if(!isset($linkto)){
		$warningMSG="PHP_SELF";
	}
?>
<html>
<head>
<title><? echo $warningtitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
-->
</style>
<link rel="stylesheet" href="css.css">
</head>
<body bgcolor="#FFFFFF">
<table width="752" border="0" vspace="0" hspace="0" align="center">
  <tr> 
    <td> 
      <p><span lang="EN-US" style="mso-fareast-font-family:·s²Ó©úÅé;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-fareast-language:ZH-TW"><b><img src="images/top.gif" width="752" height="60" vspace="0" hspace="0"></b></span></p>
    </td>
  </tr>
  <tr> 
    <td height="243"> 
      <div v:shape="_x0000_s3074" class="O">
        <div style="mso-line-spacing:&quot;100 50 0&quot;"> 
          <div v:shape="_x0000_s3074" class="O">
           
            <div style="text-align:center;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">

                <tr> <!-- Shim row, height 1. --> 
                  <td><img src="images/shim.gif" width="630" height="1" border="0"></td>
                  <td><img src="images/shim.gif" width="10" height="1" border="0"></td>
                  <td><img src="images/shim.gif" width="1" height="1" border="0"></td>
                </tr>
                <tr valign="top"><!-- row 2 --> 
                  <td colspan="2"><img name="table_r2_c2" src="images/table_r2_c2.gif" width="640" height="20" border="0"></td>
                  <td><img src="images/shim.gif" width="1" height="20" border="0"></td>
                </tr>
                <tr valign="top"><!-- row 3 --> 
                  <td bgcolor="ffffcc">
		    <form>
                    <table width="95%" border="0" cellpadding="3" cellspacing="0" align="center">
                      <tr>
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial"><? echo $warningtitle; ?></font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo "Are you sure you want to cancel the sign up?"; ?></font></p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <table>
                          <tr>
                            <td>
                          <input type="submit" name="sure_cancel" value="Yes, I want to cancel">
                            </td>
                            <td>
                          <input type="submit" name="sure_cancel" value="No, I don't want to cancel">                          
                          <input type="hidden" name="id" value="<? echo $id; ?>">
	                  <input type="hidden" name="mode" value="<? echo $mode; ?>">
        	          <input type="hidden" name="sessions" value="<? echo $sessions; ?>">
                	  <input type="hidden" name="description" value="<? echo $description; ?>">
                  	  <input type="hidden" name="experimenters" value="<? echo $experimenters; ?>">
                	  <input type="hidden" name="AssignCreditsto" value="<? echo $AssignCreditsto; ?>">
              		  <input type="hidden" name="preRequisite" value="<? echo $preRequisite; ?>">
              		  <input type="hidden" name="target" value="<? echo $target; ?>">
                  	  <input type="hidden" name="signupcode" value="<? echo $signupcode; ?>">
                  	  <input type="hidden" name="ck" value="<? echo $ck; ?>">
                  	  <input type="hidden" name="ck1" value="<? echo $ck1; ?>">
                  	  <input type="hidden" name="undo" value="<? echo $undo; ?>">
                  	    </td>
                      	  </tr>
                      	  </table>
                      	  <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="right">
                            <hr noshade size="1" width="98%">
                            <a href="<? echo $linkto;?>"><img src="images/but_back.gif"  border="0"></a></div>
                        </td>
                      </tr>
                    </table>
                    </form>
                  </td>
                  <td background="images/table_r3_c3.gif">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="top"><!-- row 4 --> 
                  <td colspan="2"><img name="table_r4_c2" src="images/table_r4_c2.gif" width="640" height="25" border="0"></td>
                  <td><img src="images/shim.gif" width="1" height="25" border="0"></td>
                </tr>
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
</table>
</body>
</html>

<?
}

?>
<?
if( !isset($subjectprofile) ) {
	warningx(W0002);
	exit();
}
// $sessions in function list_sessions_signupstage is array
// this will set the session_array which will store what u have chosen 
                if($mode == "All"){
                	//global $ck1;
                	if (isset($ck1)) $sessionid_array[1] = $ck1;
                }
                elseif($mode == "One"){
			//global $ck;
                	if (isset($ck)) $sessionid_array[1] = $ck;
                }
                elseif($mode == "Any"){
                	$no_of_sessions_chosen = 1;                	
                	for ( $i=1; $i<= $sessions; $i++){
                		
                		$temp = "ck".$i;
                		//global $$temp;
                		if (isset($$temp)){ 
                			$sessionid_array[$no_of_sessions_chosen] = $$temp;
                			$no_of_sessions_chosen ++;
                		}
                	}
                }
                else{
        	}

//This will check this subject is blocked or not
if (is_blocking($subjectprofile) || IS_BLOCKING_SUBJECT){
		if ( is_ust() ) {
			$msg = W0045.W0046;
		} else {
			$msg = W0045;
		}
		warningx($msg);
		exit();
}

//This will ensure that the user have check the box
$is_checkbox_emt = FALSE;
if($mode == "All" && !isset($ck1)){ $is_checkbox_emt = TRUE;}
elseif($mode == "One" && !isset($ck)){ $is_checkbox_emt = TRUE;}
elseif($mode == "Any"){
	
       	$no_of_sessions_chosen = 0;                	
       	for ( $i=1; $i<= $sessions; $i++){
               		
 		$temp = "ck".$i;
      		//global $$temp;
       		if (!isset($$temp)){
       			$no_of_sessions_chosen ++;
       		}
       	}
       	if( $no_of_sessions_chosen == $sessions ){
      		$is_checkbox_emt = TRUE;
       	}else{  $is_checkbox_emt = FALSE; }
}else{ $is_checkbox_emt = FALSE; }

//This will check the prerequsite
if ($signup == "Sign up") {
	//warningx($loginName.$id);
	if (!checkprerequisite($loginName,$id)){ 
	warningx(W0026); exit;
	}
}
if($is_checkbox_emt){
	warningx(W0021); exit;
}
if($this_exp_is_type != "open"){
	if($signupcode != ""){
		if ( $signupcode != $signUpCode ){
			if (SHOWSIGNUPCODE == TRUE){
				$inputerrmsg = W0019." The correct signupcode is $signUpCode, not \"$signupcode\"";
			}else{
				$inputerrmsg = W0019;
			}
			warningx($inputerrmsg); exit;
		}	
	}
	else{
		warningx(W0020); exit;
	}
}

//This will check the sessions wheather it is end or not
//If the session in the choose list is ended, it will show the error msg
if( $signup == "Sign up" ) {
	$is_sessions_ended = false;
	$is_sessions_signedupb4 = false;
	if ( $mode == "All" || $mode == "One" ) {
		for ( $i=1; $i<= $sessions; $i++){
			//echo"\$i= ".$i."<br>";
			if ($i <10){
				$sessionid = $id.'0'.$i;
			}
			else{
				$sessionid = "$id"."$i";
			}
			$sessionid_array[$i] = $sessionid;
		}
		for($i=1; $i<=count($sessionid_array); $i++) {
			// Is the session is ended ?
			$is_one_session_ended = is_session_ended($sessionid_array[$i]);
			$is_sessions_ended = $is_sessions_ended || $is_one_session_ended;
			if (DEBUG_ISSESSIONEND) {
				$show_is_one_session_ended = $is_one_session_ended ? "TRUE" : "FALSE";
				echo "$i: sessionid : $sessionid_array[$i] :\$is_one_session_ended is $show_is_one_session_ended <br>";
			}
			
			// Is the session is sign up b4 by this loginName
			$is_one_session_signedupb4 = is_sessions_signedupb4($sessionid_array[$i],$loginName);
			$is_sessions_signedupb4 = $is_sessions_signedupb4 || $is_one_session_signedupb4;
			if ( DEBUG_ISSESSIONSIGNEDUP ) {
				$show_is_one_session_signedupb4 = $is_one_session_signedupb4 ? "TRUE" : "FALSE";
				$show_is_sessions_signedupb4 = $is_sessions_signedupb4 ? "TRUE" : "FALSE";
				echo "$i: sessionid : $sessionid_array[$i] :\$is_one_session_signedupb4 is $show_is_one_session_signedupb4 <br>";
				echo "$i: sessionid : $sessionid_array[$i] :\$show_is_sessions_signedupb4 is $show_is_sessions_signedupb4 <br>";
			}
		}
	} else { 
		for($i=1; $i<=count($sessionid_array); $i++) {			
			// Is the session is ended ?
			$is_one_session_ended = is_session_ended($sessionid_array[$i]);
			$is_sessions_ended = $is_sessions_ended || $is_one_session_ended;
			if (DEBUG_ISSESSIONEND) {
				$show_is_one_session_ended = $is_one_session_ended ? "TRUE" : "FALSE";
				echo "$i: sessionid : $sessionid_array[$i] :\$is_one_session_ended is $show_is_one_session_ended <br>";
			}
			
			// Is the session is sign up b4 by this loginName
			$is_one_session_signedupb4 = is_sessions_signedupb4($sessionid_array[$i],$loginName);
			$is_sessions_signedupb4 = $is_sessions_signedupb4 || $is_one_session_signedupb4;
			if ( DEBUG_ISSESSIONSIGNEDUP ) {
				$show_is_one_session_signedupb4 = $is_one_session_signedupb4 ? "TRUE" : "FALSE";
				$show_is_sessions_signedupb4 = $is_sessions_signedupb4 ? "TRUE" : "FALSE";
				echo "$i: sessionid : $sessionid_array[$i] :\$is_one_session_signedupb4 is $show_is_one_session_signedupb4 <br>";
				echo "$i: sessionid : $sessionid_array[$i] :\$show_is_sessions_signedupb4 is $show_is_sessions_signedupb4 <br>";
			}
		}
	}
	if ( $is_sessions_ended ) { 
		warningx(W0041);
		exit();
	}
	if ( $is_sessions_signedupb4 ) {
		warningx(W0044);
		exit();
	}
}

//This will check the sessions wheather it is started or not
//If the session in the choose list is started, it will show the error msg
if($undo == "Cancel" && !isset($sure_cancel)) {
	$is_sessions_started = false;
	if ( $mode == "All" ) {
		for ( $i=1; $i<= $sessions; $i++){
			//echo"\$i= ".$i."<br>";
			if ($i <10){
				$sessionid = $id.'0'.$i;
			}
			else{
				$sessionid = "$id"."$i";
			}
			$sessionid_array[$i] = $sessionid;
		}
		for($i=1; $i<=count($sessionid_array); $i++) {
			$is_one_session_started = is_session_started($sessionid_array[$i]);
			$is_sessions_started = $is_sessions_started || $is_one_session_started;
			$show_is_one_session_started = $is_one_session_started ? "TRUE" : "FALSE";
			if (DEBUG_ISSESSIONSTART) echo "$i: sessionid : $sessionid_array[$i] :\$is_one_session_started is $show_is_one_session_started <br>";
		}
	} else { 
		for($i=1; $i<=count($sessionid_array); $i++) {			
			$is_one_session_started = is_session_started($sessionid_array[$i]);
			$is_sessions_started = $is_sessions_started || $is_one_session_started;
			$show_is_one_session_started = $is_one_session_started ? "TRUE" : "FALSE";
			if (DEBUG_ISSESSIONSTART) echo "$i: sessionid : $sessionid_array[$i] :\$is_one_session_started is $show_is_one_session_started <br>";
		}
	}
	if ( $is_sessions_started ) { 
		warningx(W0042);
		exit();
	}
}

if($loginName == "guest"){
	warningx(W0004); exit;
}
elseif(isset($subjectprofile)){
	
	if($undo == "Cancel" && !isset($sure_cancel)){
		are_u_sure_cancel();exit;
	}elseif($sure_cancel == "Yes, I want to cancel" && $undo == "Cancel"){
		content($title);exit;
	}else{
		content($title);exit;
	}
	
	content($title);
}else{
	warningx(W0002);exit;
}
	
	


?>
