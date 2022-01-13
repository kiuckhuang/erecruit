<?
//$erecruit_datadir = "/ultra/home/mk/recruit/web_html/fun";
include("../fun/config.inc");
include("../fun/mysql.inc");

include("../fun/mail.inc");
include("../fun/subject_mail.inc");
include("../fun/search.inc");
include("../fun/errmsg.inc");
include("../fun/common.inc");
include("../fun/blocking.inc");
include("../fun/timing.inc");
include("../fun/prerequisite.inc");

//TIMEFORMAT: time format: "g:i a"
//DATEFORMAT: date format: "d M Y"
//WITH DEFINE IN CONFIG.INC

function is_ust(){
    	global $isust;
	$temp = split("-", $isust);
	$isnon = $temp[0];
	if ( $isnon == "is" ){
		return true;	
	}else { 
		return false;
	}
}
    
function UST_Login($subjectprofile) {
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
	
	//$query = "SELECT hkust FROM subject WHERE loginName = '$loginName'";
	//$rs = $db->query($query);
	//$hkust = $rs->fields[hkust];
	
	$rs->close();		
	$db->close();
	

    // NYU no need to check this
	//if(($hkust == $mail) && $numOfRows){
	//        $result = true;
	//}
   	if($numOfRows){
	        $result = true;
	}

    
	return $result;
}
    
function is_vaild_account($loginName){
    $db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT password FROM subject WHERE loginName = '$loginName'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		return true;
	}else{
		return false;
	}
	$rs->close();		
	$db->close();
     }
    
    //check input email is exit in our subject table
    //return true: exiting email
function is_exist_email($email){
    $db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT email FROM subject WHERE email = '$email'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		return true;
	}else{
		return false;
	}
	$rs->close();		
	$db->close();
}
    
//check input stuID is exit in our subject table
//return true: exiting stuID
function is_exist_stuID($stuID){
    	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT stuID FROM subject WHERE stuID = '$stuID'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows){
		return true;
	}else{
		return false;
	}
	$rs->close();		
	$db->close();
    }
    function is_UST_account($subjectprofile) {
	//$CRYPT_STD_DES = 1;	// Standard DES Encryption
	$LOGIN = split("-", $subjectprofile);
	$loginName = $LOGIN[0]; $password = $LOGIN[1];
	//global $PHP_AUTH_USER;
	//global $mail;
	
	$result = false;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT password FROM subject WHERE loginName = '$loginName'";
	$rs = $db->query($query);
	$cryptpassword = $rs->fields[password];
	$password = crypt($password, substr("$cryptpassword", 0, 2));
	
	$query = "SELECT loginName, hkust FROM subject WHERE loginName = '$loginName' and password = '$password'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	$query = "SELECT hkust FROM subject WHERE loginName = '$loginName'";
	$hkust = $rs->fields[hkust];
	$rs = $db->query($query);
		
	$rs->close();		
	$db->close();
	if(($hkust != '0') && ($numOfRows == 1)){
	        $result = true;
	}
	return $result;
}
    
function isLogin($subjectprofile) {
	//$CRYPT_STD_DES = 1;	// Standard DES Encryption
	$LOGIN = split("-", $subjectprofile);
	$loginName = $LOGIN[0]; $password = $LOGIN[1];
	
	$result = false;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT password FROM subject WHERE loginName = '$loginName'";
	$rs = $db->query($query);
	$cryptpassword = $rs->fields[password];
	//echo $cryptpassword;
	
	$password = crypt($password, substr("$cryptpassword", 0, 2));
	
	$query = "SELECT sid FROM subject WHERE loginName = '$loginName' and password = '$password'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	$rs->close();		
	$db->close();
	
	
	if($password == $cryptpassword){
	        $result = true;
	}
	return $result;
    }
    
function is_nonust_Login($subjectprofile) {
	//$CRYPT_STD_DES = 1;	// Standard DES Encryption
	$LOGIN = split("-", $subjectprofile);
	$loginName = $LOGIN[0]; $password = $LOGIN[1];
	//global $PHP_AUTH_USER;
	//global $mail;
	
	$result = false;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT password FROM subject WHERE loginName = '$loginName'";
	$rs = $db->query($query);
	$cryptpassword = $rs->fields[password];
	$password = crypt($password, substr("$cryptpassword", 0, 2));
	
	$query = "SELECT loginName, hkust FROM subject WHERE loginName = '$loginName' and password = '$password'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	$query = "SELECT hkust FROM subject WHERE loginName = '$loginName'";
	$rs = $db->query($query);
		
	$rs->close();		
	$db->close();
	
	if(($hkust == 0) && ($numOfRows == 1)){
	        $result = true;
	}
	return $result;
}    
    
function is_member($loginName,$password){
    	global $subjectprofile;	
	$subjectprofile = "$loginName-$password";
	setcookie ( "subjectprofile", $subjectprofile, time()+3600);
	if (is_ust())
	{
		if (UST_Login($subjectprofile))
		{	
			$cookie_val = $subjectprofile;
			setcookie( "subjectprofile", $cookie_val, time()+3600);
			return true;
		}else{
			warningx(W0029);
			return false;
		}
	}else{
		if(isLogin($subjectprofile))
		{	
			return true;
		}else{
			warning("$subjectprofile");
			return false;
		}
	}
}
    
function is_correct_passwd($subjectprofile) {
	//$CRYPT_STD_DES = 1;	// Standard DES Encryption
	$LOGIN = split("-", $subjectprofile);
	$loginName = $LOGIN[0]; $password = $LOGIN[1];
	//global $PHP_AUTH_USER;
	//global $mail;
	
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
	
	$rs->close();		
	$db->close();
	
	if($numOfRows == 1){
	        $result = true;
	}
	return $result;
}    

//used by Create_Account.php
function is_doubleloginName($loginName){
              	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "SELECT loginName FROM subject where loginName='$loginName'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		$rs->close();		
		$db->close();	/*	optional	*/
		if ($numOfRows)
		return true;
		else{
		return false;
		}
}

//used by Create_Account.php
function is_doubleemailfornonust($email){
              	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "SELECT email FROM subject where email='$email'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		$rs->close();		
		$db->close();	/*	optional	*/
		if ($numOfRows)
		return true;
		else{
		return false;
		}
}

//used by Create_Account.php
function is_doublestuID($stuID){
              	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "SELECT loginName FROM subject where stuID = '$stuID'";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		$rs->close();		
		$db->close();	/*	optional	*/
		if ($numOfRows)
		return true;
		else{
		return false;
		}
}

//used by Create_Account.php
function is_checkbit_setted($mail,$stuID){
              	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "SELECT DISTINCT stuID FROM subject where hkust = '$mail' and checkbit > 0";// and stuID='$stuID'
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		$rs->close();		
		$db->close();	/*	optional	*/
		if ($numOfRows)
		return true;
		else{
		return false;
		}
}

//using email to return loginName
function return_loginName($email){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT loginName FROM subject where email = '$email'";// and stuID='$stuID'
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	$loginName = $rs->fields[loginName];
	$rs->close();		
	$db->close();	/*	optional	*/
	if ($numOfRows == 1)
	return $loginName;
	else if ($numOfRows == 0)
	return "error_no_logiName";
	else return "error";
}
	
