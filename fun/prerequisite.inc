<?
/*--------------------------------------------------------------------------------------*/	

/*	define this module, to prevent double class declaration.	*/
	if (!defined("_PREREQ_ABSTRACT_LAYER")) {
	  define("_PREREQ_ABSTRACT_LAYER", 1 );
	}
	
//	1: debug mode is on, 0: debug mode is off
	define("PREREQ_DEBUG", 0);	
	
/*--------------------------------------------------------------------------------------*/	
	
class PreReq{

	/*	public variables	*/
	var $error = "";
	
	/*	private variables	*/
	var $_inputPreRequisite	= "no";			//	This will store the prerequisite of experiment which you need to sign up
	var $_loginName		= "";				//	Your login Name which will be used to check that weather it can satisify this experment sign up or not
	var $_expid		= "";					//	This is the experiment which you want to sign it up
	var $_have_preReq	= "no";			//	This will store the first element of the _inputPreRequistite eg. yes, no 	
	
	//There are two parse of one _inputPreRequisite
	//There are two case which need to handle
	//experienced, inexperienced
	var $_preReq_a		= "";
	var $_any_all_set_a	= "any";				
	var $_sessionid_set_a	= "";		//	The session id need to be checked
	var $_logic		= "or";
	var $_any_all_set_b	= "any";
	var $_preReq_b		= "";
	var $_sessionid_set_b	= "";
	
	function preReq($loginName,$expid) {
		$this->_loginName = $loginName;
		$this->_expid = $expid;

		$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "SELECT preRequisite FROM experiment WHERE id = '$this->_expid'";
		$rs = $db->query($query);
		
		$this->_inputPreRequisite = $rs->fields[preRequisite];
		$numOfRows = $rs->getNumOfRows();
		$tmp_inputPreRequisite = split("->",$this->_inputPreRequisite);
		$this->_have_preReq = $tmp_inputPreRequisite[0];
		$this->_preReq_a = $tmp_inputPreRequisite[1];
		$this->_any_all_set_a = $tmp_inputPreRequisite[2];
		$tmp_sessionid_set_a = $tmp_inputPreRequisite[3];
		$tmp_sessionid_set_a = ereg_replace(" ","",$tmp_sessionid_set_a);
		$this->_sessionid_set_a = $tmp_sessionid_set_a;

		$this->_logic = $tmp_inputPreRequisite[4];
		$this->_preReq_b = $tmp_inputPreRequisite[5];
		$this->_any_all_set_b = $tmp_inputPreRequisite[6];
		$tmp_sessionid_set_b = $tmp_inputPreRequisite[7];
		$tmp_sessionid_set_b = ereg_replace(" ","",$tmp_sessionid_set_b);
		$this->_sessionid_set_b = $tmp_sessionid_set_b;
		
		$rs->close();
		$db->close();
		$returnvar = $numOfRows ? true : false;
		
		if (DEBUG_PREREQUSITE) $this->error = "---  creating object START  ---<br>
				_loginName = $this->_loginName<br>
				_expid = $this->_expid<br>
				numOfRows = $numOfRows<br>
				_have_preReq = $this->_have_preReq<br>
				_preReq_a = $this->_preReq_a<br>
				_any_all_set_a = $this->_any_all_set_a<br>
				_sessionid_set_a = $this->_sessionid_set_a<br>
				tmp_sessionid_set_a = $tmp_sessionid_set_a<br>
				_logic = $this->_logic<br>
				_preReq_b = $this->_preReq_b<br>
				_any_all_set_b = $this->_any_all_set_b<br>
				_sessionid_set_b = $this->_sessionid_set_b<br>
				tmp_sessionid_set_b = $tmp_sessionid_set_b<br>
				---  creating object END  ---<br>";
		return $returnvar;
	}
	
	function is_pass() {
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() START ---<br>";
		if ( $this->_have_preReq == "no" ) { 
			if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() END ---<br>
					---  is_pass() return true ---<br>";
			return true; 
		}
		if ( isset($this->_preReq_a)) {
			
			$is_pass_one_part_a = $this->_is_pass_one_part($this->_preReq_a,$this->_any_all_set_a,$this->_sessionid_set_a);
			
			if (DEBUG_PREREQUSITE) $show_is_pass_one_part = $this->_is_pass_one_part ? "true" : "false";
			if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					--->>>  calling _is_pass_one_part a END and return \$show_is_pass_one_part = $show_is_pass_one_part ---<br>";
		}else {
			$is_pass_one_part_a = true;
		}
		
		if ( isset($this->_preReq_b)) {
			$is_pass_one_part_b = $this->_is_pass_one_part($this->_preReq_b,$this->_any_all_set_b,$this->_sessionid_set_b);
			if (DEBUG_PREREQUSITE) $show_is_pass_one_part = $this->_is_pass_one_part ? "true" : "false";
			if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					--->>>  calling _is_pass_one_part b END and return \$show_is_pass_one_part = $show_is_pass_one_part ---<br>";
		}else {
			$is_pass_one_part_b = true;
		}
		
		if ( ($this->_logic == "or") and ($this->_preReq_b == "experienced" || "inexperienced" || "no")){
			$returnvar = $is_pass_one_part_a || $is_pass_one_part_b;
			if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() \$returnvar = \$is_pass_one_part_a || \$is_pass_one_part_b; ---<br>";
		}elseif( $this->_logic == "and" && isset($this->_preReq_b)) {
			$returnvar = $is_pass_one_part_a && $is_pass_one_part_b;
			if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() \$returnvar = \$is_pass_one_part_a && \$is_pass_one_part_b; ---<br>";
		}else {
			$returnvar = $is_pass_one_part_a;
			if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() \$returnvar = \$is_pass_one_part_a; ---<br>";
		}
		if (DEBUG_PREREQUSITE) $show_is_pass_one_part_a = $is_pass_one_part_a ? "true" : "false";
		if (DEBUG_PREREQUSITE) $show_is_pass_one_part_b = $is_pass_one_part_b ? "true" : "false";
		if (DEBUG_PREREQUSITE) $show_returnvar = $returnvar ? "true" : "false";
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() \$this->_logic = $this->_logic \$this->_preReq_b = $this->_preReq_b---<br>";
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() \$is_pass_one_part_a = $show_is_pass_one_part_a ---<br>";
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() \$is_pass_one_part_b = $show_is_pass_one_part_b ---<br>";
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() END ---<br>";
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  runing is_pass() END --->>>>>>> final output $show_returnvar<br>";
		return $returnvar;
	}
	
