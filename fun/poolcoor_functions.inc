<?

include("../fun/mysql.inc");
include("../fun/config.inc");
include("../fun/common.inc");
include("../fun/errmsg.inc");

$db = new phpDB();
$db->connect() or die ("Can't connect to database server or select database");

include("../fun/poolcoor_mail.inc");

function checkcookie($pcprofile){
  	$cookie_var = split("-", $pcprofile);
	$loginName = $cookie_var[0];
	$password = $cookie_var[1];
	global $db;
	
	$query = "SELECT loginName FROM poolCoordinator WHERE loginName = '$loginName' and password='$password'";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){	
		return true;
	}else{
		return false;
	}
}
    
    
    
    
function Login($loginStr) {
	//$CRYPT_STD_DES = 1;	// Standard DES Encryption
	$LOGIN = explode("\t", $loginStr);
	$loginName = $LOGIN[0]; $password = $LOGIN[1];
	
	$result = false;
	global $db;
	
	$query = "SELECT password FROM poolCoordinator WHERE loginName = '$loginName'";
	$rs = $db->query($query);
	$cryptpassword = $rs->fields[password];
	
	$password = crypt($password, substr("$cryptpassword", 0, 2));
	
	$query = "SELECT pool FROM poolCoordinator WHERE loginName = '$loginName' and password = '$password'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	if($numOfRows){
		$rs->firstRow();
		$poolname = $rs->fields[pool];
		$md5str = MD5( TIME() );
		$cookie_val = "$loginName-$password-$md5str";
		setcookie( "pcprofile", $cookie_val, time()+3600); 
		setcookie( "poolname", $poolname, time()+3600); 
        $result = true;
	    
	}
	return $result;
}

function checkLogin(){
	global $pcprofile;
	
	if(!(isset($pcprofile) && checkcookie($pcprofile))){
		warning(P0028);
		exit();
	}

}

//function to change password
function change_password($pasStr){
	
		global $db;
		
		$loginName = $pasStr[0];
		$newpassword =$pasStr[1];
		$query = "UPDATE poolCoordinator SET password='$newpassword' WHERE loginName='$loginName'";
		$rs = $db->query($query);
		setcookie("pcprofile", "$login", time()-6000);
		setcookie( "sessionid", $sessionid, time()-3600); 
		setcookie("iamust", "yes", time()-3600);
		setcookie("poolname", "yes", time()-3600);
		
		message(P0029, "index.php");
		
}


function foot_link(){

?>
<p class="normal"><div align="center"><a href="Change_Password.php">Change Password</a> | <a href="logout.php">Log Out</a></div></p>
<?
foot();
}




function show_subject_pool($pool, $selectall){
	global $db;	
	$query = "SELECT id, signUpCode, year, semester, authcode FROM pool where id='$pool' order by id, year ASC";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$pool = $rs->fields[id];
		$signUpCode = $rs->fields[signUpCode];
		$year = $rs->fields[year];
		$semester = $rs->fields[semester];
		$authcode = $rs->fields[authcode];
		
		
		?>
		  <tr> 
                    <td width="10%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($selectall !="") echo "checked"; ?>>
                      </div>
                    </td>
                    <td width="30%" valign="top" class="normal"><? echo $pool." ".$year." ".$semester; ?></td>
                    <input type="hidden" name="pools[<? echo $i; ?>]" value="<? echo $pool."--".$year."--".$semester; ?>">
                    <td width="30%" valign="top" class="normal"><? echo $signUpCode; ?></td>
                    <td width="30%" valign="top" class="normal"><? echo $authcode; ?></td>
                  </tr>
                <?
        }
        echo "<input type=\"hidden\" name=\"total\" value=\"$numOfRows\">";
	return $numOfRows;


}



function show_all_experimenters($selectall){
	global $db;
	
	$query = "SELECT * FROM experimenter order by firstName ASC";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$password = $rs->fields[password];
		$sid = $rs->fields[sid];
		$phone = $rs->fields[phone];
		$email = $rs->fields[email];
		$remarks = $rs->fields[remarks];
		$instructor = $rs->fields[instructor];
		if($instructor == ""){
			$instructor = "&nbsp;";
		}
		if($remarks == ""){
			$remarks = "&nbsp;";
		}
		if($phone == ""){
			$phone = "&nbsp;";
		}
		if($email == ""){
			$email = "&nbsp;";
		}
		
		
		$name = $lastName.", ".$firstName;
		?>
		
		
		<tr> 
                    <td width="6%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]"<?
				if($selectall !="")
					echo "checked ";
			?>>
                      </div>
                    </td>
                    <td width="8%" valign="top" class="normal"><? echo $name; ?></td>
                    <td width="14%" valign="top" class="normal"><? echo $instructor ;?></td>
                    <td width="10%" valign="top" class="normal"><? echo $loginName ;?></td>
                    <input type="hidden" name="loginNames[<? echo $i; ?>]" value="<? echo $loginName; ?>">
                    <!--
                    <td width="12%" valign="top" class="normal"><? echo $password ;?></td>
                    -->
                    <td width="12%" valign="top" class="normal"><? echo $sid ;?></td>
                    <td width="8%" valign="top" class="normal"><? echo $phone ;?></td>
                    <td width="12%" valign="top" class="normal"><a href="mailto:<? echo $email ;?>"><? echo $email ;?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email; ?>">
                    <td width="18%" valign="top" class="normal"><? echo $remarks ;?></td>
                  </tr>
                <?  

		
        }
        echo "<input type=\"hidden\" name=\"total\" value=\"$numOfRows\">";
	
}

function expid($expid){
	global $PHP_SELF;
	global $db;
	
	$query = "SELECT id FROM experiment WHERE id = '$expid' ";
	$rs = $db->query($query);	
	$numOfRows = $rs->getNumOfRows();
	
	if($numOfRows){
		$rs->firstRow();	/*	optional, but recommended.	*/
		$expid = $rs->fields[id];
		
		return $expid;
	}
	else{
		return false;
	}
	
}



