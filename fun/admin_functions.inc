<?
include("../fun/mysql.inc");
include("../fun/config.inc");
include("../fun/common.inc");
include("../fun/errmsg.inc");

$db = new phpDB();
$db->connect() or die ("Can't connect to database server or select database." . $db->errorMsg());

include("../fun/admin_mail.inc");

function check_password($password){
	$PASS = fopen(".htpasswd", "r");
	$pasStr = trim(fread($PASS, 1024));
	list($username, $oldpassword)  = explode(":", $pasStr);
	//echo "$username<br>$oldpassword<br>";
	if(crypt($password, substr($oldpassword, 0, 2)) == $oldpassword){
		
		return true;
	}
	else{
		//echo crypt($password, substr($oldpassword, 0, 2))."<br>$password";
		return false;
	}
}


function show_pool($selectall){
	global $db;	
	$query = "SELECT firstName, lastName, email, pool  FROM poolCoordinator order by pool ASC";

	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$pool = $rs->fields[pool];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$email = $rs->fields[email];
		
		?>
		  <tr> 
                    <td width="6%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($selectall !="") echo "checked"; ?>>
                      </div>
                    </td>
                    <td width="18%" valign="top" class="normal"><? echo $pool; ?></td>
                    <input type="hidden" name="pools[<? echo $i; ?>]" value="<? echo $pool; ?>">
                    <td width="16%" valign="top" class="normal"><? echo $firstName; ?></td>
                    <td width="17%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <td width="18%" valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email; ?>">
                    
                  </tr>
                <?
        }
        echo "<input type=\"hidden\" name=\"total\" value=\"$numOfRows\">";
	return $numOfRows;


}

function select_course(){
	global $db;
	$query = "select courseID, year, semester from course order by id asc";
	$rs= $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	//<option value="">Please Select One Course&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
	for($i=0; $i < $numOfRows; $i++){
		$rs->moveRow($i);
		$courseID = eregi_replace(" ", "_", $rs->fields[courseID]);
		$coursevalue = $courseID."--".$rs->fields[year]."--".$rs->fields[semester];
		$course = $rs->fields[courseID]."--".$rs->fields[year]."--".$rs->fields[semester];
				
		echo "<option value=\"$coursevalue\">$course</option>\n";
	}
	echo "</select>\n";
	
	
}


function show_all_experimenters($selectall){
	global $db;
	
	$query = "SELECT * FROM experimenter order by firstName ASC";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$password = $rs->fields[password];
		$sid = $rs->fields[sid];
		$phone = $rs->fields[phone];
		$email = $rs->fields[email];
		$remarks = $rs->fields[remarks];
		$instructor = $rs->fields[instructor];
		$hkust = $rs->fields[hkust];
		
		
		if($instructor == ""){
			$instructor = "&nbsp;";
		}
		if($remarks == ""){
			$remarks = "&nbsp;";
		}
		if($phone == ""){
			$phone = "&nbsp;";
		}
		if($email == ""){
			$email = "&nbsp;";
		}
		
		if($sid == ""){
			$sid = "&nbsp;";
		}
		
		
		?>
		
		
		<tr> 
                    <td width="6%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]"<?
				if($selectall !="")
					echo "checked ";
			?>>
                      </div>
                    </td>
                    <td width="6%" valign="top" class="normal"><? echo $firstName; ?></td>
                    <td width="6%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <td width="10%" valign="top" class="normal"><? echo $loginName; ?></td>
                    <input type="hidden" name="loginNames[<? echo $i; ?>]" value="<? echo $loginName; ?>">
                    <td width="12%" valign="top" class="normal"><? echo $sid ;?></td>
                    <td width="8%" valign="top" class="normal"><? echo $phone ;?></td>
                    <td width="12%" valign="top" class="normal"><a href="mailto:<? echo $email ;?>"><? echo $email ;?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email; ?>">
                    <td width="25%" valign="top" class="normal"><? echo $remarks ;?></td>
                    <td width="3%" valign="top" class="normal"><? echo $hkust ;?></td>
                  </tr>
                <?  

		
        }
        echo "<input type=\"hidden\" name=\"total\" value=\"$numOfRows\">";
        return $numOfRows;
	
}

function expid($expid){
	global $PHP_SELF;
	global $db;
	
	$query = "SELECT id FROM experiment WHERE id = '$expid' ";
	$rs = $db->query($query);	
	$numOfRows = $rs->getNumOfRows();
	
	if($numOfRows){
		$rs->firstRow();	/*	optional, but recommended.	*/
		$expid = $rs->fields[id];
		
		return $expid;
	}
	else{
		return false;
	}
	
}



function list_all_courses($pool, $selectall){
	if($selectall != ""){
		$checked = "checked";
	}
	 	
	global $db;
	
	
	$query = "SELECT * FROM course where enable='y' and authcode<>'' and signUpCode<>'' order by courseID, year ASC";
		
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
	 	$courseID = $rs->fields[courseID];
	 	$year = $rs->fields[year];
	 	$semester = $rs->fields[semester];
	 	$firstName = $rs->fields[firstName];
	 	$lastName = $rs->fields[lastName];
	 	$email = $rs->fields[email];
	 	$signUpCode = $rs->fields[signUpCode];
	 	
	 	if($signUpCode == ""){
	 		$signUpCode = "&nbsp;";
	 	}
	 	
	 	$authcode = $rs->fields[authcode];
	 	
	 	if($authcode == ""){
	 		$authcode = "&nbsp;";
	 	}
	 	
	 	?>
	 	<tr> 
                    <td valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? echo $checked; ?>>
                      </div>
                    </td>
                    <td valign="top" class="normal"><? echo $courseID; ?></td>
                     <td valign="top" class="normal"><? echo $year; ?></td>
                      <td valign="top" class="normal"><? echo $semester; ?></td>
                    <input type="hidden" name="courseIDs[<? echo $i; ?>]" value="<? echo $courseID."--".$year."--".$semester; ?>">
                    <td valign="top" class="normal"><? echo $firstName; ?></td>
                    <td valign="top" class="normal"><? echo $lastName; ?></td>
                    <td valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email; ?>">
                    
                    <? if(trim($pool)==""){ ?>
                    <td valign="top" class="normal"><? echo $signUpCode; ?></td>
                    <? } ?>
                    <td valign="top" class="normal"><? echo $authcode; ?></td>
                 </tr>
                 <?
                 
        }
        ?>
        <input type="hidden" name="total" value="<? echo $numOfRows; ?>">
        <?
        
        return $numOfRows;
}


                

// function to show one experimenter infor
function show_experimenter_info($loginName, $send){
	
  	if($loginName !=""){
		global $db;
		
		$query = "SELECT * FROM experimenter Where loginName='$loginName'";
		$rs = $db->query($query);
	
		$rs->firstRow();
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$password = $rs->fields[password];
		$sid = $rs->fields[sid];
		$phone = $rs->fields[phone];
		$email = $rs->fields[email];
		$remarks = $rs->fields[remarks];
		$instructor = $rs->fields[instructor];
		$hkust = $rs->fields[hkust];
	
	}
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Experimenter 
                      e-Recruit Login Name :</td>
                    <td width="40%" bgcolor="ffffcc">
                    <input type="text" name="loginName" value="<? echo $loginName; ?>">
                      <input type="hidden" name="oldloginname" value="<? echo $loginName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Experimenter Password :</td>
                    <td width="40%">
                    <input type="password" name="password" value="<? echo $password; ?>">
                      <input type="hidden" name="oldpassword" value="<? echo $password; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">First Name(s) (e.g. Tai Man) :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="firstName" value="<? echo $firstName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Last Name (e.g. Chan) :</td>
                    <td width="40%"> 
                      <input type="text" name="lastName" value="<? echo $lastName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">*Staff/Student ID :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="sid" value="<? echo $sid; ?>">
                    </td>
                  </tr>
                  <input type="hidden" name="instructor" value="<? echo $instructor; ?>">
                  
                  <tr> 
                    <td width="60%" class="normal">*Phone No(s) (e.g. 97123456, 23821234) :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="phone" value="<? echo $phone; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Email Address :</td>
                    <td width="40%"> 
                      <input type="text" name="email" value="<? echo $email; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal"><? echo ORG_SHORT; ?> Experimenter? :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      	<select name="hkust">
                      		<?
                      			if(isset($hkust)){
                      				echo "<option value=\"$hkust\" selected>$hkust</option>\n";
                      			}
                      		?>
       				<option value="Yes">Yes</option>
       				<option value="No">No</option>
           		</select>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="60%" class="normal"  bgcolor="ffffcc">*Remarks :</td>
                    <td width="40%" > 
                      <input type="text" name="remarks" value="<? echo $remarks; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="tablerow">&nbsp;</td>
                    <td width="40%"> 
                      <div align="right">
                      <?
                 if($send == ""){
                        
                        echo "<input type=\"submit\" name=\"";
                        	if($loginName !="")
                        		echo "Modify";
                        	else
                        		echo "Add";
                        echo "\" value=\"";
                        	if($loginName !="")
                        		echo "Modify";
                        	else
                        		echo "Add";
                        
                        echo "\">";
                        
                        echo "<input type=\"reset\" name=\"reset\" value=\"Reset\">";
                        
                 }
                 if($loginName != ""){
                 	echo "<input type=\"submit\" name=\"sendtoexp\" value=\"Send to Experimenter\">";
                 }
                        
                 if($send =="send"){
                 	echo "<br><input type=\"submit\" name=\"gotoexp\" value=\"Go to Experimenter Management\">";
		 }
                        
                        ?>
                      </div>
                    </td>
                  </tr>
                </table>
                
                
<?
                
}

