<?//***************************************************************************
  // by lion
  //***************************************************************************
require("../fun/subject_functions.inc");

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");          // Date in the past
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate");        // HTTP/1.1
header("Pragma: no-cache");                                // HTTP/1.0

if (!($ds = ldap_connect("ldap.ust.hk")))
  warning("Cannot connect to LDAP server (ldap.ust.hk)");
elseif ($PHP_AUTH_USER == "" || $PHP_AUTH_PW == ""
        || !(@$isBind = ldap_bind($ds, "uid=$PHP_AUTH_USER,ou=people,o=ust.hk", $PHP_AUTH_PW)))
{
header("WWW-authenticate:basic realm=\"".ORG_SHORT." Password\"");
  header("HTTP/1.0 401 Unauthorized");
  warning("You must enter a valid ".ORG_SHORT." login ID and password to access this resource");
}
else
{
	$sr = ldap_search($ds, "ou=people,o=ust.hk", "uid=$PHP_AUTH_USER");
	$info = ldap_get_entries($ds, $sr);

  $detail = "<br>ds=".$ds
           ."<br>ldap_search=".$sr
           ."<br>ldap_count_entries=".ldap_count_entries($ds,$sr)
           ."<br>info[count]=".$info["count"];
  ldap_unbind($ds);

  if ($info[0]["sn"][0] == "")
  {
    for ($i=0; $i < $info["count"]; $i++)
    	$detail .= "<br>i=".$i
                ."<br>dn=".$info[$i]["dn"]
                ."<br>cn=".$info[$i]["cn"][0]
                ."<br>sn=".$info[$i]["sn"][0]
                ."<br>givenname=".$info[$i]["givenname"][0]
                ."<br>mail=".$info[$i]["mail"][0]
  /*
                ."<br>fax=".$info[$i]["fax"][0]
                ."<br>mobile=".$info[$i]["mobile"][0]
                ."<br>url=".$info[$i]["url"][0]
                ."<br>departmentCode=".$info[$i]["departmentCode"]
                ."<br>userClass=".$info[$i]["userClass"][0]
  */
                ;
    warning("LDAP error!! Please report the following to "
            .BUG_MAIL_WITH_LINK."<br>".$detail);
  }
  else
  {
/*
		setcookie("lastName", $info[0]["sn"][0], time()+3600);
		setcookie("firstName", $info[0]["givenname"][0], time()+3600);
		setcookie("mail", $info[0]["mail"][0], time()+3600);
	  setcookie("isust", "is-".MD5(TIME()), time()+3600);
*/	  
		header("Location: logon.php");
  }
}
?>