function list_all_courses($pool, $selectall){
	
	if($selectall != ""){
		$checked = "checked";
	}
	 	
	global $db;
	
	$query = "SELECT * FROM course where enable='y' and pool='$pool' order by courseID ASC";
		
		
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$id = $rs->fields[id];
	 	$courseID = $rs->fields[courseID];
	 	$year = $rs->fields[year];
	 	$semester = $rs->fields[semester];
	 	$firstName = $rs->fields[firstName];
	 	$lastName = $rs->fields[lastName];
	 	$email = $rs->fields[email];
	 	$signUpCode = $rs->fields[signUpCode];
	 	
	 	?>
	 	<tr> 
                    <td valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? echo $checked; ?>>
                      </div>
                    </td>
                    
                    <td valign="top" class="normal"><? echo $courseID."  ".$year."  ".$semester; ?></td>
                    <input type="hidden" name="courseIDs[<? echo $i; ?>]" value="<? echo $courseID."--".$year."--".$semester; ?>">
                    <td valign="top" class="normal"><? echo $firstName; ?></td>
                    <td valign="top" class="normal"><? echo $lastName; ?></td>
                    <td valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email; ?>">
                    <input type="hidden" name="ids[<? echo $i; ?>]" value="<? echo $id; ?>">
                    <? if(trim($pool)==""){ ?>
                    <td valign="top" class="normal"><? echo $signUpCode; ?></td>
                    <? } ?>
                 </tr>
                 <?
                 
        }
        ?>
        <input type="hidden" name="total" value="<? echo $numOfRows; ?>">
        <?
return $numOfRows;        
}


                

// function to show one experimenter infor
function show_experimenter_info($loginName){
	
  	if($loginName !=""){
		global $db;
		
		$query = "SELECT * FROM experimenter Where loginName='$loginName'";
		$rs = $db->query($query);
	
		$rs->firstRow();
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$password = $rs->fields[password];
		$sid = $rs->fields[sid];
		$phone = $rs->fields[phone];
		$email = $rs->fields[email];
		$remarks = $rs->fields[remarks];
		$instructor = $rs->fields[instructor];
	
	}
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Experimenter 
                      e-Recruit Login Name :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="loginName" value="<? echo $loginName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Experimenter Password(Encrypted/Will be Encrypted) :</td>
                    <td width="40%"> 
                      <input type="text" name="password" value="<? echo $password; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">First Name(s) 
                      (e.g. Tai Man) :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="firstName" value="<? echo $firstName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Last Name (e.g. Chan) :</td>
                    <td width="40%"> 
                      <input type="text" name="lastName" value="<? echo $lastName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Staff/Student 
                      ID :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="sid" value="<? echo $sid; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Instructor of which course(s) 
                      (e.g. MARK 112 L1 Fall 2000) : </td>
                    <td width="40%"> 
                      <input type="text" name="instructor" value="<? echo $instructor; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Phone No(s) 
                      (e.g. 97123456, 23821234) :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="phone" value="<? echo $phone; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal">Email Address :</td>
                    <td width="40%"> 
                      <input type="text" name="email" value="<? echo $email; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="normal" bgcolor="ffffcc">Remarks :</td>
                    <td width="40%" bgcolor="ffffcc"> 
                      <input type="text" name="remarks" value="<? echo $remarks; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="60%" class="tablerow">&nbsp;</td>
                    <td width="40%"> 
                      <div align="right">
                        <input type="submit" name="<?
                        	if($loginName !="")
                        		echo "Modify";
                        	else
                        		echo "Add";
                        ?>" value="<?
                        	if($loginName !="")
                        		echo "Modify";
                        	else
                        		echo "Add";
                        
                        ?>">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>
                
                
<?
                
}

//function to check experimenter info
function check_experimenter_info($infoStr){
	if($infoStr =="")
		exit();
		
	$info = explode("->", $infoStr);
	$loginName = $info[0];
	$firstName = $info[1];
	$lastName = $info[2];
	$password = $info[3];
	
	$sid = $info[4];
	$phone = $info[5];
	$email = $info[6];
	$remarks = $info[7];
	$instructor = $info[8];
	$action = $info[9];
	
	if($loginName =="" ){
		warning(P0030);
		exit();
	}
	
	if($password == ""){
		warning(P0031);
		exit();
	}
	
	if($firstName ==""){
		warning(P0008);
		exit();
	}
	
	if($lastName ==""){
		warning(P0009);
		exit();
	}
	
	
	
	if($email ==""){
		warning(P0010);
		exit();
	}
	
	
	if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)) {
		
		warning(P0012);
		exit();
	}
	$password = crypt($password);
	
	global $db;
	
	
	
	
	if($action == "Add"){
		$query = "SELECT loginName from experimenter where loginName='$loginName'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
	
		if($numOfRows ){
			warning(P0032);
			exit();
		}
		
		$query = "INSERT INTO experimenter (loginName, firstName, lastName, password, sid, phone, email, remarks, instructor)";
		$query .=" VALUES ('$loginName', '$firstName', '$lastName', '$password', '$sid', '$phone', '$email', '$remarks', '$instructor')";
	}
	else if($action == "Modify"){
		$query = "UPDATE experimenter SET loginName='$loginName', firstName='$firstName' , lastName='$lastName', password='$password', sid='$sid', phone='$phone', email='$email', remarks='$remarks', instructor='$instructor' where loginName='$loginName'";
		
	}
	
	$rs = $db->query($query);
}



//show warning message