function foot_menu(){
	?>
	      <table width="524" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td class="normal"> 
                    <div align="center">| <a href="../index.php">Home</a> | <a href="upcomingexp.php">Upcoming Experiments</a> | <a href="pastexp.php">Past Experiments</a>
                      | <a href="view_signup.php">My Experiments</a>|</div>
                  </td>
                </tr>
                <tr> 
                  <td class="normal"> 
                    <div align="center">| <a href="ChangePersonalInformation.php">Change Personal Information</a> 
                      | <a href="ChangePassword.php">Change Password</a>  | <a href="search.php">Search</a> | <a href="logout.php">Logout</a> 
                      |</div>
                  </td>
                </tr>
              </table>
              
<?
}

//show all course in the select
function show_all_course(){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	
	$query="select distinct courseID,semester,year from course where enable='y' order by courseID ASC";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i< $numOfRows; $i++){ //$numOfRows
		$rs->moveRow($i);
		$course= $rs->fields[courseID];
		$semester= $rs->fields[semester];
		$year= $rs->fields[year];
		
		//Modified by Kiu at 15/8/2000 8:25pm
		//change the position of $semester and $year
		//$show = $course." ".$semester." ".$year;
		//$coursename = $course."--".$semester."--".$year;
		$passcourse = ereg_replace(" ","__",$course);
		$show = $course." ".$year." ".$semester;
		$coursename = $passcourse."--".$year."--".$semester;
		echo "<option value=\"$coursename\">$show</option>\n";
	}
	$rs->close();		
	$db->close();	/*	optional	*/
}

//show all upcoming course in the select
function show_all_course_upcoming(){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$now = getdate(time());
	//echo $now[mon];
	if ( $now[mon] < DAYTWO_MONTH ) {
		$query="select distinct courseID,semester,year from course where (semester = 'FALL' and year = '$now[year]-1') or (semester = 'SPRING' and year = '$now[year]') and enable='y' order by courseID ASC";
	}else {
		$query="select distinct courseID,semester,year from course where (semester = 'FALL' and year = '$now[year]') or (semester = 'SPRING' and year = '$now[year]') and enable='y' order by courseID ASC";
	}
	//$query="select distinct courseID,semester,year from course where (semester = 'FALL' and year = '$now[year]') or (semester = 'SPRING' and year = '$now[year]+1') enable='y' order by courseID ASC";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i< $numOfRows; $i++){ //$numOfRows
		$rs->moveRow($i);
		$course= $rs->fields[courseID];
		$semester= $rs->fields[semester];
		$year= $rs->fields[year];
		
		//Modified by Kiu at 15/8/2000 8:25pm
		//change the position of $semester and $year
		//$show = $course." ".$semester." ".$year;
		//$coursename = $course."--".$semester."--".$year;
		$passcourse = ereg_replace(" ","__",$course);
		$show = $course." ".$year." ".$semester;
		$coursename = $passcourse."--".$year."--".$semester;
		echo "<option value=\"$coursename\">$show</option>\n";
	}
	$rs->close();		
	$db->close();	/*	optional	*/
}

//show all experimenters which are main experimenters
function Select_experimenters(){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	
	$query="select loginName, firstName, lastName from experimenter order by loginName ASC";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	echo "<option value=\"-1\">--choose one--</option>\n";
	for($i=0; $i< $numOfRows; $i++){ //$numOfRows
		$rs->moveRow($i);
		$loginName= $rs->fields[loginName];
		$firstName= $rs->fields[firstName];
		$lastName= $rs->fields[lastName];
		$show = $firstName." ".$lastName;
		$experimenters = "$loginName";
		echo "<option value=\"$experimenters\">$show</option>\n";
	}
	$rs->close();		
	$db->close();	/*	optional	*/
}

//function used by Select_allexperimenters()
//add experimenters string to ary_list
function addtolist($old_list,$instring,$arg){
	if($arg == "a")
		if(split(", ",$instring)) $ary_temp = split(", ",$instring); else $ary_temp[0] = $instring;
	else
		if(split("->",$instring)) $ary_temp = split("->",$instring); else $ary_temp[0] = $instring;
	$return_list = $old_list;

	for($x=0; $x< count($old_list); $x++){ /*echo $old_list[$x].">";*/ }

	for($y=0; $y< count($ary_temp); $y++){ /*echo $ary_temp[$y]." | ";*/ }
	for($j=0; $j< count($ary_temp); $j++){
		$counter = 0;
		for($i=0; $i< count($old_list); $i++){
			if(strcmp($old_list[$i],$ary_temp[$j]) != 0){
				$counter++;
			}else{ break; }				
		}
		$temp_count = count($return_list);
		if ($counter == count($old_list)){ $return_list[$temp_count] = $ary_temp[$j]; /*echo "**".$temp_count."**";*/}//echo $temp_count.".".$return_list[$temp_count].", ".$ary_temp[$j].":--:";}
	}
	
	return $return_list;
}


//show all experimenters which are all experimenters in experiment
function Select_allexperimenters(){
	$db = new phpDB();
	$ary_source;
	$ary_list;
	$ary_tmp;
	$tmp_string;
	$db->pconnect() or die ("Can't connect to database server or select database");
	
	$query="select experimenters from experiment where experimenters not like '' order by id ASC";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	echo "<option value=\"-1\">--choose one--</option>\n";
	
	//input all experimenters into source
	for($i=0; $i< $numOfRows; $i++){
		$rs->moveRow($i);
		$ary_source[$i] = experimentersstr($rs->fields[experimenters]);
	}
	
	$i=0;
	$tmp_string = $ary_source[0];
	$ary_tmp = split(", ",$tmp_string);
	for($j=0; $j< count($ary_tmp); $j++){
		$ary_list[$j] = $ary_tmp[$j];
	}
	
	for($i=1; $i< $numOfRows; $i++){
		$ary_list = addtolist($ary_list,$ary_source[$i],"a");
	}
	sort($ary_list);
	echo "<option value=\"%\">All experimenters</option>\n";
	for($i=1; $i< count($ary_list); $i++){
		echo "<option value=\"$ary_list[$i]\">$ary_list[$i]</option>\n";
	}
	$rs->close();		
	$db->close();	/*	optional	*/
}

function show_all_pool(){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	
	$query="select id from pool order by id ASC";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$pool = $rs->fields[id];
				
		if(!strstr($poolStr, $pool)){
			$poolStr .= "$pool"."->";
			echo "<option value=\"$pool\">$pool</option>\n";
                }
        }
        
	$rs->close();		
	$db->close();	/*	optional	*/
}

function show_all_pool_course($pool_course){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	
	$query="select courseID, semester, year from course where pool ='$pool_course' and enable ='y' order by courseID ASC";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	echo $numOfRows;
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$courseID = $rs->fields[courseID];
		$semester = $rs->fields[semester];
		$year = $rs->fields[year];
		$pool = $courseID."--".$year."--".$semester;
		$show_pool = $courseID." ".$year." ".$semester;
		
		echo "<option value=\"$pool\">$show_pool</option>";
		
        }
        
	$rs->close();		
	$db->close();	/*	optional	*/
}


