<?
include("../fun/poolcoor_functions.inc");
checkLogin();                 
//include("../fun/poolcoor_functions.inc");
//checkLogin();
$courseID = ereg_replace("_", " ", $courseID);
setcookie("credit_courseID", $courseID, time()+3600);

//echo $loginName;
$poolstr = ereg_replace("--", "  ", $pool);
$title="Add";

head($title);

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

                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">First Name(s) 
                      (e.g. Tai Man) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="firstName">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Last Name (e.g. Chan) :</td>
                    <td width="56%"> 
                      <input type="text" name="lastName">
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="44%" class="normal">Email Address :</td>
                    <td width="56%"> 
                      <input type="text" name="email">
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="2" class="tablerow"> 
                      <div align="right"> 
                        <input type="submit" name="submit" value="Add">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>

                </form>

              
<?
foot_link();
?>