function show_experiments_of_experimenter($loginName){
	if($loginName != ""){
		global $db;
		$db->pconnect() or die ("Can't connect to database server or select database");
		
		$query = "SELECT firstName, lastName from experimenter where loginName = '$loginName'";
		$rs = $db->query($query);
		
		$rs->firstRow();
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
?>
		<table width="61%" border="0" cellpadding="3" align="left">
                <tr> 
                  <td width="51%" class="normal">Experimenter Name : </td>
                  <td width="49%" bgcolor="ffffcc" class="tablerow"><? echo $lastName.", ".$firstName; ?></td>
                </tr>
                <tr> 
                  <td width="51%" class="normal">Experimenter Login Name :</td>
                  <td width="49%" bgcolor="ffffcc" class="tablerow"><? echo $loginName; ?></td>
                </tr>
                <tr>
                
<?
		$condition = "experimenters like '$loginName"."->%'";
		
		$query = "SELECT id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated FROM experiment WHERE enable='y' and $condition order by id asc";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
?>
               <td width="51%" class="normal">Number of Experiment(s) created:</td>
                  <td width="49%" bgcolor="ffffcc" class="tablerow"><? echo $numOfRows; ?></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p><br>
                <br>
              </p>
              <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                <tr bgcolor="#000099" valign="top"> 
                  <td width="6%" class="tablecolumn">Experiment ID</td>
                  <td width="8%" class="tablecolumn" bgcolor="#000099"> Title</td>
                  <td width="14%" class="tablecolumn">Created/Modified On</td>
                </tr>
              
<?		
	for($i=0; $i< $numOfRows; $i++){ //$numOfRows
		$rs->moveRow($i);
		$expid = $rs->fields[id];
		$title = $rs->fields[title];
		$createdon = date("jM Y", $rs->fields[dateCreated]);
?>
	
	        <tr> 
                  <td width="6%" valign="top"> 
                    <div align="center" class="normal"><? echo $expid; ?></div>
                  </td>
                  <td width="8%" valign="top" class="normal"><? echo $title; ?></a></td>
                  <td width="14%" valign="top" class="normal"><? echo $createdon; ?></td>
                </tr>
<?
	}
  
?>
	      </table>


<?
	}
}




// function to show subject record;
function show_subject_record($condition, $selectall){
	global $db;
	
	$queryStr = explode("->", $condition);
	if($queryStr[0] == "name"){
		$firstName = $queryStr[1];
		$lastName = $queryStr[2];
		$conditions = "firstName = '$firstName' and lastName = '$lastName'";
	}else{
		$conditions = "email = '$condition'";
	}
	$query = "SELECT firstName, lastName, loginName, password, email FROM subject Where $conditions";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$password = $rs->fields[password];
		$email = $rs->fields[email];
?>
		<tr> 
			<td width="6%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]"  <? if($selectall != "") echo "checked"; ?>>
                      </div>
                    </td>
                    <td width="8%" valign="top" class="normal"><? echo "$firstName"; ?></td>
                    <td width="14%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <td width="10%" valign="top" class="normal"><? echo $loginName; ?></td>
                    <td width="12%" valign="top" class="normal"><? echo $password; ?></td>
                    <td width="12%" valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                  </tr>		
	
<?
	}
?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
<?
}




//funtion to add/modify course
function add_course_layout($modify, $signup, $send){
	if($modify != ""){
		global $db;
		
		list($courseID, $year, $semester) = explode("--", $modify);
		$query = "SELECT * FROM course where courseID='$courseID' and year='$year' and semester='$semester'";
		
		$rs = $db->query($query);
		$rs->firstRow();
		$id = $rs->fields[id];
	 	$courseID = $rs->fields[courseID];
	 	$year = $rs->fields[year];
	 	$semester = $rs->fields[semester];
	 	$firstName = $rs->fields[firstName];
	 	$lastName = $rs->fields[lastName];
	 	$email = $rs->fields[email];
	 	$signUpCode = $rs->fields[signUpCode];
	 	$year = $rs->fields[year];
	 	$semester = $rs->fields[semester];
	 	$modify = urlencode($modify);
	}
	?>
		
		
              <form name="form1" method="post" action="Check_Course.php<? if($modify != "") echo "?courseID=$modify"; ?>" >
                
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Course (e.g. MARK 231 L1) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="course" value="<? echo $courseID; ?>" size="20">
                      <input type="hidden" name="id" value="<? echo $id; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Year :</td>
                    <td width="56%">
                      <select name="year">
                      <? 
                      if(isset($year))
                       echo "<option selected value=\"$year\">$year</option>";
                       for($i=2000; $i<2051; $i++){
                      		echo "<option value=\"$i\">$i</option>\n\t\t\t";
                      	}
                      ?>
                      </select>
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="44%" class="normal">Semester :</td>
                    <td width="56%">
                      <select name="semester">
                       <? if(isset($semester) )
                       echo "<option selected value=\"$semester\">$semester</option>";
                       ?>
                        <option value="SPRING">SPRING</option>
                        <option value="SUMMER">SUMMER</option>
                        <option value="FALL">FALL</option>
                        <option value="WINTER">WINTER</option>
                      </select>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal">First Name(s) (e.g. Tai Man):</td>
                    <td width="56%"> 
                      <input type="text" name="firstName" value="<? echo $firstName; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Last Name (e.g. Chan) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="lastName" value="<? echo $lastName; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Email Address :</td>
                    <td width="56%">
                      <input type="text" name="email" value="<? echo $email; ?>" size="20">
                    </td>
                  </tr>
                  <? 
                  if($signup != ""){
                  ?>	
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">System Generated Sign-Up Code :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="signUpCode" value="<?
                      	if($modify =="" || (isset($signUpCode) && $signUpCode=="")){
                      		$md5str = MD5( TIME() );
                      		
                      		$signUpCode = substr($md5str, 0, 8);
                      		
                      	}
                      	       	 echo $signUpCode; ?>" size="20">
                    </td>
                  </tr>
                  <?
                  }
                ?>
                  <tr> 
                    <td colspan="2" class="tablerow"> 
                      <div align="right"> 
                        <input type="submit" name="submit" value="<?
                        	if($modify =="")
                        		echo "Add";
                        	else
                        		echo "Modify";
                        	?>">
                        <input type="reset" name="reset" value="Reset">
                  <?
                  if($modify != ""){
                 	echo "<input type=\"submit\" name=\"sendtocouse\" value=\"Send to Course Instructor\">";
                 }
                        
                 if($send =="send" && $modify == ""){
                 	echo "<br><input type=\"submit\" name=\"gotoexp\" value=\"Go to Course Management\">";
		 }
		 ?>
                      </div>
                    </td>
                  </tr>
                </table>
                </form>
<?
}