function list_all_open_exp($is_enable,$page,$order){
	global $choose_exp,$postcourse;
	global $PHP_SELF;
	
	if ( $order == "experimenters" ){
		$order = "experimenters";
	}
	elseif ( $order == "title" ) {
		$order = "title";
	}
	elseif ( $order == "dateCreated") {
		$order = "dateCreated";
	}else{
		$order = "id";
	}
	
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	if ( $is_enable == 'y'){
		if($order == "dateCreated" || $order == "id"){
			$query="select e.id, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target = 'open' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate >= now() && e.enable = '$is_enable' group by e.id order by '$order' DESC";
		}else{
			$query="select e.id, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target = 'open' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate >= now() && e.enable = '$is_enable' group by e.id order by '$order' ASC";
		}
	} else {
		if($order == "dateCreated" || $order == "id"){
			$query="select e.id, count(s.id) as total, e.sessions, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category, e.enable from experiment e, session s where target = 'open' and e.id = substring(s.id,1,length(s.id)-2) and s.enddate < now() group by e.id having total = e.sessions and e.enable = 'y' order by '$order' DESC";
		}else{
			$query="select e.id, count(s.id) as total, e.sessions, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category, e.enable from experiment e, session s where target = 'open' and e.id = substring(s.id,1,length(s.id)-2) and s.enddate < now() group by e.id having total = e.sessions and e.enable = 'y' order by '$order' ASC";
		}
	}
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	$total_no = $numOfRows;
	$total_pages = ceil($total_no/ITEMINPAGE);
	if ( !isset($page) ){
		$page = 1;
	}	
	
	if ( $numOfRows == 0 ){
	?>
	<table border="0" cellspacing="0" cellpadding="3" width="100%">
	<tr>
	<td width="26%" class="normal" bgcolor="ffffcc">No experiments available.</td>	
	</tr>
	</table>
	<?
	$rs->close();		
	$db->close();	/*	optional	*/
	return 0;
	}
if(DEBUG_SHOWSQL){?>	
	<table border="0" cellspacing="0" cellpadding="3" width="100%">
	<tr>
	<td width="26%" class="normal" bgcolor="ffffcc"><? echo "query = $query and show_test = $show_test";?></td>	
	</tr>
	</table>
<?}
	show_page($total_pages, $page, $order, $choose_exp, $postcourse);
	for($i=(ITEMINPAGE*($page-1)+1); (($i <=(ITEMINPAGE*$page)) && ($i <=($total_no))); $i++){
		$moveto	= $i - 1;
		$rs->moveRow($moveto);
		$id = $rs->fields[id];
		$title = $rs->fields[title];
		$description = $rs->fields[description];
		$experimenters = $rs->fields[experimenters];
		$dateCreated = $rs->fields[dateCreated];
		
		$query = "select sessions from experiment where id = '$id'";
        
	        $rs1 = $db->query($query);
	        $rs1->firstRow();
	        $expsessionno = $rs1->fields[sessions];
        
		$query = "select count(id) as total from session where id like '$id%'";
        
       		$rs2 = $db->query($query);
	        $rs2->firstRow();
        	$total = $rs2->fields[total];
                
	        if($total == $expsessionno || SHOWREADYEXPONLY){//it can be config in config.inc
	        	
		$experimenters = experimentersstr($experimenters);
		$dateCreatedshow = date("j M,Y",$dateCreated);
		if( $description == " " ) { $description = "no description" ;}
		if( $description == "" ) { $description = "no description" ;}
		if( $title == " " ) { $title = "no title" ;}
		if( $title == "" ) { $title = "no title" ;}
		
				//Determine the bg color
		if (is_int($i/2)){
			$bgcolor = "ffffcc";
		}else{
			$bgcolor = "EBEBEB";
		}
		
?>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td height="39" class="normal" colspan="2">
                      <table width="752" border="0" cellpadding="3" bgcolor="<? echo $bgcolor; ?>" cellspacing="0" align="right">
                        <tr> 
                          <td width="150" class="normal" valign="top">Experiment 
                            Title : </td>
                          <? if ($total == $expsessionno && isset($total) && isset($expsessionno) && $total != 0 && $expsessionno != 0){?>
                          <td width="602" class="normal" valign="top"><i><a href="expdetails_exptitle.php?id=<? echo $id; ?>"><? echo $title; ?></a></i></td>
                          <? }else{?>
                          <td width="602" class="normal" valign="top"><i><? echo $title; ?></i></td>
                          <? }?>
                         </tr>
                         <tr>
                          <td width="150" class="normal" valign="top" valign="top" >Experiment ID: 
                          </td>
                          <td width="602" class="normal" valign="top"><i><? echo $id; ?></i></td>
                        </tr>
                         <tr>
                          <td width="150" class="normal" valign="top" valign="top" >Experimenter(s) : 
                          </td>
                          <td width="602" class="normal" valign="top"><i><? echo $experimenters; ?></i></td>
                        </tr>
                        <tr> 
                          <td width="150" class="normal" valign="top" height="19" valign="top">Description 
                            :</td>
                          <td width="602" class="normal" height="19" valign="top"> <i><? echo $description; ?></i></td>
                        </tr>
                        <tr> 
                          <td width="150" class="normal" valign="top">Last Modified : 
                          </td>
                          <td width="602" class="normal" height="19" valign="top"> <i><? echo $dateCreatedshow; ?></i></td>
                          
                        </tr>                              
                  	<tr>
                    	  <td width="752" class="normal" colspan="2">
                      		<table width="100%" border="0" cellpadding="3" bgcolor="<? echo $bgcolor; ?>" cellspacing="0" align="right">
                      		<tr><td>
                        	<div align="center" >
                        	<textarea name="textfield" cols="<? echo TEXTFIELDWIDTH;?>" rows="5" wrap="OFF">
<? 
   if($total == $expsessionno && isset($total) && isset($expsessionno) && $total != 0 && $expsessionno != 0){
   //$show_sessions = str_sessions($id,$expsessionno);
   //echo $show_sessions;
   $query_session = "select title, reward, UNIX_TIMESTAMP(fromdate) AS fromdate, durationEnd, venue, quota, enrolled, UNIX_TIMESTAMP(dateCreated) as dateCreated from session where id like '$id%' ";
   $rs_sessions = $db->query($query_session);
   $session_numOfRows = $rs_sessions->getNumOfRows();
   for ($k=1; $k<= $session_numOfRows; $k++){
   	 $gotosessionrow = $k - 1;
   	 $rs_sessions->moveRow($gotosessionrow);
   	 $title = $rs_sessions->fields[title];
	 $reward = $rs_sessions->fields[reward];
	 $fromdate = $rs_sessions->fields[fromdate];
	 $venue = $rs_sessions->fields[venue];
	 $quota = $rs_sessions->fields[quota];
	 $enrolled = $rs_sessions->fields[enrolled];
	 
	 if(strlen($title) >= 20 ){
	 $show_title = substr($title,0,20);
	 $show_title = $show_title."...          ";
 	 }else{
	 $show_title = $title;
	 $show_title = $title."             ";
 	 }
	 $show_vacancy = $quota - $enrolled;
	 $show_date = date(DATEFORMAT,$fromdate);
	 $show_date = $show_date."           ";
	 $show_time = date(TIMEFORMAT,$fromdate);
			 
?>
Sessions Title: <? echo $show_title;?>Vacancy:    <? echo $show_vacancy;?> 
Start Date:     <? echo $show_date;?>Start Time: <? echo $show_time;?><? echo "\n";?>
<?
/* 
<!--
Sessions Title: Session 2: Just for ......          Vacancy: 20 
Start Date:     10 May 2000                          Start Time: 8:00am
Sessions Title: Session 3: a short title..          Vacancy: 30 
Start Date:     11 May 2000                          Start Time: 7:00pm
Sessions Title: Session 4: a long title...          Vacancy: 40 
Start Date:     12 May 2000                          Start Time: 11:00am
Sessions Title: Session 5: a long title...          Vacancy: 11 
Start Date:     13 May 2000                          Start Time: 10:30pm
Sessions Title: Session 6: a long title...          Vacancy: 15 
Start Date:     14 May 2000                          Start Time: 1:00pm
-->
*/
?>
<? }?>
<? $rs_sessions->close();?>
<? }else{?>
This experiment is not ready for you to sign up.
<? }?>
                        </textarea>
                        </div>
                        </td></tr>
                      </table>
                    </td>
                  </tr>
                  </table>
                 </td>
               </tr>
             </table>
                   
<? 
		}
		$rs1->close();
		$rs2->close();


	}
	?>
	<? show_page($total_pages, $page, $order, $choose_exp, $postcourse); ?>
    <p><?
	$rs->close();		
	$db->close();	/*	optional	*/
}

