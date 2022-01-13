<?
include("../fun/poolcoor_functions.inc");
checkLogin();
if(!isset($courseID)){
	$courseID = ereg_replace("_", " ", $creditcourseid);
}else{
//echo $courseID."abc";
}
setcookie("courseID", $courseID, time()+3600);

if(isset($total) && $total >=0 && (!isset($selectall))){
	$k=0;
	for($j=0; $j<$total; $j++){
		if($checkbox[$j] == "on"){
			$k++;
		}
	}
	if($k <= 0 ){
		warning(P0020);
		exit;
	}
}
	

if(isset($sendmail) && $sendmail = "Here"){
	$target = $pool."->".$courseID;
	send_credit_table($target);
	message(P0019, $PHP_SELF);
	exit;
}

	
if($submit == "Assign Credit(s) to Student"){
	for($i=0; $i< $total; $i++){
		$loginName = $loginNames[$i];
		$id = $creditid[$i];
		if($loginName != "" && $checkbox[$i] == "on"){
			$coursestuid = $loginName."-->".$id;
			setcookie("creditstuid", $coursestuid, time()+60);
			header("Location: PM_Courses_Credits_Students_Earned_Assign.php");
			exit();
		}
	}
	
	
}



if($submit == "Delete"){
	setcookie( "names");
	setcookie("delnames");
	for($i=0; $i<$total; $i++){
		if($checkbox[$i] == "on"){
			$loginnameStr .= $loginNames[$i]."->";
			$nameStr .= "$lastnames[$i], $firstnames[$i]"."->";
				
			
		}
	}
	$loginnameStr = substr($loginnameStr, 0, strlen($loginnameStr) -2);
	//credit_delelte($ids);
	//$link = $PHP_SELF;	
	//message("Credits Successfully deleted!", $link);
	//echo $nameStr;
	if($loginnameStr !=""){
		
		$nameStr = substr($nameStr, 0, strlen($nameStr) -2);
		
		$msg = ereg_replace("->", "<br>\n<li>", $nameStr);
		
		$msg = "(Message no.P1007)Do you really want to delete the following subject(s):<br>\n<li>".$msg;
		$delloginnames = explode("->", $loginnameStr);
		
		for($k=0; $k< sizeof($delloginnames); $k++){
			setcookie( "names[$k]", $delloginnames[$k], time()+60);
			
		}
		$delnames = urlencode($nameStr);
		$link = "Del_Credit.php?delnames=$delnames";
		confirm($msg, $link);
		exit();
	}

}






$poolstr = ereg_replace("--", "  ", $pool);
$title="Credits Students Earned";

head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 

                  <?
                
		$where = "index.php||Log on->Pool_Management.php||$poolname Pool Management->PM_Courses.php||Manage Course(s): $poolstr Pool->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?>
                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
	<?
		course_info($courseID);
	?>
		
              <p>&nbsp;</p>

              <p><br>
              </p>
              <form method="post" action="<? echo $PHP_SELF; ?>">
              <input type="hidden" name="courseID" value="<? echo $courseID; ?>">
                <? 
                /*
                <p> </p>
                <p align="left" class="normal">Experimenter can update the following 
                  records from time to time until the end of semester. <br>
                  e-Recruit will <font color="ff0000">not</font> allow the experimenter 
                  to modify the followings <font color="#FF0000">after <? pool_deadline($pool, ""); ?>.</font></p>
                  
                  */ 
                 ?>
                <table width="100%">
                  <tr> 
                    <td class="normal" colspan="2">
                      <div align="right">Click <a href="PM_Courses_Credits_Students_Earned_Add.php"><img src="images/but_here.gif" border="0" align="absmiddle"></a> 
                        to add student</div>
                    </td>
                  </tr>
                </table>
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td width="8%" class="tablecolumn">Select</td>
                    <td width="15%" class="tablecolumn" bgcolor="#000099"> First 
                      Name(s) </td>
                    <td width="10%" class="tablecolumn">Last Name</td>
                    <td width="10%" class="tablecolumn">Email</td>
                    <td width="15%" class="tablecolumn">Total Credits Earned</td>
                    <td width="42%" class="tablecolumn">Credits Breakdown</td>
                  </tr>
                  <?
                  	$target = $pool."->".$courseID;
                  	$no = list_credit_student_earned($target, $selectall);
                  	
                  	if(!($no >0 )){
                 ?>
                   	<tr>
			    <td width="100%" colspan="6">No experimenter has submitted any credit information</td>
  			</tr>
		<?
		}
                  ?>
                  	
                </table>
                <table width="100%">
                  <tr> 
                    <td> 
                      <div align="right"> 
                        <input type="submit" name="selectall" value="Select All Students">
                        
                        <input type="submit" name="submit" value="Delete">
                        <input type="submit" name="submit" value="Assign Credit(s) to Student">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="normal">
                      <div align="right">To email the above table to instructor, 
                        click 
                        <input type="submit" name="sendmail" value="Here">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
<?
foot_link();
?>
