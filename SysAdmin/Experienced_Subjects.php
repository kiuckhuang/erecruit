<?
include("../fun/admin_functions.inc");
if(isset($sendmail) && $sendmail=="Send Mail"){
	sendmail("subject");
}
if(isset($condition) && is_array($condition)){
	$c2 = $condition[2];
	$c3 = $condition[3];
	$c6 = $condition[6];
	
	
	$c2 = eregi_replace(" ", "", $c2);
	if($c2 == ""){
		warning(S0044);
	}
	
	$sessionids1 = explode(",", $c2);
	
	for($i =0; $i < sizeof($sessionids1); $i++){
		if(!(is_valid_sessionid($sessionids1[$i]))){
			warning(S0043."The session id: $sessionids1[$i] is not exist");
		}
		
	}
	if($c3 == "and"){
	
		$c6 = eregi_replace(" ", "", $c6);
		if($c6 == ""){
			warning(S0045);
		}
		$sessionids2 = explode(",", $c6);
	
		for($j =0; $j < sizeof($sessionids2); $j++){
			if(!(is_valid_sessionid($sessionids2[$j]))){
				warning(S0043."The session id: $sessionids2[$j] is not exist");
			}
			
		}
	}
}


$title = "In/experienced Subjects";
head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Home->Subject_Management.php||Subject Management->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?></tr>
              </table>
              <hr noshade align="center" width="98%" size="1">
              <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
              <table width="100%" border="0" cellpadding="3" align="center" cellspacing="0">
                 <tr>
                  <td class="normal" colspan="2">
                  Here is a list of subjects who are : <br>
                    <select name="condition[0]">
                      <option selected value="<? echo $condition[0]; ?>" ><? echo $condition[0]; ?></option>
                      <option value="experienced">experienced</option>
                      <option value="inexperienced">inexperienced</option>
                    </select>
                     to 
                    <select name="condition[1]">
                       <option selected value="<? echo $condition[1]; ?>" ><? echo $condition[1]; ?></option>
                       <option value="any" >any</option>
                       <option value="all" >all</option>
                    </select> of the session(s):
                    <input type="text" name="condition[2]" size="50" value="<? echo $condition[2]; ?>">  
                    <select name="condition[3]">
                     <option selected value="<? echo $condition[3]; ?>" ><? echo $condition[3]; ?></option>
                      <option value="and">and</option>
                      <option value="or">or</option>
                    </select>
                    <br>
                    <select name="condition[4]">
                    <option selected value="<? echo $condition[4]; ?>" ><? echo $condition[4]; ?></option>
                      <option value="experienced">experienced</option>
                      <option value="inexperienced">inexperienced</option>                      
                    </select>
                    to                              
                    <select name="condition[5]">                       
                       <option selected value="<? echo $condition[5]; ?>" ><? echo $condition[5]; ?></option>
                       <option value="any" selected>any</option>
                       <option value="all">all</option>
                    </select>
                    of the session(s): 
                    <input type="text" name="condition[6]" size="50" value="<? echo $condition[6]; ?>">
                   <!--
                    <br>
                    <a href="search.php" target="blank">
                    Search session ID here.</a>
                    Close the new window when you have finished the search.
                    -->
                     </td>
                </tr>
              </table>
              <br>
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td class="tablecolumn">Select</td>
                    <td class="tablecolumn">First Name(s)</td>
                    <td class="tablecolumn">Last Name</td>
                    <td class="tablecolumn">Login Name</td>
                    <td class="tablecolumn">Sex</td>
                    <td class="tablecolumn">Phone</td>
                    
                    <td class="tablecolumn">Email</td>
                    <td class="tablecolumn">SID</td>
                    <td class="tablecolumn">*<? echo ORG_SHORT; ?> Subjects?</td>
                  </tr>
                  <?
                  	//$conditionStr = $showsub1."->".$showsub2."->".$showsub3."->".$showsub4."->".$showsub5."->".$submit;
                  	$no = show_experienced_subjects($condition, $submit);
                  	if($no <= 0){
                  	?>
                  	<tr>
    				<td width="100%" colspan="9">No Subject Found</td>
  			</tr>
			<?
			}
                 	
                  ?>
                </table>
                <br>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td> 
                      <div align="left">
                      <?
                      if($no != 0){
                      	?>
                      	
                        <input type="submit" name="submit" value="Select All Subjects">
                        <?
                	}
                	?>
                      </div>
                    </td>
                  </tr>
                </table>
                
              <hr width="98%" size="1" noshade align="center">
              
<?
mail_form("subject");
?>
              </form>
              <p class="notes"><i>* Information of sex and phone for <? echo ORG_SHORT; ?>
subjects was given by subjects. All information for non-<? echo ORG_SHORT; ?> subjects was
provided by subjects.</i></p>
 <?
foot();
?>
