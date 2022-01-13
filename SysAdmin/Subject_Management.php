<?
include("../fun/admin_functions.inc");

$title = "Subject Management";
head($title);


?>

              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Home->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");

		?>
                </tr>
              </table>
              <hr noshade width="98%" size="1">
              <form name="form1" method="post" action="Experienced_Subjects.php" >
                <p align="left" class="tablerow">In/experienced Subjects :</p>
                <table width="75%" border="0" cellpadding="3" cellspacing="0" bgcolor="ffffcc">
                 <?
                 /*
                  <tr> 
                    <td width="24%" class="normal">Show subjects who are</td>
                    <td width="76%" class="normal"> 
                      <select name="showsub1">
                        <option value="experienced">experienced</option>
                        <option value="inexperienced">inexperienced</option>
                       <!--
                        <option value="partially experienced">partially  experienced</option>
                        <option value="experienced or partially experienced">experienced or partially experienced</option>
                        <option value="inexperienced or partially experienced">inexperienced or partially experienced</option>
                       -->
                      </select>
                      to experiment(s):</td>
                  </tr>
                  <tr> 
                    <td width="24%" height="27">&nbsp;</td>
                    <td width="76%" height="27"> 
                      <input type="text" name="showsub2" size="50" value="Experiment ID(s), seperated by COMMA">
                      <select name="showsub3">
                        <option value="and">and</option>
                        <option value="or">or</option>
                      </select>
                    </td>
                  </tr>
                  <tr> 
                    <td width="24%">&nbsp;</td>
                    <td width="76%" class="normal"> 
                      <select name="showsub4">
                        <option value="experienced">experienced</option>
                        <option value="inexperienced">inexperienced</option>
                      <!--
                        <option value="partially experienced">partially experienced</option>
                        <option value="experienced or partially experienced">experienced or partially experienced</option>
                        <option value="inexperienced or partially experienced">inexperienced or partially experienced</option>
                      -->
                      </select>
                      to experiment(s):</td>
                  </tr>
                  <tr> 
                    <td width="24%">&nbsp;</td>
                    <td width="76%"> 
                      <input type="text" name="showsub5" size="50" value="Experiment ID(s), seperated by COMMA">
                    </td>
                  </tr>
                 */
                  ?>
                <tr>
                  <td class="normal" colspan="2">
                  Show subjects who are : <br>
                    <select name="condition[0]">
                      
                      <option value="experienced">experienced</option>
                      <option value="inexperienced">inexperienced</option>
                    </select>
                     to 
                    <select name="condition[1]">
                       
                       <option value="any" >any</option>
                       <option value="all" >all</option>
                    </select> of the session(s):
                    <input type="text" name="condition[2]" size="50" value="Session ID(s), seperated by COMMA">  
                    <select name="condition[3]">
                     
                      <option value="and">and</option>
                      <option value="or">or</option>
                    </select>
                    <br>
                    <select name="condition[4]">
                    
                      <option value="experienced">experienced</option>
                      <option value="inexperienced">inexperienced</option>                      
                    </select>
                    to                              
                    <select name="condition[5]">                       
                       <option value="any" selected>any</option>
                       <option value="all">all</option>
                    </select>
                    of the session(s): 
                    <input type="text" name="condition[6]" size="50" value="Session ID(s), seperated by COMMA">
                   <!--
                    <br>
                    <a href="search.php" target="blank">
                    Search session ID here.</a>
                    Close the new window when you have finished the search.
                    -->
                     </td>
                </tr>
                  <tr>
                    <td width="24%">&nbsp;</td>
                    <td width="76%"> 
                      <div align="right">
                        <input type="submit" name="show" value="Show">
                      </div>
                    </td>
                  </tr>
                </table>
                
              </form>
              
               <hr width="98%" size="1" noshade align="center"> 
              <form method="post" action="Session_Att.php">
                <p align="left" class="tablerow">Session Attendance Information:</p>
                <table width="75%" border="0" cellspacing="0" cellpadding="3">
                  <tr bgcolor="ffffcc"> 
                    <td width="100%" height="27" class="normal"> 
                        Enter session ID to modify subjects' attendance information:
                        <input type="text" name="sessionid"  value="">
                        
                    </td>
                    
                  </tr>
                  <tr bgcolor="ffffcc"> 
                  <td width="100%"> 
                      <div align="right"> 
                        <input type="submit" value="Modify">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
              
              <hr width="98%" size="1" noshade align="center">
            
              <form method="post" action="Subject_Record.php">
                <p align="left" class="tablerow">Subject Record :</p>
                <table width="75%" border="0" cellspacing="0" cellpadding="3">
                 
                  <tr bgcolor="ffffcc"> 
                    <td width="28%" height="27" class="normal"> 
                      <div align="center">
                        <input type="radio" name="search"  value="name" checked >
                        Search by Name :</div>
                    </td>
                    <td width="72%" height="27" class="normal">First Name : 
                      <input type="text" name="firstName" size="20" value="">
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="28%" height="27" class="normal">&nbsp;</td>
                    <td width="72%" height="27" class="normal">Last Name : 
                      <input type="text" name="lastName" size="20" value="">
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="28%" class="normal"> 
                      <div align="center">
                        <input type="radio" name="search" value="email">
                        Search by email :</div>
                    </td>
                    <td width="72%" class="normal"> 
                      <input type="text" name="email" size="20" value="">
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="28%">&nbsp;</td>
                    <td width="72%">&nbsp;</td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="28%">&nbsp;</td>
                    <td width="72%"> 
                      <div align="right"> 
                        <input type="submit" value="Search">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
             <hr width="98%" size="1" noshade align="center"> 
              <form method="post" action="Show_Blocked_Subject.php">
                <p align="left" class="tablerow">Blocked Subjects :</p>
                <table width="75%" border="0" cellspacing="0" cellpadding="3">
                  <tr bgcolor="ffffcc"> 
                    <td width="100%" height="27" class="normal"> 
                    Show subjects who have been blocked access to e-Recruit because:
                    </td>
                  </tr>
                  
                 
                  <tr bgcolor="ffffcc"> 
                    <td width="100%" height="27" class="normal"> 
                        <input type="radio" name="type"  value="attend" checked >
                        their no show limit has exceeded that of the e-Recruit policy
                    </td>
                    
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="100%" class="normal"> 
                      
                        <input type="radio" name="type" value="cancel">
                        their sign up cancellation limit has exceeded that of the e-Recruit policy
                    </td>
                    
                  </tr>
                  <tr bgcolor="ffffcc"> 
                  
                    <td width="100%"> 
                      <div align="right"> 
                        <input type="submit" value="Show">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
              
               <hr width="98%" size="1" noshade align="center"> 
              <form method="post" action="Unblock_Subject.php">
                <p align="left" class="tablerow">Unblock Subjects :</p>
                <table width="75%" border="0" cellspacing="0" cellpadding="3">
                  <tr bgcolor="ffffcc"> 
                    <td width="100%" height="27" class="normal"> 
                        Unblock subjects with e-Recruit login name:
                        <input type="text" name="loginNames"  value="">
                        
                    </td>
                    
                  </tr>
                  <tr bgcolor="ffffcc"> 
                  <td width="100%"> 
                      <div align="right"> 
                        <input type="submit" value="Unblock">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
              
              <hr width="98%" size="1" noshade align="center"> 
              <form method="post" action="End_of_SemesterDay.php">
                <p align="left" class="tablerow">End of Semester Day :</p>
                <table width="75%" border="0" cellspacing="0" cellpadding="3">
                <tr bgcolor="ffffcc"> 
                    <td width="100%" height="27" class="normal"> 
                        The last "End of Semester Day": 
                        <font size=+1 color="red"> 
                        <?
                        print_end_of_semester_day();
                        ?>
                        </font>
                    </td>
                    
                  </tr>
                  
                  <tr bgcolor="ffffcc"> 
                    <td width="100%" height="27" class="normal"> 
                        Select next End of Semester Day:
                        <p>Year
                          <select name="year">
                          <?
                          for($i=2000; $i<=2050; $i++){
  			  	echo "<option value=\"$i\">$i</option>\n";
  			  }
			  ?>
			  </select>
			  Month
			  <select name="month">
			  <?
			  for($i=1; $i<=12; $i++){
  			  	echo "<option value=\"$i\">$i</option>\n";
  			  }
  			  ?>
  			  </select>
  			  Date
  			  <select name="day">
  			  <?
  			  for($i=1; $i<=31; $i++){
  			  	echo "<option value=\"$i\">$i</option>\n";
  			  }
  			  ?>
  			  </select>
  			</p>

                        
                    </td>
                    
                  </tr>
                  <tr bgcolor="ffffcc"> 
                  <td width="100%"> 
                      <div align="right"> 
                        <input type="submit" value="Submit">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
              
