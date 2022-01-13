<?
require("../fun/exp_functions.inc");
//setcookie( "expid", $expid, time()-3600);
checkLogin();
$title="Add Experiment";

//################### Step 1 Error Checking ###################

if (!isset($isStep2) && !isset($isStep3) && isset($isStep1) ){ 
	if($target=="course" ){
		if($course=="choose" || $course==""){
			warning(T0001);
			exit();
		}
		else if ($course_signupcode==""){
			warning(T0002);
			exit();
		}
		else{

			if (Signupcode_Match($course_signupcode, $target, $course)){				
			
				$target .="->".$course;
				//message("Step 1 Finished!", "Add_Experiment.php");				
				//exit();
			}
			else{
				warning(T0003);				
				exit();
			
			}
		}	
	}


	if($target=="pool" ){
		if($pool=="choose" || $pool==""){
			warning(T0004);
			exit();
		}
		else if ($pool_signupcode==""){
			warning(T0005);
			exit();
		}
		else{
			if (Signupcode_Match($pool_signupcode, $target, $pool) ){				
			
				$target .="->".$pool;		
			}
			else{
				warning(T0006);				
				exit();
			}
		
		}		

	}
}
//############## Step 1 Error Checking End ###############



//############## Step 2 Error Checking ##############
if (isset($isStep2) && !isset($isStep3) && isset($isStep1) ){ 

	if ($import==""){
		warning(T0007);
		exit();	
	}
	else if ($import=="yes"){
		if ($import_expid==""){
			warning(T0008);
			exit();
		}
		//#######Search the experiment ID########
		else{
			if ( expid($import_expid)==false ){
				warning(T0009);
				exit();
			}		
		}//Search
		
	}
	else if ($import=="no"){
		//nothing
	}
}
//############## Step 2 Error End ###################