function show_page($total_pages, $page, $order, $choose_exp, $postcourse){
	global $PHP_SELF;
?>
<table border="0" cellspacing="3" cellpadding="0" width="100%">
	<tr><td class="normal" bgcolor="ffffcc"><? if($total_pages != 1 ){?>Pages:   <? }?><?
	if($total_pages != 1 ){
        for ($k=1;$k<= $total_pages;$k++){
        	if ( $page != $k ){
        	?>
        	| <a href="<? echo basename($PHP_SELF).'?order='."$order".'&page='.$k.'&choose_exp='.$choose_exp.'&postcourse='.$postcourse; ?>"><? echo $k;?></a>
        	<?
        	}else{
        	?>
        	| <? echo $k;?>
        	<?
        	}
        }
        echo "|";
        }
        ?></td></tr></table>

<?	
}

//input the course_name (eg. Econ 214 L1--SPRING--2000) to find it belone to which pool 
//return either 0 or pool--COMP--2000--SPRING 
function find_pool_name($course_name){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$courseName = split("--",$course_name);
	$courseID = $courseName[0];
	$year = $courseName[1];
	$semester = $courseName[2];
	$query = "select pool from course where courseID like '$courseID' and semester like '$semester' and year like '$year' and pool <> ''";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	$returnpoolstr = $rs->fields[pool];
		
	if($numOfRows == 0){
		$rs->close();		
		$db->close();	/*	optional	*/
		return "Nothing to be found";
	}else{
		$rs->close();		
		$db->close();	/*	optional	*/
		return $returnpoolstr;
	}
}


//input the course_name (eg. Econ 214 L1 SPRING 2000) to find it have course_exp or pool_exp
//or it have both course_exp and pool_exp
//this function will return a string
//"Belong_to_Pool": stand for it belone to the pool only
//"Belong_to_Course": stand for it belone to the course only
//"Belong_to_Both": stand for it belone to the pool and the course both
//"Belong_to_non": stand for the system can find this course_name 
//"Error":	stand for the error
function belongto_exptype($course_name){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$courseName = split("--",$course_name);
	$courseID = $courseName[0];
	$year = $courseName[1];
	$semester = $courseName[2];
	$query = "select signUpCode, pool from course where courseID like '$courseID' and semester like '$semester' and year like '$year'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	$signUpCode = $rs->fields[signUpCode];
	$pool = $rs->fields[pool];
	
	if($numOfRows == 1){
		if($signUpCode == "" && $pool != ""){ return "Belong_to_Pool"; 
		}elseif($signUpCode != "" && $pool == ""){ return "Belong_to_Course"; 
		}else{
			$rs->close();		
			$db->close();
			return "Error";
		}
	}elseif($numOfRows == 2){
		$rs->close();		
		$db->close();
		return "Belong_to_Both";
	}else{
		$rs->close();		
		$db->close();
		return "Error";
	}
}


