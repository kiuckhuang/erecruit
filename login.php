<?
   function  authenticate()  {
   	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
	header("Pragma: no-cache");                                   // HTTP/1.0
   	Header("WWW-authenticate:  basic  realm='". ORG_SHORT ." Username and Password'");
   	Header("HTTP/1.0  401  Unauthorized");
   	echo "$REMOTE_USER <br>\n";
   	echo "$REMOTE_PASSWORD <br>\n";
   	echo "$PHP_AUTH_USER <br>\n";
   	echo "$PHP_AUTH_PW <br>\n";
   	
   	
   	
   	$REMOTE_USER = "";
   	$REMOTE_PASSWORD = "";
   	$PHP_AUTH_USER = "";
   	$PHP_AUTH_PW = "";
   
   	echo  "You  must  enter  a  valid  login  ID  and  password  to  access  this  resource\n";
   	
   	exit;
      }

$ds=ldap_connect("ldap.ust.hk"); // must be a valid LDAP server!

if(isset($PHP_AUTH_USER)  && $PHP_AUTH_USER != "" && $PHP_AUTH_PW != "")  {
  	$bind = @ldap_bind($ds, "uid=$PHP_AUTH_USER,ou=people,o=ust.hk", $PHP_AUTH_PW);
	if($bind){
	 	$sr=ldap_search($ds,"ou=People, o=ust.hk", "uid=$PHP_AUTH_USER");
	 	
 	
   	
		echo "Search result is ".$sr."<p>";
		echo "Number of entires returned is ".ldap_count_entries($ds,$sr)."<p>";
		echo "Getting entries ...<p>";
		$info = ldap_get_entries($ds, $sr);
		echo "Data for ".$info["count"]." items returned:<p>";
		for ($i=0; $i<$info["count"]; $i++) {
			
			echo "dn is: ". $info[$i]["dn"] ."<br>";
			echo "first cn entry is: ". $info[$i]["cn"][0] ."<br>";
			echo "first email entry is: ". $info[$i]["mail"][0] ."<p>";
			echo "first fax entry is: ". $info[$i]["fax"][0] ."<p>";
			echo "first mobile entry is: ". $info[$i]["mobile"][0] ."<p>";
			echo "first url entry is: ". $info[$i]["url"][0] ."<p>";
			echo "first departmentCode entry is: ". $info[$i]["departmentCode"] ."<p>";
			echo "first userClass entry is: ". $info[$i]["userClass"][0] ."<p>";
			
		}
		
		echo "Closing connection";
		ldap_close($ds);
		 
		
	}else{
		authenticate();
		exit();
	}
}else{		
  	authenticate();
}

  
?>
