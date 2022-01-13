<?
//this page will pass so many variable to sigup_sessions.php
//id, mode, sessions, description, experimenters
//if mode == All, $ck1 = id 
//if mode == One, $ck = sessionid
//if mode == Any, there are numof(sessions) $cki = sessioned
require("../fun/exp_functions.inc");

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
$experimenters = experimentersstr($experimenters);
$rs -> close();
$db -> close();



if (!isset($description)) { $description = "No description.";}
if ($description == "") { $description = "No description.";}
if ($description == " ") { $description = "No description.";}
$headtitle="Experiment Title: $title";
	
head($headtitle);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->||Search";
		//$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");;
                 ?>
 		
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
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo $experimenters; ?> 
                  </td>
                </tr>
                <tr> 
                  <td width="21%" class="normal" valign="top">Prerequisites
                     :</td>
                  <td width="79%" bgcolor="ffffcc" class="tablerow"><? echo show_prereq($preRequisite); ?>                                     
                  </td>
                </tr>                
                
                </table>
                <!--<table width="100%" cellpadding="0">-->
                 </tr>
                 <!--</table>--> 
                </td>
                </tr>
                <tr>
                <td colspan="2">
                 <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC" vspace="0" hspace="0">
                  <tr bgcolor="#000099"> 
                    
                    <td width="13%" class="tablecolumn" bgcolor="#000099" valign="top"> 
                      Session ID </td>
                    <!--<td width="11%" class="tablecolumn" valign="top">Description</td>-->
                    <td width="9%" class="tablecolumn" valign="top">Start Date</td>
                    <td width="5%" class="tablecolumn" valign="top">Start Time</td>
                    <td width="12%" class="tablecolumn" valign="top">Approximate 
                      Duration</td>
                    <td width="6%" class="tablecolumn" valign="top">Venue</td>
                    <td width="6%" class="tablecolumn" valign="top">Quota</td>                    
                    <td width="16%" class="tablecolumn" valign="top">Reward</td>
                  </tr>
                  <? list_sessions($id,$mode,$sessions); ?>
                </table>                                    
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