//funtion to show course detail course
function show_course_layout($courseidstr){
	
		global $db;
		global $PHP_SELF;
		
		list($courseID, $year, $semester) = explode("--", $courseidstr);
		$query = "SELECT * FROM course where courseID='$courseID' and year='$year' and semester='$semester'";
		$rs = $db->query($query);
		$rs->firstRow();
	 	$courseID = $rs->fields[courseID];
	 	$firstName = $rs->fields[firstName];
	 	$lastName = $rs->fields[lastName];
	 	$email = $rs->fields[email];
	 	$signUpCode = $rs->fields[signUpCode];
	 	$authcode = $rs->fields[authcode];
	 	$year = $rs->fields[year];
	 	$semester = $rs->fields[semester];
	 	
	
	?>
		
		
              <form name="form1" method="post" action="<? echo $PHP_SELF ?>" >
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Course (e.g. MARK 231 L1) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <? echo $courseID; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Year :</td>
                    <td width="56%">
                      <? echo $year; ?>
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="44%" class="normal">Semester :</td>
                    <td width="56%">
                      <? echo $semester; ?>
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal">First Name(s) (e.g. Tai Man):</td>
                    <td width="56%"> 
                      <? echo $firstName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Last Name (e.g. Chan) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <? echo $lastName; ?>
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Email Address :</td>
                    <td width="56%">
                      <? echo $email; ?>
                    </td>
                  </tr>
                  
                    <td colspan="2" class="tablerow"> 
                      <div align="right"> 
                      <input type="hidden" name="courseidstr" value="<? echo $courseidstr; ?>">
                        <?
                 
                 	echo "<input type=\"submit\" name=\"sendtocouse\" value=\"Send to Course Instructor\">";
                 	echo "<br><input type=\"submit\" name=\"gotocourse\" value=\"Go to Course Management\">";
		        
                        ?>
                      </div>
                    </td>
                  </tr>
                </table>
                </form>
<?
}


// function to add/modify a course

function add_course($courseStr){
	$courseval = explode("->", $courseStr);
	$courseID = $courseval[0];
	$firstName = $courseval[1];
	$lastName = $courseval[2];
	$email = $courseval[3];
	$signUpCode = $courseval[4];
	$pool = $courseval[5];
	$submit = $courseval[6];
	$semester = $courseval[7];
	$year = $courseval[8];
	$id = $courseval[9];
	
	global $db;
	
	
	
	if($submit == "Add"){
		$query = "INSERT into course (courseID, firstName, lastName, email, pool, signUpCode, semester, year) values ('$courseID', '$firstName', '$lastName', '$email', '$pool', '$signUpCode', '$semester', '$year')";
	}else{
		$query = "UPDATE course set courseID='$courseID', firstName='$firstName', lastName='$lastName', email='$email', pool='$pool', signUpCode='$signUpCode', semester='$semester', year='$year' where id=$id";
	}
	if($db->query($query)){
		return true;
	}else{
		return false;
	}
}

// function to show experienced subjects
function show_experienced_subjects($conditionStr){
	global $db;
	$condition = explode("->", $conditionStr);
	
	$c1 = $condition[0];
	$c2 = $condition[1];
	$c3 = $condition[2];
	$c4 = $condition[3];
	$c5 = $condition[4];
	$c6 = $condition[5];
	
	if($c6 == "Select All Participant(s)")
		$checked = "checked";
	
	$query = "SELECT firstName, lastName, sex, phone, email FROM subject /*where $cond */ order by id ASC";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$phone = $rs->fields[phone];
		$email = $rs->fields[email];
		$sex = $rs->fields[sex];
	?>
	
	<tr> 
                    <td width="6%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($checked == "checked") echo $checked; ?>>
                      </div>
                    </td>
                    <td width="8%" valign="top" class="normal"><? echo $firstName; ?>
                    </td>
                    <td width="14%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <td width="10%" valign="top" class="normal"><? echo $sex; ?></td>
                    <td width="12%" valign="top" class="normal"><? echo $phone; ?></td>
                    <td width="12%" valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                 <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
                  </tr>		
	
<?
	}
?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
<?
}



// this function is check whether the course is exist or not
function course_exist($course, $pool){
	global $db;
	list($courseID, $year, $semester) = explode("--", $course);
	$query = "SELECT courseID FROM course where enable='y' courseID='$courseID' and year='$year' and semester='$semester' and pool='$pool'";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		return true;
	}else{
		return false;
	}
}
	