// function to show one experimenter infor
function confirm_experimenter_info($loginName, $password){
	
  	if($loginName !=""){
		global $db;
		
		$query = "SELECT * FROM experimenter Where loginName='$loginName'";
		$rs = $db->query($query);
	
		$rs->firstRow();
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$sid = $rs->fields[sid];
		
		if($sid == ""){
			$sid = "&nbsp;";
		}
		
		
		$phone = $rs->fields[phone];
		
		if($phone == ""){
			$phone = "&nbsp;";
		}
		
		$email = $rs->fields[email];
		$remarks = $rs->fields[remarks];
		
		if($remarks == ""){
			$remarks = "&nbsp;";
		}
		
		$instructor = $rs->fields[instructor];
		
		if($instructor == ""){
			$instructor = "&nbsp;";
		}
		
		$hkust = $rs->fields[hkust];
		
		
	}
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Experimenter 
                      e-Recruit Login Name :</td>
                    <td width="40%" bgcolor="ffffcc">
                    <? echo $loginName; ?>
                      <input type="hidden" name="loginName" value="<? echo $loginName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Experimenter Password :</td>
                    <td width="40%">
                    <? echo "*************"; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">First Name(s) (e.g. Tai Man) :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <? echo $firstName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Last Name (e.g. Chan) :</td>
                    <td width="40%"> 
                      <? echo $lastName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">*Staff/Student ID :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <? echo $sid; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">*Phone No(s) (e.g. 97123456, 23821234) :</td>
                    <td width="40%" > 
                      <? echo $phone; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Email Address :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <? echo $email; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal"><? echo ORG_SHORT; ?> Experimenter? :</td>
                    <td width="40%"> 
                      	<? echo $hkust; ?>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="60%" class="normal"  bgcolor="ffffcc">*Remarks :</td>
                    <td width="40%"  bgcolor="ffffcc"> 
                      <? echo $remarks; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="tablerow">&nbsp;</td>
                    <td width="40%"> 
                      <div align="right">
                      <?
               
                 
                 	echo "<input type=\"submit\" name=\"sendtoexp\" value=\"Send to Experimenter\">";
                 
                 	echo "<br><input type=\"submit\" name=\"gotoexp\" value=\"Go to Experimenter Management\">";
		        ?>
                      </div>
                    </td>
                  </tr>
                </table>
                
                
<?
                
}


//function to check experimenter info
function check_experimenter_info($infoStr){
	if($infoStr =="")
		exit();
		
	$info = explode("->", $infoStr);
	$loginName = $info[0];
	$firstName = $info[1];
	$lastName = $info[2];
	$password = $info[3];
	
	$sid = $info[4];
	$phone = $info[5];
	$email = $info[6];
	$remarks = $info[7];
	$instructor = $info[8];
	$hkust = $info[9];
	$action = $info[10];
	
	if($action != "Add"){
		$oldloginname = $info[11];
		$oldpassword =  $info[12];
	}
	
	
	if($loginName =="" ){
		warning(S0009);
		exit();
	}
	
	if($password == ""){
		warning(S0018);
		exit();
	}
	
	if($firstName ==""){
		warning(S0009);
		exit();
	}
	
	if($lastName ==""){
		warning(S0010);
		exit();
	}
	
	if($email ==""){
		warning(S0011);
		exit();
	}
	if($sid != "" && !eregi("^[0-9]{3,10}", $sid)){
		warning(S0031);
		exit;
	}
	
	
	if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)) {
		
		warning(S0013);
		exit();
	}
	
	$uncryptpassword = $password;
	$password = crypt($password);
	
	global $db;
	
	
	
	
	if($action == "Add"){
		$query = "SELECT loginName from experimenter where loginName='$loginName'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
	
		if($numOfRows ){
			warning(S0032);
			exit();
		}
		
		$query = "SELECT email from experimenter where email='$email' and hkust='Yes'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		
		if($numOfRows ){
			warning("(Message no.S1008)There is already an ".ORG_SHORT." experimenter with Email: $email. <br>
				Please go to <a href=\"Experimenter_Management.php\">experimenter management</a> and delete the old account first.");
			
			exit();
		}
		
		
		$query = "INSERT INTO experimenter (loginName, firstName, lastName, password, sid, phone, email, remarks, instructor, hkust)";
		$query .=" VALUES ('$loginName', '$firstName', '$lastName', '$password', '$sid', '$phone', '$email', '$remarks', '$instructor', '$hkust')";
	}
	else{
		if($loginName != $oldloginname){
			$query = "SELECT loginName from experimenter where loginName='$loginName'";
			$rs = $db->query($query);
			$numOfRows = $rs->getNumOfRows();
	
			if($numOfRows ){
				warning(S0032);
				exit();
			}
			
		}
		if($uncryptpassword == $oldpassword){
			$password = $oldpassword;
		}
		
		
		$query = "UPDATE experimenter SET loginName='$loginName', firstName='$firstName' , lastName='$lastName', password='$password', 
		sid='$sid', phone='$phone', email='$email', remarks='$remarks', instructor='$instructor', hkust='$hkust' where loginName='$oldloginname'";
		
	}
	
	$rs = $db->query($query);
	return $loginName;
	
}



//show warning message

function show_experiments_of_experimenter($loginName){
	if($loginName != ""){
		global $db;
		
		$query = "SELECT firstName, lastName from experimenter where loginName = '$loginName'";
		$rs = $db->query($query);
		
		$rs->firstRow();
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
?>
		<table width="61%" border="0" cellpadding="3" align="left">
                <tr> 
                  <td width="51%" class="normal">Experimenter Name : </td>
                  <td width="49%" bgcolor="ffffcc" class="tablerow"><? echo $lastName.", ".$firstName; ?></td>
                </tr>
                <tr> 
                  <td width="51%" class="normal">Experimenter Login Name :</td>
                  <td width="49%" bgcolor="ffffcc" class="tablerow"><? echo $loginName; ?></td>
                </tr>
                <tr>
                
<?
		$condition = "experimenters like '$loginName"."->%'";
		
		$query = "SELECT id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated FROM experiment WHERE enable='y' and $condition order by id asc";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
?>
               <td width="51%" class="normal">Number of Experiment(s) created:</td>
                  <td width="49%" bgcolor="ffffcc" class="tablerow"><? echo $numOfRows; ?></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p><br>
                <br>
              </p>
              <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
              <tr bgcolor="#000099" valign="top"> 
                  
                    <td width="10%" class="tablecolumn">Experiment ID</td>
                    <td width="25%" class="tablecolumn">Experiment Title</td>
                    <td width="15%" class="tablecolumn">Last Modified On</td>
                    <td width="10%" class="tablecolumn">Session</td>
                    <td width="15%" class="tablecolumn">Attendance and  Credit Records Submitted on</td>
                    <td width="25%" class="tablecolumn">Deadline for submitting Attendance and Credits Records</td>
                  
                </tr>
              
<?		
	for($i=0; $i< $numOfRows; $i++){ //$numOfRows
		$rs->moveRow($i);
		$expid = $rs->fields[id];
		$title = $rs->fields[title];
		//$description = $rs->fields[description];
		$createdon = date("jM Y", $rs->fields[dateCreated]);
?>
	
	        <tr> 
                  <td width="10%" valign="top"> 
                    <div align="center" class="normal"><? echo $expid; ?></div>
                  </td>
                  <td width="25%" valign="top" class="normal"><? echo $title; ?></a></td>
                  <td width="15%" valign="top" class="normal"><? echo $createdon; ?></td>
                  <td width="10%" class="tablecolumn">&nbsp;</td>
                  <td width="15%" class="tablecolumn">&nbsp;</td>
                  <td width="25%" class="tablecolumn">&nbsp;</td>
                </tr>
<?

                $query = "SELECT id, UNIX_TIMESTAMP(fromdate) as startdate, durationEnd FROM session WHERE id like '$expid%' order by id asc";
		
		$rs1 = $db->query($query);
		$numOfRows1 = $rs1->getNumOfRows();
		for($j=0; $j <$numOfRows1; $j++){
			$rs1->moveRow($j);
		
			$sessionid = $rs1->fields[id];
			
			$startdate = $rs1->fields[startdate];
			$duration = $rs1->fields[durationEnd];
			$durationarr = explode("-", $duration);
			$duration_stamp = ($durationarr[0] *24*3600) + ($durationarr[1] * 3600) + ($durationarr[2] * 60);
			
			$submit_deadline_stamp = ($startdate + $duration_stamp + ($deadline * 3600));
			$submit_deadline = date("j M Y H:i", $submit_deadline_stamp);
			$query = "select UNIX_TIMESTAMP(max(date)) as submit_date from attendancy where sessionid=$sessionid";
			
			$rs2 = $db->query($query);
			$numOfRows2 = $rs2->getNumOfRows();
			
			if($numOfRows2){
				$rs2->firstRow();
				$asubmit_date = $rs2->fields[submit_date];
				//$submittedon = date("jM Y", $rs->fields[submitdate]);
			}
			$query = "select UNIX_TIMESTAMP(max(date)) as submit_date from credit where sessionid=$sessionid";
			$rs3 = $db->query($query);
			$numOfRows3 = $rs3->getNumOfRows();
			
			if($numOfRows3){
				$rs3->firstRow();
				$csubmit_date = $rs3->fields[submit_date];
				//$submittedon = date("jM Y", $rs->fields[submitdate]);
			}
			
			if($asubmit_date != "" || $csubmit_date != ""){
				if($asubmit_date > $csubmit_date){
					$submittedon = date("j M Y", $asubmit_date);
				}
				else{
					$submittedon = date("j M Y", $csubmit_date);
				}
			}
			else{
				$submittedon = "Never";
			}
			
			
                  ?>
	                <tr> 
        	           <td width="50%" colspan="3"><? echo "&nbsp;"; ?></td>
                  	   <td width="10%"><? echo substr($sessionid, 8, 2); ?></td>
                    	   <td width="15%"><? echo "$submittedon"; ?></td>
                    	   <td width="25%" valign="top" class="normal"><? echo "$submit_deadline"; ?></td>
                   
                  	</tr>	
                  <?
                }
	}
  
?>


<?
}

return $numOfRows;
}




// function to show subject record;
function show_subject_record($condition, $selectall){
	global $db;
	
	$queryStr = explode("->", $condition);
	if($queryStr[0] == "name"){
		$firstName = $queryStr[1];
		$lastName = $queryStr[2];
		$conditions = "firstName like '$firstName%' and lastName like '$lastName%'";
		
	}else{
		$conditions = "email like '$condition%'";
	}
		$query = "SELECT firstName, lastName, loginName, email, phone, sex, hkust, stuID FROM subject Where $conditions";
	
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$loginName = $rs->fields[loginName];
		$phone = $rs->fields[phone];
		$email = $rs->fields[email];
		$sex = $rs->fields[sex];
		$hkust = $rs->fields[hkust];
		$stuid = $rs->fields[stuID];
		
		if($hkust != "0" && $hkust != ""){
			$hkust = "Yes";
		}
		else{
			$hkust = "No";
		}
		
		if($stuid == "0"){
			$stuid = "N/A";
		}
		
	?>
	
	<tr> 
                    <td width="10%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($checked == "checked") echo $checked; ?>>
                      </div>
                    </td>
                    <td valign="top" class="normal"><? echo $firstName; ?>
                    </td>
                    <td valign="top" class="normal"><? echo $lastName; ?></td>
                    <td valign="top" class="normal"><? echo $loginName; ?></td>
                    <td valign="top" class="normal"><? echo $sex; ?></td>
                    <td valign="top" class="normal"><? echo $phone; ?></td>
                    <td valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <td valign="top" class="normal"><? echo $stuid; ?></td>
                 <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                 <td width="15%" valign="top" class="normal"><? echo $hkust; ?></td>
                  </tr>		
	
<?
	}
