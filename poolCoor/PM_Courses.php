<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(isset($credit_courseID)){
	setcookie("credit_courseID", $courseID, time()-3600);
}
if(isset($courseID)){
	setcookie("courseID", "", time()-3600);
}

if(!isset($pool))
	warning(P0021);

if(isset($sendmail) && $sendmail=="Send Mail"){
	sendmail("Course Instructor");
}

if(isset($submit) && $submit !=""){
	$k=0;
	for($j=0; $j<$total; $j++){
		if($checkbox[$j] == "on"){
			$k++;
		}
	}
	if($k <= 0 ){
		warning(P0022);
		exit;
	}
}

	

if($submit == "Modify Course"){
	$k=0;
	for($j=0; $j<$total; $j++){
		if($checkbox[$j] == "on"){
			$k++;
		}
	}
	if($k >1 ){
		warning(P0023);
		exit;
	}
	for($i=0; $i<$total; $i++){
		$courseID = $courseIDs[$i];
		if($courseID != "" && $checkbox[$i] == "on"){
			
			setcookie( "modifycourseid", $courseID, time()+60);
			header("Location: PM_Courses_Modify_Course.php");
			exit();
		}
	}
	
}
if($submit == "Credits Students Earned"){
	$k=0;
	for($j=0; $j<$total; $j++){
		if($checkbox[$j] == "on"){
			$k++;
		}
	}
	if($k >1 ){
		warning(P0024);
		exit;
	}
	
	for($i=0; $i<$total; $i++){
		$courseID = $courseIDs[$i];
		if($courseID != "" && $checkbox[$i] == "on"){
			
			$courseID = ereg_replace(" ", "_", $courseID);
			setcookie("creditcourseid", $courseID, time()+600);
			header("Location: PM_Courses_Credits_Students_Earned.php");
			exit();
		}
	}
	
}




if($submit == "Delete Course(s)"){
	for($i=0; $i<$total; $i++){
		if($checkbox[$i] == "on"){
			$delcourseID = $courseIDs[$i];
			$courseStr .= $delcourseID."->";
		}
	}
	if($courseStr !=""){
		$courseStr = substr($courseStr, 0, strlen($courseStr) -2);
		$msg = ereg_replace("->", "<br>\n<li>", $courseStr);
		$msg = ereg_replace("--", "  ", $msg);
		$msg = "(Message no.P1006)<br>\nDo you really want to delete the following course(s):<br>\n<li>".$msg;
		$delcourses = explode("->", $courseStr);
		for($k=0; $k< sizeof($delcourses); $k++){
			setcookie( "delcourses[$k]", $delcourses[$k], time()+60);
		}
		
		$link = "Del_Course.php";
		confirm($msg, $link);
		exit();
	}
	
}



$poolstr = ereg_replace("--", "  ", $pool);
$title="Manage Course(s): $poolstr";

head($title);


?>
              
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Log on->Pool_Management.php||$poolname Pool Management->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where"); 
               ?>



</tr>

                <tr>

                  <td class="pagetitle" colspan="2">&nbsp;</td>

                </tr>

              </table>
              

              <hr noshade align="center" width="98%" size="1">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <div align="right" class="normal">Click <a href="PM_Courses_Add_Course.php"><img src="images/but_here.gif" border ="0"  align="absmiddle"></a> to add course</div>
                  </td>
                </tr>
              </table>
              <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td class="tablecolumn">Select</td>
                    <td class="tablecolumn">Course</td>
                    <td class="tablecolumn">Course Instructor First Name(s) </td>
                    <td class="tablecolumn">Course Instructor Last Name </td>
                    <td class="tablecolumn">Course Instructor Email</td>
                   
                  </tr>
                 <?
                 	if($submit == "Select All Course(s)")
                 		$selectall = "Select All Course(s)";
                 	$no = list_all_courses($pool, $selectall);
                 	if(!($no >0 )){
                 ?>
                   	<tr>
			    <td width="100%" colspan="5">No Course is available</td>
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

                        <p> 
                          <input type="submit" name="selectall" value="Select All Boxes">
                          <input type="submit" name="submit" value="Modify Course">
                          <input type="submit" name="submit" value="Delete Course(s)">
                          <input type="submit" name="submit" value="Credits Students Earned">
                         
                        </p>
                      </div>
                      
                     </td>
                   </tr>
                 </table>
<?
	mail_form("course instructor");
/*                 
                 <!--
                        <table width="100%" cellpadding="3" bordercolor="#CCCCCC" border="0" cellspacing="0">
                  <tr bgcolor="ffffcc">
                    <td colspan="2" class="normal">To send an email to course instructor(s),
                      click the select box(es) then click &quot;Send Mail&quot;.</td>
                  </tr>
                  <tr>
                    <td width="13%" class="tablerow">Subject :</td>
                    <td width="87%">
                      <input type="text" name="subject" value="">
                    </td>
                  </tr>
                  <tr>
                    <td width="13%" class="tablerow">cc:</td>
                    <td width="87%">
                      <input type="text" name="cc" value="">
                    </td>
                  </tr>
                  <tr>
                    <td width="13%" class="tablerow">Message:</td>
                    <td width="87%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <textarea name="message" rows="3" cols="70" value=""></textarea>
                      <input type="submit" name="sendmail" value="Send Mail">
                    </td>
                  </tr>
                </table>
                -->
                
*/
?>
                </form>

              
<?


foot_link();
?>