//function to show experimenter with specified pool
function show_pool_experiments($pool, $selectall){
	global $db;
	
	$condition = "target='pool->$pool'";
	list($poolid, $poolyear, $poolsem) = explode("--", $pool);
	$query = "select deadline  from pool where  id='$poolid' and year=$poolyear and semester='$poolsem'";
	$rs = $db->query($query);
	
	$deadline = $rs->fields[deadline];
	
	
	$query = "SELECT id, title, experimenters, sessions, UNIX_TIMESTAMP(creditcoursesubmitdate) as submitdate,UNIX_TIMESTAMP(dateCreated) as dateCreated  FROM experiment WHERE enable='y' and $condition order by id asc";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		
		$id = $rs->fields[id];
		$title = $rs->fields[title];
		$experimenters = $rs->fields[experimenters];
		$sessions = $rs->fields[sessions];
		
		$query = "select count(*) as total from session where id like '$id%'";
		$rs0310 = $db->query($query);
		$total = $rs0310->fields[total];
		if($total == $sessions)
		{
		
			$experimenters = explode("->", $experimenters);
			$experimenter = $experimenters[0];
			$query = "select firstName, lastName, email from experimenter where loginName='$experimenter'";
			$rs1= $db->query($query);
			$rs1->firstRow();
			$email = $rs1->fields[email];
			$firstName = $rs1->fields[firstName];
			$lastName = $rs1->fields[lastName];
				
			?>
			  <tr> 
	                    <td width="5%" valign="top"> 
	                      <div align="center" class="normal">
	                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($selectall !="") echo "checked"; ?> >
	                      </div>
	                    </td>
	                    <td width="10%" valign="top" class="normal"><? echo $id; ?></a></td>
	                    <td width="25%" valign="top" class="normal"><? echo $title; ?></td>
	                    <td width="10%" valign="top" class="normal"><? echo $firstName; ?></td>
	                    <td width="10%" valign="top" class="normal"><? echo $lastName; ?></td>
	                    <td width="10%" valign="top" class="normal"><? echo "&nbsp;"; ?></td>
	                    <td width="10%" valign="top" class="normal"><? echo "&nbsp;"; ?></td>
	                   <input type="hidden" name="emails[<? echo $i; ?>]" value="<? echo $email;?>">
	                   <td width="20%" valign="top" class="normal"><? echo "&nbsp;"; ?></td>
	                  </tr>	
	                  <?
	                $query = "SELECT id, UNIX_TIMESTAMP(fromdate) as startdate, durationEnd FROM session WHERE id like '$id%' order by id asc";
			
			$rs1 = $db->query($query);
			$numOfRows1 = $rs1->getNumOfRows();
			for($j=0; $j <$numOfRows1; $j++){
				$rs1->moveRow($j);
			
				$sessionid = $rs1->fields[id];
				$startdate = $rs1->fields[startdate];
				$duration = $rs1->fields[durationEnd];
				$durationarr = explode("-", $duration);
				$duration_stamp = ($durationarr[0] *24*3600) + ($durationarr[1] * 3600) + ($durationarr[2] * 60);
				
				$submit_deadline_stamp = ($startdate + $duration_stamp + ($deadline * 24 * 3600));
				$submit_deadline = date("j M Y H:i", $submit_deadline_stamp);
				
				$query = "select UNIX_TIMESTAMP(max(date)) as submit_date from attendancy where sessionid=$sessionid";
				
				$rs2 = $db->query($query);
				$numOfRows2 = $rs2->getNumOfRows();
				
				if($numOfRows2){
					$rs2->firstRow();
					$asubmit_date = $rs2->fields[submit_date];
				}
				$query = "select UNIX_TIMESTAMP(max(date)) as submit_date from credit where sessionid=$sessionid";
				$rs3 = $db->query($query);
				$numOfRows3 = $rs3->getNumOfRows();
				
				if($numOfRows3){
					$rs3->firstRow();
					$csubmit_date = $rs3->fields[submit_date];
				}
				
				if($asubmit_date != "" || $csubmit_date != ""){
					if($asubmit_date > $csubmit_date){
						$submittedon = date("j M Y", $asubmit_date);
					}
					else{
						$submittedon = date("j M Y", $csubmit_date);
					}
				}
				else{
					$submittedon = "Never";
				}
			
	                  ?>
	                  <tr> 
	                    <td width="60%" colspan="5"><? echo "&nbsp;"; ?></td>
	                    <td width="10%"><? echo substr($sessionid, 8, 2); ?></td>
	                    <td width="10%"><? echo "$submittedon"; ?></td>
	                    <td width="20%" valign="top" class="normal"><? echo "$submit_deadline"; ?></td>
	                   
	                  </tr>	
	                  <?
	        	}
                }
                  ?>	
	
<?
	}

?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
<?
	return $numOfRows;
}





// function to show a course info
function course_info($courseID){
	global $db;
	list($course, $year, $semester) = explode("--", $courseID);
	
	$query = "SELECT firstName, lastName, email FROM course where courseID='$course' and year='$year' and semester='$semester' ";
		
	$rs = $db->query($query);
	$rs->firstRow();
	 	
	 $firstName = $rs->fields[firstName];
	 $lastName = $rs->fields[lastName];
	 $email = $rs->fields[email];
      
      ?>
              <table width="46%" border="0" cellpadding="3" align="left" cellspacing="0">
                <tr> 
                  <td width="42%" class="normal">Course :</td>
                  <td width="58%" class="tablerow"><? echo ereg_replace("--", "  ", $courseID); ?></td>
                </tr>
                <tr> 
                  <td width="42%" class="normal" bgcolor="ffffcc">Instructor's Name :</td>
                  <td width="58%" bgcolor="ffffcc" class="tablerow"><? echo $lastName.", ".$firstName; ?></td>
                </tr>
                <tr>
                  <td width="42%" class="normal" height="21">Instructor's Email :</td>
                  <td width="58%" class="tablerow" height="21"><a href="mailto://<? echo $email; ?>"><? echo $email; ?></a></td>
                </tr>
              </table>
	<?
}


function pool_code($pool, $newsignupcode){
	global $db;
	
	if($newsignupcode==""){
		$query = "SELECT signUpCode from pool where id='$pool'";
		$rs = $db->query($query);
		$rs->firstRow();
		 	
		$signUpCode = $rs->fields[signUpCode];
        	echo $signUpCode;
	
	}
	else{
		$query = "update pool set signUpCode='$newsignupcode' where id='$pool'";
		
		$rs = $db->query($query);
	}
	
		
}

function pool_deadline($pool, $newdeadline){
	global $db;
	
	if($newdeadline ==""){
		$query = "SELECT UNIX_TIMESTAMP(deadline) as deadline from pool where id='$pool'";
		$rs = $db->query($query);
	
		$rs->firstRow();
	
		$deadline = date("jM Y", $rs->fields[deadline]);
       	echo $deadline;
	}
	else{
		$query = "UPDATE pool set deadline=$newdeadline where id='$pool'";
		$rs = $db->query($query);
	}		
	
}



function del_course($course){
	
	list($courseID, $year, $semester) = explode("--", $course);
	global $db;
	
	$query = "update course set enable='n' where courseID='$courseID' and year='$year' and semester='$semester'";
	
	$rs = $db->query($query);
	if($rs){
		return true;
	}else{
		return false;
	}
}

