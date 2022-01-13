<?include("../fun/admin_functions.inc");
setcookie("credit_courseID", $courseID, time()-3600);
setcookie( "pool", $cookie_val, time()-36000); 
if(isset($sendmail) && $sendmail=="Send Mail"){
	sendmail("Course instructor");
	
}

if(isset($submit) && $submit!="Select All Courses"){
	$k=0;
	for($j=0; $j<$total; $j++){
		if($checkbox[$j] == "on"){
			$k++;
		}
	}
	if($k <=0 ){
		warning(S0025);
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
		warning(S0026);
		exit;
	}
		
		
	
	for($i=0; $i<$total; $i++){
		
		$courseID = $courseIDs[$i];
		if($courseID != "" && $checkbox[$i] == "on"){
			$courseID = ereg_replace(" ", "_", $courseID);
			header("Location: Modify_Course.php?courseID=$courseID");
			exit();
		}
	}
	
}
if($submit == "Delete Course(s)"){
	for($i=0; $i<$total; $i++){
		$courseID = $courseIDs[$i];
		if($courseID != "" && $checkbox[$i] == "on"){
			$courseID = ereg_replace("_", " ", $courseID);
			//del_course($courseID);
			$courseStr .= $courseID."->";
		}
	}
	if($courseStr !=""){
		
		
		$courseStr = substr($courseStr, 0, strlen($courseStr) -2);
		//echo $courseStr;
		$msg = ereg_replace("->", "<br>\n<li>", $courseStr);
		
		$msg = "(Message no.S1007)Do you really want to delete the following course(s):<br>\n<li>".$msg;
		$courseStr = urlencode($courseStr);
		$link = "Del_Course.php?courseStr=$courseStr";
		confirm($msg, $link);
		exit();
	}
	
	
}


$title="Course Management";

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
              <hr noshade align="center" width="98%" size="1">
              <table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td>
                    <div align="right" class="normal">Click <a href="Add_Course.php"><img src="images/but_here.gif" border ="0"  align="absmiddle"></a> to add course</div>
                  </td>
                </tr>
              </table>
              <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td class="tablecolumn">Select</td>
                    <td class="tablecolumn">Course</td>
                    <td class="tablecolumn">Year</td>
                    <td class="tablecolumn">Semester</td>
                    <td class="tablecolumn">Course Instructor First Name(s) </td>
                    <td class="tablecolumn">Course Instructor Last Name </td>
                    <td class="tablecolumn">Course Instructor Email</td>
                    <td class="tablecolumn">Course Sign-up Code</td>
                    <td class="tablecolumn">Course Authorization Code</td>
                  </tr>
                 <?
                 	if($submit == "Select All Courses")
                 		$selectall = "Select All Courses";
                 	$no = list_all_courses("", $selectall);
                 	if($no == 0){
                  	?>
                  	<tr>
    				<td width="100%" colspan="9">No Course is available</td>
  			</tr>
			<?
			}
                 	
                 ?>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td> 
                      <div align="left">
                        <input type="submit" name="submit" value="Select All Courses">
                        <input type="submit" name="submit" value="Modify Course">
                        <input type="submit" name="submit" value="Delete Course(s)">
                      </div>
                    </td>
                  </tr>
                </table>
                
              <hr width="98%" size="1" noshade align="center">
              <?
                mail_form("course instructor");
                ?>
              </form>
<?
foot();
?>