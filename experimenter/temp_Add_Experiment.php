<?
require("../fun/exp_functions.inc");
setcookie( "expid", $expid, time()-3600); 
checkLogin();
$title="Add Experiment";
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
      <div v:shape="_x0000_s3074" class="O"><div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"><hr noshade align="center" width="98%" size="1">
        </div>
      </div>
      <form name="form1" method="post" action="Check_Experiment.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <?
          if(isset($modify)){
          	?>
          <tr> 
            <td width="27%" valign="top"> 
              <p class="normal">Experiment ID : </p>
            </td>
            <td class="tablerow" width="73%" valign="top"></td>
          </tr>
           <?
        }
        ?>
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc">Experimenter:</td>
            <td  class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <?
              $login_var = explode("-", $expprofile);
		if(!isset($loginName))
		$loginName = $login_var[0]; 
              $returnval = show_experimenter_name($loginName);
              echo $returnval;
               ?>
               </td>
          </tr>
         
          <tr> 
            <td width="27%" valign="top" class="normal">Other(s) Experimenter(s) 
              : </td>
            <td class="normal" width="73%" valign="top"> 
              <input type="text" name="otherexp" value="">
              (e.g. Gary Cheung, Peter Chan) </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc">Experiment 
              Title :</td>
            <td class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <input type="text" name="exptitle" value="">
            </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal"><a name="mode"><font class = "noteindicator"> * </font>Mode</a> [<a href="<? echo $PHP_SELF; ?>#Note">more 
              info 1</a>]:</td>
            <td class="normal" width="73%" valign="top"> 
              <select name="mode">
                <option selected value="choose">Choose One</option>
                <option value="One">One</option>
                <option value="All">All</option>
                <option value="Any">Any</option>
              </select>
              </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc"><font class = "noteindicator"> * </font>Total 
              No. of Session(s) in this Experiment : </td>
            <td class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <select name="sessions">
              <?
              	for($i=1; $i<100; $i++){
              		echo "<option value=\"$i\">$i</option>\n";
              	}
              ?>	
              </select>
            </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal">Experiment Software :</td>
            <td class="normal" width="73%" valign="top"> 
              <input type="text" name="software" value="">
            </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc"><font class = "noteindicator"> * </font>Pre-requisite 
              :</td>
            <td class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <table width="100%" cellpadding="2" bgcolor="ffffcc" cellspacing="0" border="0">
                <tr> 
                  <td class="normal" valign="top"> 
                    <input type="radio" name="preRequisite" value="yes">
                    Yes</td>
                  <td class="normal">The target subjects should 
                    <select name="pre1">
                      <option value="have not">have not</option>
                      <option value="have">have</option>
                    </select>
                     participated in experiment(s):</td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td> 
                    <input type="text" name="pre2" value="">
                    <select name="pre3">
                      <option value="and">and</option>
                      <option value="or">or</option>
                    </select>
                     </td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td class="normal"> 
                    <select name="pre4">
                      <option value="have not">have not</option>
                      <option value="have">have</option>
                    </select>
                    participated in experiment(s): 
                    
                  </td> 
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td> 
                    <input type="text" name="pre5" value="">
                    <a href="Add Link Here" target="blank"><img src="images/but_search_exp_id.gif" align="absmiddle" border="0"></a>
                  </td>
                </tr>
                <tr> 
                  <td class="normal" valign="top"> 
                    <input type="radio" name="preRequisite" value="no" checked >
                    No </td>
                  <td>&nbsp;</td>
                </tr>
               </table>
            </td>
          </tr>
          <tr> </tr>
          <tr> </tr>
          <tr> </tr>
          
          <tr> 
            <td width="27%" valign="top" class="normal">Description :</td>
            <td class="normal" width="73%" valign="top"> 
              <textarea name="description" cols="40" rows="5" wrap="virtual"></textarea>
            </td>
          </tr>
          <tr> 
            <td class="normal" bgcolor="ffffcc"><font class = "noteindicator"> * </font><a name="target">Target Participants:</a></td>
            <td class="normal" bgcolor="ffffcc"> 
            
              <input type="radio" name="target" value="open" checked >
              This experiment is open to <? echo ORG_SHORT; ?> and non-<? echo ORG_SHORT; ?> individuals.</td>
          </tr>
          <tr> 
            <td class="normal" bgcolor="ffffcc">&nbsp; </td>
            <td class="normal" bgcolor="ffffcc"> 
              <hr noshade align="center" width="98%" size="1">
              <input type="radio" name="target" value="course">
              (authorized use only)<br> This experiment is restricted to students taking
              <select name="course" >
                <option selected value="choose">Choose One Course</option>
                <?
                	show_all_course();
                ?>
              </select> [ <a href="<? echo $PHP_SELF; ?>#Note2">more info 2</a>]
               to participate.</td>
          </tr>
          <tr> 
            <td class="normal" bgcolor="ffffcc">&nbsp; </td>
            <td class="normal" bgcolor="ffffcc"> 
              <hr noshade align="center" width="98%" size="1">
              <input type="radio" name="target" value="pool">
              (authorized use only) <br> This experiment is restricted to students under
              <select name="pool">
                <option selected value="choose">Choose One Pool</option>
                <?
                	show_all_pool();
                ?>
              </select>
              pool to participate.</td>
          </tr>
          <tr> 
            <td class="normal"> 
              <div align="right"> 
                <input type="submit" name="Submit" value="Add">
                <input type="reset" name="reset" value="Reset">
              </div>
            </td>
          </tr>
        </table>
        <br>
      </form>
      <hr noshade align="center" width="98%" size="1">
      <br>
      <table width="100%" cellpadding="0">
        <tr> 
          <td colspan="2" width="100%" valign="top" class="notes">Fields with <font class="noteindicator"> * </font> cannot be modified once you have pressed "Add". If you must make changes to these fields, you should
          delete the experiment and create a new one</td>
        </tr>
        <tr> 
          <td width="9%" valign="top" class="notes">Note 1:</td>
          <td width="91%" class="notes"><a name="Note">An experiment may contain many sessions. Session 
            can have different duration times. When you add experiment, you can 
            restrict subjects to sign up one / all / any of the sessions.Sessions information can only be accessed 
            by participants when all sessions information is input to e-Recruit.&quot; 
          </a>[ <font class="normal"><a href = "#mode"> back </a> </font> ]</td>
        </tr>

	<tr> 
          <td width="9%" valign="top" class="notes">Note 2:</td>
          <td width="91%" class="notes"><a name="Note2">If you want your course be appeared in this box, click <a href="add link here"><img src="images/but_here.gif" width="52" height="25" align="absmiddle" border="0"></a>to provide more information.
          </a> [ <font class="normal"><a href = "#target"> back </a> </font> ]</td>
        </tr>        
      </table>
<?





foot();
?>

