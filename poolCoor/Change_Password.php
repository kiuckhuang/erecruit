<?
require("../fun/poolcoor_functions.inc");
checkLogin();

if(isset($newpassword) && isset($confirmpassword)){
		$cookie_var = split("-", $pcprofile);
		$oldloginName = $cookie_var[0];
		$oldpassword = $cookie_var[1];
		
		if($oldloginName != $loginName){
			warning(P0001);
			exit();
		}
		
		$pass = crypt($password, substr($oldpassword, 0, 2));
		if($pass != $oldpassword){
			warning(P0002);
			exit();
			
		}
		
		if($password == $newpassword){
			warning(P0003);
			exit();
		}
		
		if($newpassword != $confirmpassword){
			warning(P0004);
			exit();
		}
		
		if(trim($newpassword) == ""){
			warning(P0005);
			exit();
		}
		$pasStr = array($loginName, crypt($newpassword));
		change_password($pasStr);
}
	
$title="Change Password";
head($title);
		
	
?>
<form method="POST" action="<? echo $PHP_SELF; ?>">
<span class="tablerow"></span> 

                <table border="0" width="90%" >
                <tr>
                 <?
		$where = "index.php||Log on->Pool_Management.php||$poolname Pool Management->";
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
                      <input type="password" name="password" size="20">
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




foot_link();
?>