?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
	
<?
return $numOfRows;
}



//funtion to add/modify course
function add_course_layout($modify, $signup, $send){
	if($modify != ""){
		global $db;
		list($courseid, $year, $semester) = explode("--", $modify);
		$query = "SELECT * FROM course where courseID='$courseid' and year='$year' and semester='$semester'";
		$rs = $db->query($query);
		$rs->firstRow();
	 	$courseID = $rs->fields[courseID];
	 	$firstName = $rs->fields[firstName];
	 	$lastName = $rs->fields[lastName];
	 	$email = $rs->fields[email];
	 	$signUpCode = $rs->fields[signUpCode];
	 	$authcode = $rs->fields[authcode];
	 	$year = $rs->fields[year];
	 	$semester = $rs->fields[semester];
	 	$modify = urlencode($modify);
	}
	?>
		
		
              <form name="form1" method="post" action="Check_Course.php<? if($modify != "") echo "?courseID=$modify"; ?>" >
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Course (e.g. MARK 231 L1) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="course" value="<? echo $courseID; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Year :</td>
                    <td width="56%">
                      <select name="year">
                      <? 
                      if(isset($year))
                       echo "<option selected value=\"$year\">$year</option>";
                       for($i=2000; $i<2051; $i++){
                      		echo "<option value=\"$i\">$i</option>\n\t\t\t";
                      	}
                      ?>
                      </select>
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="44%" class="normal">Semester :</td>
                    <td width="56%">
                      <select name="semester">
                       <? if(isset($semester) )
                       echo "<option selected value=\"$semester\">$semester</option>";
                       ?>
                        <option value="SPRING">SPRING</option>
                        <option value="SUMMER">SUMMER</option>
                        <option value="FALL">FALL</option>
                        <option value="WINTER">WINTER</option>
                      </select>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal">First Name(s) (e.g. Tai Man):</td>
                    <td width="56%"> 
                      <input type="text" name="firstName" value="<? echo $firstName; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Last Name (e.g. Chan) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="lastName" value="<? echo $lastName; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Email Address :</td>
                    <td width="56%">
                      <input type="text" name="email" value="<? echo $email; ?>" size="20">
                    </td>
                  </tr>
                  <? 
                  if($signup != ""){
                  ?>	
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">System Generated Sign-Up Code :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="signUpCode" value="<?
                      	if($modify =="" || (isset($signUpCode) && $signUpCode=="")){
                      		$md5str = MD5( TIME() );
                      		
                      		$signUpCode = substr($md5str, 0, 8);
                      		
                      	}
                      	       	 echo $signUpCode; ?>" maxlength="8" size="20">
                    </td>
                  </tr>
                  <?
                  }
                ?>
                  <tr> 
                  <tr> 
                    <td width="44%" class="normal">System Gernerated Course Authorization Code :</td>
                    <td width="56%"> 
                      <input type="text" name="authcode" value="<?
                      	if($authcode == ""){
                      		srand((double)microtime()*1000000);
				$valuestr = rand(102344, 999999);
                      		$authcode = substr($valuestr, 0, 6);
                      	}	
                      	
                      	       	 echo $authcode; ?>" maxlength="6" size="20">
                    </td>
                  </tr>
                  
                  <tr> 
                  
                    <td colspan="2" class="tablerow"> 
                      <div align="right"> 
                        <?
                 if($modify == ""){
                        
                        echo "<input type=\"submit\" name=\"";
                        	
                        		echo "submit";
                        echo "\" value=\"";
                        		echo "Add";
                        
                        echo "\">";
                        
                        echo "<input type=\"reset\" name=\"reset\" value=\"Reset\">";
                        
                 }else{
                 	echo "<input type=\"submit\" name=\"";
                        	
                        		echo "submit";
                        echo "\" value=\"";
                        		echo "Modify";
                        
                        echo "\">";
                        
                        echo "<input type=\"reset\" name=\"reset\" value=\"Reset\">";
                }
                
                 
                 if($modify != ""){
                 	echo "<input type=\"submit\" name=\"sendtocouse\" value=\"Send to Course Instructor\">";
                 }
                        
                 if($send =="send" && $modify == ""){
                 	echo "<br><input type=\"submit\" name=\"gotoexp\" value=\"Go to Course Management\">";
		 }
                        
                        ?>
                      </div>
                    </td>
                  </tr>
                </table>
                </form>
<?
}

//funtion to show course detail course
function show_course_layout($courseidstr){
	
		global $db;
		global $PHP_SELF;
		
		list($courseID, $year, $semester) = explode("--", $courseidstr);
		$query = "SELECT * FROM course where courseID='$courseID' and year='$year' and semester='$semester'";
		$rs = $db->query($query);
		$rs->firstRow();
	 	$courseID = $rs->fields[courseID];
	 	$firstName = $rs->fields[firstName];
	 	$lastName = $rs->fields[lastName];
	 	$email = $rs->fields[email];
	 	$signUpCode = $rs->fields[signUpCode];
	 	$authcode = $rs->fields[authcode];
	 	$year = $rs->fields[year];
	 	$semester = $rs->fields[semester];
	 	
	
	?>
		
		
              <form name="form1" method="post" action="<? echo $PHP_SELF ?>" >
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Course (e.g. MARK 231 L1) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <? echo $courseID; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Year :</td>
                    <td width="56%">
                      <? echo $year; ?>
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="44%" class="normal">Semester :</td>
                    <td width="56%">
                      <? echo $semester; ?>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal">First Name(s) (e.g. Tai Man):</td>
                    <td width="56%"> 
                      <? echo $firstName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Last Name (e.g. Chan) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <? echo $lastName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Email Address :</td>
                    <td width="56%">
                      <? echo $email; ?>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">System Generated Sign-Up Code :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <? echo $signUpCode; ?>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal">System Generated Authorization Code :</td>
                    <td width="56%">
                      <? echo $authcode; ?>
                    </td>
                  </tr>
                  <tr> 
                  
                    <td colspan="2" class="tablerow"> 
                      <div align="right"> 
                      <input type="hidden" name="courseidstr" value="<? echo $courseidstr; ?>">
                        <?
                 
                 	echo "<input type=\"submit\" name=\"sendtocouse\" value=\"Send to Course Instructor\">";
                 	echo "<br><input type=\"submit\" name=\"gotocourse\" value=\"Go to Course Management\">";
		        
                        ?>
                      </div>
                    </td>
                  </tr>
                </table>
                </form>
<?
}




// function to add/modify a course

function add_course($courseStr){
	$courseval = explode("->", $courseStr);
	$courseID = $courseval[0];
	$firstName = $courseval[1];
	$lastName = $courseval[2];
	$email = $courseval[3];
	$signUpCode = $courseval[4];
	$authcode = $courseval[5];
	$pool = $courseval[6];
	$submit = $courseval[7];
	$semester = $courseval[8];
	$year = $courseval[9];
        list($oldcourseID, $oldyear, $oldsemester) = split("--", $submit); 

	
	global $db;
	
	
	
	if($submit == "Add"){
		$query = "INSERT into course (courseID, firstName, lastName, email, pool, signUpCode, authcode, semester, year) values ('$courseID', '$firstName', '$lastName', '$email', '$pool', '$signUpCode', '$authcode', '$semester', '$year')";
	}
	else{
	        $query = "UPDATE course set courseID='$courseID', firstName='$firstName', lastName='$lastName', email='$email', pool='$pool', signUpCode='$signUpCode', authcode='$authcode', semester='$semester', year='$year' where courseID='$oldcourseID' and year=$oldyear and semester='$oldsemester'";	
                   //echo $query;
	}
	if($db->query($query))
		return true;
	else
		return false;
}
	
		
// function to get the check whether a session id is valid or not.	
function is_valid_sessionid($sessionid){
	global $db;
	$query = "select count(*) as total from session where id=$sessionid";
	$rs = $db->query($query);
	$total = $rs->fields[total];
	if($total){
		return true;
	}
	return false;
}

		
	