	function _is_pass_one_part($command,$command_set,$sessionid_set) {
		//$sessionid_ary[1] = 1000003601;
		
		$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		if ( $command == "experienced" && $command_set == "any") $is_pass = false;
		if ( $command == "experienced" && $command_set == "all") $is_pass = true;
		if (($command == "inexperienced" || $command == "no") && $command_set == "any" ) $is_pass = false;
		if (($command == "inexperienced" || $command == "no") && $command_set == "all" ) $is_pass = true;
		$sessionid_ary = split(",",$sessionid_set);
		$sessionid_ary_count = count($sessionid_ary);
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  b4 for loop START ---<br>
					command = $command<br>
					command_set = $command_set<br>
					_loginName = $this->_loginName<br>
					sessionid_set = $sessionid_set<br>
					sessionid_ary_count = $sessionid_ary_count<br>
					sessionid_ary[0] = $sessionid_ary[0]<br>
					sessionid_ary[1] = $sessionid_ary[1]<br>
					sessionid_ary[2] = $sessionid_ary[2]<br>
					sessionid_ary[3] = $sessionid_ary[3]<br>
					";
		for($key = 0; $key < count($sessionid_ary); $key++) {
			if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  just in for loop START ---<br>
					\$key = $key<br>";
			if ($command == "experienced") {
				$query2 = "SELECT a.attendancy, a.sessionid, a.loginName, a.date
		        	FROM attendancy a                                        
		        	WHERE a.loginName = '$this->_loginName'                                
		        	and a.attendancy = 'experienced'                                                            
		        	and a.sessionid = '$sessionid_ary[$key]'";                                 
			                                                                              
			        $rs = $db->query($query2);                                                     
				$numOfRows = $rs->getNumOfRows();
				if ( $numOfRows ) { $is_pass_one_session = true; } else { $is_pass_one_session = false; }                                                      
			        
				$rs->close();
				if ($command_set == "any") $is_pass = $is_pass || $is_pass_one_session;
				if ($command_set == "all") $is_pass = $is_pass && $is_pass_one_session;
			}elseif ($command == "inexperienced" || $command == "no") {
				$sign_up_pos = signup_position($sessionid_ary[$key],$this->_loginName);
				if ( !$sign_up_pos || !isset($sign_up_pos) ) {
					$is_pass_one_session = true;
				} else { 
					$query2 = "SELECT a.attendancy, a.sessionid, a.loginName, a.date
					FROM attendancy a
					WHERE (a.attendancy = 'inexperienced' OR a.attendancy = 'no') 
					AND a.loginName = '$this->_loginName' 
					AND a.sessionid = '$sessionid_ary[$key]'";
				        $rs = $db->query($query2);                                                     
					$numOfRows = $rs->getNumOfRows();                                                      
				        if ( $numOfRows ) { $is_pass_one_session = true; } else { $is_pass_one_session = false; }
		                                                                                       
					$rs->close();			
				}
				
				if ($command_set == "any") $is_pass = $is_pass || $is_pass_one_session;
				if ($command_set == "all") $is_pass = $is_pass && $is_pass_one_session;

			}else {
				if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
						---  in the _is_pass_one_part  ---<br>";			
			}
			if (DEBUG_PREREQUSITE) $show_is_pass_one_session = $is_pass_one_session ? "true" : "false";
			if (DEBUG_PREREQUSITE) $show_is_pass = $is_pass ? "true" : "false";
			if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  in the _is_pass_one_part \$command == \"experienced\" START ---<br>
					command = $command<br>
					command_set = $command_set<br>
					sessionid = $sessionid_ary[$key]<br>
					numOfRows = $numOfRows<br>
					is_pass_one_session = $show_is_pass_one_session<br>
					is_pass = $show_is_pass<br>
					---  in the _is_pass_one_part \$command == \"experienced\" END  ---<br>";
		}
		$db->close();
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					---  just in for loop END ---<br>";
					$show_is_pass = $is_pass ? "true" : "false";
		if (DEBUG_PREREQUSITE) $this->error = "$this->error"."
					--->>>  just in for loop END and then return \$is_pass = $show_is_pass---<br>";
			return $is_pass;
	}

}
// This is the end of the class PreReq

/*--------------------------------------------------------------------------------------*/
// This is used by signup_sessions.php
//check prerequisite
//Given the loginName,and prerequsite which from the db
//return bool, ture:: meet all the prerequisite
function checkprerequisite($loginName,$expid) {
	$PreReq = new PreReq($loginName,$expid);
	$PreReq or die ("Can't create the object PreReq!");
	$returnvar = $PreReq->is_pass();
	if (DEBUG_PREREQUSITE) warningx($PreReq->error);
	return $returnvar;
}



?>