function del_pool($poolID){
	$poolID = ereg_replace("_", " ", $poolID);
	list($poolname, $year, $semester) = explode("--", $poolID);
	global $db;
	
	$query = "delete from pool where id='$poolname' and year='$year' and semester='$semester'";
		
	if($db->query($query)){
		return true;
	}else{
		return false;
	}
}
	
function delExperimenter($loginName){
	global $db;
	
	$query = "delete from experimenter where loginName='$loginName'";
	
	$rs = $db->query($query);
	if($rs){
		return true;
	}else{
		return false;
	}
}

function list_credit_student_earned($target, $selectall){
	list($pool, $courseID) = explode("->", $target);
	global $db;
	
	$condition = "pool->".$pool;
	$query = "select distinct loginName from credit where pool='$pool' and course='$courseID'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$id = $rs->fields[id];
		$loginName = $rs->fields[loginName];
		$query = "select sum(credit) as totalcredit from credit where loginName='$loginName' and pool='$pool' and course='$courseID'";
		$rs1 = $db->query($query);
		$totalcredit = $rs1->fields[totalcredit];
		
		$query =" select firstName, lastName, email from subject where loginName='$loginName'";
		$rs3 = $db->query($query);
		$rs3->firstRow();
		$firstName = $rs3->fields[firstName];
		$lastName = $rs3->fields[lastName];
		$email = $rs3->fields[email];
		
	?>
		  <tr> 
                    <td width="8%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($selectall !="") echo "checked"; ?>>
                      </div>
                    </td>
                    <input type="hidden" name="creditid[<? echo $i; ?>]" value="<? echo $id; ?>">
                    <input type="hidden" name="loginNames[<? echo $i; ?>]" value="<? echo $loginName; ?>">
                    
                    <td width="15%" valign="top" class="normal"><? echo $firstName; ?></td>
                    <input type="hidden" name="firstnames[<? echo $i; ?>]" value="<? echo $firstName; ?>">
                    <td width="10%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <input type="hidden" name="lastnames[<? echo $i; ?>]" value="<? echo $lastName; ?>">
                    <td width="10%" valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <td width="15%" valign="top" class="normal"><? echo $totalcredit; ?></td>
                    <td width="42%" valign="top" class="normal">
                    <?
                    	$query = "select distinct credit, sessionid from credit where loginName='$loginName' and pool='$pool' and course='$courseID' order by id asc";
				$rs3 = $db->query($query);
				$numOfRows2 = $rs3->getNumOfRows();
				
				for($j=0; $j <$numOfRows2; $j++){
					$rs3->moveRow($j);
					$credit = $rs3->fields[credit];
					$experiementid = substr($rs3->fields[sessionid], 0, 8);
					$sessionid = substr($rs3->fields[sessionid], 8, 2);
					if($sessionid+0 <10){
						$sessionid += 0;
					}
					if($sessionid == 0){
						$sessionid ="1";
					}
					 
					echo $credit." credit(s) from Exp ID ".$experiementid." Session $sessionid<br>";
					
				}
					

			?>
                    
                    
                    </td>
                  </tr>
                  
<?
		
	}
	?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
	<?
	
return $numOfRows;

}


function list_student_attandance($target, $selectall){
	list($pool, $courseID) = explode("->", $target);
	global $db;
	
	$condition = "pool->".$pool;
	$query = "select distinct loginName from credit where pool='$pool' and course='$courseID'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$id = $rs->fields[id];
		$loginName = $rs->fields[loginName];
		$query = "select sum(credit) as totalcredit from credit where loginName='$loginName' and pool='$pool' and course='$courseID'";
		$rs1 = $db->query($query);
		$totalcredit = $rs1->fields[totalcredit];
		
		$query =" select firstName, lastName, email from subject where loginName='$loginName'";
		$rs3 = $db->query($query);
		$rs3->firstRow();
		$firstName = $rs3->fields[firstName];
		$lastName = $rs3->fields[lastName];
		$email = $rs3->fields[email];
		
	?>
		  <tr> 
                    <td width="8%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox[<? echo $i; ?>]" <? if($selectall !="") echo "checked"; ?>>
                      </div>
                    </td>
                    <input type="hidden" name="creditid[<? echo $i; ?>]" value="<? echo $id; ?>">
                    <input type="hidden" name="loginNames[<? echo $i; ?>]" value="<? echo $loginName; ?>">
                    
                    <td width="15%" valign="top" class="normal"><? echo $firstName; ?></td>
                    <input type="hidden" name="firstnames[<? echo $i; ?>]" value="<? echo $firstName; ?>">
                    <td width="10%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <input type="hidden" name="lastnames[<? echo $i; ?>]" value="<? echo $lastName; ?>">
                    <td width="10%" valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                    <td width="15%" valign="top" class="normal"><? echo $totalcredit; ?></td>
                    <td width="42%" valign="top" class="normal">
                    <?
                    	$query = "select distinct credit, sessionid from credit where loginName='$loginName' and pool='$pool' and course='$courseID' order by id asc";
				$rs3 = $db->query($query);
				$numOfRows2 = $rs3->getNumOfRows();
				
				for($j=0; $j <$numOfRows2; $j++){
					$rs3->moveRow($j);
					$credit = $rs3->fields[credit];
					$experiementid = substr($rs3->fields[sessionid], 0, 8);
					$sessionid = substr($rs3->fields[sessionid], 8, 2);
					if($sessionid+0 <10){
						$sessionid += 0;
					}
					if($sessionid == 0){
						$sessionid ="1";
					}
					 
					echo $credit." credit(s) from Exp ID ".$experiementid." Session $sessionid<br>";
					
				}
					

			?>
                    
                    
                    </td>
                  </tr>
                  
<?
		
	}
	?>
	<input type="hidden" name="total" value="<? echo $numOfRows; ?>">
	<?
	
return $numOfRows;

}



