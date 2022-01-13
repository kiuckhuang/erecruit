<?
require("../fun/exp_functions.inc");
checkLogin();

if(!checkexpid($expid)){
	warning(T0073);
	exit();	
}

if(isTakenAttendency($sessionid)==0){
if(isset($total) && $mail=="Send"){
	for($i=0; $i <$total; $i++){
		if(${checkbox.$i} == "on"){
			/*			
			if(${attend.$i} =="choose"){
				warning("Please select all the attendance!");
				exit();
			}
			*/
			
			//if(${attend.$i} != "no"){				
				if(isset($sessionid)){
					//if (isAssignCredit($sessionid)){
					
					if (isPool($expid)){
						if(${credit.$i} == ""){
							warning(T0074);
						}
					}
				}
				$loginName = ${loginName.$i};				
				$attendtype = ${attend.$i};
				$creditnum = ${credit.$i};
				//echo $attendtype."\n";
				$attendtype = explode("->", $attendtype);
				//echo $attendtype[1]."\n";
				
				if($i < $total -1 ){
					$loginnames .= $loginName."->";
					$attendtypes .= $attendtype[1]."->";
					$credits .= $creditnum."->";
				}else{
					$loginnames .= $loginName;
					$attendtypes .= $attendtype[1];
					$credits .= $creditnum;
				}
			//}
			
				
		
		}
	
	}

	if($total != 0 && $loginnames != ""){		
		$login_var = explode("-", $expprofile);
		$exploginName = $login_var[0];
		//this function will also send mail to admin.
		update_addendancy($sessionid, $loginnames, $attendtypes, $exploginName);		
		// this function will add credit and also send mail to adm
		if (isPool($expid)){
			add_credit($loginnames, $credits, $sessionid, $exploginName); 
		}
		$link = "Session_Management.php";
		
		if (isPool($expid)){
			message(T0075, $link);
		}
		else{
			message(T0099, $link);
		}		
		exit();
	}
			
}
}
else{
	warning(T0100);
}

if (isPool($expid)){
	$title="Record Subject Attendance And Credit Information";
}else {
	$title="Record Subject Attendance";
}
head($title);



//echo $total;

?>
<a name="top"></a>
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
          <table width="100%" border="0" cellpadding="3">
            <?
		$expid  = substr($sessionid, 0, 8);		
            	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");		
		$query = "select target from experiment where id='$expid'";
		$rs=$db->query($query);
		$rs->firstRow();
		$target = $rs->fields[target];
		$target = explode("->", $target);                     
            ?>
            <?  //########## Check whether the session is Credit Awards or not #############
                if(isset($sessionid)){			
			if (!isPool($expid)){
				$AssignCredit = "false";
			}
		}
						            
            ?>
            <? //########### Display the Deadline #############            
               //if ($target[0]=="pool"){ 
                $poolinfo = explode("--", $target[1]);
                // poolinfo[0]=pool ,poolinfo[1]=year, poolinfo[2]=semester
                $daylimit = get_deadline($poolinfo[0],$poolinfo[1],$poolinfo[2]);               
            ?>
            	<?            	          
            	   if (isTakenAttendency($sessionid)==0){
            		//if (isset($daylimit) ){
            	?>
            		<tr bgcolor="ffffcc"> 
              		<td class="normal">
              		<ul>
	              		<li>
        	      			Please fill up the table and press "Send" to send it to the System Administrator within <font color=red><? echo $daylimit; ?></font> day(s) after this session is ended. 
              				This table can only be sent <font color=red>ONCE</font>.
              			</li>
              			<li>
              				In cases like waiting list subjects have participated in the experiment, you have the option to send their information. Check boxes are shown in the "Select" column next to their names.  
              			</li>
              		</ul>
              		</td>
            		</tr>
            		
            	<? 	
            	    }
            	    else{
                ?>
            	    	<tr bgcolor="ffffcc"> 
              		<td class="normal">
              		You have already sent this table to the System Administrator.</td>
            		</tr>            	    
            	 <? 
            	    }            	
            	?>
            <? //} ?>
          </table>
          <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
   		<SCRIPT LANGUAGE="JavaScript"> 
			function getConfirm() {
				if (confirm("This table can only be sent ONCE. Are you sure you want to send?")) {
					document.form1.submit();
				}
			}
		</script>
  
            <table width="100%" cellpadding="2" cellspacing="0" border="1" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC" bordercolor="#CCCCCC">
              <tr valign="top" bgcolor="#000099"> 
              <? if (isTakenAttendency($sessionid)==0){ ?>
               		<td width="6%" class="tablecolumn" bgcolor="#000099">Select</td>                
              <? } ?>
                <td width="22%" class="tablecolumn">First Name(s)</td>
                <td width="12%" class="tablecolumn">Last Name</td>
                <td width="5%" class="tablecolumn">Sex</td>
                <td width="10%" class="tablecolumn">Phone</td>
                <td width="23%" class="tablecolumn">Email</td>
                <? if ($AssignCredit != "false"){ ?>              	
                	<td width="10%" class="tablecolumn">Credit(s) Earned</td>
                <? } ?>
                <td width="25%" class="tablecolumn">Subjects showed up?<font color=red> * </font> </td>
                <td width="23%" class="tablecolumn">Waiting List?</td>
              </tr>
             <?
             	list_all_attend_subjects($sessionid, $selectall,$AssignCredit);
             	?>
            </table>
            <br>
            
            <? 
            //echo isTakenAttendency($sessionid);
            if (isTakenAttendency($sessionid)==0){ ?>
            <table width="100%" cellpadding="0">
              <tr> 
                <td width="49%"> 
                  <div align="left"> 
                    <input type="submit" name="selectall" value="Select All Participants">
                  </div>
                </td>
                <td width="51%"> 
                  <div align="right"> 
                    
                    	<input type="submit" name="mail" value="Send" onclick="getConfirm()">
                    
                  </div>
                </td>
              </tr>
            </table>
           <br>
            <?}
              foot_menu();
             ?>
          </form>
          <hr noshade align="center" width="98%" size="1">
          <br>
          <table width="100%" cellpadding="0">
          
          <? //if ($AssignCredit != "false"){ ?>
          <!-- tr>          
          <td width="91%" class="notes" colspan="2">
          <p>You are not required to input the credits students earned if this experiment
          is not restricted to students in a particular pool.</p>
          </td>
          </tr -->
          <? // } ?>
          
          </tr>
          
          <td width="91%" class="notes" colspan="2">
          <tr><td class="normal">
          <font color=red> * </font> If you choose the "No" option, the subject will be penalized according
          to the <a href="<? echo RECRUIT_URL; ?>/subject/SignUpPolicy.php">sign up 
          policy</a> which has already been made known to them.

          If an upcoming session requires the prerequisites of experience in this session, 
          remember to count the subject as "experienced" so that he or she can sign up
          that session successfully.
</td></tr>                    
          
</table>
	   	 </div>
	            
          [ <font class="normal"><a href = "#top"> go to top </a> </font> ]</td>
        </tr>
            <!--
            <tr> 
              <td width="8%" valign="top" class="notes">Note1:</td>
              <td width="92%" class="notes">Options include: Not Yet Entered, 
                Yes, No.</td>
            </tr>
            -->
          </table>
<?
foot();
?>