//############## Step 3 Error Checking ##############
if (isset($isStep2) && isset($isStep3) && isset($isStep1) ){ 

	if(trim($exptitle)==""){		
		warning(T0010);
	}
	if(trim($mode)==""){		
		warning(T0011);
	}
	if(trim($sessions)==""){		
		warning(T0012);
	}
	if(trim($otherexp)==""){		
		warning(T0101);
	}
	
	if($preRequisite == "yes" && !isset($modify)){
		if(trim($pre1)==""){
			warning(T0013);
		}
		//he has chosen the student type
		else{
			//he hasn't input the session ID
			if(trim($pre2)==""){
				warning(T0014);
			} 
			//Check the FIRST session ID is valid or not
			else{
				$expIDs = explode(",",trim($pre2));
				for($i=0; $i< sizeof($expIDs); $i++){				
					if(!is_sess_exist($expIDs[$i])){						
						//T0015
						$wn = T0015."Session IDs: <font color=\"FF0000\">$expIDs[$i]</font> do not exist. <br>Please try again.\n";
						warning($wn);
					}
					//Used to check whether all the session in that expid is taken the attendency or not
					if(!is_sess_TakenAtt($expIDs[$i])){						
						//T0016
						$wn = T0016."As the attendance of session : $expIDs[$i] has not been recorded by the experimenter, $expIDs[$i] cannot be a prerequiste of any other experiment.";
						warning($wn);
					}
				}
			
			}
			//the SECOND pre-re			
			if(trim($pre3)!=""){
				if(trim($pre4)==""){
					warning(T0017);					
				}
				else if(trim($pre5)==""){
					warning(T0018);
				}
				else{			
					$expIDs = explode(",",trim($pre5));
					for($i=0; $i< sizeof($expIDs); $i++){				
						if(!is_sess_exist($expIDs[$i])){							
							//T0019
							$wn = T0019."Session IDs: <font color=\"FF0000\">$expIDs[$i]</font> do not exist. <br>Please the input correct IDs.\n";
							warning($wn);
						}
						//Used to check whether all the session in that expid is taken the attendency or not
						if(!is_sess_TakenAtt($expIDs[$i])){	
							//T0020
							$wn = T0020."As the attendance of session : $expIDs[$i] has not been recorded by the experimenter, $expIDs[$i] cannot be a prerequiste of any other experiment.";
							warning($wn);
						}
					}			
				}
			}			
		}
		
		/*
		if(trim($pre2) =="" && trim($pre5) ==""){
			$wn= "Please input any Experiment ID at the correct field as You choose Pre-requisite as Yes!";
			warning($wn);
		}
		
		if(trim($pre2) != "Experiment ID(s), seperated by COMMA"){
			$expIDs = explode(",",trim($pre2));
			for($i=0; $i< sizeof($expIDs); $i++){
				//echo expid($expIDs[$i]);
				if(!expid($expIDs[$i])){
					$wn="ExperimentID: <font color=\"FF0000\">$expIDs[$i]</font> is not exist!<br>Please input correct ID\n";
					warning($wn);
				}
				//Used to check whether all the session in that expid is taken the attendency or not
				if(!expTakenAtt($expIDs[$i])){
					$wn="As the attendance of experiment $expIDs[$i] has not been recorded by
					     the experimenter, $expIDs[$i] cannot be a prerequiste of any other
					     experiment.";
					warning($wn);
				}
			}
		}
	
			
		if(trim($pre5) != "Experiment ID(s), seperated by COMMA"){
			$expIDs = explode(",",trim($pre5));
			for($i=0; $i< sizeof($expIDs); $i++){
				if(!expid($expIDs[$i])){
					$wn= "ExperimentID: $expIDs[$i] not exist!<br>Please input correct ID";
					warning($wn);
				}
								//Used to check whether all the session in that expid is taken the attendency or not
				if(!expTakenAtt($expIDs[$i])){
					$wn="As the attendance of experiment $expIDs[$i] has not been recorded by
					     the experimenter, $expIDs[$i] cannot be a prerequiste of any other
					     experiment.";
					warning($wn);
				}
			}
		}
		*/
		
		/*
		$preRequisite .= "->$pre1";
		$preRequisite .= "->$pre2";
		$preRequisite .= "->$pre3";
		$preRequisite .= "->$pre4";
		$preRequisite .= "->$pre5";
		*/
		$preRequisite .= "->$pre1";
		$preRequisite .= "->$any_all";
		$preRequisite .= "->$pre2";
		if (trim($pre3)!=""){
			$preRequisite .= "->$pre3";
			$preRequisite .= "->$pre4";
			$preRequisite .= "->$any_all2";
			$preRequisite .= "->$pre5";
		}
		
	}
	$preRequisite = ereg_replace(" ", "", $preRequisite);
	//echo $preRequisite;
	if($mode=="choose"){
		warning(T0021);
		exit();
	}	
	$otherexp = ereg_replace(",", "->", $otherexp);

	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
	
	$experimenters = "$loginName"."->"."$otherexp";	
	
	$description = AddSlashes($description);
	$query = "VALUES( 
	'$exptitle',
	'$description',
	'$experimenters',
	'$mode',
	'$sessions',
	'$software',
	'$preRequisite',
	'$target',
	'$category')";

	$newexpid = addExperiment($query);
	setcookie("expid", $newexpid, time()+3600); 
	$msg =T0023."<p>The Experiment has been added. The ID is: <font color=\"#FF0000\">$newexpid </font><br>\n <p>";
	$msg .= "
	An experiment may contain many sessions. Subjects can only view the information of this experiment after <font color=\"#FF0000\">ALL</font> session information has been input to e-Recruit.<br>\n";
	
	$checktarget = explode("->", $target);
	$personname = explode("->", $experimenters);
	//echo $checktarget[0];
	
	if ($checktarget[0]=="course"||$checktarget[0]=="open"){
		$deadline="14";
		$record = "attendance";	
		$instructor="System administrator";
		$name = "";
		//$mail = get_inst_mail($name);
		$mail = ADMIN_MAIL;
	}else
	if ($checktarget[0]=="pool"){
		$poolinfo = explode("--", $checktarget[1]);
		$deadline= get_deadline($poolinfo[0], $poolinfo[1], $poolinfo[2]);
		$record = "credit information";
		$instructor="Pool coordinator";
		$poolname = explode("-", $checktarget[1]);
		$info = get_poolco_info($name, $poolname[0]);
		//$info = explode("->", $info);
		$mail = $info[0];
		$name = $info[1]." ".$info[2].", ";		
	}
	
	//if ($checktarget[0]=="course" || $checktarget[0]=="pool"){
		$msg .=	"<p>For any reason if you cannot record the $record within $deadline day(s) after the end of each session, please contact the $instructor $name (<a href=mailto:$mail>$mail</a>).<br>";
	//}
	
	$msg .= "<p>Please click OK to add sessions.";
	message($msg, "Add_Session.php");
	exit();

}
//############## Step 3 Error End ###################



