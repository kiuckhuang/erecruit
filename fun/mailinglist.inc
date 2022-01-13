<?
include("./fun/mysql.inc");
include("./fun/config.inc");
include("./fun/common.inc");
include("./fun/mailinglist_mail.inc");
include("./fun/errmsg.inc");

$db = new phpDB();
$db->connect() or die ("Can't connect to database server or select database");

function check_mail_format($email){
	if($email == ""){
		warning(M0005);
		exit;
	}
	
	if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $email) && trim($email) !=""){
		warning(M0006);
		exit;
	}
	
}



function select_course(){
	global $db;
	$query = "select courseID, year, semester from course order by id asc";
	$rs= $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	?>
	<select name="course">
	<option value="">Please Select One Course&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
	<?
	for($i=0; $i < $numOfRows; $i++){
		$rs->moveRow($i);
		$courseID = eregi_replace(" ", "_", $rs->fields[courseID]);
		$coursevalue = $courseID."--".$rs->fields[year]."--".$rs->fields[semester];
		$course = $rs->fields[courseID]."--".$rs->fields[year]."--".$rs->fields[semester];
				
		echo "<option value=\"$coursevalue\">$course</option>\n";
	}
	echo "</select>\n";
	
	
}

function mailexist($email, $category, $name){
	global $db;
	
	$name = eregi_replace("_", " ", $name);
	if($category == "course"){
		$query = "select email from mailinglist_course where email='$email' and course='$name'";
	}
	elseif($category == "public"){
		$query = "select email from mailinglist_public where email='$email'";
	}
	else{
		$query = "select email from mailinglist_hkust where email='$email'";
	}
	
	$rs= $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	if($numOfRows){
		return true;
	}
	else{
		return false;
	}
}


function add2templist($email, $category, $name){
	global $db;
	$md5str = MD5( TIME() );
        $authcode = substr($md5str, 0, 6);
        
        $name = eregi_replace("_", " ", $name);
	
	if($category == "org"){
		$query = "insert into mailinglist_hkust (email, addcode) values ('$email', '$authcode')";
	}
	elseif($category == "course"){
		$query = "insert into mailinglist_course (email, course, addcode) values ('$email','$name', '$authcode')";
	}
	elseif($category == "public"){
		$query = "insert into mailinglist_public (email, addcode) values ('$email', '$authcode')";
		
	}
	else{
		
	}
	
	$rs = $db->query($query);
	$link = RECRUIT_URL."/mailinglist_check.php?action=add+email=$email+category=$category+name=$name+addcode=$authcode";	
	subscribe_mail($email, $link);

}



function del2templist($email, $category, $name){
	global $db;
	$md5str = MD5( TIME() );
        $authcode = substr($md5str, 0, 6);
	$name = eregi_replace("_", " ", $name);
	if($category == "public"){
		$query = "update mailinglist_public set delcode='$authcode' , addcode='' where email='$email'";
	}
	elseif($category == "course"){
		$query = "update mailinglist_course set delcode='$authcode' , addcode='' where email='$email' and course='$name'";
	}
	elseif($category == "org"){
		$query = "update mailinglist_hkust set delcode='$authcode' , addcode='' where email='$email'";
		
	}
	else{
		
	}
	
	$rs = $db->query($query);
	
	$link = RECRUIT_URL."/mailinglist_check.php?action=del+email=$email+category=$category+name=$name+delcode=$authcode";
	unsubscribe_mail($email, $link);
}





function add2list($email, $category, $name, $addcode){
	global $db;
	$name = eregi_replace("_", " ", $name);
	if($category == "public"){
		$query = "update mailinglist_public set addcode='' where email='$email' and addcode='$addcode'";
	}
	elseif($category == "course"){
		$query = "update mailinglist_course set addcode='' where email='$email' and course='$name' and addcode='$addcode'";
	}
	elseif($category == "org"){
		$query = "update mailinglist_hkust set addcode='' where email='$email' and addcode='$addcode'";
		
	}
	else{
		
	}
	
	
	
	$rs= $db->query($query);
	
	
	if($rs){
		message(M0007, RECRUIT_URL);
		exit;
	}
	else{
		message(M0008, RECRUIT_URL);
		exit;
	}
}


function del2list($email, $category, $name, $delcode){
	global $db;
	$name = eregi_replace("_", " ", $name);
	if($category == "public"){
		$query = "delete from  mailinglist_public where email='$email' and delcode='$delcode'";
	}
	elseif($category == "course"){
		$query = "delete from  mailinglist_course where email='$email' and course='$name' and delcode='$delcode'";
	}
	elseif($category == "org"){
		$query = "delete from  mailinglist_hkust where email='$email'  and delcode='$delcode'";
		
	}
	else{
		
	}
	
	
	
	$rs= $db->query($query);
	
	
	if($rs){
		message(M0009, RECRUIT_URL);
		exit;
	}
	else{
		message(M0008, RECRUIT_URL);
		exit;
	}
}

?>