function credit_delelte($loginname, $pool, $courseID){
	global $db;
	$query = "delete from credit where loginName='$loginname' and pool='$pool' and course='$courseID'";
	$rs= $db->query($query);
	
	
}

function subject_modify_data($loginName){
	global $db;
	
	$query = "select firstName, lastName, email from subject where loginName='$loginName'";
	$rs = $db->query($query);
	
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$email = $rs->fields[email];
	
	
	$returnStr = "$firstName"."->"."$lastName"."->"."$email";
	return $returnStr;
}


function add_student($firstName, $lastName, $email, $submit, $course, $pool){
	global $db;
	
	$query = "select loginName from subject where firstName='$firstName' and  lastName='$lastName' and email='$email'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		$loginName = $rs->fields[loginName];
		if($submit = "Add"){
			
			$query = "insert into credit (loginName, course, pool) values('$loginName', '$course', '$pool')";
			
		}
		else{ 
			$query = "update credit set loginName='$loginName'  where id = $submit";
		}
		$rs1 = $db->query($query);
	}
	else{
		warning(P0033);
	}
}



function assign_credit($loginName, $id, $expid1,$sessionid1, $expid2,$sessionid2, $addcredit, $delcredit, $pool, $course){
	global $db;
	
	
	if($sessionid1 <10 ){
		$sessionid1 = "0". ($sessionid1 + 0 );
	}
	
	if($sessionid2 <10 ){
		$sessionid2 = "0". ($sessionid2 + 0 );
	}
	
	$sessionid_add = $expid1.$sessionid1;
	$sessionid_del = $expid2.$sessionid2;
		
	
	if($expid1 !="" && $addcredit !=""){
		$query = "select loginName from credit where sessionid=$sessionid_add and loginName='$loginName'";
		
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		if($numOfRows){
			$query = "update credit set credit=credit+$addcredit where sessionid=$sessionid_add and loginName='$loginName'";
		}
		else{
			$query = "insert into credit (credit, sessionid, loginName, pool, course) values ($addcredit, '$sessionid_add' ,'$loginName', '$pool', '$course')";
		}
		
		$rs = $db->query($query);
		
	}
	if($expid2 !="" && $delcredit != ""){
		$query = "select credit from credit where sessionid=$sessionid_del  and  loginName='$loginName'";
		$rs = $db->query($query);
		
		$orgcredit = $rs->fields[credit];
		
		$newcredit = $orgcredit - $delcredit;
		if($newcredit <= 0){
			$newcredit = 0;
		}
		
		$query = "update credit set credit=$newcredit where sessionid=$sessionid_del  and loginName='$loginName'";
		$rs = $db->query($query);
	
	}
	
}

	
function add_pool($poolStr){
	//$addStr = $loginName."->".$password."->".$firstName."->".$lastName."->".$email."->".$signUpCode."->".$pool."->".$year."->".$semester."->".$authcode."->".$message."->".$submit;
	$poolval = explode("->", $poolStr);
	$poolname = $poolval[0];
	$year = $poolval[1];
	$semester = $poolval[2];
	$signUpCode = $poolval[3];
	$authcode = $poolval[4];
	$message = $poolval[5];
	$submit = $poolval[6];
	$deadline = $poolval[9];
	
	
	if($submit != "Add"){
		$oldyear = $poolval[7];
		$oldsemester = $poolval[8];
		
	}
	
	
	global $db;
	
	if($submit == "Add"){
		$query = "select id from pool where id='".$poolname."' and year='".$year."' and semester='".$semester."'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		if($numOfRows){
			warning("(Message no.P1011)The Pool: $poolname $year $semester already exists.");
			return false;
		}
	
		
	}else{
		
		if($year != $oldyear || $semester != $oldsemester){
			$query = "select id from pool where id='".$poolname."' and year='".$year."' and semester='".$semester."'";
			$rs = $db->query($query);
			$numOfRows = $rs->getNumOfRows();
			if($numOfRows){
				warning("(Message no.P1012)The Pool: $poolname $year $semester already exists.");
				return false;
			}
		}
		
	}
		
	
	
	if($submit == "Add"){
		$query = "INSERT into pool (signUpCode, id , year, semester, authcode, message, deadline) values ( '$signUpCode', '$poolname', '$year', '$semester', '$authcode', '$message', $deadline )";
	}else{
		$query = "UPDATE pool set signUpCode='$signUpCode', year='$year', semester='$semester', authcode='$authcode', message='$message', deadline='$deadline' where year='$oldyear' and semester='$oldsemester'";
	}
	if($db->query($query)){
		return true;
	}else{
		return false;
	}
}
	
	


