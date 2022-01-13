<?
include("../fun/poolcoor_functions.inc");
checkLogin();
$courseID = ereg_replace("_", " ", $courseID);
setcookie("credit_courseID", $courseID, time()+3600);

$poolstr = ereg_replace("--", "  ", $pool);
$title="Modify";

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

              <form name="form1" method="post" action="Credit_Add_Check.php" >
		<input type="hidden" name="id" value="<? echo $id; ?>">
                <table width="752" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">First Name(s) 
                      (e.g. Tai Man) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="firstName" value="<? echo $firstName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Last Name (e.g. Chan) :</td>
                    <td width="56%"> 
                      <input type="text" name="lastName" value="<? echo $lastName; ?>">
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="44%" class="normal">Email Address :</td>
                    <td width="56%"> 
                      <input type="text" name="email" value="<? echo $email; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="2" class="tablerow"> 
                      <div align="right"> 
                        <input type="submit" name="submit" value="Modify">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>

                </form>

 <?
foot_link();
?>