head($title);

?>


<a name="top"></a>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <?
                $where="index.php||Log In->Experimenter_Administration.php||Experimenter Administration->";
                $where .= basename($PHP_SELF)."||".$title;
                position("$where");
            ?>
              
              
            </tr>
</table>
        </div>
      </div>
      <div v:shape="_x0000_s3074" class="O"><div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"><hr noshade align="center" width="98%" size="1">
        </div>
      </div>
      
      
      
      
<? //#####################  Step 3 ########################  ?>
<? if (isset($isStep1) && isset($isStep2) && !isset($isStep3) ){ ?>
      <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
        <input type="hidden" name="isStep1" value="Step1Finish">
        <input type="hidden" name="isStep2" value="Step2Finish">        
        <input type="hidden" name="isStep3" value="Step3Finish">
        <input type="hidden" name="target" value="<? echo "$target"; ?>">
        <? 
	   $login_var = explode("-", $expprofile);	
	   if(!isset($loginName))
		$loginName = $login_var[0];	   	   
           experimentDetail_to_modify($import_expid, $loginName, $target, $import);
         ?>
           

	</form>	          
	<hr noshade align="center" width="98%" size="1">
        <? //########## Note ########## ?>
      <table width="100%" cellpadding="0">
        <tr> 
          <td colspan="2" width="100%" valign="top" class="notes">Fields with <font class="noteindicator"> # </font> cannot be modified once you have pressed "Submit". If you must make changes to these fields, you should
          delete the experiment and create a new one<br></td>
        </tr>
        <tr> 
          <td colspan="2" width="100%" valign="top" class="notes">' <font class="noteindicator"> * </font> ' denotes optional fields<br></td>
        </tr>
        <tr>
        
          <td width="9%" valign="top" class="notes">Note 1:</td>
          <td width="91%" class="notes"><a name="Note1">An experiment may contain many sessions. Sessions 
            can have different duration times. When you add an experiment, you can 
            restrict subjects to sign up one / all / any of the sessions.Sessions information can only be accessed 
            by participants when all sessions information has been input to e-Recruit. 
          </a>[ <font class="normal"><a href = "#to"> go to top </a> </font> ]</td>
        </tr>
        
        
         <tr> 
          <td width="9%" valign="top" class="notes">Note 2:</td>
          <td width="91%" class="notes"><a name="Note2">
          
          A subject is considered experienced to a past session if the respective experimenter has counted him/her  
          as "experienced" on "Record Subject Attendance" page under "Session Management" of "Experimenter Administration".
        
        
</table>
	   	 </div>      
	  
	  
          
          [ <font class="normal"><a href = "#back2"> back </a> </font> ]</td>
        </tr>
        
      </table>          
      
<? } //Step 3 ?>          

<? //##################### End of Step 3 ######################?>          





<? //##################### Step 2 #################### ?>          
<? if (!isset($isStep2) && !isset($isStep3) && isset($isStep1) ){ 
?>
      <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
        <input type="hidden" name="isStep1" value="Step1Finish">        
        <input type="hidden" name="isStep2" value="Step2Finish">       
         <input type="hidden" name="target" value="<? echo "$target"; ?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">        
        <tr>
        <td class="normal" bgcolor="ffffcc" colspan="2">
        <font color="red">Step 2: </font>
        </td>
        
        </tr>
        <tr>
            <td class="normal" bgcolor="ffffcc" colspan="2">
            If this experiment is similar to an earlier experiment created in 
              e-Recruit, you may want to import the information of the earlier 
              experiment, and modify it for this experiment. Do you want to import
              an earlier experiment?
            
            </td>
         </tr>
                
       <tr>
           <td class="normal" bgcolor="ffffcc" width="20%" align="right" valign="top">
           	<input type="radio" name="import" value="yes">
           </td>
           <td class="normal" bgcolor="ffffcc" width="80%" align="left"> 
           	Yes. The earlier experiment's ID is : 
           	<br><input type="text" name="import_expid" size="12">
           	<a href="search.php" target="blank">
           	Search Experiment ID here.</a>
           	Close the new window when you have finished the search.
	   </td>
	</tr>
	
	<tr>
	   <td class="normal" bgcolor="ffffcc" width="20%" align="right" valign="top">
           	<input type="radio" name="import" value="no" checked>
           </td>
           <td class="normal" bgcolor="ffffcc" width="80%" align="left">
           No
	  </td>
       </tr>
          <tr> 
            <td colspan="2" class="normal" align = "right"> 
              <!--<div align="right"> -->
                <input type="submit" name="Submit" value="Next">
                <input type="reset" name="reset" value="Reset">
              <!--</div>-->
            </td>
          </tr>
	</table>
        <br>
      </form>          
      
      <br>

<? } //Step 2 ?>          
<? // ############################# End of Step 2 ##########################?>          





