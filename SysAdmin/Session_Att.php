<?
include("../fun/admin_functions.inc");

if(isset($modify)){
	$counter=0;
	for($i=0; $i< $total; $i++){
		if($boxes[$i] == "on"){
			$counter++;
		}
	//	echo "boxes[$i] => $boxes[$i]<br>";
	}
	if($counter){
		update_subject_attend($sessionid, $boxes, $loginNames, $attends, $total);
	}else{
		warning(S0040);
	}
	
	
}

//header("Location: Experienced_Subjects.php");

if(!(isset($sessionid) && $sessionid != "")){
	header("Location: Subject_Management.php");
}
$sessionid = ereg_replace(" ", "", $sessionid);
$title = "Subject Attendance of Session: $sessionid";
head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Home->Subject_Management.php||Subject Management->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?>

                </tr>
                </table>
<form method="post" action="<? echo $PHP_SELF; ?>">
<input type="hidden" name="sessionid" value="<? echo $sessionid; ?>">
            <table width="100%" cellpadding="2" cellspacing="0" border="1" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC" bordercolor="#CCCCCC">
              <tr valign="top" bgcolor="#000099"> 
              <td class="tablecolumn" bgcolor="#000099">Select</td>                
              <td class="tablecolumn">Login Name(s)</td>
              <td class="tablecolumn">First Name(s)</td>
              <td class="tablecolumn">Last Name</td>
              <td class="tablecolumn">Sex</td>
              <td class="tablecolumn">Phone</td>
              <td class="tablecolumn">Email</td>
              <td class="tablecolumn">SID</td>
              <td class="tablecolumn"><? echo ORG_SHORT; ?> Subjects?</td>
              <td class="tablecolumn">Participant showed up for the WHOLE session? <font color=red> * </font> </td>
              <td class="tablecolumn">Waiting List?</td>
              <td class="tablecolumn">Recored?</td>
              </tr>
             <?
             	$no = list_session_subjects_attend($sessionid, $selectall);
             	
             	if($no == 0){
             ?>
                  	<tr>
    				<td width="100%" colspan="12">No Subject Found</td>
  			</tr>
		<?
		
		}else{
		?>
			<tr>
    				<td width="100%" colspan="12">Total <? echo $no; ?> Records</td>
  			</tr>
             	<?
             	}
             	?>
             	
             	<input type="hidden" name="total" value="<? echo $no; ?>">
            </table>
            <br>
            
            <table width="100%" cellpadding="0">
              <tr> 
                <td width="49%"> 
                  <div align="left"> 
                    <input type="submit" name="selectall" value="Select All Participants">
                  </div>
                </td>
                <td width="51%"> 
                  <div align="right"> 
                    
                    	<input type="submit" name="modify" value="Modify">
                    
                  </div>
                </td>
              </tr>
            </table>           
            </form>     
            <?
              foot();
             ?>
    