<?
/*              
              
         <!-- Block subjects -->     
         <form method="post" action="Block_Subject.php"> 
                <p align="left" class="tablerow">Block subjects from accessing 
                e-Recruit if they:</p>
                <table width="75%" border="0" cellspacing="0" cellpadding="3">
                  <tr bgcolor="ffffcc"> 
                    <td width="4%" height="27" class="normal"> 
                        <input type="radio" name="type"  value="0" checked >
                        
                    </td>
                    
                    <td width="96%" height="27" class="normal"> 
                        have not shown up in experiments, that they have signed 
                        up, for more than <select name="no_show_times">
                        <?
                        for($i=1; $i <11; $i++){
                        	echo "<option value=\"$i\">$i</option>\n";
                        }
                        ?>
                        </select>times
                        
                    </td>
                    
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="4%" height="27" class="normal"> 
                        <input type="radio" name="type"  value="1" >
                        
                    </td>
                    
                    <td width="96%" height="27" class="normal"> 
                        have cancelled signups within <select name="cancel_hours">
                         <?
                        for($i=1; $i <11; $i++){
                        	echo "<option value=\"$i\">$i</option>\n";
                        }
                        ?>
                        </select> hours before the session start times for more 
                        than <select name="cancel_times">
                         <?
                        for($i=1; $i <11; $i++){
                        	echo "<option value=\"$i\">$i</option>\n";
                        }
                        ?>
                        </select> times
                        
                    </td>
                    
                  </tr>
                  <?
  
                  <tr bgcolor="ffffcc"> 
                    <td width="100%" height="27" class="normal" colspan="2"> 
                        Block subjects with e-Recruit login name:
                        <input type="text" name="loginName"  value="">
                        
                    </td>
                    
                  </tr>
  
                  ?>
                  <tr bgcolor="ffffcc"> 
                  <td width="100%" colspan="2"> 
                      <div align="right"> 
                        <input type="submit" value="Block">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>

*/
 foot();
 ?>
