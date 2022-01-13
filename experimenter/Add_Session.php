<?
require("../fun/exp_functions.inc");
checkLogin();
if(!checkexpid($expid)){
	warning(T0022);
	exit();	
}

check_session_no($expid);

$title="Add Session";
head($title);

if ($modifyold!=""){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	
	$query = "SELECT * from session WHERE id='$modifyold'";
	$rs = $db->query($query);
	$rs->firstRow();
	
	$oldtitle=$rs->fields[title];
	$reward=$rs->fields[reward];
	$fromdate=$rs->fields[fromdate];
	$durationEnd=$rs->fields[durationEnd];
	$venue=$rs->fields[venue];
	$quota=$rs->fields[quota];
	$description =$rs->fields[description];
	
	$reward = explode("->", $reward);
	$fromyear = substr($fromdate, 0, 4);
	$frommonth = substr($fromdate, 4, 2);
	$fromday = substr($fromdate, 6, 2);
	$fromhour = substr($fromdate, 8, 2);
	$frommin = substr($fromdate, 10, 2);
	$durationEnd = explode("-", $durationEnd);
}

?>
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
          <form method="post" action="Check_Session.php">
            <table width="100%" cellpadding="3" cellspacing="0" border="0">
              <tr> 
                <td width="15%" valign="top" class="normal">Session Title: </td>
                <td width="85%"> 
                  <!-- input type="text" name="title" value="Session <? echo "".show_session_no($expid); ?>" --> 
                  
                  <font class="normal" >Session <? echo "".show_session_no($expid); ?></font>
                  <input type="hidden" name="title" value="<? echo "Session ".show_session_no($expid); ?>"> <!-- value="Session <? echo "".show_session_no($expid); ?>" -->
                  
                </td>
              </tr>
              <tr> 
                <td width="15%" valign="top" class="normal" bgcolor="ffffcc" height="122">Reward 
                  Type :</td>
                <td width="85%" height="122" bgcolor="ffffcc"> 
                  <table width="100%" cellpadding="3" border="0" cellspacing="0" bgcolor="ffffcc">
                    <tr> 
                      <td width="21%" class="normal" valign="top"> 
                        <input type="radio" name="reward" value="money" <? if ($reward[0]=="money") echo "checked"; ?> >
                        Money:</td>
                      <td width="79%" class="normal"> 
                        <select name="money1">
                          <? if ($reward[0]=="money"){ 
                          	 echo "<option value=\"$reward[1]\">$reward[1]</option>";
                             }
                             else{
                             	 echo "<option></option>";
                            }

                          ?>
                          <option value="A fixed">A fixed</option>
                          <option value="A maximum" >A maximum</option>
                          <option value="A minimum">A minimum</option>
                          <option value="An average">An average</option>
                        </select>
                        amount of 
                        <input type="text" name="money2" value="<? if ($reward[0]=="money") echo "$reward[2]" ?>" size="8"> (e.g. <? echo CURRENCY; ?>100.00) will be given to each participant. </td>
                    </tr>
                    <tr> 
                      <td colspan="2" class="normal" valign="top"> 
                        <hr noshade width="100%" size="1">
                      </td>
                    </tr>
                    <tr> 
                      <td width="21%" class="normal" valign="top"> 
                        <input type="radio" name="reward" value="credit" <? if ($reward[0]=="credit") echo "checked"; ?> >
                        Credit: </td>
                      <td width="79%" class="normal"> 
                        <select name="credit1">
                          <? if ($reward[0]=="credit"){ 
                          	 echo "<option value=\"$reward[1]\">$reward[1]</option>";
                             }
                             else{
                             	 echo "<option></option>";
                            }

                          ?>
                          <option value="A fixed">A fixed</option>
                          <option value="A maximum" >A maximum</option>
                          <option value="A minimum">A minimum</option>
                          <option value="An average">An average</option>
                        </select>
                        number of 
                        <? /*
                        <select name="credit2">
                        <option></option>
                        <? for($i=1; $i<=10; $i++){
                        	echo "<option value=\"$i\">$i</option>\n";
                           }
                        ?>
                        </select>
                        */ ?>
                          <input type="text" name="credit2" value="<? if ($reward[0]=="credit") echo "$reward[2]" ?>" size="8"> (e.g. 4)
                        credit(s) will be given to each participant. </td>
                    </tr>
                    <tr> 
                      <td colspan="2" class="normal" valign="top">
                        <hr noshade width="100%" size="1">
                      </td>
                    </tr>
                    <tr> 
                      <td width="21%" class="normal" valign="top"> 
                        <input type="radio" name="reward" value="creditmoney" <? if ($reward[0]=="creditmoney") echo "checked"; ?>>
                        Credit &amp; Money :</td>
                      <td width="79%" class="normal"> 
                        <select name="creditmoney1">
                          <? if ($reward[0]=="creditmoney"){ 
                          	 echo "<option value=\"$reward[1]\">$reward[1]</option>";
                             }
                             else{
                             	 echo "<option></option>";
                            }
                          ?>
                          <option value="A fixed">A fixed</option>
                          <option value="A maximum" >A maximum</option>
                          <option value="A minimum">A minimum</option>
                          <option value="An average">An average</option>
                        </select>
                        amount of 
                        
                        <input type="text" name="creditmoney2" value="<? if ($reward[0]=="creditmoney") echo "$reward[2]"; ?>" size="8"> (e.g. <? echo CURRENCY; ?>100.00)
                        AND <br>
                        <select name="creditmoney3">
                          <? if ($reward[0]=="creditmoney"){ 
                          	 echo "<option value=\"$reward[3]\">$reward[3]</option>";
                             }
                             else{
                             	 echo "<option></option>";
                            }

                          ?>                                     
                          <option value="A fixed">a fixed</option>
                          <option value="A maximum" >a maximum</option>
                          <option value="A minimum">a minimum</option>
                          <option value="An average">an average</option>
                        </select>
                        number of 
                        <? /*
                        <select name="creditmoney4">
                        <option></option>
                        <? for($i=1; $i<=10; $i++){
                        	echo "<option value=\"$i\">$i</option>\n";
                           }
                        ?>
                        </select>
                        */
                        ?>
                        <input type="text" name="creditmoney4" value="<? if ($reward[0]=="creditmoney") echo "$reward[4]"; ?>" size="8"> (e.g. 4) 
                        credit(s) will be given to each participant. </td>
                    </tr>
		    <tr> 
                      <td colspan="2" class="normal" valign="top">
                        <hr noshade width="100%" size="1">
                      </td>
                    </tr>
                    <tr> 
                      <td width="21%" class="normal" valign="top"> 
                        <input type="radio" name="reward" value="Not specified" <? if ($reward[0]=="Not specified") echo "checked"; ?>>Not specified
                      </td>
                    </tr>
                    
                  </table>
                </td>
              </tr>
              <tr> 
                <td width="15%" valign="top" class="normal">Date :</td>
                <td width="85%"> 
                  <select name="date">
                  
                  <?    echo "<option value=\"$fromday\">$fromday</option>\n";
                  	for($i=1; $i<=31; $i++){
                  		if($i <10){
                  			$j = "0".$i;
                  		}
                  		else{
                  			$j = $i;
                  		}
                  		
                  		
                  		echo "<option value=\"$j\">$j</option>\n";
                  	}
                  ?>
                  </select>
                  <select name="month">
                  
                  <?  $month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                      
                      //$frommonth = $month[$frommonth];
                      echo "<option value=\"$frommonth\">".$month[$frommonth-1]."</option>";
                  
                  	for($i=0; $i<12; $i++){
                  		$j=$i+1;
                  		if($j <10)
                  			$k = "0".$j;
                  		else
                  			$k = $j;
                  		echo "<option value=\"$k\">$month[$i]</option>\n";
                  	}
                  ?>

                  </select>
                  <select name="year">
                  
                  <?  	echo "<option value=\"$fromyear\">$fromyear</option>\n"; 
                  	for($i=2000; $i<=2050; $i++){
                  		echo "<option value=\"$i\">$i</option>\n";
                  	}
                  ?>

                  </select>
                </td>
              </tr>
              <tr bgcolor="ffffcc"> 
                <td width="15%" valign="top" class="normal">Start Time :</td>
                <td width="85%" valign="top" class="normal"> 
                 <? /*<input type="text" name="starttime" value="<? if($sessionid!="")  echo $starttime; else echo "HH:MM"; ?>"> */?>
                 <select name="starthour">
                        <? echo "<option value=\"$fromhour\">$fromhour</option>\n";
                           for($i=0; $i<=23; $i++){
				if ($i<10){
					echo "<option value=\"0$i\">0$i</option>\n";
				}
				else{
					echo "<option value=\"$i\">$i</option>\n";				
				}
		
                           }
                        ?>
                  </select> : 
                  <select name="startmin">

                        <? 	echo "<option value=\"$frommin\">$frommin</option>\n";
                           for($i=0; $i<=59; $i++){
                           	if ($i<10){
					echo "<option value=\"0$i\">0$i</option>\n";
				}
				else{
					echo "<option value=\"$i\">$i</option>\n";				
				}
                           }
                        ?>
                  </select>(24-Hour Format)
                </td>
              </tr>
              <tr> 
                <td width="15%" valign="top" class="normal">Approximate Duration 
                  :</td>
                <td width="85%" class="normal"> 
                  <select name="duration1">
                  <? echo "<option value=\"$durationEnd[0]\">$durationEnd[0]</option>" ?>
                        <? for($i=0; $i<=200; $i++){
                        	echo "<option value=\"$i\">$i</option>\n";
                           }
                        ?>
                  </select>
                  <? //<input type="text" name="duration1" size="5"> ?>
                  day(s)
                  <? //<input type="text" name="duration2" size="5"> ?>
                  <select name="duration2">
                 <? echo "<option value=\"$durationEnd[1]\">$durationEnd[1]</option>" ?>
                        <? for($i=0; $i<=23; $i++){
                        	echo "<option value=\"$i\">$i</option>\n";
                           }
                        ?>
                  </select>
                  hour(s)
                  <? //<input type="text" name="duration3" size="5"> ?>
                  <select name="duration3">
                  <? echo "<option value=\"$durationEnd[2]\">$durationEnd[2]</option>" ?>
                        <? for($i=0; $i<=59; $i++){
                        	echo "<option value=\"$i\">$i</option>\n";
                           }
                        ?>
                  </select>
                  minute(s)</td>
              </tr>
              <tr bgcolor="ffffcc"> 
                <td width="15%" valign="top" class="normal"><font class="noteindicator"> # </font> Quota :</td>
                <td width="85%" class="tablerow">
                     <? show_quota_to_modify($expid, $quota); ?>
                  
                </td>
              </tr>
              <tr> 
                <td width="15%" valign="top" class="normal">Venue :</td>
                <td width="85%" valign="top" class="normal"> 
                  <input type="text" name="vennue" value="<? echo "$venue"; ?>" > (e.g. <? echo ORG_SHORT; ?> RM 4115A)
                </td>
              </tr>
             
              <tr> 
                <td width="15%" valign="top">&nbsp;</td>
                <td width="85%"> 
                  <div align="right"> 
                    <input type="submit" name="submit" value="Add">
                    <input type="reset" name="reset" value="Reset">
                  </div>
                </td>
              </tr>
            </table>
          </form>
          <hr noshade align="center" width="98%" size="1">
           <div align="left"><font class="notes">Fields with <font class="noteindicator"> # </font> cannot be modified once you have pressed "Add". If you must make changes to these fields, you should
          delete the experiment and create a new one</font>
          </div>
          <br>
          <div align="left"><font class="notes">' <font class="noteindicator">*</font> ' denotes optional fields</font>
          </div>
<?



foot();
?>

