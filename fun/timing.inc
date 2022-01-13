<?
/*
Session time line
Sign up control
fromdate		enddate
   |			   |
---------------------------------
^		^		^		
|		|		|
now()		now()		now()
|		|		|
		-		-
		|		|cannot sign up
		V		
have warning, but can sign up


Cancel sign up control
fromdate		enddate
   |			   |
---------------------------------
^		^		^
|		|		|
now()		now()		now()
|		|		|
-		-----------------
|			|
V			V
can be cancelled	cannot be cancelled
*/
//this can check whether the session is started or not
//input: sessionid
//output: TRUE: session is started
//	  FALSE: session is not started yet
function is_session_started($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT fromdate FROM session WHERE fromdate <= now() and id = '$sessionid'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	$rs->close();		
	$db->close();
	if ($numOfRows >= 1){
		return true;
	}else{
		return false;
	}
}

//this can check whether the session is between the startdate and the enddate or not
//input: sessionid
//output: TRUE: session is started
//	  FALSE: session is not started yet
function is_session_bw_start_and_end($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT fromdate FROM session WHERE fromdate <= now() and now() <= enddate and id = '$sessionid'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	$rs->close();		
	$db->close();
	if ($numOfRows >= 1){
		return true;
	}else{
		return false;
	}
}

//this can check whether the session is ended or not
//input: sessionid
//output: TRUE: session is ended
//	  FALSE: session is not ended yet
function is_session_ended($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT fromdate FROM session WHERE enddate <= now() and id = '$sessionid'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	$rs->close();		
	$db->close();
	if ($numOfRows >= 1){
		return true;
	}else{
		return false;
	}
}

//this can check whether the session is signed up b4 or not
//input: sessionid, loginName
//output: TRUE: session is signed up b4 by this loginName
//	  FALSE: session is not signed up b4 by this loginName
function is_sessions_signedupb4($sessionid,$loginName){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT loginName FROM waitingList WHERE loginName = '$loginName' and sessionid = '$sessionid'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	$rs->close();		
	$db->close();
	if ($numOfRows >= 1){
		return true;
	}else{
		return false;
	}
}


//checking the experiment is upcoming or not
//return true : the exp is upcoming
//return false : the exp is past
function is_upcoming_exp($expid) {
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select e.id, e.title, e.description, UNIX_TIMESTAMP(e.dateCreated) as dateCreated, e.experimenters, e.mode, e.sessions, e.software, e.preRequisite, e.target, e.category from experiment e, session s where e.id = '$expid' && e.id = substring(s.id,1,length(s.id)-2) && s.enddate >= now() && e.enable = 'y' group by e.id ";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	
	$rs->close();		
	$db->close();
	if ($numOfRows >= 1){
		return true;
	}else{
		return false;
	}
}
?>