<?
	$clear ="";
	setcookie("subjectprofile",$clear, time() - 3600 );
	setcookie("isust",$clear, time() - 3600 );
	setcookie("mail",$clear, time() - 3600 );
	setcookie("firstName",$clear, time() - 3600 );
	setcookie("lastName",$clear, time() - 3600 );
	setcookie("REMOTE_USER",$clear, time() + 3600 );
	setcookie("REMOTE_PASSWORD",$clear, time() + 3600 );
	setcookie("PHP_AUTH_USER",$clear, time() + 3600 );
	setcookie("PHP_AUTH_PW",$clear, time() + 3600 );
include("../fun/subject_functions.inc");

//if (is_ust())$isNon = "";
//else { $isNon = "Non-"; }


		

//$loginStr = "$loginName"."\t"."$password";
//$login_var = explode("-", $expprofile);
//if(!isset($loginName))
//	$loginName = $login_var[0];



function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isnon;
	global $isNon;
	$title="Log In (for Other Participants)";
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td> 
 		<?
 		$where = "index.php||Log In->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where"); ?>
		</td>
		<td>
		<!--
 		<? if (is_ust()){ echo "<a href=\"logout.php\">";?>
 		<img src="images/but_logout.gif" border="0" align="absmiddle"></a>
 		<?}?>
 		-->
 		</td>
 		</tr>
                
              </table>
              <hr noshade align="center" width="98%" size="1">
              
              
                                <br>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="ffffcc"> 
                      <td height="39"> 
                        <div class="normal">
                          <div align="center">Welcome! Have you created an <font color="#000099">e-Recruit</font> 
                            account? If not, please click 
                            <a href="Create_Account.php"><img src="images/but_create.gif" border="0" align="absmiddle"></a><br>
                            To visit our system without creating a new account, 
                            please type "guest" in both of the blanks below. <br> For bugs and suggestions, please direct them to <? echo BUG_MAIL_WITH_LINK; ?>.
                            
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                  
                </div>

              </div>

              <div v:shape="_x0000_s3074" class="O"><div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;

mso-kinsoku-overflow:1" class="pagetitle"><hr noshade align="center" width="98%" size="1">
                </div>
              </div>

              <form method="POST" action="login_member_nonust.php">

                <!--webbot bot="SaveResults"

  U-File="C:\My Documents\ERECRUIT\_private\form_results.txt"

  S-Format="TEXT/CSV" S-Label-Fields="TRUE" --> <span class="tablerow"></span> 

                <table border="0" width="53%" align="center">
                  <tr> 
                    <td width="50%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">e-Recruit 
                      Login Name:</font></span></td>
                    <td width="50%">
                      <div align="right">
                        <input type="text" name="loginName" size="20" value="">
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="50%" class="tablerow"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">
                      Password:</font> </span></td>
                    <td width="50%"> 
                      <div align="right">
                        <input type="password" name="password" size="20">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td> 
                    <td> 
                      <div align="right">
                        <input type="submit" value="Log In" name="logon">
                        <input type="reset" value="Reset" name="reset">
                      </div>
                    </td>
                  </tr>
                                  </table>

              </form>

<p align="center" class="tablerow"><a href="../mailinglist.php">Upcoming Experiments Notifications</a><br>
                      <a href="forgetpassword.php">Forgotten Your Password?</a></p>
<?
	foot();
}
?>

<?
  //-------------main-----------
//content($title);
  //----------------------------
?>

<?
if(is_ust()){	

	content($title);
}else{
	content($title);
}
?>