// function to show experienced subjects
function show_experienced_subjects($condition, $selectall){
	global $db;

	$c0 = $condition[0];
	$c1 = $condition[1];
	$c2 = $condition[2];
	$c3 = $condition[3];
	$c4 = $condition[4];
	$c5 = $condition[5];
	$c6 = $condition[6];
	
	// Search for the first row of session ids
	$c2 = eregi_replace(" ", "", $c2);
	$nID = sizeof(explode(",", $c2));
	
	
	if($c1 == "any"){
		$query = "select distinct loginName from attendancy where attendancy='experienced' and sessionid in ($c2)";
	}else{
		$query = "select loginName from attendancy where attendancy='experienced' and sessionid in ($c2)
			group by loginName having count(loginName)=$nID";
	}
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		
		$loginName = $rs->fields[loginName];
		
		if($i != $numOfRows -1){
			$cond1 .=  "$loginName','";
		}
		else{
			$cond1 .=  "$loginName";
		}
	}
	
	if($c0 != "experienced"){
		$query = "select loginName from subject where loginName not in ('$cond1')";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
	
	
		$cond1 = "";	
		for($i=0; $i <$numOfRows; $i++){
			$rs->moveRow($i);
		
			$loginName = $rs->fields[loginName];
		
			if($i != $numOfRows -1){
				$cond1 .=  "$loginName','";
			}
			else{
				$cond1 .=  "$loginName";
			}
		}
	}
	
		
	
	// Search for the last row of session ids
	$c6 = eregi_replace(" ", "", $c6);
	$nID = sizeof(explode(",", $c6));
	
	if($c5 == "any"){
		$query = "select distinct loginName from attendancy where attendancy='experienced' and sessionid in ($c6)";
	}
	else{
		$query = "select loginName from attendancy where attendancy='experienced' and sessionid in ($c6)
			group by loginName having count(loginName)=$nID";
	}
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		
		$loginName = $rs->fields[loginName];
		
		if($i != $numOfRows -1){
			$cond2 .=  "$loginName','";
		}
		else{
			$cond2 .=  "$loginName";
		}
	}
	
		
	if($c4 != "experienced"){
		$query = "select loginName from subject where loginName not in ('$cond2')";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
	
	
		$cond2 = "";	
		for($i=0; $i <$numOfRows; $i++){
			$rs->moveRow($i);
		
			$loginName = $rs->fields[loginName];
		
			if($i != $numOfRows -1){
				$cond2 .=  "$loginName','";
			}
			else{
				$cond2 .=  "$loginName";
			}
		}
	}
	
	
	
	if($selectall != "")
		$checked = "checked";
	
	$query = "SELECT loginName, firstName, lastName, sex, phone, email, hkust, stuID FROM subject where loginName in ('$cond1') $c3 loginName in ('$cond2')  order by id ASC";
	//echo $query;
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$phone = $rs->fields[phone];
		$stuid = $rs->fields[stuID];
		
		if($stuid == "0"){
			$stuid = "N/A";
		}
		
		
		if($phone == ""){
			$phone = "&nbsp;";
		}
		$email = $rs->fields[email];
		$sex = $rs->fields[sex];
		$hkust = $rs->fields[hkust];
		
		if($hkust != "0" && $hkust != ""){
			$hkust = "Yes";
		}
		else{
			$hkust = "No";
		}
		 
	?>
	<tr> 
                    <td width="10%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($checked == "checked") echo $checked; ?>>
                      </div>
                    </td>
                    <td valign="top" class="normal"><? echo $firstName; ?></td>
                    <td valign="top" class="normal"><? echo $lastName; ?></td>
                    <td valign="top" class="normal"><? echo $loginName; ?></td>
                    <td valign="top" class="normal"><? echo $sex; ?></td>
                    <td valign="top" class="normal"><? echo $phone; ?></td>
                    
                    <td valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                 <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                 <td valign="top" class="normal"><? echo $stuid; ?></td>
                 <td width="5%" valign="top" class="normal"><? echo $hkust; ?></td>
                  </tr>
<?
	}
?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
	
<?
return $numOfRows;
}




function show_blocked_subjects($conditionStr){
	global $db;
	$condition = explode("->", $conditionStr);
	
	$type = $condition[0];
	$submit = $condition[1];
	
	if($type == "attend"){
		$query = "select distinct loginName from blocklist where attend_type='1' and unblockdate > now()";
	}else{
		$query = "select distinct loginName from blocklist where cancel_type='1' and unblockdate > now()";
	}
	
	
	//echo $query;
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		
		$loginName = $rs->fields[loginName];
		
		if($i != $numOfRows -1){
			$cond .=  "loginName='$loginName' or ";
		}
		else{
			$cond .=  "loginName='$loginName'";
		}
	}
	
	
	if($submit != "")
		$checked = "checked";
	
	$query = "SELECT  firstName, lastName, sex, phone, email, hkust FROM subject where $cond  order by id ASC";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$phone = $rs->fields[phone];
		
		if($phone == ""){
			$phone = "&nbsp;";
		}
		$email = $rs->fields[email];
		$sex = $rs->fields[sex];
		$hkust = $rs->fields[hkust];
		
		if($hkust != "0" && $hkust != ""){
			$hkust = "Yes";
		}
		else{
			$hkust = "No";
		}
		 
	?>
	
	<tr> 
                    <td width="10%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($checked == "checked") echo $checked; ?>>
                      </div>
                    </td>
                    <td width="20%" valign="top" class="normal"><? echo $firstName; ?>
                    </td>
                    <td width="15%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <td width="10%" valign="top" class="normal"><? echo $sex; ?></td>
                    <td width="10%" valign="top" class="normal"><? echo $phone; ?></td>
                    <td width="10%" valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                 <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                 <td width="15%" valign="top" class="normal"><? echo $hkust; ?></td>
                  </tr>		
	
<?
	}
?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
	
<?
return $numOfRows;
}

// this function is check whether the course is exist or not
function course_exist($course, $pool){
	global $db;
	
	list($courseID, $year, $semester) = explode("--", $course);
	$query = "SELECT courseID FROM course where enable='y' courseID='$courseID' and year='$year' and semester='$semester' and pool='$pool'";
	
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	//echo $query;
	if($numOfRows)
		return true;
	else
		return false;
}
	

//function to show experimenter with specified pool
function show_pool_experiments($pool, $selectall){
	global $db;
	
	$condition = "target='pool->$pool'";
	$query = "SELECT id, title, experimenters, UNIX_TIMESTAMP(dateCreated) as dateCreated FROM experiment WHERE enable='y' and $condition order by id asc";
	//echo $query;
	$rs = $db->query($query);
	
	
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		
		$id = $rs->fields[id];
		$title = $rs->fields[title];
		$experimenters = $rs->fields[experimenters];
		
		$experimenters = explode("->", $experimenters);
		$experimenter = $experimenters[0];
		$query = "select email from experimenter where loginName='$experimenter'";
		$rs1= $db->query($query);
		$rs1->firstRow();
		$email = $rs1->fields[email];
		
		
		$createdon = date("jM Y", $rs->fields[dateCreated]);
		?>
		  <tr> 
                    <td width="5%" valign="top"> 
                      <div align="center" class="normal">
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($selectall !="") echo "checked"; ?> >
                      </div>
                    </td>
                    <td width="12%" valign="top" class="normal"><? echo $id; ?></a></td>
                    <td width="30%" valign="top" class="normal"><? echo $title; ?></td>
                    <td width="22%" valign="top" class="normal"><? echo $experimenter; ?></td>
                    <td width="31%" valign="top" class="normal"><? echo $createdon; ?></td>
                   <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                  </tr>		
	
<?
	}
?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
<?
}





// function to show a course info
function course_info($courseID){
	global $db;
	
	$query = "SELECT firstName, lastName, email FROM course where courseID='$courseID' ";
		
	$rs = $db->query($query);
	$rs->firstRow();
	 	
	 $firstName = $rs->fields[firstName];
	 $lastName = $rs->fields[lastName];
	 $email = $rs->fields[email];
	 	
	
      
      
      
      ?>
              <table width="46%" border="0" cellpadding="3" align="left" cellspacing="0">
                <tr> 
                  <td width="42%" class="normal">Course :</td>
                  <td width="58%" class="tablerow"><? echo $courseID; ?></td>
                </tr>
                <tr> 
                  <td width="42%" class="normal" bgcolor="ffffcc">Instructor's Name :</td>
                  <td width="58%" bgcolor="ffffcc" class="tablerow"><? echo $firstName.", ".$lastName; ?></td>
                </tr>
                <tr>
                  <td width="42%" class="normal" height="21">Instructor's Email :</td>
                  <td width="58%" class="tablerow" height="21"><a href="mailto://<? echo $email; ?>"><? echo $email; ?></a></td>
                </tr>
              </table>
	<?
}


function pool_code($pool, $newsignupcode){
	global $db;
	
	if($newsignupcode==""){
		$query = "SELECT signUpCode from pool where id='$pool'";
		//echo $query;	
		$rs = $db->query($query);
		$rs->firstRow();
		 	
		//$deadline = $rs->fields[deadline];
		$signUpCode = $rs->fields[signUpCode];
        	echo $signUpCode;
	
	}
	else{
		$query = "update pool set signUpCode='$newsignupcode' where id='$pool'";
		
		$rs = $db->query($query);
	}
	
		
}

function pool_deadline($pool, $newdeadline){
	global $db;
	
	if($newdeadline ==""){
		$query = "SELECT UNIX_TIMESTAMP(deadline) as deadline from pool where id='$pool'";
		$rs = $db->query($query);
	
		$rs->firstRow();
	
		$deadline = date("jM Y", $rs->fields[deadline]);
	
      	echo $deadline;
	}
	else{
		$query = "UPDATE pool set deadline=$newdeadline where id='$pool'";
		//echo "$query";
		$rs = $db->query($query);
	}		
	
}



function del_course($courseID){
	$courseID = ereg_replace("_", " ", $courseID);                
	global $db;
	
	$query = "update course set enable='n' where courseID='$courseID'";
	
	$rs = $db->query($query);
	if($rs)
		return true;
	else
		return false;
}

function del_pool($pool){
	$pool = ereg_replace("_", " ", $pool);
	
	global $db;
	
	$query = "delete from poolCoordinator where pool='$pool'";
		
	if($db->query($query))
		return true;
	else
		return false;
}
	
function delExperimenter($loginName){
	global $db;
	
	$query = "delete from experimenter where loginName='$loginName'";
	
	$rs = $db->query($query);
	if($rs)
		return true;
	else
		return false;
}

function list_credit_student_earned($target, $selectall){
	list($pool, $courseID) = explode("->", $target);
	global $db;
	
	$condition = "pool->".$pool;
	$query = "select id, loginName from credit where pool='$pool' and course='$courseID' order by id asc";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$id = $rs->fields[id];
		$loginName = $rs->fields[loginName];
		$query = "select sum(credit) as totalcredit from credit where loginName='$loginName'";
		$rs1 = $db->query($query);
		$totalcredit = $rs1->fields[totalcredit];
		
		$query =" select firstName, lastName, email from subject where loginName='$loginName'";
		$rs3 = $db->query($query);
		$rs3->firstRow();
		$firstName = $rs3->fields[firstName];
		$lastName = $rs3->fields[lastName];
		$email = $rs3->fields[email];
		
	?>
		  <tr> 
                    <td width="8%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="ck<? echo $i; ?>" <? if($selectall !="") echo "checked"; ?>>
                      </div>
                    </td>
                    <input type="hidden" name="creditid<? echo $i; ?>" value="<? echo $id; ?>">
                    <input type="hidden" name="loginName[<? echo $i; ?>]" value="<? echo $loginName; ?>">
                    
                    <td width="15%" valign="top" class="normal"><? echo $firstName; ?></td>
                    <td width="10%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <td width="10%" valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <td width="15%" valign="top" class="normal"><? echo $totalcredit; ?></td>
                    <td width="42%" valign="top" class="normal">
                    <?
                    	$query = "select credit, sessionid from credit where loginName='$loginName' order by id asc";
				$rs3 = $db->query($query);
				$numOfRows2 = $rs3->getNumOfRows();
				for($j=0; $j <$numOfRows2; $j++){
					$rs3->moveRow($j);
					$credit = $rs3->fields[credit];
					$experiementid = substr($rs3->fields[sessionid], 0, 8);
					if($credit != 0){
						echo $credit."credit(s) from: (Exp ID: ".$experiementid.")<br>";
					}
				}
				
			?>
                    
                    
                    </td>
                  </tr>
                  <input type="hidden" name="total" value="<? echo $numOfRows; ?>">
<?
		
	}
	


}