function add_pool_layout($bigpool, $pool){
	if($pool !=""){
		global $db;
		
		list($poolname, $year, $semester) = explode("--", $pool);
		
		$query = "select * from pool where id='$poolname' and year='$year' and semester='$semester'";
		$rs = $db->query($query);
		$rs->firstRow();
		$year  = $rs->fields[year];
		$semester  = $rs->fields[semester];
		$message = $rs->fields[message];
		$signUpCode = $rs->fields[signUpCode]; 
		$authcode = $rs->fields[authcode]; 
		$deadline = $rs->fields[deadline]; 
	}
	
	
	?>


              <form name="form1" method="post" action="Check_Pool.php" >

                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Pool Name :</td>
                    <td width="56%" bgcolor="ffffcc">
                      
                      
                      <?
                      echo $bigpool;
                      
                      
                      
                      ?>	
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Year :</td>
                    <td width="56%">
                      <select name="year">
                      <? 
                      if(isset($year))
                       echo "<option selected value=\"$year\">$year</option>";
                       for($i=2000; $i<2051; $i++){
                      		echo "<option value=\"$i\">$i</option>\n\t\t\t";
                      	}
                      ?>
                      </select>
                      <?
                      if(isset($poolname)){
                      		echo "<input type=\"hidden\" name=\"oldyear\"  value=\"$year\">\n";
                      }
                      ?>	
                    </td>
                  </tr>
                  <tr bgcolor="ffffcc"> 
                    <td width="44%" class="normal">Semester :</td>
                    <td width="56%">
                      <select name="semester">
                       <? if(isset($semester) )
                       echo "<option selected value=\"$semester\">$semester</option>";
                       ?>
                        <option value="SPRING">SPRING</option>
                        <option value="SUMMER">SUMMER</option>
                        <option value="FALL">FALL</option>
                        <option value="WINTER">WINTER</option>
                      </select>
                      <?
                      if(isset($poolname)){
                      		echo "<input type=\"hidden\" name=\"oldsemester\"  value=\"$semester\">\n";
                      }
                      ?>	
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" >Pool Sign-up Code(8 characters) :</td>
                    <td width="56%" > 
                      <input type="text" name="signUpCode" value="<?
                      if(!isset($signUpCode)){
                    	$md5str = MD5( TIME() );
                      	$signUpCode = substr($md5str, 0, 8);
                      	}
                      	echo $signUpCode; 
                      	?>" maxlength="8">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Pool Authorization Code(5 digits) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="authcode" value="<?
                      if(!isset($authcode)){
                    	$randstr = rand(1, 100000)+10000;
                      	$authcode = substr($randstr, 0, 5);
                	}
                
                      	echo $authcode; 
                      	?>" maxlength="5">
                    </td>
                  </tr>
                  <tr> 
                  <tr> 
                    <td width="44%" class="normal">Deadline for Experimenter to submit Attendance and Credit Information :</td>
                    <td width="56%">
                      <select name="deadlinedays">
                      <? 
                      if(isset($deadline))
                       echo "<option selected value=\"$deadline\">$deadline</option>";
                       for($i=1; $i<100; $i++){
                      		echo "<option value=\"$i\">$i</option>\n\t\t\t";
                      	}
                      ?>
                      </select>
                      
                    day(s) after the Session is Ended</td>
                  </tr>
                  
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Pool Message :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                    <textarea name="message" cols="40" rows="5"><? if(isset($message)) echo $message; ?></textarea>  
                    </td>
                  </tr>
                  
              
                  <tr> 
                    <td width="44%" class="tablerow">
                    </td>
                    <td width="56%"> 
                      <div align="right"> 
                        <?
                        	if($poolname!=""){
                        		$action = "submit";
                        		$actionvalue="Modify";
                        	}else{
                        		$action = "submit";
                        		$actionvalue="Add";
                        	}
                        	
                        	
                        
                       echo " <input type=\"submit\" name=\"$action\" value=\"$actionvalue\">";
                       ?>
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>

                </form>
                
       <?
}


function sendmail($person){
	
	global $total;
	global $checkbox;
	global $emails;
	global $PHP_SELF;
	global $cc;
	global $subject;
	global $message;
	
	global $db;
	
	global $pool;
	list($poolname, $year, $semester) = explode("--", $pool);
	
	$query="select	email from poolCoordinator where pool='$poolname'";
	$rs= $db->query($query);
	$rs->firstRow();
	
	$poolmail = $rs->fields[email];   
	
	$k=0;
	for($j=0; $j<$total; $j++){
		if($checkbox[$j] == "on"){
			$k++;
		}
	}
	if($k == 0 ){
		warning("(Message no.P1013)Please select $person"."(s) whom you want to send the message to.");
			exit;
	}
	if(isset($total) && $total >= 0 ){
		
		// check for invalid cc mail and send mail
		$cc = ereg_replace(" ", "", $cc);
		$ccmail = explode(",", $cc);
				
		for($l = 0; $l< sizeof($ccmail); $l++){
			if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $ccmail[$l]) && trim($ccmail[$l]) !="") {
  				warning(P0012);
			}
			if(trim($ccmail[$l]) !=""){
				poolMail("$ccmail[$l]", "$subject", "$message", $poolmail);
			}
		}

		// now send mail to the selected person
		for($i=0; $i<$total; $i++){
			if($checkbox[$i] == "on"){
				$email = $emails[$i];
				
				poolMail("$email", "$subject", "$message", $poolmail);
			
			}
		
		}
		$link = $PHP_SELF;
		message(P0019, $link);
		exit();
	}
	else{
		warning("(Message no.P1014)Please select $person"."(s) whom you want to send the message to.");
		exit();
	}
	

}

function mail_form($to){
	global $db;
	global $PHP_SELF;
	global $pool;
	list($poolname, $year, $semester) = explode("--", $pool);
	
	$query="select	firstName, lastName from poolCoordinator where pool='$poolname'";
	$rs= $db->query($query);
	$rs->firstRow();
	
	$firstName = $rs->fields[firstName];   
	$lastName = $rs->fields[lastName];

	$name = "$lastName, $firstName";
?>
                <table width="100%" cellpadding="3" bordercolor="#CCCCCC" border="0" cellspacing="0">
                  
                  
                  <tr bgcolor="ffffcc">
                    <td colspan="2" class="normal">To send an email to the <? echo $to; ?>(s),
                      click the select boxes then click &quot;Send Mail&quot;.</td>
                  </tr>
                  <tr>
                    <td width="13%" class="tablerow">From :</td>
                    <td width="87%"><? echo $name;?>
                    </td>
                  </tr>
                  <tr>
                    <td width="13%" class="tablerow">Subject :</td>
                    <td width="87%">
                      <input type="text" name="subject" value="">
                    </td>
                  </tr>
                  <tr>
                    <td width="13%" class="tablerow">cc:</td>
                    <td width="87%">
                      <input type="text" name="cc" value="">
                    </td>
                  </tr>
                  <tr>
                    <td width="13%" class="tablerow">Message:</td>
                    <td width="87%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <textarea name="message" rows="3" cols="70" value=""></textarea>
                      <input type="submit" name="sendmail" value="Send Mail">
                    </td>
                  </tr>
                </table>
<?
}


// function to check whether the experiment is undet the pool or not
function isPoolExp($pool, $expid){
	global $db;
	$query = "select * from experiment where target='pool->$pool' and id=$expid";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		return true;
	}
	return false;
}

?>