function list_all_exp_from($arg1,$what,$is_enable,$page,$order){
	global $choose_exp,$postcourse;
	global $PHP_SELF;
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	
	if ( $order == "experimenters" ){
		$order = "experimenters";
	}
	elseif ( $order == "title" ) {
		$order = "title";
	}
	elseif ( $order == "dateCreated") {
		$order = "dateCreated";
	}else{
		$order = "id";
	}
	//new query to choose upcomingexp: select e.id, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like 'open' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate >= now() group by e.id order by dateCreated DESC	
	if( $is_enable == 'y' ){
		if ( $what == "course" ) {                                                                                                                                                                                                                                                                                                                                            
	        	$course = "course->".$arg1;                                                                                                                                                                                                                                                                                                                                   
	        	if($order == "dateCreated" || $order == "id"){                                                                                                                                                                                                                                                                                                                                  
	        		$query="select e.id, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like '%$course%' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate >= now() && e.enable = '$is_enable' group by e.id order by dateCreated DESC";
	        	}else{                                                                                                                                                                                                                                                                                                                                                        
	        		$query="select e.id, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like '%$course%' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate >= now() && e.enable = '$is_enable' group by e.id order by '$order' ASC";    
	        	}                                                                                                                                                                                                                                                                                                                                                             
	        }                                                                                                                                                                                                                                                                                                                                                                     
	        elseif ( $what == "pool" ) {                                                                                                                                                                                                                                                                                                                                          
	        	$pool = "pool->".$arg1;                                                                                                                                                                                                                                                                                                                                       
	        	if($order == "dateCreated" || $order == "id"){
	        		$query="select e.id, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like '$pool' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate >= now() && e.enable = '$is_enable' group by e.id order by dateCreated DESC";
	        	}else{                                                                                                                                                                                                                                                                                                                                                        
	        		$query="select e.id, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like '$pool' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate >= now() && e.enable = '$is_enable' group by e.id order by '$order' ASC";
	        	}                                                                                                                                                                                                                                                                                                                                                             
	
		}
	}else {
		if ( $what == "course" ) {                                                                                                                                                                                                                                                                                                                                            
	        	$course = "course->".$arg1;                                                                                                                                                                                                                                                                                                                                   
	        	if($order == "dateCreated" || $order == "id"){
	        		$query="select e.id, count(s.id) as total, e.sessions, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like '%$course%' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate < now() && e.enable = 'y' group by e.id having total = e.sessions order by '$order' DESC";
	        	}else{                                                                                                                                                                                                                                                                                                                                                        
	        		$query="select e.id, count(s.id) as total, e.sessions, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like '%$course%' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate < now() && e.enable = 'y' group by e.id having total = e.sessions order by '$order' ASC";
	        	}
	        }       
	        elseif ( $what == "pool" ) {
	        	$pool = "pool->".$arg1;
	        	if($order == "dateCreated" || $order == "id"){
	        		$query="select e.id, count(s.id) as total, e.sessions, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like '$pool' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate < now() && e.enable = 'y' group by e.id having total = e.sessions order by '$order' DESC";
	        	}else{                                                                                                                                                                                                                                                                                                                                                        
	        		$query="select e.id, count(s.id) as total, e.sessions, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where target like '$pool' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate < now() && e.enable = 'y' group by e.id having total = e.sessions order by '$order' ASC";
	        	}                                                                                                                                                                                                                                                                                                                                                             
	
		}
	}
	
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	$total_no = $numOfRows;
	$total_pages = ceil($total_no/ITEMINPAGE);
	if ( !isset($page) ){
		$page = 1;
	}
	if ( $numOfRows == 0 ){
		$returnmsg ="<tr ><td colspan=\"4\" width=\"26%\" class=\"normal\" bgcolor=\"ffffcc\"><blockquote>No experiment is available for this course now.</blockquote></td></tr>";
	$rs->close();		
	$db->close();	/*	optional	*/
	return $returnmsg;
	}
	?>
	<table border="0" cellspacing="0" cellpadding="3" width="100%" bgcolor="ffffcc">
	<? if( $what == "course" ){?>
	<tr>
	<td width="26%" class="normal" bgcolor="ffffcc"><!--Course -->Experiment(s) that are now available for this course.</td>	
	</tr>
	<? }elseif( $what == "pool" ){?>
	<tr>
	<td width="26%" class="normal" bgcolor="ffffcc"><!--Pool -->Experiment(s) that are now available for this course.</td>	
	</tr>
	<? }else{?>
	<tr>
	<td width="26%" class="normal" bgcolor="ffffcc">Experiment(s) are available for this course now.</td>	
	</tr>
	<? }?>
	</table>
<?
	for($i=(ITEMINPAGE*($page-1)+1); (($i <=(ITEMINPAGE*$page)) && ($i <=($total_no))); $i++){
		$goto = $i - 1;
		$rs->moveRow($goto);
		$id = $rs->fields[id];
		$title = $rs->fields[title];
		$description = $rs->fields[description];
		$experimenters = $rs->fields[experimenters];
		$dateCreated = $rs->fields[dateCreated];
		$showdate = date("j M,Y",$dateCreated);
		
		$query = "select sessions from experiment where id = '$id'";
        
	        $rs1 = $db->query($query);
	        $rs1->firstRow();
	        $expsessionno = $rs1->fields[sessions];
        
		$query = "select count(id) as total from session where id like '$id%'";
        
       		$rs2 = $db->query($query);
	        $rs2->firstRow();
        	$total = $rs2->fields[total];
                
	        if(ALL_SESSION_READY? $total == $expsessionno : TRUE ){	
	        		
		if ($description == "" ){ $description = " ";}
		if ($title == "" ){ $title = " ";}
		$experimenters = experimentersstr($experimenters);
		if( $description == " " ) { $description = "no description" ;}
		if( $description == "" ) { $description = "no description" ;}
		if( $title == " " ) { $title = "no title" ;}
		if( $title== "" ) { $title = "no title" ;}
		
		//Determine the bg color
		if (is_int($i/2)){
			$bgcolor = "ffffcc";
		}else{
			$bgcolor = "EBEBEB";
		}
?>
		<? show_page($total_pages, $page, $order, $choose_exp, $postcourse); ?>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td height="39" class="normal">
                      <table width="752" border="0" cellpadding="3" bgcolor="<? echo $bgcolor; ?>" cellspacing="0" align="right">
                        <tr> 
			 <td width="150" class="normal" valign="top"  valign="top">Experiment <? //echo $total_no." ".$what." ".$pool; ////testechohere ?>
                            Title : 
                          </td>
                            <? if ($total == $expsessionno && isset($total) && isset($expsessionno) && $total != 0 && $expsessionno != 0){?>
                          <td width="602" class="normal" valign="top"><i><a href="expdetails_exptitle.php?id=<? echo $id; ?>"><? echo $title; ?></a></i>
                          </td>
                          <? }else{?>
                          <td width="602" class="normal" valign="top"><i><? echo $title; ?></i></td>
                          <? }?>
                        </tr>
                        <tr>
                          <td width="150" class="normal" valign="top" >Experiment ID : <? //echo $expsessionno." ".$total; //////testechohere ?>
                          </td>
                          <td width="602" class="normal" valign="top"><i><? echo $id; ?></i></td>
                        </tr>
                        <tr>
                          <td width="150" class="normal" valign="top" >Experimenter(s) : <? //echo $expsessionno." ".$total; //////testechohere ?>
                          </td>
                          <td width="602" class="normal" valign="top"><i><? echo $experimenters; ?></i></td>
                        </tr>
                        <tr> 
                          <td width="150" class="normal" valign="top" height="19">Description 
                            :</td>
                          <td width="602" class="normal" height="19" valign="top"> <i><? echo $description; ?></i></td>
                        </tr>
                        <tr>
                          <td width="150" class="normal" valign="top">Last Modified :</td>
                           <td width="602" class="normal" height="19" valign="top"> <i><? echo $showdate;?></i></td>
                        </tr>
                        <tr>       
                      		<td width="752" height="39" class="normal" colspan="2">
                      		<table width="100%" border="0" cellpadding="3" cellspacing="0" align="right">
                        	<tr><td bgcolor="<? echo $bgcolor; ?>">
                        	<div align="center">
                        	<textarea name="textfield" cols="<? echo TEXTFIELDWIDTH;?>" rows="5" wrap="OFF">
<? 

   if($total == $expsessionno && isset($total) && isset($expsessionno) && $total != 0 && $expsessionno != 0){
   //$show_sessions = str_sessions($id,$expsessionno);
   //echo $show_sessions;
   $query_session = "select title, reward, UNIX_TIMESTAMP(fromdate) AS fromdate, durationEnd, venue, quota, enrolled, UNIX_TIMESTAMP(dateCreated) as dateCreated from session where id like '$id%' ";
   $rs_sessions = $db->query($query_session);
   $session_numOfRows = $rs_sessions->getNumOfRows();
   for ($k=1; $k<= $session_numOfRows; $k++){
   	 $gotosessionrow = $k - 1;
   	 $rs_sessions->moveRow($gotosessionrow);
   	 $title = $rs_sessions->fields[title];
	 $reward = $rs_sessions->fields[reward];
	 $fromdate = $rs_sessions->fields[fromdate];
	 $venue = $rs_sessions->fields[venue];
	 $quota = $rs_sessions->fields[quota];
	 $enrolled = $rs_sessions->fields[enrolled];
	 
	 if(strlen($title) >= 20 ){
	 $show_title = substr($title,0,20);
	 $show_title = $show_title."...          ";
 	 }else{
	 $show_title = $title."             ";
 	 }
	 $show_vacancy = $quota - $enrolled;
	 $show_date = date(DATEFORMAT,$fromdate);
	 $show_date = $show_date."           ";
	 $show_time = date(TIMEFORMAT,$fromdate);
			 
?>
Sessions Title: <? echo $show_title;?>Vacancy:    <? echo $show_vacancy;?> 
Start Date:     <? echo $show_date;?>Start Time: <? echo $show_time;?><? echo "\n";?>
<?
/* 
<!--
Sessions Title: Session 2: Just for ......          Vacancy: 20 
Start Date:     10 May 2000                          Start Time: 8:00am
Sessions Title: Session 3: a short title..          Vacancy: 30 
Start Date:     11 May 2000                          Start Time: 7:00pm
Sessions Title: Session 4: a long title...          Vacancy: 40 
Start Date:     12 May 2000                          Start Time: 11:00am
Sessions Title: Session 5: a long title...          Vacancy: 11 
Start Date:     13 May 2000                          Start Time: 10:30pm
Sessions Title: Session 6: a long title...          Vacancy: 15 
Start Date:     14 May 2000                          Start Time: 1:00pm
-->
*/
?>
<? }?>
<? $rs_sessions->close();?>
<? }else{?>
This experiment is not ready for you to sign up.
<? }?>
                        </textarea>
                        </div>
                        </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                 </table>
                 </td>
                 </tr>
               </table>

<?                    
		}
		$rs1->close();
		$rs2->close();


        }
	?>
	<? show_page($total_pages, $page, $order, $choose_exp, $postcourse); ?>
        <p><?
	$rs->close();		
	$db->close();	/*	optional	*/
}

