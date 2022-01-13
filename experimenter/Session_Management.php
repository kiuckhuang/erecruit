<?
require("../fun/exp_functions.inc");
checkLogin();
if(!checkexpid($expid)){
	warning(T0073);
	exit();	
}
setcookie( "expid", $expid, time()+3600); 

if($submit=="View/Modify Session" && $mysessionid != ""){
	setcookie( "sessionid", $mysessionid, time()+3600); 
	header("Location: ./View-Modify_Session.php");
	exit();
}

if($submit=="View/Modify Session" && $mysessionid == ""){
	warning(T0087);
	exit();
}

if($submit =="Delete Session" && $mysessionid != ""){
}
/*
if($submit == "Record Credits Subjects Earned" && $mysessionid != ""){
	setcookie( "sessionid", $mysessionid, time()+3600); 
	header("Location: ./Record_Credits.php");
	exit();
}

if($submit =="Record Subject Attendance" && $mysessionid != ""){
	setcookie( "sessionid", $mysessionid, time()+3600); 
	header("Location: ./Record_Subject_Attendance.php");
	exit();
}
*/

if($submit =="Record Subject Attendance And Credit Information" && $mysessionid != ""){
	setcookie( "sessionid", $mysessionid, time()+3600); 
	header("Location: ./Record_Subject_Attendance.php");
	exit();	
}
if($submit =="Record Subject Attendance" && $mysessionid != ""){
	setcookie( "sessionid", $mysessionid, time()+3600); 
	header("Location: ./Record_Subject_Attendance.php");
	exit();	
}
if($submit =="Record Subject Attendance" && $mysessionid == ""){
	warning(T0087);
	exit();
	
}
if($submit =="Record Subject Attendance And Credit Information" && $mysessionid == ""){
	warning(T0087);
	exit();
	
}
if(isset($signup) && $mysessionid != ""){
	setcookie( "sessionid", $mysessionid, time()+3600); 
	header("Location: ./ViewEmailSignedUpSubjects.php");
	exit();
}
if(isset($signup) && $mysessionid == ""){
	warning(T0087);
	exit();
}
setcookie( "sessionid", $sessionid, time()-3600); 

$title="Session Management";
head($title);
?>
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
      <div v:shape="_x0000_s3074" class="O"> 
        <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
          <hr noshade align="center" width="98%" size="1">
          <div align="right" class="normal">Click <a href="Add_Session.php"><img src="images/but_here.gif" width="52" height="25" border="0" align="absmiddle"></a> to Add 
            Session </div>
            
          <form method="post" action="<? echo $PHP_SELF; ?>">
           <?   
           	$returnval = show_all_session($expid);
           	list($mode, $target, $pool) = explode("->", $returnval);
           ?>
           
                </td>
              </tr>
              <tr> 
                <td colspan="3"> 
                  <div align="right"> 
                    <input type="submit" name="submit" value="View/Modify Session">
                    <? /*<input type="submit" name="submit" value="Delete Session"> */ ?>
                  </div>
                </td>
              </tr>
              <tr> 
                <td colspan="3"> 
                  <div align="right"> 
                    
                    <? 
                    if (isPool($expid))
                    	echo "<input type=\"submit\" name=\"submit\" value=\"Record Subject Attendance And Credit Information\">";
                    else
                    	echo "<input type=\"submit\" name=\"submit\" value=\"Record Subject Attendance\">";
                    ?>                                        
                    <input type="submit" name="signup" value="View &amp; Email Signed Up Subjects">
                    <br>
                    <?
                    /*
                    
                    <font size="-2" color="#FF0000">Note to programmer: The Record 
                    Credits Subjects Earned button will only be shown to expts 
                    in MARK Subject Pool </font> */
                    ?>
                    </div>
                </td>
              </tr>
            </table>
            <? foot_menu(); ?>
            <hr noshade align="center" width="98%" size="1">
          </form>
          <table width="100%" cellpadding="0">
          <? 
          if($mode == "All"){
          	?>
            <tr> 
              <td width="12%" valign="top" class="notes">Note:</td>
              <td width="88%" class="notes" valign="top">You have created an experiment 
                which restricts subjects to sign up for all of the sessions. Session 
                information can only be accessed by subjects when ALL sessions 
                have been added.</td>
            </tr>
            <?
            }
            else if($mode == "One"){
            	?>
            <tr> 
              <td width="12%" valign="top" class="notes">Note:</td>
              <td width="88%" class="notes" valign="top">You have created an experiment 
                which restricts subjects to sign up for only ONE of the sessions. Session 
                information can only be accessed by subjects when ALL sessions have been added.
              </td>
            </tr>
            
            <?
            }
            else if($mode =="Any"){
            	?>
            <tr> 
              <td width="12%" valign="top" class="notes">Note:</td>
              <td width="88%" class="notes" valign="top">You have created an experiment 
                which allows subjects to sign up for ANY of the sessions. Session information
                can only be accessed by subjects when ALL sessions have been added.
              </td>
            </tr>
            
            <?
            }
           /*
            <tr> 
              <td width="12%" valign="top" class="noteindicator"><font color="#FF0000">Note 
                to programmer:</font></td>
              <td width="88%" class="notes" valign="top"> either of the above 
                note will be shown depending on the mode of the experiment. </td>
            </tr>
            */
            ?>
            
          </table>
          
<?

foot();
?>