function credit_delelte($ids){
	$id = explode("->", $ids);
	global $db;
	
	
	for($i=0; $i < sizeof($id); $i++){
		$cid = $id[$i];
		$query = "delete from credit where id='$cid'";
		$rs= $db->query($query);
	}
	
	
}

function subject_modify_data($loginName){
	global $db;
	
	$query = "select firstName, lastName, email from subject where loginName='$loginName'";
	$rs = $db->query($query);
	
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$email = $rs->fields[email];
	
	
	$returnStr = "$firstName"."->"."$lastName"."->"."$email";
	return $returnStr;
}


function add_student($firstName, $lastName, $email, $submit, $course, $pool){
	global $db;
	
	$query = "select loginName from subject where firstName='$firstName' and  lastName='$lastName' and email='$email'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		$loginName = $rs->fields[loginName];
		if($submit = "Add"){
			
			$query = "insert into credit (loginName, course, pool) values('$loginName', '$course', '$pool')";
			
		}
		else{ 
			$query = "update credit set loginName='$loginName'  where id = $submit";
		}
		$rs1 = $db->query($query);
	}
	else{
		warning(S0033);
	}
}



function assign_credit($loginName, $id, $expid1, $expid2, $credits){
	global $db;
	
	if($expid1 !="" && credits !=""){
		$query = "update credit set credit=$credits , sessionid=$expid1  where id = $id and loginName='$loginName'";
	

		$rs = $db->query($query);
	}
	if($expid2 !=""){
		$query = "update credit set credit=0 where sessionid='$expid2%'  and  id = $id and loginName='$loginName'";

		$rs = $db->query($query);
	}
	
}

	
function add_pool($poolStr){
	//$addStr = $poolname."->".$firstName."->".$lastName."->".$loginName."->".$password."->".$email."->".$submit."->".$oldpoolname."->".$oldloginName."->".$oldpassword;
	$poolval = explode("->", $poolStr);
	
	$poolname = $poolval[0];
	$firstName = $poolval[1];
	$lastName = $poolval[2];
	$loginName = $poolval[3];
	$uncryptpassword = $poolval[4];
	$password = crypt($poolval[4]);
	$email = $poolval[5];
	$submit = $poolval[6];
	
	if($submit != "Add"){
		$oldpoolname = $poolval[7];
		$oldloginname = $poolval[8];
		$oldpassword = $poolval[9];
		if($oldpassword == $uncryptpassword){
			$password = $oldpassword;
		}
		
		
	}
	
	
	global $db;
	
	if($submit == "Add"){
		$query = "select pool from poolCoordinator where pool='$poolname'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		if($numOfRows){
			warning("(Message no.S1009) The Pool: $poolname already exists");
			return false;
		}
	
		$query = "select loginName from poolCoordinator where loginName='".$loginName."'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		if($numOfRows){
			warning("(Message no.S1010)The Login Name: $loginName already exists.<br>\nPlease choose another one.");
			return false;
		}
	}else{
		if($oldloginname != $loginName){
			$query = "select loginName from poolCoordinator where loginName='".$loginName."'";
			$rs = $db->query($query);
			$numOfRows = $rs->getNumOfRows();
			if($numOfRows){
				warning("(Message no.S1011)The Login Name: $loginName already exists.<br>\nPlease choose another one.");
				return false;
			}
		}
		
		if($oldpoolname != $poolname){
			$query = "select pool from poolCoordinator where pool='$poolname'";
			$rs = $db->query($query);
			$numOfRows = $rs->getNumOfRows();
			if($numOfRows){
				warning("(Message no.S1012)The Pool: $poolname already exists.");
				return false;
			}
		}
	}
	
	
	if($submit == "Add"){
		$query = "insert into poolCoordinator (loginName,password,firstName,lastName,email, pool) values ('$loginName','$password','$firstName','$lastName','$email', '$poolname')";

	}
	else{
		$query = "UPDATE poolCoordinator set firstName='$firstName', lastName='$lastName', email='$email', password='$password', loginName='$loginName', pool='$poolname' where loginName='$oldloginname'";
		
	}
	if($db->query($query)){
		return true;
	}else{
		return false;
	}
}
	
	


function add_pool_layout($pool){
	if($pool !=""){
		global $db;
		
		$query = "select * from poolCoordinator where pool='$pool'";
		$rs = $db->query($query);
		$rs->firstRow();
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName  = $rs->fields[lastName];
		$email = $rs->fields[email];
		$password = $rs->fields[password];
		
	}
	
	
	?>


              <form name="form1" method="post" action="Check_Pool.php" >

                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Pool Name (e.g. MARK) :</td>
                    <td width="56%" bgcolor="ffffcc">
                      
                      <input type="text" name="poolname"  value="<? if(isset($pool)&& $pool !="") echo $pool; ?>">
                      <?
                      if(isset($pool)){
                      		echo "<input type=\"hidden\" name=\"oldpoolname\"  value=\"$pool\">\n";
                      }
                      ?>	
                    </td>
                  </tr>
                 
                  <tr> 
                    <td width="44%" class="normal">Coordinator Login Name(s) :</td>
                    <td width="56%"> 
                      <input type="text" name="loginName" value="<? if(isset($loginName)) echo $loginName; ?>">
                      <?
                      if(isset($pool)){
                      		echo "<input type=\"hidden\" name=\"oldloginname\"  value=\"$loginName\">\n";
                      }
                      ?>	
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Coordinator Password :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="password" name="password" value="<? if(isset($password)) echo $password; ?>">
                      <?
                      if(isset($pool)){
                      		echo "<input type=\"hidden\" name=\"oldpassword\"  value=\"$password\">\n";
                      }
                      ?>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal">Coordinator First Name(s) (e.g. Tai Man) :</td>
                    <td width="56%"> 
                      <input type="text" name="firstName" value="<? if(isset($firstName)) echo $firstName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Coordinator Last Name (e.g. Chan) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="lastName" value="<? if(isset($lastName)) echo $lastName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Coordinator's Email Address : </td>
                    <td width="56%"> 
                      <input type="text" name="email" value="<? if(isset($email)) echo $email; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="tablerow">
                    </td>
                    <td width="56%"> 
                      <div align="right"> 
                        <?
                        	if($pool!=""){
                        		$action = "submit";
                        		$actionvalue="Modify";
                        	}else{
                        		$action = "submit";
                        		$actionvalue="Add";
                        	}
                        	
                        	
                        
                       echo " <input type=\"submit\" name=\"$action\" value=\"$actionvalue\">";
                       ?>
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>

                </form>
                
       <?
}


function sendmail($person){
	
	global $total;
	global $checkbox;
	global $emails;
	global $PHP_SELF;
	global $cc;
	global $subject;
	global $message;
	
	$k=0;
	for($j=0; $j<$total; $j++){
		if($checkbox[$j] == "on"){
			$k++;
		}
	}
	if($k == 0 ){
		warning("(Message no.S1013)Please select $person"."(s) whom you want to send the message to.");
			exit;
	}
	if(isset($total) && $total >= 0 ){
		$cc = ereg_replace(" ", "", $cc);
		$ccmail = explode(",", $cc);
		
		// check for the cc mail is valid or not		
		for($l = 0; $l< sizeof($ccmail); $l++){
			if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $ccmail[$l]) && trim($ccmail[$l]) !="") {
  				warning(S0013);
			}
			if(trim($ccmail[$l]) !=""){
				adminMail("$ccmail[$l]", "$subject", "$message");
			}
			
		}

		// now send the mail to selected person
		for($i=0; $i<$total; $i++){
			if($checkbox[$i] == "on"){
				$email = $emails[$i];
				
				adminMail("$email", "$subject", "$message");
			
			}
		
		}
		$link = $PHP_SELF;
		message(S0034, $link);
		exit();
	}
	else{
		warning("(Message no.S1014)Please select $person"."(s) whom you want to send the message to.");
		exit();
	}
	

}


//function to send an email to the mailing list

function mailinglist($list, $course_list){
	global $db;
	global $cc;
	global $subject;
	global $message;
	global $PHP_SELF;
	
	$cc = ereg_replace(" ", "", $cc);
	$ccmail = explode(",", $cc);
	
	
	for($l = 0; $l< sizeof($ccmail); $l++){
		
		if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $ccmail[$l]) && trim($ccmail[$l]) !="") {
  			warning(S0013);
		}
		
		if(trim($ccmail[$l]) !=""){
			$email = $ccmail[$l];
			$emails .= $email.",";
		}
		
			
	}
	
	$select_emails = substr($emails, 0, strlen($emails)-1);
	$select_emails = eregi_replace(",", "','", $select_emails);
	
	
	
	if($list[1] == "on"){
		$query = "select distinct email from mailinglist_hkust  where addcode='' and email not in ('$select_emails')";
	
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		for($i=0; $i <$numOfRows; $i++){
			$rs->moveRow($i);
			$email = $rs->fields[email];
			$emails .= $email.",";
		}
	
		$select_emails = substr($emails, 0, strlen($emails)-1);
		$select_emails = eregi_replace(",", "','", $select_emails);
	}
	
	if($list[0] == "on"){
		if($course_list != "all"){
			$query = "select distinct email from mailinglist_course  where addcode='' and email not in ('$select_emails')";
		}else{
			$query = "select distinct email from mailinglist_course  where course='$course_list' and addcode='' and email not in ('$select_emails')";
		}
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		for($i=0; $i <$numOfRows; $i++){
			$rs->moveRow($i);
			$email = $rs->fields[email];
			$emails .= $email.",";
		}
	
		$select_emails = substr($emails, 0, strlen($emails)-1);
		$select_emails = eregi_replace(",", "','", $select_emails);
	}
	
	
	if($list[2] == "on"){
		$query = "select distinct email from mailinglist_public  where addcode='' and  email not in ('$select_emails')";
	
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		for($i=0; $i <$numOfRows; $i++){
			$rs->moveRow($i);
			$email = $rs->fields[email];
			$emails .= $email.",";
		}
	}
	
		
	
	$emails = substr($emails, 0, strlen($emails)-1);
	
	$bcc = "\nBcc: ".$emails;
	adminMail(ADMIN_MAIL, "$subject", "$message",$bcc);
	$link = $PHP_SELF;
	message(S0034, $link);
	exit();
}