function rewardstr($reward){
	if ( $reward == "Not specified" ){ return $reward; }
	$reward = split("->", $reward);
	if ( count($reward) == 3 ){
		if ( $reward[0] == "money" ){
			$returnstr = $reward[1]." amount of ".$reward[2]." will be given to each participant.";
			return $returnstr;
		}
		if ( $reward[0] == "credit"){
			$returnstr = $reward[1]." number of ".$reward[2]." credit(s) will be given to each participant.";
			return $returnstr;
		}
		else{ return ""; }
	}
	elseif( count($reward) == 5 ){
		$returnstr = $reward[1]." amount of ".$reward[2]." AND ".$reward[3]." number of ".$reward[4]." credit(s) will be given to each participant.";
		return $returnstr;
	}
	else { return ""; }
}

function preRequisitestr($preRequisite){
	$preRequisite = split("->", $preRequisite);
	if ($preRequisite[0] == "no" ){
		return "No prerequisite.";
	}
	if ( $preRequisite[4] == "" || $preRequisite[4] == " " || !isset($preRequisite[4]) ) {
	$returnstr = "The target subjects should be ".$preRequisite[1]." to ".$preRequisite[2]." of the session(s): "
	.$preRequisite[3].".(Before signing up, check whether you have fulfilled the prerequisites <a href=\"my_experience.php\" target=\"_blank\">here</a>.)";
	return $returnstr;
	}
	else{
	$returnstr = "The target subjects should be ".$preRequisite[1]." to ".$preRequisite[2]." of the session(s): "
	.$preRequisite[3]." ".$preRequisite[4]." ".$preRequisite[5]." to ".$preRequisite[6]." of the session(s): "
	.$preRequisite[7].".(Before signing up, check whether you have fulfilled the prerequisites <a href=\"my_experience.php\" target=\"_blank\">here</a>.)";
	return $returnstr;
	}	
}

function experimentersstr($experimenters){
	$experimenter = split("->",$experimenters);
	$experimenter[0] = "";
	$newexperimenters = implode(", ",$experimenter);
	if ( substr($experimenters,strlen($experimenters)-2,strlen($experimenters)) != "->") $newexperimenters = substr($newexperimenters,2,strlen($newexperimenters)); else $newexperimenters = $experimenter[1];
	return $newexperimenters;
}

function show_mode_str($mode){
        if ( $mode == "All" ) { return "You have to sign up for all sessions in this experiment."; }
        elseif ( $mode == "One" ) { return "You can only sign up for one of the sessions in this experiment."; }
        else { return "You can sign up for any number of sessions in this experiment."; }	
}


function list_sessions($id,$mode,$sessions){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	for ( $i=1; $i<= $sessions; $i++){
		if ($i <10){ $sessionid = $id."0$i";}
		else{ $sessionid = $id."$i";}
		$defaulttitle = "Session "."$i";
		
		$query="select title, reward, UNIX_TIMESTAMP(fromdate) AS fromdate, durationEnd, venue, quota, enrolled, UNIX_TIMESTAMP(dateCreated) as dateCreated from session where id = '$sessionid' ";
	
		$rs = $db->query($query);
		$title = $rs->fields[title];
		$reward = $rs->fields[reward];
		$fromdate = $rs->fields[fromdate];
		$durationEnd = $rs->fields[durationEnd];
		$venue = $rs->fields[venue];
		$quota = $rs->fields[quota];
		$enrolled = $rs->fields[enrolled];
		$dateCreated = $rs->fields[dateCreated];
		
		$starttime = date("g:i a", $fromdate);
		$startdate = date("d M Y", $fromdate);
		$duration = split("-", $durationEnd);
		$Duration = $duration[0]." day(s) ".$duration[1]." hr(s) ".$duration[2]." min(s)";
		
		$rewardstr = rewardstr($reward);
		$Vacancy = $quota - $enrolled;
		$numOfWaiting = NumOfSubjectInWaiting($sessionid,$quota);		
		?>
		  <tr>
		  <? if ( $mode == "All" && $i != 1 ){?>

		  <? }else{?>
                    <td width="6%" height="2" <? if($mode == "All" && $i == 1){ ?> rowspan="<? echo $sessions; ?>" <?}?>> 
                      <div align="center">
                        <? 	
                        if ($mode == "All" && $i == 1 ){
                        	$ck = "ck$i"; ?>
                        	<input type="checkbox" name="<? echo $ck; ?>" value="<? echo $id; ?>">
                        <?}
                        elseif ($mode == "One"){ ?>
                        	<input type="radio" name="<? echo "ck"; ?>" value="<? echo $sessionid; ?>">
                        <?}
                        elseif ($mode == "Any"){
                        	$ck = "ck$i"; ?>
                        	<input type="checkbox" name="<? echo $ck; ?>" value="<? echo $sessionid; ?>">
                        <?}
                        else { 
                        	?>
			<?}?>
                      </div>
                    </td>
                  <? }?>
                    <td width="13%" class="normal">Session <? echo $i; ?>:<br>
                      <? if ( $title == $defaulttitle ) echo ""; else{ echo $title; }?></td>
                    <!--<td width="11%" class="normal"><? echo "Description"; ?>(more)</td>-->
                    <? if (is_session_bw_start_and_end($sessionid)){ ?><td width="9%" class="normal"><font color="ff0000"><? echo $startdate; ?><font></td><? }else {?><td width="9%" class="normal"><? echo $startdate; ?></td><?}?>
                    <? if (is_session_bw_start_and_end($sessionid)){ ?><td width="9%" class="normal"><font color="ff0000"><? echo $starttime; ?><font></td><? }else {?><td width="9%" class="normal"><? echo $starttime; ?></td><?}?>
                    <td width="12%" class="normal"><? echo $Duration; ?></td>
                    <td width="6%" class="normal"><? echo $venue; ?></td>
                    <td width="6%" class="normal"><? echo $quota; ?></td>
                    <td width="8%" class="normal"><? echo $Vacancy; ?></td>
                    <td width="8%" class="normal"><? echo $numOfWaiting; ?></td>
                    <td width="16%" class="normal"><? echo $rewardstr; ?></td>
                  </tr>
                  <?
                } 
        $rs->close();		
	$db->close();	/*	optional	*/               
        }
        
