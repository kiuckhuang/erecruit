<?
require("../fun/exp_functions.inc");
if((isset($expprofile) && checkcookie($expprofile)) ){
	warning(T0079);
	exit();
}


$title="Log In (Non-".ORG_SHORT." Experimenter)";
head($title);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <?
                $where="index.php||Log In->";
                $where .= basename($PHP_SELF)."||".$title;
                position("$where");
            ?>
            </tr>
       </table>
 
 
              <hr noshade align="center" width="98%" size="1">
 
          </div>
          <form method="POST" action="Check_Login.php">
             
	    <div align="center"><font class="normal">  Welcome! Have you created an e-Recruit Experimenter account? If not, please click <a href="Experimenter_Reg.php"><img src="images/but_create.gif" align="absmiddle" border="0"></a>.
 Note that this page is NOT for people who want to participate in experiment.
Rather this page is for those who want to recruit subjects. <BR> For bugs and suggestions, please direct them to <? echo BUG_MAIL_WITH_LINK; ?>. </div>
            <table border="0" width="270" align="center">
              <tr> 
                <td width="40%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Login Name:</font></span></td>
                <td width="60%"> 
                  <input type="text" name="loginName" size="20" value="">
                </td>
              </tr>
              <tr> 
                <td width="40%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Password:</font> 
                  </span></td>
                <td width="60%"> 
                  <input type="password" name="password" size="20">
                  <input type="hidden" name="nonust" value="yes">
                </td>
              </tr>
              <tr>
              <td width="40%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">&nbsp;</font> 
                  </span></td>
                <td width="60%">  
                
                  <div align="right"> 
                  
                    <input type="submit" value="Log in" name="logon">
                    <input type="reset" value="Reset" name="reset">
                  </div>
                </td>
              </tr>
            </table>
          </form>
          <p class="normal" align="center">If you have forgetten your password, please 
            contact the system administrator at <a href="mailto:<? echo ADMIN_MAIL; ?>"><? echo ADMIN_MAIL; ?></a><br>
          </p>
          
          
<?




foot();
?>