function mailexist($email, $category, $name){
	global $db;
	
	if($category == "course"){
		$query = "select email from mailinglist_course where email='$email' and course='$name'";
	}
	elseif($category == "public"){
		$query = "select email from mailinglist_public where email='$email'";
	}
	else{
		$query = "select email from mailinglist_hkust where email='$email'";
	}
	
	//echo $query;
	//exit;
	$rs= $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	if($numOfRows){
		return true;
	}
	else{
		return false;
	}
}


function add2list($email, $category, $name){
	
	if(mailexist($email, $category, $name)){
		return "";
	}
	
	
	global $db;
	
	if($category == "hkust"){
		$query = "insert into mailinglist_hkust (email, addcode) values ('$email', '')";
	}
	elseif($category == "course"){
		$query = "insert into mailinglist_course (email, course, addcode) values ('$email','$name', '')";
	}
	elseif($category == "public"){
		$query = "insert into mailinglist_public (email, addcode) values ('$email', '')";
		
	}
	else{
		
	}
	
	$rs = $db->query($query);
	if($rs){
		return $email;
	}
	

}


function del2list($email, $category, $name){
	if(!(mailexist($email, $category, $name))){
		return $email;
	}
	
	global $db;
	
	if($category == "public"){
		$query = "delete from  mailinglist_public where email='$email' ";
	}
	elseif($category == "course"){
		$query = "delete from  mailinglist_course where email='$email' and course='$name'";
	}
	elseif($category == "hkust"){
		$query = "delete from  mailinglist_hkust where email='$email'  ";
		
	}
	else{
		
	}
	
	
	
	$rs= $db->query($query);
		
}





function addmail2list($mails, $category, $course){
	global $db;
	global $PHP_SELF;
//	echo $mails."<br>";
	
	$addlist = eregi_replace(",", "','", $mails);
	if($category[0] == "course"){
		$query = "select email from mailinglist_course where course='$course' and email in('$addlist')";
		$rs = $db->query($query);
	
		$numOfRows = $rs->getNumOfRows();
	
		if($numOfRows){
			for($i=0; $i <$numOfRows; $i++){
				$rs->moveRow($i);
				$email = $rs->fields[email];
				$atlist .= $email.",";
			}
			$atlist_course = substr($atlist, 0, strlen($atlist)-1);
			$atlist = "";
		}
		$addmailarray = explode(",", $mails);
		for($i =0; $i< sizeof($addmailarray); $i++){
			$addedmail = add2list($addmailarray[$i], "course" , $course);
			if($addedmail != "")
				$addedmails .= "$addedmail,";
		}
		
		$addedmails_course = substr($addedmails, 0, strlen($addedmails) -1);
		$addedmails = "";
	
$atlist_course = eregi_replace(",", "\n--", $atlist_course);
$addedmails_course = eregi_replace(",", "\n--", $addedmails_course);

if($addedmails_course != "")		
$addmsg_course = "(Message no.S1015)The following emails have been added to the \ncourse: $course mailinglist:
--$addedmails_course\n\n";

if($atlist_course != "")
$existmsg_course = "(Message no.S1016)The following emails already exist in the \ncourse: $course mailinglist:
--$atlist_course\n\n";

	$coursemsg = "$addmsg_course"."$existmsg_course";
		
	
	}
	
	if($category[1] == "hkust"){
		$query = "select email from mailinglist_hkust where email in('$addlist')";
		//echo "$query<br>";
		$rs = $db->query($query);
	
		$numOfRows = $rs->getNumOfRows();
	
		//echo "$numOfRows<br>";
		if($numOfRows){
			for($i=0; $i <$numOfRows; $i++){
				$rs->moveRow($i);
				$email = $rs->fields[email];
				$atlist .= $email.",";
			}
			$atlist_hkust = substr($atlist, 0, strlen($atlist)-1);
			$atlist = "";
		}
		$addmailarray = explode(",", $mails);
		for($i =0; $i< sizeof($addmailarray); $i++){
			$addedmail = add2list($addmailarray[$i], "hkust" , "");
			if($addedmail != "")
				$addedmails .= "$addedmail,";
		}
		
		$addedmails_hkust = substr($addedmails, 0, strlen($addedmails) -1);
		$addedmails = "";
		
$atlist_hkust = eregi_replace(",", "\n--", $atlist_hkust);
$addedmails_hkust = eregi_replace(",", "\n--", $addedmails_hkust);

if($addedmails_hkust != "")		
$addmsg_hkust = "(Message no.S1017)The following emails have been added to the \n\"Experiments for ".ORG_SHORT." staff/students only\" mailinglist:
--$addedmails_hkust\n\n";

if($atlist_hkust != "")
$existmsg_hkust = "(Message no.S1018)The following emails already exist in the \n\"Experiments for ".ORG_SHORT." staff/students only\"  mailinglist:
--$atlist_hkust\n\n";

	$hkustmsg = "$addmsg_hkust"."$existmsg_hkust";
		
		
		
	
	}
	
	if($category[2] == "public"){
		$query = "select email from mailinglist_public where email in('$addlist')";

		$rs = $db->query($query);
	
		$numOfRows = $rs->getNumOfRows();
	

		if($numOfRows){
			for($i=0; $i <$numOfRows; $i++){
				$rs->moveRow($i);
				$email = $rs->fields[email];
				$atlist .= $email.",";
			}
			$atlist_public = substr($atlist, 0, strlen($atlist)-1);
			$atlist = "";
		}
		$addmailarray = explode(",", $mails);
		for($i =0; $i< sizeof($addmailarray); $i++){
			$addedmail = add2list($addmailarray[$i], "public" , "");
			if($addedmail != "")
				$addedmails .= "$addedmail,";
		}
		
		$addedmails_public = substr($addedmails, 0, strlen($addedmails) -1);
		$addedmails = "";


$atlist_public = eregi_replace(",", "\n--", $atlist_public);
$addedmails_public = eregi_replace(",", "\n--", $addedmails_public);

if($addedmails_public != "")		
$addmsg_public = "(Message no.S1019)The following emails have been added to the \n\"Experiments for all subjects\" mailinglist:
--$addedmails_public\n\n";

if($atlist_public != "")
$existmsg_public = "(Message no.S1020)The following emails already exist in the \n\"Experiments for all subjects\"  mailinglist:
--$atlist_public\n\n";

	$publicmsg = "$addmsg_public"."$existmsg_public";
		

		
		
		
	
	}
	$link = $PHP_SELF;
	
	message("<pre>".$coursemsg.$hkustmsg.$publicmsg."</pre>", $link);
	exit;

}


function delmail2list($mails, $category, $course){
	global $db;
	global $PHP_SELF;
	
	$dellist = eregi_replace(",", "','", $mails);
	if($category[0] == "course"){
		$query = "select email from mailinglist_course where course='$course' and email in('$dellist')";
		$rs = $db->query($query);
	
		$numOfRows = $rs->getNumOfRows();
	
		if($numOfRows){
			for($i=0; $i <$numOfRows; $i++){
				$rs->moveRow($i);
				$email = $rs->fields[email];
				$atlist .= $email.",";
			}
			$atlist_course = substr($atlist, 0, strlen($atlist)-1);
			$atlist = "";
		}
		$delmailarray = explode(",", $mails);
		for($i =0; $i< sizeof($delmailarray); $i++){
			$deledmail = del2list($delmailarray[$i], "course" , $course);
			if($deledmail != "")
				$deledmails .= "$deledmail,";
		}
		
		$deledmails_course = substr($deledmails, 0, strlen($deledmails) -1);
		$deledmails = "";

$atlist_course = eregi_replace(",", "\n--", $atlist_course);
$deledmails_course = eregi_replace(",", "\n--", $deledmails_course);

if($atlist_course != "")		
$delmsg_course = "(Message no.S1021)The following emails have been deleted from the \ncourse: $course mailinglist:
--$atlist_course\n\n";


if($deledmails_course != "")
$existmsg_course = "(Message no.S1022)The following emails do not exist in the \ncourse: $course mailinglist:
--$deledmails_course\n\n";

	$coursemsg = "$delmsg_course"."$existmsg_course";
		
	
	}
	
	if($category[1] == "hkust"){
		$query = "select email from mailinglist_hkust where email in('$dellist')";
		$rs = $db->query($query);
	
		$numOfRows = $rs->getNumOfRows();
	
		if($numOfRows){
			for($i=0; $i <$numOfRows; $i++){
				$rs->moveRow($i);
				$email = $rs->fields[email];
				$atlist .= $email.",";
			}
			$atlist_hkust = substr($atlist, 0, strlen($atlist)-1);
			$atlist = "";
		}
		$delmailarray = explode(",", $mails);
		for($i =0; $i< sizeof($delmailarray); $i++){
			$deledmail = del2list($delmailarray[$i], "hkust" , "");
			if($deledmail != "")
				$deledmails .= "$deledmail,";
		}
		
		$deledmails_hkust = substr($deledmails, 0, strlen($deledmails) -1);
		$deledmails = "";
		
$atlist_hkust = eregi_replace(",", "\n--", $atlist_hkust);
$deledmails_hkust = eregi_replace(",", "\n--", $deledmails_hkust);

if($atlist_hkust != "")		
$delmsg_hkust = "(Message no.S1023)The following emails have been deleted from the \n\"Experiments for ".ORG_SHORT." staff/students only\" mailinglist:
--$atlist_hkust\n\n";

if($deledmails_hkust != "")
$existmsg_hkust = "(Message no.S1024)The following emails do not exist in the \n\"Experiments for ".ORG_SHORT." staff/students only\"  mailinglist:
--$deledmails_hkust\n\n";

	$hkustmsg = "$delmsg_hkust"."$existmsg_hkust";
		
		
		
	
	}
	
	if($category[2] == "public"){
		$query = "select email from mailinglist_public where email in('$dellist')";
		$rs = $db->query($query);
	
		$numOfRows = $rs->getNumOfRows();
	
		if($numOfRows){
			for($i=0; $i <$numOfRows; $i++){
				$rs->moveRow($i);
				$email = $rs->fields[email];
				$atlist .= $email.",";
			}
			$atlist_public = substr($atlist, 0, strlen($atlist)-1);
			$atlist = "";
		}
		$delmailarray = explode(",", $mails);
		for($i =0; $i< sizeof($delmailarray); $i++){
			$deledmail = del2list($delmailarray[$i], "public" , "");
			if($deledmail != "")
				$deledmails .= "$deledmail,";
		}
		
		$deledmails_public = substr($deledmails, 0, strlen($deledmails) -1);
		$deledmails = "";


$atlist_public = eregi_replace(",", "\n--", $atlist_public);
$deledmails_public = eregi_replace(",", "\n--", $deledmails_public);

if($atlist_public != "")		
$delmsg_public = "(Message no.S1025)The following emails have been deleted to the \n\"Experiments for all subjects\" mailinglist:
--$atlist_public\n\n";

if($deledmails_public != "")
$existmsg_public = "(Message no.S1026)The following emails do not exist in the \n\"Experiments for all subjects\"  mailinglist:
--$deledmails_public\n\n";

	$publicmsg = "$delmsg_public"."$existmsg_public";
		

		
		
		
	
	}
	$link = $PHP_SELF;
	
	message("<pre>".$coursemsg.$hkustmsg.$publicmsg."</pre>", $link);
	exit;
}


