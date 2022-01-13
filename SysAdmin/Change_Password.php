<?
require("../fun/admin_functions.inc");


if(isset($newpassword) && isset($confirmpassword)){
		
		if($REMOTE_USER != $loginName){
			warning(S0001);
			exit();
		}
		
		
		if(!check_password($oldpassword)){
			warning(S0002);
			exit();
			
		}
		
		if($REMOTE_PASSWORD == $newpassword){
			warning(S0003);
			exit();
		}
		
		if($newpassword != $confirmpassword){
			warning(S0004);
			exit();
		}
		
		if(trim($newpassword) == ""){
			warning(S0005);
			exit();
		}
		$pasStr = "$loginName:".crypt($newpassword);
		$passfile = fopen("./.htpasswd", "w+");
		fwrite($passfile, "$pasStr");
		fclose($passfile);
		message(S0006, RECRUIT_URL);
		
		//change_password($pasStr);
}
	
$title="Change Password";
head($title);
		
	
?>
<form method="POST" action="<? echo $PHP_SELF; ?>">
<span class="tablerow"></span> 

                <table border="0" width="90%" >
                <tr>
                 <?
                $where="index.php||Home->";
                $where .= basename($PHP_SELF)."||".$title;
                position("$where");
            ?>
              </tr>
                  <tr> 
                    <td width="41%" class="tablerow" align="right"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Login 
                      Name :</font></span></td>
                    <td width="59%"> 
                      <input type="text" name="loginName" size="20" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="41%" class="tablerow"  align="right"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Old 
                      Password :</font> </span></td>
                    <td width="59%"> 
                      <input type="password" name="oldpassword" size="20">
                    </td>
                  </tr>
                  <tr>
                    <td width="41%" class="tablerow" align="right"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">New Password :</font></span></td>
                    <td width="59%">
                      <input type="password" name="newpassword" size="20">
                    </td>
                  </tr>
                  <tr>
                    <td width="41%" class="tablerow" align="right"><span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US"><font color="#996600">Confirm Password :</font></span></td>
                    <td width="59%">
                      <input type="password" name="confirmpassword" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="2"> 
                      <div align="right"> 
                        <input type="submit" value="Change Password" name="change">
                        <input type="reset" value="Reset" name="reset">
                      </div>
                    </td>
                  </tr>
                </table>

              </form>
              
<?

foot();
?>

