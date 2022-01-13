<?
include("../fun/poolcoor_functions.inc");
checkLogin();
$courseID = ereg_replace("_", " ", $courseID);
setcookie("credit_courseID", $courseID, time()+3600);
list($loginName, $id) = explode("-->", $creditstuid);

if($loginName == ""){
	list($loginName, $id) = explode("-->", $creditstuid2);
}
if($creditstuid2 == ""){
	setcookie("creditstuid2", $creditstuid, time()+3600);
}
setcookie("creditstuid", $loginName."-->".$id, time()-600);


if(isset($assigncredit)){

	if(trim($expid1) !=""){
	
		if(!expid($expid1)){
			warning("(Message no.P1008)No such Experiment ID: $expid1");
			exit();
		}
		
		if(!isPoolExp($pool, $expid1)){
			warning(P0034);
			exit();
		}
		
		
	}
	if(trim($expid2) !=""){
	
		if(!expid($expid2)){
			warning("(Message no.P1009)No such Experiment ID: $expid2");
			exit();
		}
		if(!isPoolExp($pool, $expid2)){
			warning(P0034);
			exit();
		}
		
	}

//echo "$login, $id, $expid1, $sessionid1,  $expid2, $sessionid2, $addcredit, $delcredit, $pool, $courseID\n";
assign_credit($login, $id, $expid1, $sessionid1,  $expid2, $sessionid2, $addcredit, $delcredit, $pool, $courseID);

header("Location: ./PM_Courses_Credits_Students_Earned.php");
exit();
}


$poolstr = ereg_replace("--", "  ", $pool);
$title="Assign Credit(s) to Student";

head($title);
$returnStr = subject_modify_data($loginName);
list($firstName, $lastName, $email) = explode("->", $returnStr);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 

                  <?
                
		$where = "index.php||Log on->Pool_Management.php||$poolname Pool Management->PM_Courses.php||Manage Course(s): $poolstr Pool->PM_Courses_Credits_Students_Earned.php||Credits Students Earned->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
               ?>
                </tr>

              </table>
              <hr noshade align="center" width="98%" size="1">
              <table width="56%" border="0" cellpadding="3" align="left">
                <tr> 
                  <td width="49%" class="normal">First Name(s) (e.g. Tai Man) : </td>
                  <td width="51%" class="tablerow"><? echo $firstName; ?></td>
                </tr>
                <tr> 
                  <td width="49%" class="normal" bgcolor="ffffcc">Last Name (e.g. Chan) :</td>
                  <td width="51%" bgcolor="ffffcc" class="tablerow"><? echo $lastName; ?></td>
                </tr>
                <tr>
                  <td width="49%" class="normal">Email Address :</td>
                  <td width="51%" class="tablerow"><? echo $email; ?></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p><br>
                <br>
              </p>
              <form method="post" action="<? echo $PHP_SELF; ?>">
                <table width="80%" border="0" cellspacing="1" cellpadding="0" align="left">
                  <input type="hidden" name="cid" value="<? echo $id; ?>">
                  <input type="hidden" name="loginName" value="<? echo $loginName; ?>">
                  <tr> 
                    <td class="normal" bgcolor="ffffcc" height="25">Assign &nbsp;&nbsp;
                      <input type="text" name="addcredit" size="3" value="">Credit(s) from Exp ID : 
                      <input type="text" name="expid1" size="10" value="">
                      Session: <input type="text" name="sessionid1" size="2" value=""> 
                    </td>
                  </tr>
                  <tr> 
                    <td class="normal" bgcolor="ffffcc">Withdraw
                     <input type="text" name="delcredit" size="3" value=""> Credit(s) from Exp ID: 
                      <input type="text" name="expid2" size="10" value="">
                      Session: <input type="text" name="sessionid2" size="2" value=""> 
                    </td>
                  </tr>
                  <tr> 
                    <td class="normal"> 
                      <div align="right"> 
                      <input type="hidden" name="login" value="<? echo $loginName; ?>">
                        <input type="submit" name="assigncredit" value="Assign">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
              </form>
      <br>
<? 
foot_link();
?>