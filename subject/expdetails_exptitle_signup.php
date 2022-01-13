<?
require("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$query = "select * from experiment where id = '$id' ";
	$rs = $db->query($query);
	$id = $rs->fields[id];
	$title = $rs->fields[title];
	$description = $rs->fields[description];
	$dateCreated = $rs->fields[dateCreated];
	$experimenters = $rs->fields[experimenters];
	$mode = $rs->fields[mode];
	$sessions = $rs->fields[sessions];
	$software = $rs->fields[software];
	$preRequisite = $rs->fields[preRequisite];
	$target = $rs->fields[target];
	$category = $rs->fields[category];
	$enable = $rs->fields[enable];
	$experimenters = ereg_replace("->", ", ", $experimenters);



function content($headtitle){
	global $expprofile;
	global $PHP_SELF;
	global $isNon;
	global $id,$title,$description,$dateCreated,$experimenters,$mode,$sessions,$software,$preRequisite,$target,$category,$enable;
	$headtitle="Experiments Title: $title";
		
	head($headtitle);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->logon_nonust.php||Log on(for ".$isNon.ORG_SHORT." participants)->upcomingexp.php||Upcoming Experiments->";
		$where .= basename($PHP_SELF)."||".$headtitle;
		
		position("$where"); ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
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
                  <td width="21%" class="normal" valign="top">Mode : </td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow">This experiment 
                    requires you to sign up <? echo $mode; ?> sessions. </td>
                </tr>
              </table>
              <p>&nbsp;</p><p>&nbsp;</p>
              <p><br>
                <br>
              </p>
              <form method="post" action="">
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC" vspace="0" hspace="0">
                  <tr bgcolor="#000099"> 
                    <td width="6%" class="tablecolumn" valign="top">Select</td>
                    <td width="13%" class="tablecolumn" bgcolor="#000099" valign="top"> 
                      Session Title </td>
                    <!--<td width="11%" class="tablecolumn" valign="top">Description</td>-->
                    <td width="9%" class="tablecolumn" valign="top">Start Date</td>
                    <td width="5%" class="tablecolumn" valign="top">Start Time</td>
                    <td width="12%" class="tablecolumn" valign="top">Approximate 
                      Duration</td>
                    <td width="6%" class="tablecolumn" valign="top">Venue</td>
                    <td width="6%" class="tablecolumn" valign="top">Quota</td>
                    <td width="8%" class="tablecolumn" valign="top">Vacancy</td>
                    <td width="8%" class="tablecolumn" valign="top">Waiting List 
                    </td>
                    <td width="16%" class="tablecolumn" valign="top">Reward</td>
                  </tr>
                  <? list_sessions($id,$mode,$sessions); ?>
                  <input type="hidden" name="id" value="<? echo $id; ?>">
                  <input type="hidden" name="mode" value="<? echo $mode; ?>">
                  <input type="hidden" name="sessions" value="<? echo $sessions; ?>">
                  <!--
                  <tr valign="top"> 
                    <td width="6%"  height="2"> 
                      <div align="center"> 
                        <input type="checkbox" name="ck1" value="checkbox">
                      </div>
                    </td>
                    <td width="13%" class="normal">Session 1:<br>
                      <a href="link">Bargain With Search</a></td>
                    <td width="11%" class="normal">You cannot sign up... (more)</td>
                    <td width="9%" class="normal">10Jan 2000</td>
                    <td width="5%" class="normal">2:30 pm </td>
                    <td width="12%" class="normal">1 hour</td>
                    <td width="6%" class="normal">Lab 5</td>
                    <td width="6%" class="normal">30</td>
                    <td width="8%" class="normal">0 </td>
                    <td width="8%" class="normal">1</td>
                    <td width="16%" class="normal">A fixed amount of <? echo CURRENCY; ?>100 will be given to participants.</td>
                  </tr>
                  
                  <tr valign="top"> 
                    <td width="6%" height="2"> 
                      <div align="center"> 
                        <input type="checkbox" name="ck2" value="checkbox">
                      </div>
                    </td>
                    <td width="13%" class="normal" height="2">Session 2 :</td>
                    <td width="11%" class="normal" height="2">NA </td>
                    <td width="9%" class="normal" height="2">11 Jan 2000</td>
                    <td width="5%" class="normal" height="2">2:30 pm</td>
                    <td width="12%" class="normal" height="2">1 hour</td>
                    <td width="6%" class="normal" height="2">Lab 2</td>
                    <td width="6%" class="normal" height="2">40</td>
                    <td width="8%" class="normal" height="2">12</td>
                    <td width="8%" class="normal" height="2">0</td>
                    <td width="16%" class="normal" height="2">A fixed amount of 
                      5 credit(s) will be given to participants.</td>
                  </tr>
                  -->
                </table>  
                
                <br>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                  <? $target = split("->",$target); ?>
                  <? if ( $target[0] != "open" ){ ?>  
                    <td width="39%" class="normal" height="27" valign="top">Sign 
                      Up Code for Mark112 L1 Fall 99 : </td>
                    <td colspan="2" class="normal" height="27" width="61%"> 
                      <input type="text" name="signupcode" value="" size="15">
                    </td>
                  <? } ?>
                  </tr>
                </table>
                 
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                
                  <tr> 
                  <? if ( $target[0] == "course" ){ ?>  
                    <td class="normal" width="39%" valign="top">Assign Credits 
                      Earned from this Experiment to : </td>
                    <td colspan="2" width="61%"> 
                      <select name="select">
                        <? show_all_course(); ?>
                      </select>
                      <span class="notes"><span class="noteindicator">Note to 
                      programmer: </span>This box will show when this experiment 
                      is for students taking ANY Marketing courses to sign up 
                      </span></td>
                  <? } ?>
                  </tr>
                </table>
                
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td> 
                      <div align="right">
                        <input type="submit" name="signup" value="Sign up">
                      </div>
                    </td>
                  </tr>
                </table>
                
                <br>
              </form>
<?
	foot();
}
?>

<?
  //-------------main-----------
//content($title);
  //----------------------------
?>

<?

if(isset($subjectprofile)){
	if(false){
		/*
		$condition = "$radio"."->"."$loginName";
			
		if(!checkexpid($condition)){
			warning("This experiment is not belong to you!");
			exit();	
		}
		
		
		if($adminaction== "View/Modify Experiment"){
			header("Location: ./View-Modify_Experiment.php?expid=$radio");
			exit();
		}
		else if($adminaction== "Delete Experiment"){
			header("Location: ./Delete_Exp.php?expid=$radio");
			exit();
		}
		else if($adminaction=="Session Management"){
			header("Location: ./Session_Management/index.php?expid=$radio");
			exit();
		}
		else{
			echo "testing";
			exit();
		}
		*/
	}
	else{
		content($title);
	}
}else{
	warning("Sorry,  Login first!");
}
?>