<?
require("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

	$Loginstr = split("-", $subjectprofile);
	$loginName = $Loginstr[0];
              
        $db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
        $query5 = "select sessions from experiment where id = '$id' ";
        $rs5 = $db->query($query5);
	$sessions = $rs5->fields[sessions];
	$rs5->close();		
	$db->close();
	 
function content($headtitle){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $id,$loginName,$description,$experimenters,$mode,$sessions,$undo;
	
	$headtitle="Sign up";
		
	head($headtitle);
	?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function getConfirm() {
	if (confirm("You will cancel this sign up. Are you sure you want to cancel?")) {
		document.forms[0].submit();
	}else {
		//history.back();
	}
}
-->
</script>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->upcomingexp.php||Upcoming Experiments->";
		$where .= basename($PHP_SELF)."||".$headtitle;
		
		position("$where"); 
		?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              <?
                  $db = new phpDB();
		  $db->pconnect() or die ("Can't connect to database server or select database");
                  $query2 = "select title, description, mode, sessions, experimenters, preRequisite from experiment where id = '$id' ";
			$rs2 = $db->query($query2);
			$exptitle = $rs2->fields[title];
			$description = $rs2->fields[description];
			$mode = $rs2->fields[mode];
			$sessions = $rs2->fields[sessions];
			$experimenters = $rs2->fields[experimenters];
			$preRequisite = $rs2->fields[preRequisite];
			$experimenters = experimentersstr($experimenters);
			if($description == ""){ $description = "No description.";}
			if($description == " "){ $description = "No description.";}
			$rs2->close();		
			$db->close();	/*	optional	*/              
              ?>
              
              <table width="752" border="0" cellpadding="3" align="left">
                <!-- First row -->
                <tr><td>
                <table width="752" border="0" cellpadding="3" align="left">
                <tr> 
                  <td width="21%" class="normal" valign="top">Experiment ID :</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo $id; ?></td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Experiment Description 
                    :</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo $description; ?></td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Experimenter(s) 
                    :</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo $experimenters; ?> 
                  </td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Prerequisite 
                   <a href="Prerequisite.php">[more]</a>:</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo preRequisitestr($preRequisite); ?> 
                  </td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Remarks : </td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow">
                  <? echo show_mode_str($mode); ?>
                  </td>
                </tr>                
              </table>
              
              	<tr> <td>
              	<form method="post" action="<? echo $PHP_SELF; ?>">
                <table width="100%" cellpadding="0">
                  <tr bgcolor="ffffcc"> 
                    <td class="normal"> 
                      <div><ul><li>If status coloumn below shows "Signed Up Successfully", you need to present the <font color="ff0000">Sign Up Confirmation Sheet</font>
                      to experimenters. Please click the session title(s) for printing NOW <font color="ff0000">OR </font></li> "My Experiments" for printing LATER
                      </ul>
                        
                      </div>
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td class="normal"> 
                      <div><ul><li>If you want to cancel the sign-up(s), check the box(es), then click 
                      <input type="submit" name="undo" value="Cancel" onclick="getConfirm()"></li>
                      </div>
                    </td>
                  </tr>                  
                </table>
                  <input type="hidden" name="id" value="<? echo $id; ?>">
                  <input type="hidden" name="mode" value="<? echo $mode; ?>">
                  <input type="hidden" name="sessions" value="<? echo $sessions; ?>">
                  <input type="hidden" name="description" value="<? echo $description; ?>">
                  <input type="hidden" name="experimenters" value="<? echo $experimenters; ?>">

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
                    <td width="16%" class="tablecolumn" valign="top">Reward</td>
                  </tr>
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
                	for ( $i=1; $i<=$sessions; $i++){
                		
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
		if ($undo == "Cancel"){
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
		else{
		/* 
	        	if ( $mode == "All" ){
			$query = "insert into waitingList (sessionid, loginName, signOn) values ('$id','$loginName',now())";
			$query2 = "insert into signupexp (expid, loginName, signOn) values ('$id','$loginName',now())";
			$rs = $db->query($query);
			$rs = $db->query($query2);
	        	}
	        	elseif ( $mode == "One" ){
			$query = "insert into waitingList (sessionid, loginName, signOn) values ('$sessions_array[1]','$loginName',now())";
			$query2 = "insert into signupexp (expid, loginName, signOn) values ('$sessions_array[1]','$loginName',now())";
			$rs = $db->query($query);
			$rs = $db->query($query2);	        	
	        	}
	        	elseif ( $mode == "Any" ){
	        		for ( $i=1; $i<= count($sessions_array); $i++){
	        			$query = "insert into waitingList (sessionid, loginName, signOn) values ('$sessions_array[$i]','$loginName',now())";
					$query2 = "insert into signupexp (expid, loginName, signOn) values ('$sessions_array[$i]','$loginName',now())";
				}
		        }
	        	else { 
			}
		*/
		}

		//$rs->close();		
		$db->close();
		
		if ( $mode == "All" ) {
			$Allsessions[1] = $id;
		}
		else if($mode == "One"){
			$Allsessions = subject_signup_which_session($loginName,$id);
			for ( $i = 0; $i<= count($Allsessions); $i ++ ){
			}			
		} 
		else{
			$Allsessions = subject_signup_which_session($loginName,$id);
			/*
			for ( $i = 1; $i <= $sessions; $i++ ){
				if ($i < 10){
					$no = "0"."$i";
				}
				else { $no = "$i"; }
				$Allsessions[$i] = $id.$no;
			}
			*/
		}
		                                        		
                     list_sessions_signupstage($id,$loginName,$mode,$Allsessions,$sessions); 
                     
                     //list_sessions_signupstage($id,$loginName,$mode,$sessions_array,$sessions); 
                  ?>
                </table>
              	
                </tr></td>
              
              	<tr> <td>
              	<?
	foot_menu();
	foot();

?>
              	
              	</tr></td>
              
              </table>
              
              
<? } ?>


<?
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
if (is_blocking($subjectprofile) && is_ust()){
		warningx(W0027);
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
if($is_checkbox_emt){
	warningx(W0021); exit;
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
	if(false){
	}
	else{
		content($title);
	}
}else{
	warningx(W0002);exit;
}
	
	


?>
