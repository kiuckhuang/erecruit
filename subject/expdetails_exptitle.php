<?
//this page will pass so many variable to sigup_sessions.php
//id, mode, sessions, description, experimenters
//if mode == All, $ck1 = id 
//if mode == One, $ck = sessionid
//if mode == Any, there are numof(sessions) $cki = sessioned
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
	if ($description == "") { $description = "No description.";}
	if ($description == " ") { $description = "No description.";}
	$dateCreated = $rs->fields[dateCreated];
	$experimenters = $rs->fields[experimenters];
	$mode = $rs->fields[mode];
	$sessions = $rs->fields[sessions];
	$software = $rs->fields[software];
	$preRequisite = $rs->fields[preRequisite];
	$target = $rs->fields[target];
	$category = $rs->fields[category];
	$enable = $rs->fields[enable];
	//$experimenters = ereg_replace("->", ", ", $experimenters);
	$rs -> close();
	$db -> close();



function content($headtitle){
	global $expprofile;
	global $PHP_SELF;
	global $isNon;
	global $id,$title,$description,$dateCreated,$experimenters,$mode,$sessions,$software,$preRequisite,$target,$category,$enable;
	if (!isset($description)) { $description = "No description.";}
	if ($description == "") { $description = "No description.";}
	if ($description == " ") { $description = "No description.";}
	$headtitle="Experiment Title: $title";
	
	head($headtitle);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		if (is_upcoming_exp($id)){
 			$where = "index.php||Log In->upcomingexp.php||Upcoming Experiments->";//upcomingexp_expdetails.php||Experiment Details->
 		}else{
 			$where = "index.php||Log In->pastexp.php||Past Experiments->";//pastexp_expdetails.php||Experiment Details->
 		}
		$where .= basename($PHP_SELF)."||".$headtitle;
		
		position("$where"); ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
              <table width="752" border="0" cellpadding="3" align="left">
                <tr>
                <td>
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
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo experimentersstr($experimenters); ?> 
                  </td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Prerequisites
                    <a href="Prerequisite.php">[more]</a> :</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo preRequisitestr($preRequisite); ?> 
                  <!--
                  <? if (trim(preRequisitestr($preRequisite))!="no"){ ?>
                  	(Before signing up, check whether you have fulfilled the prerequisites <a href="my_experience.php" target="_blank">here</a>.)
                  <? } ?>
                  -->
                  </td>
                </tr>                
                <tr> 
                  <td width="21%" class="normal" valign="top">Remarks : </td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow">
                    <? echo show_mode_str($mode); ?></td>
                </tr>
                
                </table>
                <!--<table width="100%" cellpadding="0">-->
                 </tr>
                 <!--</table>--> 
                </td>
                </tr>
                <tr>
                <td colspan="2">
                <form method="post" action="signup_sessions.php">
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
                  <input type="hidden" name="target" value="<? echo $target; ?>">
                  <input type="hidden" name="experimenters" value="<? echo $experimenters; ?>">
                  <input type="hidden" name="preRequisite" value="<? echo $preRequisite; ?>">
                  
                  <input type="hidden" name="id" value="<? echo $id; ?>">
                  <input type="hidden" name="mode" value="<? echo $mode; ?>">
                  <input type="hidden" name="sessions" value="<? echo $sessions; ?>">
                  <input type="hidden" name="description" value="<? echo $description; ?>">
                </table>  
                
                <br>
                <? if( is_upcoming_exp($id) ){  ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                  <? $target = split("->",$target); ?>
                  <? if ( $target[0] != "open" ){ ?>
                  <? $show_target = split("--",$target[1]);?>
                  <? $show_target = $show_target[0]." ".$show_target[1]." ".$show_target[2];?> 
                  <? if ( $target[0] == "pool" ) { $Subject_ = "Pool"; } ?> 
                  <? if ( $target[0] == "course" ) { $Subject_ = "Course"; } ?>
                    <td width="50%" class="normal" height="27" valign="top"><? echo $show_target; ?> Subject <? echo $Subject_; ?> Sign 
                      Up Code: </td>
                    <td colspan="2" class="normal" height="27" width="61%"> 
                      <input type="password" name="signupcode" value="" size="8" maxlength="8">
                    </td>
                    <? } ?>
                  </tr>
                </table>
                 
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                
                  <tr> 
                  <? if ( $target[0] == "pool" ){ ?>  
                    <td class="normal" width="39%" valign="top">Assign Credits 
                      Earned from this Experiment to : </td>
                    <td colspan="2" width="61%"> 
                      <select name="AssignCreditsto">
                        <? $input_target = split("--",$target[1]);?>
                        <? $input_target = $input_target[0]."--".$input_target[1]."--".$input_target[2];?>
                        <? show_all_pool_course($input_target); ?>
                      </select>
                      <!--
                      <span class="notes"><span class="noteindicator">Note to 
                      programmer: </span>This box will show when this experiment 
                      is for students taking ANY Marketing courses to sign up 
                      </span>
                      -->
                      </td>
                <?}?>
                  </tr>
                </table>
                <? if ( $target[0] == "pool" ){ ?>  
                <font color=#FF0000> Only students enrolled in the courses listed in the box above are given the Code. Please obtain it from instructors of these courses.</font>
                <?}?>
                
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td> 
                      <div align="right">
                        <input type="submit" name="signup" value="Sign up">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td> 
                      <div align="right">
                        <font color="#FF3333"><a href="SignUpPolicy.php" target="_self">[*Sign Up Policy]</a></font>
                      </div>
                    </td>
                  </tr>
                </table>
                <? }?>
                <br>
              </form>
                
                </td>
                <tr>
                
                <tr>
                	<td colspan="2">
                	<?
			foot_menu();
			foot();
			
			?>
                
                	</td>
                </tr>
               
              </table>            

<? }
?>

<?
  //-------------main-----------
//content($title);
  //----------------------------
?>

<?

if(isset($subjectprofile)){
	if(false){
	}
	else{
		content($title);
	}
}else{
	warningx(W0002,W0001,W0003);
	exit();
}
?>