function isexist($loginName){
	global $db;
	
	$query = "select password, pool from poolCoordinator where loginName='$loginName'";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		$poolname = $rs->fields[pool];
		$password = $rs->fields[password];
		$md5str = MD5( TIME() );
		$cookie_val = "$loginName-$password-$md5str";
		setcookie( "pcprofile", $cookie_val, time()+3600, "/"); 
		setcookie( "poolname", $poolname, time()+3600, "/"); 
        return true;
	        
	}else{
		return false;
	}
}





function mail_form($to){
?>
                <table width="100%" cellpadding="3" bordercolor="#CCCCCC" border="0" cellspacing="0">
                  
                  
                  <tr bgcolor="ffffcc">
                    <td colspan="2" class="normal">To send an email to the <? echo $to; ?>(s),
                    
                   <?
                   if($to == "pool coordinator"){
                   	$selection = "pools";
                }
                elseif($to == "course instructor"){
                	$selection = "course names";
                }
                else{
                	$selection = "names";
                }
                ?>
                
                      click on the box(es) next to their <? echo $selection; ?>, then click &quot;Send Mail&quot;.</td>
                  </tr>
                  <tr>
                    <td width="13%" class="tablerow">From :</td>
                    <td width="87%">e-Recruit System Administrator</td>
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
                      <input type="submit" name="sendmail" value="Send Mail" onClick="alert('Each mail will take about ONE second to complete');return true;">
                    </td>
                  </tr>
                </table>
<?
}


function unblock_subjects($loginNames){
	global $PHP_SELF;
	global $db;
	$cond = eregi_replace("," , "', '" , $loginNames); 
	$query = "select loginName from blocklist where unblockdate > now() and loginName in ('$cond')";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		for($i=0; $i < $numOfRows; $i++){
			$rs->moveRow($i);
			$loginnames .= $rs->fields[loginName]."->";	
		}
		
	}else{
		warning(S0035);
		exit;
	}
	$loginnames = substr($loginnames, 0 , strlen($loginnames) -2 );
	
	$loginnames = eregi_replace("->", "\n<li>", $loginnames);
	$query = "update blocklist set unblockdate=now() , cancel_type='0' , attend_type='0' where loginName in ('$cond')";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	$msg = S0036;
	$msg .= "$loginnames";
	message($msg, "Subject_Management.php");
	
}


function block_subjects(){
	global $PHP_SELF;
	global $db;


	// unblock those subjects should be unblocked first;
	$query = "update blocklist set unblockdate=now() , cancel_type='0' , attend_type='0' where unblockdate <= now()";
	$rs = $db->query($query);
	
	// block for no shown subjects
	$query = "select loginName, count(*) as total from attendancy where attendancy='no' group by loginName";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		for($i=0; $i < $numOfRows; $i++){
			$rs->moveRow($i);
			$loginName = $rs->fields[loginName];
			$count = $rs->fields[total];
			if($count >= NO_SHOW_BLOCK_COUNT){
				if(being_blocked($loginName)){
					$query2 = "select attend_count, UNIX_TIMESTAMP(blockdate), UNIX_TIMESTAMP(unblockdate)  from blocklist where loginName='$loginName'";
					
					$rs2= $db->query($query2);
					$rs2->firstRow();
					$attend_count = $rs2->fields[attend_count];
					$blockdate = $rs2->fields[blockdate];
					$unblockdate = $rs2->fields[unblockdate];
					if(($count - $attend_count) > NO_SHOW_BLOCK_COUNT ){
						$unblockdate = $unblockdate + 24 * 3600 * BLOCK_PERIOD;
						
						$query3 = "update blocklist set blockdate=now(), unblockdate= FROM_UNIXTIME($unblockdate), attend_count=$count where loginName='$loginName'";
						$rs3= $db->query($query3);
					}
				}elseif(ever_blocked($loginName)){
					$query2 = "select attend_count from blocklist where loginName='$loginName'";
					$rs2= $db->query($query2);
					$rs2->firstRow();
					$attend_count = $rs2->fields[attend_count];
					if(($count - $attend_count) > NO_SHOW_BLOCK_COUNT ){
						$unblockdate = time() + 24 * 3600 * BLOCK_PERIOD;
						
						$query3 = "update blocklist set blockdate=now(), unblockdate= FROM_UNIXTIME($unblockdate), attend_count=$count, attend_type='1' where loginName='$loginName'";
						$rs3= $db->query($query3);
					}
				}else{
					$blockperiod = BLOCK_PERIOD;
					$query2 = "insert into blocklist (loginName, blockdate, unblockdate , cancel_count, attend_count, cancel_type, attend_type) values ( '$loginName', now(), FROM_UNIXTIME(UNIX_TIMESTAMP(now())+ 24 *3600 * $blockperiod), 0, $count, 0, 1)";
					$rs2= $db->query($query2);
					
					
				}
			}
		}
	}
	
	
	
	// now block those cancel signup subjects
	$cancelArr =  array();
	$query = "select * from cancelList";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		for($i=0; $i < $numOfRows; $i++){
			$rs->moveRow($i);
			$loginName = $rs->fields[loginName];
			$canceltime = $rs->fields[canceltime];
			$sessionid = $rs->fields[sessionid];
			$starttime = get_sessiontime($sessionid);
			if(($canceltime + CANCEL_B4_HOUR * 3600) > $starttime){
				
				$cancelArr = add_element($cancelArr, $loginName);
			}
		}
		reset($cancelArr);
		
		while(list($loginName, $count) = each($cancelArr)){
			if($count >= CANCEL_BLOCK_COUNT){
				if(being_blocked($loginName)){
					$query2 = "select cancel_count, UNIX_TIMESTAMP(blockdate), UNIX_TIMESTAMP(unblockdate)  from blocklist where loginName='$loginName'";
					$rs2= $db->query($query2);
					$rs2->firstRow();
					$cancel_count = $rs2->fields[cancel_count];
					$blockdate = $rs2->fields[blockdate];
					$unblockdate = $rs2->fields[unblockdate];
					if(($count - $cancel_count) > CANCEL_BLOCK_COUNT ){
						$unblockdate = $unblockdate + 24 * 3600 * BLOCK_PERIOD;
						
						$query3 = "update blocklist set blockdate=now(), unblockdate= FROM_UNIXTIME($unblockdate), cancel_count=$count where loginName='$loginName'";
						$rs3= $db->query($query3);
					}
				}elseif(ever_blocked($loginName)){
					$query2 = "select cancel_count from blocklist where loginName='$loginName'";
					$rs2= $db->query($query2);
					$rs2->firstRow();
					$cancel_count = $rs2->fields[cancel_count];
					if(($count - $cancel_count) > NO_SHOW_BLOCK_COUNT ){
						$unblockdate = time() + 24 * 3600 * BLOCK_PERIOD;
						
						$query3 = "update blocklist set blockdate=now(), unblockdate= FROM_UNIXTIME($unblockdate), cancel_count=$count, cancel_type='1' where loginName='$loginName'";
						$rs3= $db->query($query3);
					}
				}else{
					$blockperiod = BLOCK_PERIOD;
					$query2 = "insert into blocklist (loginName, blockdate, unblockdate , cancel_count, attend_count, cancel_type, attend_type) values ( '$loginName', now(), FROM_UNIXTIME(UNIX_TIMESTAMP(now())+ 24 *3600 * $blockperiod), $count, 0, 1 ,0)";
					//echo "$query2<br>\n";
					$rs2= $db->query($query2);
					
					
				}
			}
		}
	}
}
 
// function to conun the no. of cancel times.
function add_element($cancelArr, $loginName){
	if($cancelArr[$loginName]){
		$cancelArr[$loginName] = $cancelArr[$loginName] + 1;
	}
	else{
		$cancelArr[$loginName] = 1;
	}
	return $cancelArr;
}



// function to get the session start time in timestamp
function get_sessiontime($sessionid){
	global $db;
	$query = "select fromdate from session where id=$sessionid";
	$rs = $db->query($query);
	$rs->firstRow();
	$starttime = $rs->fields[fromdate];
	return $starttime;
}

	

// function to return whether the loginName is ever blocked or not
function ever_blocked($loginname){
	global $db;
	$query = "select * from blocklist where loginName='$loginname' and unblockdate > now()";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		return true;
	}
	else{
		return false;
	}
}


// function to return whether the loginName is being blocked or not
function being_blocked($loginname){
	global $db;
	$query = "select * from blocklist where loginName='$loginname' and unblockdate < now()";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		return true;
	}
	else{
		return false;
	}
}


// function to save end of semester day
function save_semesterday($year, $month, $day){
	global $db;
	$date = mktime(0,0,0,$month,$day,$year) ;
	if(time() > $date){
		warning(S0042);
	}
	
	
	
	// now update the check bit to let mew subject use re-used hkust email to create a/c
		$query = "update subject set checkbit=0 where hkust<>'0'";
		$rs2 = $db->query($query);
		
	
	$query = "insert into endsemesterdate (year, date) values ('$year', FROM_UNIXTIME($date))";
	//echo $query;
	$rs = $db->query($query);
	if($rs){
		return true;
	}
	return false;
}