<? //##################### Step 1 #################### ?>          
<? if (!isset($isStep3) && !isset($isStep2) && !isset($isStep1)){ ?>          
      <form name="form1" method="post" action="<? echo $PHP_SELF; ?>" >
      <!-- form name="form1" method="post" action="Check_Experiment.php"-->
        <input type="hidden" name="isStep1" value="Step1Finish">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
        <td class="normal" bgcolor="ffffcc" colspan="2">
        <font color="red">Step 1: </font>
        </td>
        
        </tr>
          <tr> 
            <td class="normal" bgcolor="ffffcc" width="20%"><a name="target"><font class="noteindicator"> # </font>Target Participants:</a></td>
            <td class="normal" bgcolor="ffffcc" width="80%"> 
            
              <input type="radio" name="target" value="open" checked >
              Participation in this experiment is open to <? echo ORG_SHORT; ?> and/or non-<? echo ORG_SHORT; ?> individuals.</td>
          </tr>
          <tr> 
            <td class="normal" bgcolor="ffffcc" width="20%">&nbsp; </td>
            <td class="normal" bgcolor="ffffcc" width="80%"> 
              <hr noshade align="center" width="98%" size="1">
              <input type="radio" name="target" value="course">
              Participation in this experiment is restricted to students taking
              <select name="course" >
                <option selected value="choose">Choose One Course</option>
                <?
                	show_all_course();
                ?>
              </select> Note : If you want a particular course to be added here, click <a href="../register/Course_Reg.php"><img src="images/but_here.gif" width="52" height="25" align="absmiddle" border="0"></a>to provide more information.              
               Please ask the respective course instructor for the course authorization 
               code and enter it here: <input type="password" name="course_signupcode" maxlength="6" size="6">
              
               </td>
          </tr>
          <tr> 
            <td class="normal" bgcolor="ffffcc" width="20%">&nbsp; </td>
            <td class="normal" bgcolor="ffffcc" width="80%" > 
              <hr noshade align="center" width="98%" size="1">
              <input type="radio" name="target" value="pool">
              
              
              Participation in this experiment is restricted to students under
              <select name="pool">
                <option selected value="choose">Choose One Pool</option>
                <?
                	show_all_pool();
                ?>
              </select>
              pool.             
              Please ask the respective pool coordinator for the pool authorization code and
              enter it here: <input type="password" name="pool_signupcode" maxlength="5" size="5">                                                
              </td>
          </tr>
          <tr> 
            <td colspan="2" class="normal" align = "right"> 
              <!--<div align="right"> -->
                <input type="submit" name="Submit" value="Next">
                <input type="reset" name="reset" value="Reset">
              <!--</div>-->
            </td>
          </tr>
	</table>
        <br>
      </form>          
       <hr noshade align="center" width="98%" size="1">
      <br>
      
      <table width="100%" cellpadding="0">
        <tr> 
          <td colspan="2" width="100%" valign="top" class="notes">Fields with <font class="noteindicator"> # </font> cannot be modified once you have pressed "Next". If you must make changes to these fields, you should
          delete the experiment and create a new one</td>
        </tr>
        <? /*
        <tr> 	
          <td width="91%" colspan="2" class="notes"><a name="Note">Note : If you want your course be appeared in this box, click <a href="../register/Course_Reg.php"><img src="images/but_here.gif" width="52" height="25" align="absmiddle" border="0"></a>to provide more information.
          </a> </td>
        </tr>        
          */
        ?>
      </table>
<? } //Step 1 
?>          
<? // ############################# End of Step 1 ##########################?>          

       
<?
foot();
?>