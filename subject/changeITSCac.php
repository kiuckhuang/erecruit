<?
require("../fun/subject_functions.inc");

if (isset($loginName) && isset($password) && isset($newITSClogin))
  if ($newITSClogin != $PHP_AUTH_USER)
    warning("Please use your new ". ORG_SHORT ." account to login.");
  else
  {
  	$db = new phpDB();
  	$db->connect() or die ("Can't connect to database server or select database");

  	$mail = $HTTP_COOKIE_VARS["mail"];
  	$rs = $db->query("SELECT password FROM subject WHERE loginName = '$loginName'");

    $warnmess = "e-Recruit login fail.";
  	if ($rs->getNumOfRows() == 1)
  	{
  		$cryptpassword = $rs->fields[password];
  		if ($cryptpassword == crypt($password, substr("$cryptpassword", 0, 2)))
        if (!$db->query("UPDATE subject SET org='$mail' WHERE loginName='$loginName'"))
          $warnmess = "Database update fail.";
        else
        {
          $title=" Change Account (for ".ORG_SHORT." Student/Staff)";
          head($title);
?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr><td> 
                <? position("index.php||Log In->".basename($PHP_SELF)."||".$title); ?>
              </td></tr>
            </table>
            <hr noshade align="center" width="98%" size="1"><br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr bgcolor="ffffcc"> 
                <td height="39"> 
                  <div class="normal" align="center">
          Change success. Your can use e-Recruit with your new <? echo ORG_SHORT; ?> login name.
          <br><br><a href="logon.php">Login e-Recruit</a>
                  </div>
                </td>
              </tr>
            </table>
<?
          foot();
          exit();
        }
    }
    
   	$db->close();
    warning($warnmess);
  }

$title=" Change Account (for ".ORG_SHORT." Student/Staff)";
head($title);
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td> 
      <? position("index.php||Log In->".basename($PHP_SELF)."||".$title); ?>
    </td></tr>
  </table>
  <hr noshade align="center" width="98%" size="1"><br>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="ffffcc"> 
      <td height="39"> 
        <div class="normal" align="center">
If you have changed your <? echo ORG_SHORT; ?> login name, please enter your new <? echo ORG_SHORT; ?> login name below 
<br>so that you can log on to e-Recruit using your e-Recruit login name.
<br>For bugs and suggestions, please direct them to <? echo BUG_MAIL_WITH_LINK; ?>.                            
        </div>
      </td>
    </tr>
  </table>

  <form method="POST" action=<? echo "\"$PHP_SELF\"" ?> >
  <table border="0" width="53%" align="center">
    <tr> 
      <td width="50%" class="tablerow">
        <span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US">
          <font color="#996600">e-Recruit Login Name:</font>
        </span>
      </td>
      <td width="50%"><div align="right">
        <input type="text" name="loginName" size="20" value="">
      </div></td>
    </tr>
    <tr> 
      <td width="50%" class="tablerow">
        <span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US">
          <font color="#996600">e-Recruit Password:</font>
        </span>
      </td>
      <td width="50%"><div align="right">
          <input type="password" name="password" size="20">
      </div></td>
    </tr>
    <tr> 
      <td width="50%" class="tablerow">
        <span style="mso-fareast-font-family: 新細明體; mso-hansi-font-family: Times New Roman; mso-fareast-language: ZH-TW" lang="EN-US">
          <font color="#996600">New <? echo ORG_SHORT; ?> Login Name:</font>
        </span>
      </td>
      <td width="50%"><div align="right">
        <input type="text" name="newITSClogin" size="20">
      </div></td>
    </tr>
    <tr> 
      <td></td>
      <td><div align="right">
          <input type="submit" value="Change" name="change">
          <input type="reset" value="Reset" name="reset">
      </div></td>
    </tr>
  </table>
  </form>
<? foot(); ?>