// return the position of the subject in the waiting list::all the subject who signup that session......
// if return 0 == error cannot find this loginName in this session
// if return >0 == the position of the subject ( return set 1,2,3,4,5...... ) 
function signup_position($id,$loginName)
{        	
	  $db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");		
		$query = "select W.loginName from waitingList W where W.sessionid = $id order by W.signOn asc";
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		if ( $numOfRows == 0 ){
			return 0;
		}		
		else{		
			for($i=0; $i <$numOfRows; $i++){
				$rs->moveRow($i);
				$signup_people_temp = $rs->fields[loginName];
				if ( $signup_people_temp == $loginName ){
					$returnvar = $i + 1 ;
					return $returnvar;
				}
			}
			return 0;
		}
        	$rs->close();		
		$db->close();	/*	optional	*/
        }
        
        //return the subject have signed up which exp
        //return array
        function signup_exp($loginName){
        	$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query = "select E.expid from signupexp where E.loginName = '$loginName' order by E.expid asc";        	        
        	$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		for($i=0; $i <$numOfRows; $i++){
			$rs->moveRow($i);
			$signup_exp[$i] = $rs->fields[expid];
        	}
        	$rs->close();		
		$db->close();	/*	optional	*/   
		return $signup_exp;     
        }
        
//return the number which show how many subject in waiting::after the quota is full.
//eg. two subject wait this session RETURN 2
function NumOfSubjectInWaiting($sessionid,$quota)
{
   	$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query = "select loginName from waitingList where sessionid = '$sessionid' ";        	        
   	$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		
		$returnvar = $numOfRows - $quota;
		if ( $returnvar <0 ) { $returnvar = 0; }
		$rs->close();		
		$db->close();	/*	optional	*/   
		return $returnvar;
}

//return bool 
//TRUE :: this subject is in the list of that session but don't know he is waiting or enrolled
function is_SubjectInList($loginName,$sessionid){
  	$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query = "select loginName from waitingList where loginName = '$loginName' and sessionid = '$sessionid' ";        	        
        	$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();        	
		$rs->close();		
		$db->close();	/*	optional	*/   
		if ($numOfRows){
			return true;
		}
		else {
			return false;
		}
        }
        
//return bool 
//TRUE :: this subject is in the list of that experiment but don't know he is waiting or enrolled
function is_SubjectInExp($loginName,$expid)
{
    $db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query = "select loginName from signupexp where loginName = '$loginName' and expid = '$expid' ";        	        
    $rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();        	
		$rs->close();		
		$db->close();	/*	optional	*/   
		if ($numOfRows)
			return true;
		else
			return false;
}

//Given the subject.loginName and experiment id
//it can find the subject had signuped which session
//return session array
function subject_signup_which_session($loginName,$expid){
  	$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query = "select sessionid from waitingList where loginName = '$loginName' and sessionid like '$expid%' ";
        	$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		for ($i = 0; $i < $numOfRows; $i++){
			$rs->moveRow($i);
			$counter = $i + 1;
			$session_array[$counter] = $rs->fields[sessionid];
		}
		$rs->close();		
		$db->close();	/*	optional	*/
		return $session_array;
}
        
//this function will find the subject.loginName who are in the waiting of the given session 
//and his position is $quota +1 :: 1st place in the waiting.
function find_subjectloginName_first_wait($sessionid,$quota)
{
  	$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query = "select loginName from waitingList where sessionid = '$sessionid' order by signOn";
    $rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		$rs->moveRow($quota);
		$returnvar = $rs->fields[loginName];
		return $returnvar;
}
        
function list_sessions_signupstage($id,$loginName,$mode,$sessions,$no_sessions){//$sessions is array, $id is exp id
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	if ($mode == "All"){
		$counter = $no_sessions;
	}
	else { $counter = count($sessions); }
	
	for ( $i=1; $i<= $counter; $i++){
		if ( $mode == "All"){
			if ($i <10){
				$sessionid = $id.'0'.$i;
			}
			else{
				$sessionid = "$id"."$i";
			}
			//$sessionid = $sessions[1];
		}
		else { $sessionid = $sessions[$i]; }

		if ($mode == "All"){
			if ($i <10){ $sessionidquery = $id."0$i";}
			else{ $sessionidquery = $id."$i"; }
		}
		else{
		$sessionidquery = $sessionid;
		}
		$query="select title, reward, UNIX_TIMESTAMP(fromdate) as fromdate, durationEnd, venue, quota, enrolled, UNIX_TIMESTAMP(dateCreated) as dateCreated from session where id = '$sessionidquery'";
	
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		$title = $rs->fields[title];
		$reward = $rs->fields[reward];
		$fromdate = $rs->fields[fromdate];
		$durationEnd = $rs->fields[durationEnd];
		$venue = $rs->fields[venue];
		$quota = $rs->fields[quota];
		$enrolled = $rs->fields[enrolled];
		$dateCreated = $rs->fields[dateCreated];
		
		$starttime = date("g:i a", $fromdate);
		$startdate = date("d M Y", $fromdate);
		$duration = split("-", $durationEnd);
		$Duration = $duration[0]." day(s) ".$duration[1]." hr(s) ".$duration[2]." min(s)";
		$rewardstr = rewardstr($reward);
		
		
		
		//to find the signup stage
		//now have a sessionid
		$signup_stage_no = signup_position($sessionid,$loginName);
		$waitingposition = ($signup_stage_no - $quota);
		if ( $waitingposition > 0) {
			if ( $waitingposition == 1 ){ 
				$number = "1st";
				$signup_stage = $number." in waiting list";
			}
			elseif ( $waitingposition == 2 ){ 
				$number = "2nd";
				$signup_stage = $number." in waiting list";
			}
			elseif ( $waitingposition == 3 ){ 
				$number = "3rd";
				$signup_stage = $number." in waiting list";
			}
			else{
			$signup_stage = $waitingposition."th in waiting list";
			}
		}
		elseif (($signup_stage_no <= $quota) && ( $signup_stage_no >= 1 ) ) $signup_stage = "Sign up successfully";
		else{ $signup_stage = "You have not signed up"; }
		
		
		$Vacancy = $quota - $enrolled;
		
		$numOfWaiting = NumOfSubjectInWaiting($sessionid,$quota);
				
		?>
		  <tr>
		  <? if ( $mode == "All" && $i != 1 ){?>

		  <? }else{?>
                    <td width="6%" height="2" <? if($mode == "All" && $i == 1){ ?> rowspan="<? echo $counter; ?>" <?}?>> 
                      <div align="center">
                        <? 	
                        if ($mode == "All" && $i == 1 ){
                        	$ck = "ck$i"; ?>
                        	<input type="checkbox" name="<? echo $ck; ?>" value="<? echo $id; ?>">
                        <?}
                        elseif ($mode == "One"){ ?>
                        	<input type="radio" name="<? echo "ck"; ?>" value="<? echo $sessionid; ?>">
                        <?}
                        elseif ($mode == "Any"){
                        	$ck = "ck$i"; ?>
                        	<input type="checkbox" name="<? echo $ck; ?>" value="<? echo $sessionid; ?>">
                        <?}
                        else { 
                        	?>
			<?}?>
                      </div>
                    </td>
                  <? }?>                    <td width="13%" class="normal">
                    <? if (($signup_stage_no <= $quota) && ( $signup_stage_no >= 1 )){ ?>
                    <a href="signup_confrimation.php?id=<? echo $id;?>&sessionid=<? echo $sessionidquery;?>" target="_blank">
                    Session <? $temp = substr($sessionidquery,8,2); echo $temp; ?>:</a><br>
                    <? }else{?>
                    Session <? $temp = substr($sessionidquery,8,2); echo $temp; ?>:<br>
                    <? }?>
                    </td>
                    <td width="11%" class="normal"><font color="ff0000" size="+1"><b><? echo $signup_stage; ?></b></font></td>
                    <td width="9%" class="normal"><? echo $startdate; ?></td>
                    <td width="5%" class="normal"><? echo $starttime; ?></td>
                    <td width="12%" class="normal"><? echo $Duration; ?></td>
                    <td width="6%" class="normal"><? echo $venue; ?></td>
                    <td width="6%" class="normal"><? echo $quota; ?></td>
                    <td width="8%" class="normal"><? echo $Vacancy; ?></td>
                    <td width="8%" class="normal"><? echo $numOfWaiting; ?></td>
                    <td width="16%" class="normal"><? echo $rewardstr; ?></td>
                  </tr>
                  <?
                } 
                 if ( $numOfRows == 0 ){ ?>
                <table width="100%" cellpadding="0">
                <tr> 
                  <td width="14%" valign="top">                 
                  You haven't signed up any sessions of this experiments.
                  </td>
                </tr>
                </table>
                <?}

	$db->close();	/*	optional	*/               
        }        

