<?
include("../fun/admin_functions.inc");
checkLogin();
$cookie_val = "";
setcookie( "pool", $cookie_val, time()-3600); 
setcookie("credit_courseID", $courseID, time()-3600);


$title = "System Administration";
head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr> 
 		<? 
                  	position("index.php||Log on->home.php|| $title");
                ?>
                 
              </table>
            </div>
          </div>
          <div v:shape="_x0000_s3074" class="O"><div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"><hr noshade align="center" width="98%" size="1">
                  <div align="right"><a href="Change_Password.php">Change System Admin Password</a> </div>

                
              <table width="319" border="0" cellpadding="2">
                <tr bgcolor="#FFFFCC"> 
                  <td class="tablecolumn"><a href="Experimenter_Management.php">Experimenter Management</a></td>
                </tr>
                <tr bgcolor="#FFFFCC"> 
                  <td class="tablecolumn"><a href="Subject_Management.php">Subject Management</a></td>
                </tr>
                <tr bgcolor="#FFFFCC"> 
                  <td class="tablecolumn"><a href="System_Management.php">Course Management</a></td>
                </tr>
                <?
                	print("<tr bgcolor=\"#FFFFCC\">\n"); 
                	print("  <td class=\"tablecolumn\"><a href=\"Pool_Management.php\">Subject Pool Management</a></td>\n");
                	print("</tr>");
                ?>

              </table>
<?

foot_link();
?>