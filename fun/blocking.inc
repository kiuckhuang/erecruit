<?
    function is_blocking($subjectprofile) {
	//$CRYPT_STD_DES = 1;	// Standard DES Encryption
	$LOGIN = split("-", $subjectprofile);
	$loginName = $LOGIN[0]; $password = $LOGIN[1];
	global $PHP_AUTH_USER;
	global $mail;
	
	$result = false;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT password FROM subject WHERE loginName = '$loginName'";
	$rs = $db->query($query);
	$cryptpassword = $rs->fields[password];
	$password = crypt($password, substr("$cryptpassword", 0, 2));
	
	$query = "SELECT loginName FROM subject WHERE loginName = '$loginName' and password = '$password'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	$query = "SELECT loginName FROM blocklist WHERE loginName = '$loginName' and unblockdate > now() and (cancel_type = 1 or attend_type = 1)";
	$rs = $db->query($query);
	$isblock= $rs->getNumOfRows();
	
	$rs->close();		
	$db->close();
	
	if(($isblock > 0 ) && $numOfRows){
	        $result = true;
	}

	return $result;
    }    
?>