//this function will return the number of the sessions which own by the experiment($id)
function NumOfSessionOfExp($id){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT sessions FROM experiment where id = '$id'";
	$rs = $db->query($query);
	
	$numofsession = $rs->fields[sessions];
	
	$rs->close();		
	$db->close();	/*	optional	*/
	return $numofsession;
}
	
        
            

function show_subject_pool(){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT courseID FROM course order by courseID ASC";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$courseID = $rs->fields[courseID];
		//echo "$courseID <br>";
		$pool = substr($courseID, 0, 4);
		
		if(!strstr($poolStr, $pool)){
			$poolStr .= "$pool"."->";
			print("<tr bgcolor=\"#FFFFCC\">\n"); 
                	print("  <td class=\"tablecolumn\"><a href=\"Pool_Management.php?pool=$pool\">$pool Subject Pool Management</a></td>\n");
                	print("</tr>");
                }
        }
        
	$rs->close();		
	$db->close();	/*	optional	*/
	return $result;


}



function show_all_experimenters($selectall){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
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
		
		$name = $lastName.", ".$firstName;
		?>
		
		
		<tr> 
                    <td width="6%" valign="top"> 
                      <div align="center" class="normal"> 
                        <input type="checkbox" name="checkbox<? echo $i; ?>"<?
				if($selectall !="")
					echo "checked ";
			?>>
                      </div>
                    </td>
                    <td width="8%" valign="top" class="normal"><? echo $name; ?></td>
                    <td width="14%" valign="top" class="normal"><? echo $instructor ;?></td>
                    <td width="10%" valign="top" class="normal"><? echo $loginName ;?></td>
                    <td width="12%" valign="top" class="normal"><? echo $password ;?></td>
                    <td width="12%" valign="top" class="normal"><? echo $sid ;?></td>
                    <td width="8%" valign="top" class="normal"><? echo $phone ;?></td>
                    <td width="12%" valign="top" class="normal"><a href="mailto:<? echo $email ;?>"><? echo $email ;?></a></td>
                    <td width="18%" valign="top" class="normal"><? echo $remarks ;?></td>
                  </tr>
                <?  

		
        }
        echo "<input type=\"hidden\" name=\"total\" value=\"$numOfRows\">";
	$rs->close();		
	$db->close();	/*	optional	*/
}

                

// function to show one experimenter infor
function show_experimenter_info($loginName){
	
  	if($loginName !=""){
		$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
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
                    <td width="44%" class="normal" bgcolor="ffffcc">Experimenter 
                      e-Recruit Login Name :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="loginName" value="<? echo $loginName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Experimenter Password(Encrypted) :</td>
                    <td width="56%"> 
                      <input type="text" name="password" value="<? echo $password; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">First Name(s) 
                      (e.g. Tai Man) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="firstName" value="<? echo $firstName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Last Name (e.g. Chan) :</td>
                    <td width="56%"> 
                      <input type="text" name="lastName" value="<? echo $lastName; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Staff/Student 
                      ID :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="sid" value="<? echo $sid; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Instructor of which course(s) 
                      (e.g. MARK 112 L1) : </td>
                    <td width="56%"> 
                      <input type="text" name="instructor" value="<? echo $instructor; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Phone No(s) 
                      (e.g. 97123456, 23821234) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="phone" value="<? echo $phone; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Email Address :</td>
                    <td width="56%"> 
                      <input type="text" name="email" value="<? echo $email; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Remarks :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="remarks" value="<? echo $remarks; ?>">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="tablerow">&nbsp;</td>
                    <td width="56%"> 
                      <div align="right">
                        <input type="submit" name="modify" value="Modify">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>
                
                
<?
                
}
        

function show_experiments_of_experimenter($loginName){
	if($loginName != ""){
		$db = new phpDB();
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
                  <td width="14%" class="tablecolumn">Created On</td>
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
                  <td width="8%" valign="top" class="normal"><a href="link"><? echo $title; ?></a></td>
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

function show_subject_record($condition){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$queryStr = explode("->", $condition);
	//echo "$condition";
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
                    <td width="8%" valign="top" class="normal"><? echo "$firstName"; ?></td>
                    <td width="14%" valign="top" class="normal"><? echo $lastName; ?></td>
                    <td width="10%" valign="top" class="normal"><? echo $loginName; ?></td>
                    <td width="12%" valign="top" class="normal"><? echo $password; ?></td>
                    <td width="12%" valign="top" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                  </tr>		
	
<?
	}
}




//funtion to add/modify course
function add_course($modify){
	if($modify != ""){
		$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "SELECT * FROM course where courseID='$modify'";
		$rs = $db->query($query);
		$rs->firstRow();
	 	$courseID = $rs->fields[courseID];
	 	$firstName = $rs->fields[firstName];
	 	$lastName = $rs->fields[lastName];
	 	$email = $rs->fields[email];
	 	$signUpCode = $rs->fields[signUpCode];
	}
	?>
		
              <form name="form1" method="post" action="Check_Course.php<? if($modify != "") echo "?courseID=$modify"; ?>" >
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Course :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="course" value="<? echo $courseID; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">First Name(s) (e.g. Tai Man):</td>
                    <td width="56%"> 
                      <input type="text" name="firstname" value="<? echo $firstName; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">Last Name (e.g. Chan) :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="lastname" value="<? echo $lastName; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal">Email Address :</td>
                    <td width="56%">
                      <input type="text" name="email" value="<? echo $email; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td width="44%" class="normal" bgcolor="ffffcc">System Generated Sign-Up Code :</td>
                    <td width="56%" bgcolor="ffffcc"> 
                      <input type="text" name="signupcode" value="<?
                      	if($modify ==""){
                      		$md5str = MD5( TIME() );
                      		
                      		$signUpCode = substr($md5str, 0, 8);
                      		
                      	}
                      	       	 echo $signUpCode; ?>" size="20">
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="2" class="tablerow"> 
                      <div align="right"> 
                        <input type="submit" name="add" value="Add">
                        <input type="reset" name="reset" value="Reset">
                      </div>
                    </td>
                  </tr>
                </table>
                </form>
<?
}


?>