// function to echo the last end of semester day
function print_end_of_semester_day(){
	global $db;
	$query = "select UNIX_TIMESTAMP(max(date)) as date_timestamp from endsemesterdate";
	$rs= $db->query($query);
	$rs->firstRow();
	$date = $rs->fields[date_timestamp];
	echo date("l, jS M Y", $date);
}

	


function list_session_subjects_attend($sessionid, $selectall){
	global $db;
	
	$query = "select quota from session where id=$sessionid";
	$rs=$db->query($query);
	$rs->firstRow();
	$quota = $rs->fields[quota];
	
	
	$query_enrolled = "select loginName from waitingList where sessionid=$sessionid order by signOn limit 0, $quota";
	
	$rs = $db->query($query_enrolled);			
	$nRows = $rs->getNumOfRows();	
	$enroll = "";
	for($i=0; $i < $nRows; $i++){
		$rs->moveRow($i);
		if($i != $nRows -1){
			$enroll .= $rs->fields[loginName] ."','";
		}else{
			$enroll .= $rs->fields[loginName];
		}
		
		
	}
	
	// these subjects are not waiting list
	
	$query = "select attendancy , loginName from attendancy where sessionid=$sessionid and loginName in ('$enroll')";
	
	$rs=$db->query($query);
	$nRows = $rs->getNumOfRows();
	for($i=0; $i < $nRows; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		$att = $rs->fields[attendancy];
		if($att == "experienced"){
			$experienced = "selected";
		}elseif($att == "inexperienced"){
			$inexperienced = "selected";
		}else{
			$noatt = "selected";
		}
		
		$infoquery = "SELECT loginName, firstName, lastName, sex, phone, email, hkust, stuID FROM subject where loginName='$loginName'";
		$infors = $db->query($infoquery);
		
		$infors->firstRow();
		$firstName = $infors->fields[firstName];
		$lastName = $infors->fields[lastName];
		$phone = $infors->fields[phone];
		$stuid = $infors->fields[stuID];
		
		if($stuid == "0"){
			$stuid = "N/A";
		}
		
		
		if($phone == ""){
			$phone = "&nbsp;";
		}
		$email = $infors->fields[email];
		$sex = $infors->fields[sex];
		$hkust = $infors->fields[hkust];
		
		if($hkust != "0" && $hkust != ""){
			$hkust = "Yes";
		}
		else{
			$hkust = "No";
		}
		 

		
		
		?>	
		<tr valign="top"> 
              	<td class="tablecolumn" align="center"><input type="checkbox" name="boxes[<? echo $i; ?>]" checked ></td>                
               <td class="normal"><? echo $loginName; ?></td>
               <input type="hidden" name="loginNames[<? echo $i; ?>]" value="<? echo $loginName; ?>">
                <td valign="top" class="normal"><? echo $firstName; ?></td>
                    <td valign="top" class="normal"><? echo $lastName; ?></td>
                    <td valign="top" class="normal"><? echo $sex; ?></td>
                    <td valign="top" class="normal"><? echo $phone; ?></td>
                    <td valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                    <td valign="top" class="normal"><? echo $stuid; ?></td>
                    <td valign="top" class="normal"><? echo $hkust; ?></td>

                <td class="tablecolumn">
                <select name="attends[<? echo $i; ?>]">
                    		<option value="experienced" <? echo $experienced; ?>>Yes, count him/her as experienced</option>
                    		<option value="inexperienced" <? echo $inexperienced; ?>>Yes, count him/her as inexperienced</option>
	                    	<option value="no" <? echo $noatt; ?>>No</option>
	                  </select>
	       </font> </td>
               <td>No</td>
               <td>Yes</td> 
              </tr>
              <?
              unset($experienced);
              unset($inexperienced);
              unset($noatt);
        }
        
        // now these subjects are in waitinglist but had record the attendancy!
        $waitinglist_with_attend = "";
        
        $query = "select attendancy , loginName from attendancy where sessionid=$sessionid and loginName not in ('$enroll')";
	$rs=$db->query($query);
	$nRows1 = $rs->getNumOfRows();
	for($i=0; $i < $nRows1; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		$att = $rs->fields[attendancy];
		if($att == "experienced"){
			$experienced = "selected";
		}elseif($att == "inexperienced"){
			$inexperienced = "selected";
		}else{
			$noatt = "selected";
		}
		
		
		if($i != $nRows1 -1){
			$waitinglist_with_attend .= $rs->fields[loginName] ."','";
		}else{
			$waitinglist_with_attend .= $rs->fields[loginName];
		}
		
		$infoquery = "SELECT loginName, firstName, lastName, sex, phone, email, hkust, stuID FROM subject where loginName='$loginName'";
		$infors = $db->query($infoquery);
		
		$infors->firstRow();
		$firstName = $infors->fields[firstName];
		$lastName = $infors->fields[lastName];
		$phone = $infors->fields[phone];
		$stuid = $infors->fields[stuID];
		
		if($stuid == "0"){
			$stuid = "N/A";
		}
		
		
		if($phone == ""){
			$phone = "&nbsp;";
		}
		$email = $infors->fields[email];
		$sex = $infors->fields[sex];
		$hkust = $infors->fields[hkust];
		
		if($hkust != "0" && $hkust != ""){
			$hkust = "Yes";
		}
		else{
			$hkust = "No";
		}
		 

	
		?>	
		<tr valign="top"> 
              	<td class="tablecolumn" align="center"><input type="checkbox" name="boxes[<? echo $i + $nRows; ?>]" checked ></td>                
               <td class="normal"><? echo $loginName; ?></td>
               <input type="hidden" name="loginNames[<? echo $i + $nRows; ?>]" value="<? echo $loginName; ?>">
                    <td valign="top" class="normal"><? echo $firstName; ?></td>
                    <td valign="top" class="normal"><? echo $lastName; ?></td>
                    <td valign="top" class="normal"><? echo $sex; ?></td>
                    <td valign="top" class="normal"><? echo $phone; ?></td>
                    <td valign="top" class="normal"><? echo $stuid; ?></td>
                    <td valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                    <td valign="top" class="normal"><? echo $hkust; ?></td>

                <td class="tablecolumn">
                <select name="attends[<? echo $i + $nRows;?>]">
                    		<option value="experienced" <? echo $experienced; ?>>Yes, count him/her as experienced</option>
                    		<option value="inexperienced" <? echo $inexperienced; ?>>Yes, count him/her as inexperienced</option>
	                    	<option value="no" <? echo $noatt; ?>>No</option>
	                  </select>
	       </font> </td>
               <td>Yes</td>
               <td>Yes</td> 
              </tr>
              <?
              unset($experienced);
              unset($inexperienced);
              unset($noatt);
        }
        
        // now these are waiting list and attendancy is recored!!!
        
        $query = "select loginName from waitingList where sessionid=$sessionid and loginName not in ('$enroll') and loginName not in ('$waitinglist_with_attend')";
        
	$rs=$db->query($query);
	$nRows2 = $rs->getNumOfRows();
	for($i=0; $i < $nRows2; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		
		$infoquery = "SELECT loginName, firstName, lastName, sex, phone, email, hkust, stuID FROM subject where loginName='$loginName'";
		$infors = $db->query($infoquery);
		
		$infors->firstRow();
		$firstName = $infors->fields[firstName];
		$lastName = $infors->fields[lastName];
		$phone = $infors->fields[phone];
		$stuid = $infors->fields[stuID];
		
		if($stuid == "0"){
			$stuid = "N/A";
		}
		
		
		if($phone == ""){
			$phone = "&nbsp;";
		}
		$email = $infors->fields[email];
		$sex = $infors->fields[sex];
		$hkust = $infors->fields[hkust];
		
		if($hkust != "0" && $hkust != ""){
			$hkust = "Yes";
		}
		else{
			$hkust = "No";
		}
		 

		
		
		
		$noatt = "selected";
		?>	
		<tr valign="top"> 
              	<td class="tablecolumn" align="center"><input type="checkbox" name="boxes[<? echo $i + $nRows + $nRows1; ?>]" <? if($selectall != "") echo "checked"; ?>></td>                
               <td class="normal"><? echo $loginName; ?></td>
               <input type="hidden" name="loginNames[<? echo $i  + $nRows + $nRows1; ?>]" value="<? echo $loginName; ?>">
                <td valign="top" class="normal"><? echo $firstName; ?></td>
                    <td valign="top" class="normal"><? echo $lastName; ?></td>
                    <td valign="top" class="normal"><? echo $sex; ?></td>
                    <td valign="top" class="normal"><? echo $phone; ?></td>
                    <td valign="top" class="normal"><? echo $stuid; ?></td>
                    <td valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                    <td valign="top" class="normal"><? echo $hkust; ?></td>

                <td class="tablecolumn">
                <select name="attends[<? echo $i + $nRows + $nRows1; ?>]">
                    		<option value="experienced" <? echo $experienced; ?>>Yes, count him/her as experienced</option>
                    		<option value="inexperienced" <? echo $inexperienced; ?>>Yes, count him/her as inexperienced</option>
	                    	<option value="no" <? echo $noatt; ?>>No</option>
	                  </select>
	       </font> </td>
               <td>Yes</td>
               <td>No</td> 
              </tr>
              <?
              unset($experienced);
              unset($inexperienced);
              unset($noatt);
        }
        
        return $nRows + $nRows1 + $nRows2;
}


function update_subject_attend($sessionid, $boxes, $loginNames, $attends, $total){
	global $db;
	
		
	for($i=0; $i< $total; $i++){
		if($boxes[$i] == "on"){
			
			$query = "select loginName from attendancy where sessionid=$sessionid and loginName='$loginNames[$i]'";
			$rs=$db->query($query);
			$nRows = $rs->getNumOfRows();
			if($nRows){
				$query = "update attendancy set attendancy='$attends[$i]' where sessionid=$sessionid and loginName='$loginNames[$i]'";
				$rs=$db->query($query);
			}
			else{
				$query = "insert into attendancy (attendancy,  sessionid, loginName, date) values ('$attends[$i]',$sessionid,'$loginNames[$i]', now())";
				$rs=$db->query($query);	
			}
		}
	}
	$link = "Subject_Management.php";
	message(S0039, $link);
}
