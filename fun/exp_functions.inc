<?
include("../fun/mysql.inc");
include("../fun/mail.inc");
include("../fun/config.inc");
include("../fun/common.inc");
include("../fun/exp_mail.inc");
include("../fun/errmsg.inc");


    function checkcookie($expprofile){
    	$cookie_var = split("-", $expprofile);
	$loginName = $cookie_var[0];
	$password = $cookie_var[1];
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT loginName FROM experimenter WHERE loginName = '$loginName' and password='$password'";
	$rs = $db->query($query);
	
	$numOfRows = $rs->getNumOfRows();
	
	$rs->close();		
	$db->close();	/*	optional	*/
	
	if($numOfRows){	
		return true;
	}else{
		return false;
	}

    }
    
    
    
    
    function Login($loginStr) {
	//$CRYPT_STD_DES = 1;	// Standard DES Encryption
	$LOGIN = explode("\t", $loginStr);
	$loginName = $LOGIN[0];
	$password = $LOGIN[1];
	$nonust = $LOGIN[2];
	
	
	$result = false;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	
	if($nonust != "" && $nonust=="yes"){
		$query = "SELECT password FROM experimenter WHERE loginName = '$loginName' and hkust='No'";
	}
	else{
		$query = "SELECT password FROM experimenter WHERE loginName = '$loginName'";
	}
	
	$rs = $db->query($query);
	$cryptpassword = $rs->fields[password];
	
	$password = crypt($password, substr("$cryptpassword", 0, 2));
	
	$query = "SELECT sid FROM experimenter WHERE loginName = '$loginName' and password = '$password'";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();	
	if($numOfRows){
		$rs->firstRow();	/*	optional, but recommended.	*/
		$id = $rs->fields[sid];
		$query = "SELECT firstName, lastName FROM experimenter where sid=$id";
		$rs = $db->query($query);
		$md5str = MD5( TIME() );
		$cookie_val = "$loginName-$password-$md5str";
		setcookie( "expprofile", $cookie_val, time()+10800); 
        $result = true;
	    
	}
	$rs->close();		
	$db->close();	/*	optional	*/
	return $result;
    }

function checkLogin(){
	global $loginStr;
	global $expprofile;
	$loginStr = "$loginName"."\t"."$password";
	$login_var = explode("-", $expprofile);
	if(!isset($loginName))
		$loginName = $login_var[0];

	if(!(isset($expprofile) && checkcookie($expprofile))){
		warning(T0090);
		exit();
	}

}


function message_nobut($MSG, $link){
	$title="Message!";
	head($title);
	
?>
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0" align="center">

                <tr> <!-- Shim row, height 1. --> 
                  <td><img src="images/shim.gif" width="630" height="1" border="0"></td>
                  <td><img src="images/shim.gif" width="10" height="1" border="0"></td>
                  <td><img src="images/shim.gif" width="1" height="1" border="0"></td>
                </tr>
                <tr valign="top"><!-- row 2 --> 
                  <td colspan="2"><img name="table_r2_c2" src="images/table_r2_c2.gif" width="640" height="20" border="0"></td>
                  <td><img src="images/shim.gif" width="1" height="20" border="0"></td>
                </tr>
                <tr valign="top"><!-- row 3 --> 
                  <td bgcolor="ffffcc">
                    <table width="95%" border="0" cellpadding="3" cellspacing="0" align="center">
                      <tr>
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial">Message:</font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo $MSG; ?></font></p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      
                    </table>
                  </td>
                  <td background="images/table_r3_c3.gif">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="top"><!-- row 4 --> 
                  <td colspan="2"><img name="table_r4_c2" src="images/table_r4_c2.gif" width="640" height="25" border="0"></td>
                  <td><img src="images/shim.gif" width="1" height="25" border="0"></td>
                </tr>
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
            


	
<?
foot();
exit();
}


//function to change password
function change_password($pasStr){
	
		$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$loginName = $pasStr[0];
		$newpassword =$pasStr[1];
		$query = "UPDATE experimenter SET password='$newpassword' WHERE loginName='$loginName'";
		$rs = $db->query($query);
				
		setcookie("expprofile", "", time()-6000);
		message(T0093, "index.php");
		
}

function number_of_experiment(){
	global $expprofile;
	global $PHP_SELF;
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
	$condition = "experimenters like '$loginName"."->%'";
	$query = "SELECT id from experiment WHERE enable='y' and $condition order by id asc";
	
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	echo "$numOfRows";
}


function show_my_experiment($experimentID){
	global $expprofile;
	global $PHP_SELF;
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
	
	$condition = "experimenters like '$loginName"."->%'";
	if($experimentID != "")
		$condition .=" and id=$experimentID";
	
	//echo "$condition";
	$query = "SELECT id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated FROM experiment WHERE enable='y' and $condition order by id asc";
	
	//echo "$query";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows == 0){?>

		 <tr>
  		  <td width="100%" colspan="5">No experiment was created</td>
  		</tr>
  
	<?
	}else{

		
		
	for($i=0; $i< $numOfRows; $i++){ //$numOfRows
		$rs->moveRow($i);
		$expid = $rs->fields[id];
		$title = $rs->fields[title];
		$description = $rs->fields[description];
		if(trim($description) == ""){
			$description = "&nbsp;";
		}
		
		$createdon = date("jM Y", $rs->fields[dateCreated]);
		
?>

		<tr> 
                <td width="45" valign="top"> 
                  <div align="center"> 
                    <INPUT TYPE=radio NAME="myexpid" <? if($experimentID !="") echo "checked"; ?> value="<? echo $expid; ?>">
                  </div>
                </td>
                <td width="84" valign="top" class="normal"><? echo "$expid"; ?></td>
                
                <td width="84" valign="top" class="normal"><? echo "$title"; ?></td>
                <td width="405" valign="top" class="normal"><? echo "$description"; ?></td>
                <td width="130" valign="top" class="normal"><? echo "$createdon"; ?></td>
                </tr>
	  
<?

	}
}	
	$rs->close();		
	$db->close();



}


function show_all_experiment(){
	global $expprofile;
	global $PHP_SELF;
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
	
	$condition = "experimenters like '$loginName"."->%'";
	if($experimentID != "")
		$condition .=" and id=$experimentID";
	
	$query = "SELECT id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated FROM experiment where id>10000000 order by id asc";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	if($numOfRows == 0){?>

		 <tr>
  		  <td width="100%" colspan="5">No Experiment was created</td>
  		</tr>
  
	<?
	}else{
	for($i=0; $i< $numOfRows; $i++){
		$rs->moveRow($i);
		$expid = $rs->fields[id];
		$title = $rs->fields[title];
		$description = $rs->fields[description];
		if(trim($description) == ""){
			$description = "&nbsp;";
		}
		$createdon = date("jM Y", $rs->fields[dateCreated]);
		
?>

		<tr> 
                <td width="15%" valign="top" class="normal"><? echo "$expid"; ?></td>
                
                <td width="18%" valign="top" class="normal"><? echo "$title"; ?></td>
                <td width="45%" valign="top" class="normal"><? echo "$description"; ?></td>
                <td width="16%" valign="top" class="normal"><? echo "$createdon"; ?></td>
                </tr>
	  
<?

	}
}

	$rs->close();		
	$db->close();
	

}
	
function del_experiment($expid){
	global $expprofile;
	global $PHP_SELF;
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
	
	$condition = "experimenters like '$loginName"."->%'";
	$query = "update experiment set enable='n' where $condition and id='$expid'";
	$rs = $db->query($query);
	if($rs){
		return true;
	}else{
		return false;
	}
}


function show_all_course(){
	global $expprofile;
	global $PHP_SELF;
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
	
	$query="select * from course  where enable='y' and pool='' order by courseID ASC";
	
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i< $numOfRows; $i++){ //$numOfRows
		$rs->moveRow($i);
		$course= $rs->fields[courseID];
		$semester= $rs->fields[semester];
		$year= $rs->fields[year];
		echo "<option value=\"$course--$year--$semester\">$course $year $semester</option>\n";
	}
	

}


function show_all_pool(){
	global $expprofile;
	global $PHP_SELF;
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
	
	$query="select id, semester, year from pool order by id ASC";
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i< $numOfRows; $i++){ //$numOfRows
		$rs->moveRow($i);
		$pool= $rs->fields[id];
		$semester = $rs->fields[semester];
		$year = $rs->fields[year];
		echo "<option value=\"$pool--$year--$semester\">$pool $year $semester</option>\n";
	}
	

}


// check whether the experiment id is valid or not
function  expid($expid){
	global $PHP_SELF;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
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
	$rs->close();		
	$db->close();	/*	optional	*/
}

function is_sess_exist($sessionid){
	global $PHP_SELF;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT id FROM session WHERE id = '$sessionid' ";
	$rs = $db->query($query);	
	$numOfRows = $rs->getNumOfRows();
	
	if($numOfRows){
		$rs->firstRow();	/*	optional, but recommended.	*/
		$sessionid = $rs->fields[id];
		return $sessionid;
	}
	else{
		return false;
	}
	$rs->close();		
	$db->close();	/*	optional	*/
}

//Used to check whether all the session in that expid is taken the attendency or not
function expTakenAtt($expID){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT id FROM session WHERE id like '$expID%'";
	$rs = $db->query($query);
	$num_sess = $rs->getNumOfRows();

	if ($num_sess==0){
		return false;
		exit();	
	}
	for($i=1; $i<=$num_sess; $i++){ //$numOfRows
		$rs->moveRow($i-1);
		$sessionid= $rs->fields[id];
		if(isTakenAttendency($sessionid)==0){//One of the session Not Taken Attendency
			return false;
			exit();
		}
	}
	return true;
}


function is_sess_TakenAtt($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT sessionid FROM attendancy WHERE sessionid=$sessionid";
	$rs = $db->query($query);
	$num_sess = $rs->getNumOfRows();
	if ($num_sess==0){
		return false;
		exit();	
	}
	else{
		return true;
	}
}


// check whether the experiment id is belong to the experimenter
function  checkexpid($expid){
	global $PHP_SELF;
	global $expprofile;
	$login_var = explode("-", $expprofile);
	if(!isset($loginName))
		$loginName = $login_var[0];
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$id=$expid;
	$exp=$loginName;
	
	$query = "SELECT id FROM experiment WHERE id = '$id' and enable='y' and experimenters like '$exp%'";
	$rs = $db->query($query);	
	$numOfRows = $rs->getNumOfRows();
	return true;
}

	
function addExperiment($query){
	global $expprofile;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	
	$query2 = "INSERT INTO experiment (title, description, experimenters, mode, sessions, software, preRequisite, target, category) ".$query;
	

	$rs = $db->query($query2);	
	$login_var = explode("-", $expprofile);

	if(!isset($loginName))
	$loginName = $login_var[0];
	
	$condition = "$loginName"."->";
	$query = "SELECT max(id) as id FROM experiment where enable='y' and experimenters  like '$condition%'";	
	$rs = $db->query($query);		
	return $rs->fields[id];
	

}


// update the experiment
function updateExperiment($query, $expid){
	global $expprofile;
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	
	list($title, $description, $experimenters, $software, $category)
		= explode("||_>", $query);
	$query2 = "UPDATE experiment set  
		title = '$title', 
		description = '$description', 
		experimenters = '$experimenters', 
		software = '$software', 
		category ='$category' 
		where id = $expid";
	
	$rs = $db->query($query2);
		
	$rs->close();		
	$db->close();	/*	optional	*/
}


function experimentDetail($expid, $loginName){
	
if($expid !=""){
	global $expprofile;
	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
	
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT * FROM experiment WHERE experimenters like '$loginName"."->%'"." and id = $expid and enable='y'";
	$rs = $db->query($query);	
	$experimenters = $rs->fields[experimenters];
	$rep = $loginName."->";
	
	$experimenters = str_replace($rep, "", $experimenters);
	
	$otherexp = ereg_replace("->", ",", $experimenters);	// other experimenters' name
	
	$title = $rs->fields[title];		// experiment title
	$mode	 = $rs->fields[mode];	// one/all/any
	
	$sessions = $rs->fields[sessions];	// no. of sessions
	$software = $rs->fields[software];	// software
	$preRequisite =$rs->fields[preRequisite];	// yes /no
	
	if($preRequisite !="no"){
		$preReqStr = explode("->", $preRequisite);
		$preRequisite = $preReqStr[0];
	
		$pre1    = $preReqStr[1];	// exp./inexp.
		$any_all = $preReqStr[2];	// Any or All
		$pre2    = $preReqStr[3];	// participant past experiments
		$pre3    = $preReqStr[4];	// and / or
		$pre4    = $preReqStr[5];	// exp./inexp.
		$any_all2= $preReqStr[6];	// Any or All
		$pre5    = $preReqStr[7];	// participant past experiments		
	}
	
	$description = $rs->fields[description];	// exp description
	$targetid    = $rs->fields[target];	// target participant: open/ restrict
	
	list($target, $target2) = explode("->", $targetid);
	if($target == "course"){
		$course=$target2;
	}
	
	if($target == "pool"){
		$pool=$target2;
	}
	
	
	$rs->close();		
	$db->close();	/*	optional	*/

}
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr> 
            <td width="27%" valign="top" valign="top" > 
              <p class="normal">Experiment ID : </p>
            </td>
            <td colspan="3" class="tablerow" width="73%" valign="top" ><span class="noteindicator"><? echo $expid; ?></span></td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc">Experiment Created by: </td>
            <td colspan="3" class="normal" width="73%" valign="top" bgcolor="ffffcc"> <? 
              $returnval = show_experimenter_name($loginName);
              echo $returnval; 
              ?></td>
          </tr>
          
          <tr> 
            <td width="27%" valign="top" class="normal">Experimenter(s) 
              : </td>
            <td colspan="3" class="normal" width="73%" valign="top"> 
              <input type="text" name="otherexp" value="<? echo $otherexp; ?>">
              (e.g. Gary Cheung, Peter Chan) </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc">Experiment 
              Title :</td>
            <td colspan="3" class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <input type="text" name="exptitle" value="<? echo $title; ?>">
            </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal">Session Combination :
            </td>
            <td colspan="3" class="normal" width="73%" valign="top"><span class="noteindicator"><? echo $mode; ?></span></td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc">Total 
              No. of Session(s) : </td>
            <td colspan="3" class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <span class="noteindicator"><? echo $sessions; ?>
            </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal">Experiment Software :</td>
            <td colspan="3" class="normal" width="73%" valign="top"> 
              <input type="text" name="software" value="<? echo $software; ?>">
            </td>
          </tr>
          <tr> 
            <td width="27%" rowspan="3" valign="top" class="normal" bgcolor="ffffcc">Prerequisites 
              :</td>
            <td colspan="3" rowspan="3" class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <table width="100%" cellpadding="2" bgcolor="ffffcc" cellspacing="0" border="0">
              
                <? if($preRequisite =="yes") { ?>
                
                <tr> 
                  <td class="normal" valign="top"> 
                    <input type="hidden" name="preRequisite" <? if($preRequisite =="yes") {echo "value=\"yes\"";} ?> >
                    Yes</td>
                  <td class="normal">The target subjects should :
                  <br>
                  <? echo strtoupper($pre1); ?> to <? echo strtoupper($any_all); ?> of session(s):</td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td class="normal"><? echo $pre2; ?> 
                <? if(trim($pre3)!=""){
                	echo strtoupper($pre3);
                ?>
                	</td></tr>
                	<tr><td>&nbsp;</td>
                  	<td class="normal"><? echo strtoupper($pre4); ?> to <? echo strtoupper($any_all2); ?> of session(s): 
                  	</td></tr><tr><td>&nbsp;</td>
                        <td class="normal">
                <? 	echo $pre5; 
                   }                
                ?>                                                                        
                  </td>
                </tr>
                <? }else{ ?>
                <tr> 
                  <td class="normal" valign="top"> 
                    <input type="hidden" name="preRequisite" <? if($preRequisite =="no") echo "value=\"no\"";?>>
                    No </td>
                  <td>&nbsp;</td>
                </tr>
                <? } ?>
                
              </table>
            </td>
          </tr>
          <tr> </tr>
          <tr> </tr>
          <tr> </tr>
          <tr> 
            <td width="27%" valign="top" class="normal">Description :</td>
            <td colspan="3" class="normal" width="73%" valign="top"> 
              <textarea name="description" wrap="physical" cols="69" rows="5"><? echo $description; ?></textarea>
            </td>
          </tr>
          
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc">Target Participants:</td>
           <td colspan="3" class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
           <? if($target =="open") { ?>
              <span class="noteindicator">This experiment is open to <? echo ORG_SHORT; ?> and/or non-<? echo ORG_SHORT; ?> individuals.</span> </td>
              <? }else if($target =="course"){ ?>          
              This experiment is restricted to students taking 
              <font color="#FF0000"><b><span class="noteindicator"> <? echo $course; ?></b></font></span> to participate. </td>
              <? }else{ ?>
              This experiment is restricted to students under
              <font color="#FF0000"><b><span class="noteindicator"> <? echo $pool; ?></b> </font>pool </span>to participate. </td>
              <? } ?>
          </tr>
          <tr>
           <td colspan="3" class="normal">
           <input type="checkbox" name="sendmail" value="on"> 
           I would like e-Recruit to send email to notify the subjects about this modification automatically 
           </td>
          </tr>
          <tr> 
            <td colspan="2" class="normal"> 
              <div align="right"> 
                <input type="submit" name="modify" value="Modify">
                <input type="reset" name="reset" value="Reset">
              </div>
            </td>
          </tr>
        </table>
        
 <?
}


function show_quota($expid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT mode FROM experiment WHERE id = $expid and enable='y'";
	$rs = $db->query($query);	
	$rs->firstRow();
	$mode = $rs->fields[mode];
	
	if($mode == "All"){
		$query = "SELECT quota FROM session WHERE id like '$expid%'";
		$rs = $db->query($query);	
		$rs->firstRow();
		$quota = $rs->fields[quota];
		if($quota =="" || $quota <=0){
			echo "<input type=\"text\" name=\"quota\" value=\"\">";
		}
		else{
			echo $quota;
			echo "\n<input type=\"hidden\" name=\"quota\" value=\"$quota\">";
		}
		
	}
	else{
		echo "<input type=\"text\" name=\"quota\" value=\"\" maxlength=\"4\" size=\"4\">";
	}

}

// ############ Used in Add_Session.php ##############
function show_quota_to_modify($expid, $quota){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT mode FROM experiment WHERE id = $expid and enable='y'";
	$rs = $db->query($query);	
	$rs->firstRow();
	$mode = $rs->fields[mode];
	
	if($mode == "All"){
		$query = "SELECT quota FROM session WHERE id like '$expid%'";
		$rs = $db->query($query);	
		$rs->firstRow();
		$quota = $rs->fields[quota];
		if($quota =="" || $quota <=0){
			echo "<input type=\"text\" name=\"quota\" value=\"\">";
		}
		else{
			echo $quota;
			echo "\n<input type=\"hidden\" name=\"quota\" value=\"$quota\">";
		}
		
	}
	else{
		echo "<input type=\"text\" name=\"quota\" value=\"$quota\" maxlength=\"4\" size=\"4\">";
	}

}

function show_all_session($expid){
	global $expprofile;
	$login_var = explode("-", $expprofile);
	

	
	$loginName = $login_var[0];
	
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT title, mode, target, sessions FROM experiment WHERE experimenters like '$loginName"."->%'"." and id = $expid and enable='y'";
	$rs = $db->query($query);	
	$rs->firstRow();
	
	$title=$rs->fields[title];
	$mode=$rs->fields[mode];
	$targetid=$rs->fields[target];
	$totalsessions=$rs->fields[sessions];
	
	list($target, $pool) = explode("->", $targetid);
	
	$query = "SELECT count(id) as sessions FROM session WHERE id like '$expid%'";
	$rs1 = $db->query($query);	
	$rs1->firstRow();
	$sessions = $rs1->fields[sessions];
	if($sessions == ""){
		$sessions = 0;
	}
	
    //############ Show Pool Message #######
       	$db = new phpDB();
		$db->connect() or die ("Can't connect to database server or select database");
		$query = "SELECT target FROM experiment where id='$expid' ";
		$rs_pool = $db->query($query);
		$target = $rs_pool->fields[target];		       
		$message = show_pool_message($target);
		
        
	
	
	?> <table width="100%" cellpadding="3" cellspacing="0">
              <tr> 
                <td colspan="3" class="normal" height="16"><? echo $message; ?></td>
                
              </tr>
              <tr> 
                <td colspan="2" class="normal" height="16">Experiment ID : </td>
                <td width="65%" class="tablerow" height="16"><? echo $expid; ?></td>
              </tr>
              <tr> 
                <td colspan="2" class="normal" height="16" bgcolor="ffffcc">Experiment 
                  Title : </td>
                <td width="65%" class="tablerow" height="16" bgcolor="ffffcc"><? echo $title; ?></td>
              </tr>
              <tr> 
                <td colspan="2" class="normal" height="16">Number of Sessions you have created : </td>
                <td width="65%" class="tablerow" height="16"><? echo $sessions+0; ?></td>
                
              </tr>
		<tr> 
                <td colspan="2" class="normal" height="16" bgcolor="ffffcc">Session combination [ Note - see bottom ] : </td>
                <td width="65%" class="tablerow" height="16" bgcolor="ffffcc"><? echo $mode; ?></td>
                
              </tr>

              <tr> 
                <td colspan="2" class="normal" height="16">Number of Sessions to be added :
                </td>
                <td width="65%" class="tablerow" height="16"> <? echo ($totalsessions-$sessions); ?></td>
                
              </tr>
              
              <tr> 
                <td colspan="3"> 
                  <table width="100%" cellpadding="2" cellspacing="0" border="1" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC" bordercolor="#CCCCCC">
                    <tr> 
                      <td width="8%" class="tablecolumn" bgcolor="#000099" valign="top" height="21">Select</td>
                      <td width="60%" class="tablecolumn" bgcolor="#000099" valign="top" height="21">Session Title</td>
                      
                      <td width="22%" class="tablecolumn" bgcolor="#000099" valign="top" height="21">Created/Modified On</td>
                      
                      
                      
                    </tr>
              <?
              		
        		$query = "SELECT id, title,UNIX_TIMESTAMP(dateCreated) as dateCreated FROM session WHERE id like '$expid%' order by id asc";
			//echo $query;
			$rs = $db->query($query);	
			$num = $rs->getNumOfRows();  
			if($num == 0){?>

		 <tr>
  		  <td width="100%" colspan="5" class="normal">No session has been created</td>
  		  	</tr>
  
	<?
	}else{    
               for($i=1; $i<= $num; $i++){
               		
               		$rs->moveRow($i-1);
			$sessionid = $rs->fields[id];
			$title=$rs->fields[title];
			$description = $rs->fields[description];
			$createdon = date("jM Y", $rs->fields[dateCreated]);
			
	     ?>  		 
                    <tr> 
                      <td width="8%" valign="top"> 
                        <div align="center"> 
                          <input type="radio" name="mysessionid" value="<? echo $sessionid; ?>">
                        </div>
                      </td>
                      <td width="60%" class="normal" valign="top"><!-- Session <? echo $i-1+1; ?>: --><? echo $title; ?></a></td>
                     <? /* 
                     <td width="40%" class="normal" valign="top"><? echo $description; ?></td>
                     
                     */ ?>
                      <td width="22%" class="normal" valign="top"><? echo $createdon; ?></td>
                      
                      
                    </tr>
                    <?
                }
        }
        
                    ?>
                    </table>
                  
                  <?
                  

return $mode."->".$target."->".$pool;
}

function check_session_no($expid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select sessions from experiment where id = '$expid'";
	
	$rs = $db->query($query);
	$rs->firstRow();
	$expsessionno = $rs->fields[sessions];
	
	$query = "select count(id) as total from session where id like '$expid%'";
	
	$rs1 = $db->query($query);
	$rs1->firstRow();
	$total = $rs1->fields[total];
	
	if($total+0 < $expsessionno+0){
		return true;
	}else{
		message(T0091, "Session_Management.php");
		return false;
	}
}



	



	
//function to add or update the session
function add_session($queryStr){

	//To Check whether the session added exceed the session no.
	$submit = $queryStr[7];
	$submit = explode("-", $submit);
	$submit = $submit[0];
	
	//To Check whehter we send mail to subjects after modification
	$sendmail = $queryStr[8];
	
	if ($submit != "Modify"){
		check_session_no($queryStr[0]);
	}
	if($submit != "Add"){
		$submitStr = explode("-", $queryStr[7]);
		$sessionid = $submitStr[1];
	}
	
	$expid = $queryStr[0];

	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	
	$query = "SELECT max(id) as id FROM session WHERE id like '$expid%'";
	$rs = $db->query($query);
	$rs->firstRow();
	$maxid=$rs->fields[id] + 1;
	
	
	if($maxid == 1)
		$maxid=$expid."01";
	$duration_time = explode("-", $queryStr[4]);
	$enddate_timestamp = ($duration_time[0]*24*60*60) + ($duration_time[1]*60*60) + ($duration_time[2]*60) + (24*3600);	
	
	if($submit == "Add"){
		
		//########### Add ##############
		$query = "insert into session (id, title, reward, fromdate, durationEnd, enddate, venue, quota, dateCreated) values ('$maxid', '$queryStr[1]', '$queryStr[2]', '$queryStr[3]', '$queryStr[4]', FROM_UNIXTIME(UNIX_TIMESTAMP($queryStr[3])+$enddate_timestamp)
, '$queryStr[5]', '$queryStr[6]' ,now("."))";
		$rs = $db->query($query);
	}else{
		//########### Modify #############				
		$query = "update session set title='$queryStr[1]', reward='$queryStr[2]', fromdate='$queryStr[3]', durationEnd='$queryStr[4]', enddate=FROM_UNIXTIME(UNIX_TIMESTAMP($queryStr[3])+$enddate_timestamp), venue='$queryStr[5]' where id=$sessionid";
		$rs = $db->query($query);
		if ($sendmail=="on"){
			mail_modsess($expid, $sessionid);
		}
	}
	   
	
	

	//to count the total sessions
	$query = "select sessions from experiment where id = '$expid'";
	$rs = $db->query($query);
	$rs->firstRow();
	$expsessionno = $rs->fields[sessions];
	
	$query = "select count(id) as total from session where id like '$expid%'";
	
	$rs1 = $db->query($query);
	$rs1->firstRow();
	$total = $rs1->fields[total];
	if($submit != "Add")
		$submit = "Updated";	
	$link = "Add_Session.php"; 
	if($rs){
		if($submit == "Add"){
			if($total+0 == $expsessionno+0){
				
				//Send mail to subject
				mail_newexp($expid);
			}
		
			$remindsession = $expsessionno - $total;
			$msg = T0094."<br>The session has been added.<br>\n";
			if($remindsession == 0){
				//All sessions are added
				$msg .="You have added all the sessions. <p> e-Recruit will automatically send the information of this experiment to subscribers in the mailing lists in a few minutes. Around 24-48 hours before each session is started, e-Recruit will send a <font colo
r=\"#FF0000\">reminder email</font> to all signed-up subjects.";
				$link = "Session_Management.php";
				message($msg, $link);		
			}else{  //Some sessions are not added
				$msg .= "Number of Sessions you still need to add: <font color=\"#FF0000\">$remindsession </font><br>\n";
				$msg .= "Do you want to add another session NOW?";
				$msg .= "<ol><li><a href=\"$link?modifyold=$maxid\">Yes, I want to add it by modifying from the session just added.</a></li>";
				$msg .= "<li><a href=\"$link\">Yes, I want to add a totally NEW session.</a></li>";
				$msg .= "<li><a href=\"Session_Management.php\">No, I'll do it LATER.</a></li></ol> ";
				$link = "Session_Management.php";
				message_nobut($msg, $link);
			}
		}else{
			$msg = "T0096<br>The session is $submit.";
			$link = "Session_Management.php";
			message($msg, $link);			
		}
		
	}
	else
		warning(T0092);
}


//function to show the number of session
function show_session_no($expid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select count(id) as total from session where id like '$expid%'";
	$rs1 = $db->query($query);
	$rs1->firstRow();
	$total = $rs1->fields[total];
	
	return $total+1;
}



function view_session_layout($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT * FROM session WHERE id=$sessionid";
	$rs = $db->query($query);	
	$rs->firstRow();
	$title = $rs->fields[title];
	$rewardStr= $rs->fields[reward];
	$vennue = $rs->fields[venue];
	$quota= $rs->fields[quota];
	$startime = $rs->fields[fromdate];
	$endtime= $rs->fields[durationEnd];
	$rewards = explode("->", $rewardStr);
	if($rewards[0] == "money"){
		$money = "money";
		$money1 = $rewards[1];
		$money2 = $rewards[2];
	}else if($rewards[0] == "credit"){
		$credit = "credit";
		$credit1 = $rewards[1];
		$credit2 = $rewards[2];
	}else if($rewards[0] == "creditmoney"){
		$creditmoney = "creditmoney";
		$creditmoney1 = $rewards[1];
		$creditmoney2 = $rewards[2];
		$creditmoney3 = $rewards[3];
		$creditmoney4 = $rewards[4];	
	}else if($rewards[0] == "Not specified"){
		$no = "Not specified";
	}

	$year = substr($startime, 0, 4);
	$month = substr($startime, 4, 2);
	$date = substr($startime, 6, 2);	
	
	$starthour = substr($startime, 8, 2);
	$startmin = substr($startime, 10, 2);

	$duration = explode("-", $endtime);
	
	$duration1 = $duration[0];
	$duration2= $duration[1];
	$duration3 = $duration[2];	


	?>
	
	<table width="100%" cellpadding="3" cellspacing="0" border="0">
              <tr> 
                <td width="15%" valign="top" class="normal">Title: </td>
                <td width="85%" class="normal"> 
                  <? 
                     echo "$title";
                     echo "<input type=\"hidden\" name=\"title\" value=\"$title\">";
                  ?>
                </td>
              </tr>
              <tr> 
                <td width="15%" valign="top" class="normal" bgcolor="ffffcc" height="122">Reward 
                  Type :</td>
                <td width="85%" height="122" bgcolor="ffffcc"> 
                  <table width="100%" cellpadding="3" border="0" cellspacing="0" bgcolor="ffffcc">
                    <tr> 
                      <td width="21%" class="normal" valign="top"> 
                        <input type="radio" name="reward" value="money"  <? if(isset($money)) echo "checked"; ?> >
                        Money:</td>
                      <td width="79%" class="normal"> 
                        <select name="money1">
                         <option selected value="<? echo $money1; ?>"><? echo $money1; ?></option>
                          <option value="A fixed">A fixed</option>
                          <option value="A maximum" >A maximum</option>
                          <option value="A minimum">A minimum</option>
                          <option value="An average">An average</option>
                        </select>
                         amount of 
                        <input type="text" name="money2" value="<? echo $money2; ?>" size="8"> (e.g. HK$100.00) will be given to participants. </td>
                    </tr>
                    <tr> 
                      <td colspan="2" class="normal" valign="top"> 
                        <hr noshade width="100%" size="1">
                      </td>
                    </tr>
                    <tr> 
                      <td width="21%" class="normal" valign="top"> 
                        <input type="radio" name="reward" value="credit"  <? if(isset($credit)) echo "checked"; ?>>
                        Credit: </td>
                      <td width="79%" class="normal"> 
                        <select name="credit1">
                        <option selected value="<? echo $credit1; ?>"><? echo $credit1; ?></option>
                          <option value="A fixed">A fixed</option>
                          <option value="A maximum" >A maximum</option>
                          <option value="A minimum">A minimum</option>
                          <option value="An average">An average</option>
                        </select>
                        number of 
                         <input type="text" name="credit2" value="<? echo $credit2; ?>" size="8"> (e.g. 4)
                        credit(s) will be given to participants. </td>
                    </tr>
                    <tr> 
                      <td colspan="2" class="normal" valign="top">
                        <hr noshade width="100%" size="1">
                      </td>
                    </tr>
                    <tr> 
                      <td width="21%" class="normal" valign="top"> 
                        <input type="radio" name="reward" value="creditmoney" <? if(isset($creditmoney)) echo "checked"; ?>>
                        Credit &amp; Money :</td>
                      <td width="79%" class="normal"> 
                        <select name="creditmoney1">
                        <option selected value="<? echo $creditmoney1; ?>"><? echo $creditmoney1; ?></option>
                          <option value="A fixed">A fixed</option>
                          <option value="A maximum" >A maximum</option>
                          <option value="A minimum">A minimum</option>
                          <option value="An average">An average</option>
                        </select>
                        amount of 
                        <input type="text" name="creditmoney2" value="<? echo $creditmoney2; ?>" size="8"> (e.g. HK$100.00)
                        AND <br>
                        <select name="creditmoney3">
                          <option selected value="<? echo $creditmoney3; ?>"><? echo $creditmoney3; ?></option>
                          <option value="A fixed">a fixed</option>
                          <option value="A maximum" >a maximum</option>
                          <option value="A minimum">a minimum</option>
                          <option value="An average">an average</option>
                        </select>
                        number of 
                        <input type="text" name="creditmoney4" value="<? echo $creditmoney4; ?>" size="8"> (e.g. 4)
                        credit(s) will be given to participants. </td>
                    </tr>
                    <tr> 
                      <td colspan="2" class="normal" valign="top">
                        <hr noshade width="100%" size="1">
                      </td>
                    </tr>
                    <tr> 
                      <td width="21%" class="normal" valign="top">
                        <input type="radio" name="reward" value="Not specified" <? if(isset($no)) echo "checked"; ?>>Not specified
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td width="15%" valign="top" class="normal">Date :</td>
                <td width="85%"> 
                  <select name="date">
                  <option selected value="<? echo $date; ?>"><? echo $date; ?></option>
                  <?
                  	for($i=1; $i<=31; $i++){
                  		if($i <10){
                  			$j = "0".$i;
                  		}
                  		else{
                  			$j = $i;
                  		}
                  		
                  		
                  		echo "<option value=\"$j\">$j</option>\n";
                  	}
                  ?>
                  </select>
                  <select name="month">
                  
                  <?
                  	
                  	$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                  	?> <option selected value="<? 
                  					if ( isset($month) ){
                  						echo $month;                  						
                  					}
                  				   ?>">
                  	<? echo $months[$month-1]; ?></option> <?
                  	for($i=0; $i<12; $i++){
                  		$j=$i+1;
                  		if($j <10)
                  			$k = "0".$j;
                  		else
                  			$k = $j;
                  		echo "<option value=\"$k\">$months[$i]</option>\n";
                  	}
                  ?>

                  </select>
                  <select name="year">
                  <option selected value="<? echo $year; ?>"><? echo $year; ?></option>
                  <?
                  	for($i=2000; $i<=2050; $i++){
                  		echo "<option value=\"$i\">$i</option>\n";
                  	}
                  ?>

                  </select>
                </td>
              </tr>
              <tr bgcolor="ffffcc"> 
                <td width="15%" valign="top" class="normal">Start Time :</td>
                <td width="85%" valign="top" class="normal"> 
                  <!-- input type="text" name="starttime" value="<? if($sessionid!="")  echo $starttime; else echo "HH:MM"; ?>">(24-Hour Format) -->
                <select name="starthour">
                        <option selected value="<?if($sessionid!="")  echo $starthour; else echo ""; ?>"><? echo $starthour; ?></option>
                        <? for($i=0; $i<=23; $i++){
                        	if ($i<10){
                        		echo "<option value=\"0$i\">0$i</option>\n";
                        	}
                        	else{
                        		echo "<option value=\"$i\">$i</option>\n";
                        	}
                           }
                        ?>
                  </select> : 
                  <select name="startmin">                  
                           <option selected value="<?if($sessionid!="")  echo $startmin; else echo ""; ?>"><? echo $startmin; ?></option>
                        <? for($i=0; $i<=59; $i++){
                        	if ($i<10){
                        		echo "<option value=\"0$i\">0$i</option>\n";
                        	}
                        	else{
                        		echo "<option value=\"$i\">$i</option>\n";
                        	}
                           }
                        ?>
                  </select>(24-Hour Format)
                </td>
              </tr>
              <tr> 
                <td width="15%" valign="top" class="normal">Approximate Duration 
                  :</td>
                <td width="85%" class="normal"> 
                  <!-- input type="text" name="duration1" size="5" value="<? echo $duration1; ?>" -->
                  <select name="duration1">
                  <option selected value="<? echo $duration1; ?>"><? echo $duration1; ?></option>
                  <?
                  	for($i=0; $i<=200; $i++){
                  		echo "<option value=\"$i\">$i</option>\n";
                  	}
                  ?>

                  </select>
                  day(s) 
                  <!-- input type="text" name="duration2" size="5" value="<? echo $duration2; ?>" -->
                  <select name="duration2">
                  <option selected value="<? echo $duration2; ?>"><? echo $duration2; ?></option>
                  <?
                  	for($i=0; $i<=23; $i++){
                  		echo "<option value=\"$i\">$i</option>\n";
                  	}
                  ?>

                  </select>
                  hour(s) 
                  <!-- input type="text" name="duration3" size="5" value="<? echo $duration3; ?>" -->
                  <select name="duration3">
                  <option selected value="<? echo $duration3; ?>"><? echo $duration3; ?></option>
                  <?
                  	for($i=0; $i<=59; $i++){
                  		echo "<option value=\"$i\">$i</option>\n";
                  	}
                  ?>
                  </select>
                  minute(s) </td>
              </tr>
              
              <tr bgcolor="ffffcc"> 
                <td width="15%" valign="top" class="normal">Quota :</td>
                <td width="85%"> <? echo $quota; ?> </td>
                <input type="hidden" name="quota" value="<? echo $quota; ?>">
              </tr>
              
              <tr> 
                <td width="15%" valign="top" class="normal">Venue :</td>
                <td width="85%" valign="top" class="normal"> 
                  <input type="text" name="vennue" value="<? echo $vennue; ?>"> (e.g. <? echo ORG_SHORT; ?> RM 4115A)
                </td>
              </tr>          
          <tr bgcolor="ffffcc">
           <td colspan="2" class="normal">
           <input type="checkbox" name="sendmail" value="on"> 
           I would like e-Recruit to send email to notify the subjects about this modification automatically 
           </td>
          </tr> 
              <tr> 
                <td width="15%" valign="top">&nbsp;</td>
                <td width="85%">
                  <div align="right">
                    <input type="submit" name="submit" value="Modify">
                    <input type="reset" name="reset" value="Reset">
                  </div>
                </td>
              </tr>
             <tr>
             <td colspan="2" width="100%">
             
             </td>
             </tr> 
            

             </table>
<?
}



function list_all_signed_subject($sessionid, $selectall, $plaintext){
	
	
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select quota from session where id=$sessionid";

	$rs=$db->query($query);
	$rs->firstRow();
	$quota = $rs->fields[quota];
	$query = "select mode from experiment where id=".substr($sessionid, 0, 8);

	$rs=$db->query($query);
	$rs->firstRow();
	
	$mode = $rs->fields[mode];
	
	$query = "select W.loginName from waitingList W, subject S where W.sessionid=$sessionid AND W.loginName=S.loginName order by W.signOn, S.lastName, S.firstName limit 0, $quota";
	$rs = $db->query($query);	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i< $numOfRows; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		$query1 = "Select firstName, lastName, sex, phone, email, hkust from subject where loginName='$loginName'";		
		$rs1 = $db->query($query1);	
		$rs1->firstRow();
		$firstName = $rs1->fields[firstName];
		$lastName = $rs1->fields[lastName];
		$sex = $rs1->fields[sex];
		
		$phone = $rs1->fields[phone];
		if(trim($phone) == ""){
			$phone = "&nbsp;";
		}
		
		$email = $rs1->fields[email];
		if(trim($email) == ""){
			$email = "&nbsp;";
		}
		
		$hkust_sub = $rs1->fields[hkust];
		
		if ($hkust_sub=="0"){
			$hkust_sub = "No";
		}
		else{
			$hkust_sub = "Yes";
		}
		
		if($plaintext!="yes"){
		?>
			<tr valign="top"> 
       	         	  	<td width="12%"><div align="center">
		                    <input type="checkbox" name="checkbox<? echo $i; ?>" <? if($selectall!="") echo "checked"; ?>>
        	      				</div>
                		</td>                
		                	<input type="hidden" name="loginName<? echo $i; ?>" value="<? echo $loginName; ?>">                
		                <td width="18%" class="normal"><? echo $firstName; ?></td>
                		<td width="18%" class="normal"><? echo $lastName; ?></td>
                		<td width="12%" class="normal"><? echo $sex; ?></td>
                		<td width="12%" class="normal"><? echo $phone; ?></td>
                		<td width="21%" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                 		<input type="hidden" name="email<? echo $i; ?>" value="<? echo $email; ?>">
                		<td width="7%" class="normal">No</td>
                		<td width="7%" class="normal"><? echo $hkust_sub; ?></td>
              		</tr>
              <?
        	} //plaintext is NOT YES
        	else{
        		echo $firstName.",".$lastName.",".$sex.",".$phone.",".$email.","."No".",".$hkust_sub."<br>";
        	} //plaintext is YES
        
	} //for
	
	$query = "select W.loginName from waitingList W, subject S where W.sessionid=$sessionid AND W.loginName=S.loginName order by W.signOn, S.lastName, S.firstName limit $quota, 999";
	$rs = $db->query($query);	
	$numOfRows1 = $rs->getNumOfRows();
	for($i=$numOfRows; $i< $numOfRows + $numOfRows1; $i++){
		$rs->moveRow($i-$numOfRows);
		$loginName = $rs->fields[loginName];
		$query1 = "Select firstName, lastName, sex, phone, email, hkust from subject where loginName='$loginName'";
		$rs1 = $db->query($query1);	
		$rs1->firstRow();
		$firstName = $rs1->fields[firstName];
		$lastName = $rs1->fields[lastName];
		$sex = $rs1->fields[sex];
		$phone = $rs1->fields[phone];
		if(trim($phone) == ""){
			$phone = "&nbsp;";
		}
		
		$email = $rs1->fields[email];
		if(trim($email) == ""){
			$email = "&nbsp;";
		}
		
		$hkust_sub = $rs1->fields[hkust];
		if ($hkust_sub=="0"){
			$hkust_sub = "No";
		}
		else{
			$hkust_sub = "Yes";
		}
		
		if($plaintext!="yes"){
		?>
			<tr valign="top"> 	
                		<td width="12%"><div align="center">
                    			<input type="checkbox" name="checkbox<? echo $i; ?>" <? if($selectall!="") echo "checked"; ?>>
                  			</div>
                		</td>               
                		<input type="hidden" name="loginName<? echo $i; ?>" value="<? echo $loginName; ?>">
                		<td width="18%" class="normal"><? echo $firstName; ?></td>
                		<td width="18%" class="normal"><? echo $lastName; ?></td>
                		<td width="12%" class="normal"><? echo $sex; ?></td>
                		<td width="12%" class="normal"><? echo $phone; ?></td>
                		<td width="21%" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                		<td width="7%" class="normal">Yes</td>
                		<td width="7%" class="normal"><? echo $hkust_sub; ?></td>
              		</tr>
              <?
              	} //plaintext is NOT YES
        	else{
        		echo $firstName.",".$lastName.",".$sex.",".$phone.",".$email.","."No".",".$hkust_sub."<br>";
        	} //plaintext is YES
	}
	$total = $numOfRows + $numOfRows1;
	if($total == 0){
	?>
		 <tr>
  		  <td width="100%" colspan="8" class="normal">No subject has signed up</td>
  		 </tr>  
	<?
	}else{  
		echo "<input type=\"hidden\" name=\"total\" value=\"$total\">";
	}
}

function list_all_credit_subjects($sessionid, $selectall){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select quota from session where id=$sessionid";
	$rs=$db->query($query);
	$rs->firstRow();
	$quota = $rs->fields[quota];
	$query = "select mode from experiment where id=".substr($sessionid, 0, 8);
	$rs=$db->query($query);
	$rs->firstRow();
	
	$mode = $rs->fields[mode];
	
	if($mode =="All"){
		$sessionid = substr($sessionid, 0, 8);
	}
	
	
	
	
	$query = "select loginName from waitingList where sessionid=$sessionid order by signOn limit 0, $quota";
	//echo $query;
	$rs = $db->query($query);	
	$numOfRows = $rs->getNumOfRows();
	
	for($i=0; $i< $numOfRows; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];
		$query1 = "Select firstName, lastName, sex, phone, email from subject where loginName='$loginName'";
		$rs1 = $db->query($query1);	
		$rs1->firstRow();
		$firstName = $rs1->fields[firstName];
		$lastName = $rs1->fields[lastName];
		$sex = $rs1->fields[sex];
		$phone = $rs1->fields[phone];
		if(trim($phone) == ""){
			$phone = "&nbsp;";
		}
		
		$email = $rs1->fields[email];
		if(trim($email) == ""){
			$email = "&nbsp;";
		}
		?>

		<tr valign="top"> 
                <td width="9%"> 
                  <div align="center"> 
                    <input type="checkbox" name="checkbox<? echo $i; ?>"  <? if($selectall != "") echo "checked"; ?>>
                  </div>
                </td>
                <td width="19%" class="normal"><? echo $firstName; ?></td>
                <input type="hidden" name="loginName<? echo $i; ?>" value="<? echo $loginName; ?>">
                <td width="12%" class="normal"><? echo $lastName; ?></td>
                <td width="6%" class="normal"><? echo $sex; ?></td>
                <td width="10%" class="normal"><? echo $phone; ?></td>
                <td width="23%" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                <td width="21%" class="normal"> 
                  <div align="center">
                    <input type="text" name="credit<? echo $i; ?>" maxlength="2" size="5">
                  </div>
                </td>
              </tr>
		<?

	}
	if($numOfRows == 0){?>

		 <tr>
  		  <td width="100%" colspan="7" class="normal">No subject has signed Up</td>
  		  	</tr>
  
	<?
	}
echo "<input type=\"hidden\" name=\"total\" value=\"$numOfRows\">";
}


function  list_all_attend_subjects($sessionid, $selectall,$AssignCredit){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select quota from session where id=$sessionid";
	//echo $query;
	$rs=$db->query($query);
	$rs->firstRow();
	$quota = $rs->fields[quota];
	
	$query_enrolled = "select W.loginName from waitingList W, subject S where W.sessionid=$sessionid AND W.loginName=S.loginName order by W.signOn, S.lastName, S.firstName limit 0, $quota";
	
	$rs = $db->query($query_enrolled);			
	$numOfRows = $rs->getNumOfRows();
	for($i=0; $i< $numOfRows; $i++){
		$rs->moveRow($i);
		$loginName = $rs->fields[loginName];		
		$query1 = "Select firstName, lastName, sex, phone, email from subject where loginName='$loginName'";
		$rs1 = $db->query($query1);	
		$rs1->firstRow();
		$firstName = $rs1->fields[firstName];
		$lastName = $rs1->fields[lastName];
		$sex = $rs1->fields[sex];
		$phone = $rs1->fields[phone];
		if(trim($phone) == ""){
			$phone = "&nbsp;";
		}
		
		$email = $rs1->fields[email];
		if(trim($email) == ""){
			$email = "&nbsp;";
		}
		
		if ($AssignCredit != "false" || isTakenAttendency($sessionid)!=0 ){ 
			$query_credit_earned = "select credit from credit where loginName='$loginName' and sessionid=$sessionid";
			$rs1 = $db->query($query_credit_earned);	
			$rs1->firstRow();
			$credit_earned = $rs1->fields[credit];	
			
			$query_attend = "select attendancy from attendancy where loginName='$loginName' and sessionid=$sessionid";
			$rs1 = $db->query($query_attend);	
			$rs1->firstRow();
			$attend = $rs1->fields[attendancy];					
		}	
	
	?>
		 <tr valign="top"> 	      
              	
              
              <? 
                if (isTakenAttendency($sessionid)==0){ 
              ?>
              	<td width="6" align="center">
                    <input type="checkbox" name="checkbox<? echo $i?>" <? if($selectall != "") echo "checked"; ?>>
                  </td>
              <? }
 		
               ?>  
                <input type="hidden" name="loginName<? echo $i; ?>" value="<? echo $loginName; ?>">
                <td width="22%" class="normal"><? echo $firstName; ?></td>
                <td width="12%" class="normal"><? echo $lastName; ?></td>
                <td width="5%" class="normal"><? echo $sex; ?></td>
                <td width="10%" class="normal"><? echo $phone; ?></td>
                <td width="23%" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                <? if ($AssignCredit != "false"){ ?>
                	<td width="10%" class="normal">
                		<? if (isTakenAttendency($sessionid)==0){ ?>
                			<input type="text" name="credit<? echo $i; ?>" maxlength="5" size="5">
                		<? }
                		   else{ 
                			echo $credit_earned;
                		   }
                		?>	
                		   
                		   
             		</td>
		<? } ?>                	
                <td width="25%" class ="normal"> 
                <? if (isTakenAttendency($sessionid)==0){ ?>
	                  <select name="attend<? echo $i?>">
                    		<option selected value="yes->experienced">Yes, count him/her as experienced</option>
                    		<option value="yes->inexperienced">Yes, count him/her as inexperienced</option>
	                    	
	                    	<!-- option value="yes->partially experienced">Yes, count him/her as partially experienced</option -->
                    		<option value="no->no">No</option>
	                  </select>
	        <? }
	           else{
	        		echo $attend;   
	           }
	        ?>
                  </td>
                <td width="23%" class="normal">No</td>
                
              </tr>
              
              <?
              
        }
        
       	//############### Count the number of subjects signed up (include waiting) ############3	
	$query = "select count(*) as num from waitingList where sessionid=$sessionid";
	$rs = $db->query($query);
	$num_sub_signed = $rs->fields[num];
	//echo $num_sub_signed;
	
	
	//############### new query (Wait) ##############
	$rs = $db->query($query_wait);	
	$numOfRows1 = $rs->getNumOfRows();
	for($i=$numOfRows; $i< $numOfRows + $numOfRows1; $i++){
		$rs->moveRow($i-$numOfRows);
		$loginName = $rs->fields[loginName];
		$query1 = "Select firstName, lastName, sex, phone, email from subject where loginName='$loginName'";
		$rs1 = $db->query($query1);	
		$rs1->firstRow();
		$firstName = $rs1->fields[firstName];
		$lastName = $rs1->fields[lastName];
		$sex = $rs1->fields[sex];
		$phone = $rs1->fields[phone];
		if(trim($phone) == ""){
			$phone = "&nbsp;";
		}
		
		$email = $rs1->fields[email];
		if(trim($email) == ""){
			$email = "&nbsp;";
		}
		if ($AssignCredit != "false" || isTakenAttendency($sessionid)!=0){ 
			$query_credit_earned = "select credit from credit where loginName='$loginName' and sessionid=$sessionid";
			$rs1 = $db->query($query_credit_earned);	
			$rs1->firstRow();
			$wait_credit_earned = $rs1->fields[credit];	
			
			$query_attend = "select attendancy from attendancy where loginName='$loginName' and sessionid=$sessionid";
			$rs1 = $db->query($query_attend);	
			$rs1->firstRow();
			$wait_attend = $rs1->fields[attendancy];	

		}
		

		?>
		 <tr valign="top"> 
              <? if (isTakenAttendency($sessionid)==0){ ?>
              	<td width="6" align="center">
                    <input type="checkbox" name="checkbox<? echo $i?>" <? if($selectall != "") echo "checked"; ?>>
                  </td>
              <? } ?>    
                
                <input type="hidden" name="loginName<? echo $i; ?>" value="<? echo $loginName; ?>">
                <td width="22%" class="normal"><? echo $firstName; ?></td>
                <td width="12%" class="normal"><? echo $lastName; ?></td>
                <td width="5%" class="normal"><? echo $sex; ?></td>
                <td width="10%" class="normal"><? echo $phone; ?></td>
                <td width="23%" class="normal"><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></td>
                <? if ($AssignCredit != "false"){ ?>
                	<td width="10%" class="normal">
                		<? if (isTakenAttendency($sessionid)==0){ ?>
                			<input type="text" name="credit<? echo $i; ?>" maxlength="5" size="5">
                		<? }
                		   else{ 
                			echo $wait_credit_earned;
                		   }
                		?>   	
                		   
                		   
             		</td>
		<? } ?>                	                
                <td width="25%" class="normal"> 
		<? if (isTakenAttendency($sessionid)==0){ ?>
	                  <select name="attend<? echo $i?>">
                    		<option selected value="yes->experienced">Yes, count him/her as experienced</option>
                    		<option value="yes->inexperienced">Yes, count him/her as inexperienced</option>
	                    	<!-- option value="yes->partially experienced">Yes, count him/her as partially experienced</option -->
                    		<option value="no->no">No</option>
	                  </select>
	        <? }
	           else{
	        		echo $wait_attend;   
	           }
	        ?>
                  </td>
                <td width="23%" class="normal">Yes</td>

              </tr>
              <?
	}
	$total = $numOfRows + $numOfRows1;
	if($total == 0){?>
		 <tr>
  		  <td width="100%" colspan="7" class="normal">No subject has signed up</td>
  		</tr>
  
	<?
	}else{  
		echo "<input type=\"hidden\" name=\"total\" value=\"$total\">";
	}

}


function pool_deadline($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$expid = substr($sessionid, 0,8);
	$query = "SELECT target FROM experiment WHERE id = '$expid' and enable='y'";
	$rs = $db->query($query);	
	$rs->firstRow();
	$targetid=$rs->fields[target];
	
	list($target, $pool) = explode("->", $targetid);
	
	$query = "SELECT UNIX_TIMESTAMP(deadline) as deadline from pool where id='$pool'";
	$rs = $db->query($query);
	$rs->firstRow();
	
	$deadline = date("jM Y", $rs->fields[deadline]);
	
	echo $deadline;
	
}

function expmail($expid, $exptitle, $description, $experimenters, $targetStr, $update){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	
	
	$target = explode("->", $targetStr);
	$exps = explode("->", $experimenters);
	$loginName = $exps[0];
	$query = "select firstName, lastName from experimenter where loginName='$loginName'";
	$rs = $db->query($query);
	$rs->firstRow();
	
	$expers = $rs->fields[firstName]." ".$rs->fields[lastName].", ";
	for($i=1; $i< sizeof($exps); $i++){
		$expers .= $exps[$i];
	}
	
	if($target[0]="All"){
		$query ="select email from subject where subscribe='Y'"; 
	}
	else{
		$query ="select email from subject where subscribe='Y' and hkust!='0'";
	}
	$rs = $db->query($query);	
	$numOfRows = $rs->getNumOfRows();
	
	if($update ==""){
		$subject = "New Experiment";
		$message="A new experiment has been added to e-Recruit. The details are:";
	}
	else{
		$subject = "Experiment Updated";
		$message="Experiment: $exptitle has been updated. The details are:";
		$message .="\n\t\tExperiment ID: $expid";
	}
	
	$message .="\n\t\tExperiment Title: $exptitle";
	$message .="\n\t\tExperimenter(s): $expers";
	$message .="\n\t\tDescription: $description";
	
		
	for($i=0; $i< $numOfRows; $i++){
		$rs->moveRow($i);
		$email = $rs->fields[email];
		
		mail($email, $subject, $message, "From: ".ADMIN_MAIL."\nReply-To: recruit@cebr.ust.hk\nX-Mailer: PHP/".phpversion());
		sleep(1);
	}
}

function show_experimenter_name($loginName){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select firstName, lastName from experimenter where loginName='$loginName'";
	$rs = $db->query($query);
	$rs->firstRow();
	
	return $rs->fields[firstName]." ".$rs->fields[lastName];
}

function show_experimenter_email($loginName){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select email from experimenter where loginName='$loginName'";
	$rs = $db->query($query);
	$rs->firstRow();
	
	return $rs->fields[email];
}


//this function is for send mail for the  following function
function show_subject_detail($loginName){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select firstName, lastName, phone, email from subject where loginName='$loginName'";
	$rs = $db->query($query);
	$rs->firstRow();
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$eamil = $rs->fields[email];
	$phone = $rs->fields[phone];
	
	return "$firstName,$lastName,$eamil,$phone";
	
}

	
	
//function to add the credit and send mail to system administrator
function add_credit($loginnames, $credits, $sessionid, $exploginName){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$expname = show_experimenter_name($exploginName);
	$expemail = show_experimenter_email($exploginName);
	$loginName = explode("->", $loginnames);
	$credit = explode("->", $credits);
	
	if(sizeof($loginName) == 0)
		exit();
	
	$expid = substr($sessionid, 0, 8);
	$query = "select target from experiment where id = '$expid'";
	
	$rs = $db->query($query);
	$rs->firstRow();
	list($type, $name) = explode("->", $rs->fields[target]);
	for($i=0; $i < sizeof($loginName); $i++){		
		if($loginName[$i] != "" && $credit[$i] !=""){
			$query = "select AssignCreditsto from signupexp where loginName='$loginName[$i]' and expid=".substr($sessionid, 0, 8);
			$rs = $db->query($query);			
			$course_in_pool = $rs->fields[AssignCreditsto];
			if ($type == "pool"){
				$query = "insert into credit (loginName, credit, sessionid, pool, course) values ('$loginName[$i]', '$credit[$i]', '$sessionid', '$name', '$course_in_pool')";
			}
			$rs = $db->query($query);
			$subjectStr .= show_subject_detail($loginName[$i]).",".$credit[$i]."\n";			
		}
		
	}
        $poolcor_info = get_poolcor_name($expid);
	$poolcor_info = explode("->", $poolcor_info);				

	$subject = "IMPORTANT: Credits Information for Subjects from e-Recruit";
	$receiver_name = $poolcor_info[0];
	$receiver_mail = $poolcor_info[1];	
	$msg = "Dear $receiver_name,

The following is the credit information an experimenter has submitted to e-Recruit. 
Please gather all related information for each student from all experimenters 
in your Pool and sent it to the respective course instructors.

You are advised to save this email. Though copies of it will be stored in a 
number of other places, in the unlikely event that e-Recruit fails and all 
contingent measures (i.e.,tape backup by the SBM technical team, etc.) do 
not help much, we may have to contact you for this email.  Thank you.

Regards,

System Administrator
		
The information is from the experiment session ".$sessionid." :\n\n";
	$msg .= "First Name,Last Name,Email,Phone,Credit(s)\n\n";
	$msg .= $subjectStr;
	$msg .="";		
	$m = new email ($subject, $msg, "e-Recruit System Administrator",ADMIN_MAIL, $poolcor_info[1], ADMIN_MAIL);
	$m->send();
	
	if (isPool($expid)){
		$poolcor_info = get_poolcor_name($expid);
		//echo $poolcor_info;
		$poolcor_info = explode("->", $poolcor_info);				
		$receiver_email = $expname;
		$receiver_name = "Experimenter";
		$msg = "Dear $receiver_name,

Please do NOT delete this email.

The following is the credit information you have submitted to e-Recruit. 
The System Adminstrator will gather all related information for each 
student from all experimenters in the Pool and sent it to the $poolname 
Pool Coordinator $poolcor_info[0].

You are advised to save this email. Though copies of it will be stored in a 
number of other places, in the unlikely event that e-Recruit fails and all 
contingent measures (i.e.,tape backup by the SBM technical team, etc.) do 
not help much, we may have to contact you for this email.  Thank you.

Regards,

System Administrator


		
The information is from your experiment session ".$sessionid." :\n\n";
		$msg .= "First Name,Last Name,Email,Phone,Credit(s)\n\n";
		$msg .= $subjectStr;
		$msg .="";		
		$m = new email ($subject, $msg, "e-Recruit System Administrator",ADMIN_MAIL,$expemail);
		$m->send();	
	}
	

}

//Check whether the session is in mode ALL
function isModeAll($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$expid = substr($sessionid, 0, 8);
	$query = "select mode from experiment where id = '$expid'";
	$rs = $db->query($query);
	$rs->firstRow();
	$mode = $rs->fields[mode];
	if ($mode == "All"){
		return "true";
	}
	else{
		return "false";
	}
}

	
//function to add the credit and send mail to system administrator
function update_addendancy($sessionid, $loginnames, $attendtypes, $exploginName){	
	$expname = show_experimenter_name($exploginName);
	$expemail = show_experimenter_email($exploginName);
	
	$loginName = explode("->", $loginnames);
	$attendtype = explode("->", $attendtypes);		
	if(sizeof($loginName) == 0)
		exit();
	
	$expid = substr($sessionid, 0, 8);
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");

	for($i=0; $i < sizeof($loginName); $i++){
		
		if($loginName[$i] != "" ){
			$query = "insert into attendancy (loginName,sessionid, attendancy ) values ('$loginName[$i]', '$sessionid', '$attendtype[$i]')";
			//echo $query;
			
			$rs = $db->query($query);
			
			$subjectStr .= show_subject_detail($loginName[$i]);
			$subjectStr .= ",$attendtype[$i]\n";
			
		}
		
	}
	$note = "Note : The \"Attendance\" column here is the same as the \"Subjects showed up?\" ".
		" column in the table for recording attendance. The values \"experienced\", \"inexperienced\", ".
		"and \"no\" refer to \"Yes, count him as experienced\", \"Yes, count him as inexperienced\", and \"no\", respectively.";
	$subject = "IMPORTANT: Attendance Information for Subjects from e-Recruit";
	$receiver_email = $expemail;	
	$receiver_name = "Experimenter";
	$msg = "Dear $receiver_name,
	
Please do NOT delete this email.

The following is the attendance information you have submitted to e-Recruit. 
Future experiments may benefit from this information in recruiting
experienced or inexperienced subjects.

You are advised to save this email. Though copies of it will be stored in a 
number of other places, in the unlikely event that e-Recruit fails and all 
contingent measures (i.e.,tape backup by the SBM technical team, etc.) do 
not help much, we may have to contact you for this email.  Thank you.

Regards,

System Administrator
		
	
Here is the information for your experiment session $sessionid :\n\n";
	$msg .= "First Name,Last Name,Email,Phone,Attendance\n";
	$msg .= $subjectStr;
	$msg .="";
	$msg .="\n\n$note";		
	$m = new email ($subject, $msg, "e-Recruit System Administrator", ADMIN_MAIL, $expemail, ADMIN_MAIL);	
	$m->send();
	
	if (isPool($expid)){
		$poolcor_info = get_poolcor_name($expid);
		$poolcor_info = explode("->", $poolcor_info);				
		$receiver_email = $poolcor_info[1];
		$receiver_name = $poolcor_info[0];
		$msg = "Dear $receiver_name,
		
Please do NOT delete this email.

The following is the attendance information an experimenter has submitted 
to e-Recruit. Future experiments may benefit from this information in 
recruiting experienced or inexperienced subjects.

You are advised to save this email. Though copies of it will be stored in a 
number of other places, in the unlikely event that e-Recruit fails and all 
contingent measures (i.e.,tape backup by the SBM technical team, etc.) do 
not help much, we may have to contact you for this email.  Thank you.

Regards,

System Administrator		
	
Here is the information for your experiment session $sessionid :\n\n";
		
	
		$msg .= "First Name,Last Name,Email,Phone,Attendance\n";
		$msg .= $subjectStr;
		$msg .="";		
		$msg .="\n\n$note";
		$m = new email ($subject, $msg, "e-Recruit System Administrator",ADMIN_MAIL, $receiver_email, ADMIN_MAIL);		
		$m->send();	
	}
	
}

function get_poolcor_name($expid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT target FROM experiment WHERE id=$expid";
	$rs = $db->query($query);
	$target = $rs->fields[target];
	$target = explode("->", $target);	
	$poolinfo = explode("--", $target[1]);	
	$id = $poolinfo[0];
	$query = "SELECT firstName, lastName, email FROM poolCoordinator WHERE pool='$id'";
	$rs = $db->query($query);
	$firstname = $rs->fields[firstName];
	$lastname = $rs->fields[lastName];
	$email = $rs->fields[email];
	return $firstname." ".$lastname."->".$email;
}
function isSelected($selected_value, $option_value){
	if ($selected_value==$option_value){
		echo"selected";
	}
}

//######## This Logic in this Function is wrong, DON"T USE
function isAssignCredit($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "SELECT * FROM session WHERE id=$sessionid";
	$rs = $db->query($query);	
	$rs->firstRow();
	$rewardStr= $rs->fields[reward];
	$rewards = explode("->", $rewardStr);
	if ($rewards[0] == "money"){
		return false;
	}
	else{
		return true;
	}
}

function Signupcode_Match($his_code, $type, $id){
	$id_sem_year = explode("--", $id);
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	if ($type=="course"){ 
		$idvar="courseID";
	}
	else if ($type=="pool"){
	 	$idvar="id";
	 }
	 
	//############## Note : authcode is used rather than signupcode  format : course--year--semester
	$query = "SELECT authcode FROM $type where $idvar='$id_sem_year[0]' AND semester='$id_sem_year[2]' AND year='$id_sem_year[1]'";
	$rs = $db->query($query);	
	$rs->firstRow();
	
	//############## Note : authcode is used rather than signupcode
	$true_code = $rs->fields[authcode];
	
	if ($true_code == $his_code){
		return true;
	}
	else{
		return false;	
	}
}

function show_pool_message($target){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");

	//############ Get Pool Message ######### format : pool--year--semester
	$pool_info = explode("->", $target);
	
	if ($pool_info[0]=="pool"){		
		$pool_info2 = explode("--", $pool_info[1]);
		$query_pool = "SELECT message FROM pool where id='$pool_info2[0]' AND semester='$pool_info2[2]' AND year='$pool_info2[1]'";
		$rs_pool = $db->query($query_pool);
		$pool_message = $rs_pool->fields[message];
		return "".$pool_message;
	}
	else
		return "";
}
	
	
function isTakenAttendency($sessionid){
	$db = new phpDB();	
	$db->connect() or die ("Can't connect to database server or select database");	
	$query = "SELECT count(*) as count FROM attendancy WHERE sessionid = $sessionid";
	$rs = $db->query($query);
	$count = $rs->fields[count];
	return $count;
}

//################# Used in Add_Experiment to let the experiment to modify the others epxeriments ################
function experimentDetail_to_modify($expid, $loginName, $target, $import){
	
$db = new phpDB();
$db->connect() or die ("Can't connect to database server or select database");

//############### Use Commna to separate exp. ############
$pre2 = "Session ID(s), seperated by COMMA";
$pre5 = "Session ID(s), seperated by COMMA";


//############# Modify the old experiment ############
if($expid !=""){
	global $expprofile;
	$login_var = explode("-", $expprofile);
	$loginName = $login_var[0];
		
      if ($import=="yes"){
	$query = "SELECT * FROM experiment WHERE id = $expid";		
	$rs = $db->query($query);	
	$experimenters = $rs->fields[experimenters];
	$rep = $loginName."->";
	
	$experimenters = str_replace($rep, "", $experimenters);
	
	$otherexp = ereg_replace("->", ",", $experimenters);	// other experimenters' name
	
	$title = $rs->fields[title];		// experiment title
	$mode	 = $rs->fields[mode];	// one/all/any
	
	$sessions = $rs->fields[sessions];	// no. of sessions
	$software = $rs->fields[software];	// software
	$preRequisite =$rs->fields[preRequisite];	// yes /no
	
	if($preRequisite !="no"){
		$preReqStr = explode("->", $preRequisite);
		$preRequisite = $preReqStr[0];
	
		$pre1    = $preReqStr[1];		// have/ have_not
		$any_all = $preReqStr[2];
		$pre2    = $preReqStr[3];		// participant past sessions
		$pre3    = $preReqStr[4];		// and / or
		$pre4    = $preReqStr[5];		// have /have_not
		$any_all2= $preReqStr[6];
		$pre5    = $preReqStr[7];		// participant past sessions
	}
	
	$description = $rs->fields[description];	// exp description
	$targetid    = $rs->fields[target];	// target participant: open/ restrict
	
	list($target, $target2) = explode("->", $targetid);
	if($target == "course"){
		$course=$target2;
	}	
	if($target == "pool"){
		$pool=$target2;
	}	
	$rs->close();		
	$db->close();	/*	optional	*/
      }//import if

}
	?>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	    <? //################# Display Pool Message #############
	       
	       $pool_message = show_pool_message($target);
	       if ($pool_message != ""){
               //If (isset($pool_message)){ 
            ?>
	       <tr>
          		<td width="27%" valign="top" class="normal" colspan="2" >Pool Message: 
        		<? echo $pool_message; ?>
        		</td>
        	</tr>
	    <? } ?>
	 
          <!-- ################### Add Prerequest Note ########### -->

          
          
          <tr>
        <td class="normal" bgcolor="ffffcc" colspan="2">
        <font color="red">Step 3: </font>
        </td>        
        </tr>
          
        
          <tr> 
            <td width="27%" valign="top" class="normal" >Experiment Created by:</td>
            <td  class="normal" width="73%" valign="top" > 
              <?
              $login_var = explode("-", $expprofile);
	      if(!isset($loginName))
			$loginName = $login_var[0]; 
              $returnval = show_experimenter_name($loginName);
              echo $returnval;
               ?>
               </td>
          </tr>
         
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc">Experimenters :</td>
            <td class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <input type="text" name="otherexp" value="<? echo $otherexp; ?>">
              (e.g. Gary Cheung, Peter Chan) </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" >Experiment Title :</td>
            <td class="normal" width="73%" valign="top" > 
              <input type="text" name="exptitle" value="<? echo $title; ?>">
            </td>
          </tr>
          <tr> 
                 <td width="27%" valign="top" class="normal" bgcolor="ffffcc"><a name="back1"><font class = "noteindicator"> # </font>Session Combination :</a><br> [<a href="<? echo $PHP_SELF; ?>#Note1">Note 1 - see bottom</a>]</td>
            <td class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <select name="mode">
                <option selected value="<? echo $mode; ?>"><? echo $mode; ?></option>
                <option value="One">One</option>
                <option value="All">All</option>
                <option value="Any">Any</option>
              </select>
              </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" ><font class = "noteindicator"> # </font>Total 
              No. of Sessions : </td>
            <td class="normal" width="73%" valign="top" > 
              <select name="sessions">
              <option selected value="<? echo $sessions; ?>"><? echo $sessions; ?></option>
              <?
              	for($i=1; $i<100; $i++){
              		echo "<option value=\"$i\">$i</option>\n";
              	}
              ?>	
              </select>
            </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc"><font class="noteindicator"> * </font>Experiment Software :</td>
            <td class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <input type="text" name="software" value="<? echo $software; ?>">
            </td>
          </tr>
          <tr> 
            <td width="27%" valign="top" class="normal" ><a name="back2"><font class = "noteindicator"> # </font>Prerequisites :<br>
              [<a href="<? echo $PHP_SELF; ?>#Note2">Note 2 - see bottom</a>]</td>
            <td class="normal" width="73%" valign="top" > 
              <table width="100%" cellpadding="2" cellspacing="0" border="0">
                <tr> 
                  <td class="normal" valign="top" colspan="2">
                  <?
                    if ($import=="yes"){
                    	echo "<input type=\"radio\" name=\"preRequisite\" value=\"yes\" ";
                    	 if ($preRequisite=="yes"){ 
                    	 	echo "checked";
                    	 } 
                    	echo ">";
                    }
                    else{
                    	echo "<input type=\"radio\" name=\"preRequisite\" value=\"yes\"> ";
                    }
                  ?>
                    Yes
                  </td>              
                <tr>
                  <td class="normal" colspan="2">
                  The target subjects should be : <br>
                    <select name="pre1">
                      <option selected value="<? echo "$pre1"; ?>" ><? echo "$pre1"; ?></option>
                      <option value="experienced">experienced</option>
                      <option value="inexperienced">inexperienced</option>
                    </select>
                     to 
                    <select name="any_all">
                       
                       <option value="any" <? if ($any_all=="any"){ echo "selected"; }?>>any</option>
                       <option value="all" <? if ($any_all=="all"){ echo "selected"; }?>>all</option>
                    </select> of the session(s):
                    <input type="text" name="pre2" size="50" value="<? echo "$pre2";?>">  
                    <select name="pre3">
                     <option selected value="<? echo "$pre3"; ?>" ><? echo "$pre3"; ?></option>
                      <option value="and">and</option>
                      <option value="or">or</option>
                    </select>
                    <br>
                    <select name="pre4">
                    <option selected value="<? echo "$pre4"; ?>" ><? echo "$pre4"; ?></option>
                      <option value="experienced">experienced</option>
                      <option value="inexperienced">inexperienced</option>                      
                    </select>
                    to                              
                    <select name="any_all2">                       
                       <option value="any" selected>any</option>
                       <option value="all">all</option>
                    </select>
                    of the session(s): 
                    <input type="text" name="pre5" size="50" value="<? echo "$pre5"; ?>">
                    <br>
                    <a href="search.php" target="blank">
                    Search session ID here.</a>
                    Close the new window when you have finished the search.
                     </td>
                </tr>
                <tr> 
                  <td class="normal" valign="top"> 
                  <? 
                  if ($import=="yes"){ 
                  	echo "<input type=\"radio\" name=\"preRequisite\" value=\"no\" ";
                  	if ($preRequisite=="no"){ 
                  		echo "checked";
                  	}
                  	echo ">";
                  }
                  else {
                  	echo "<input type=\"radio\" name=\"preRequisite\" value=\"no\" checked > ";
                  }
                  ?>                  
                    No </td>
                  <td>&nbsp;</td>
                </tr>
               </table>
            </td>
          </tr>
          <tr> </tr>
          <tr> </tr>
          <tr> </tr>
          
          <tr> 
            <td width="27%" valign="top" class="normal" bgcolor="ffffcc"><font class="noteindicator">*</font>Description :
            <br>(Press Enter after each line)</td>
            <td class="normal" width="73%" valign="top" bgcolor="ffffcc"> 
              <textarea name="description" wrap="physical" cols="69" rows="5"><? echo $description; ?></textarea>
            </td>
          </tr>
          <tr> 
            <td colspan="2" class="normal" bgcolor="ffffcc" align = "right"> 
            	
              <!--<div align="right"> -->
                <input type="submit" name="Submit" value="Submit">
                <input type="reset" name="reset" value="Reset">
              <!--</div>-->
            </td>
          </tr>
	</table>


<?
}

function foot_menu(){
	?>
	      <table width="524" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td class="normal"> 
                    <div align="center">
                    | <a href="<? echo RECRUIT_URL; ?>">Home</a>  
                    | <a href="Change_Password.php">Change Password</a>  
                    | <a href="search.php" target="_blank">Search Experiment</a> 
                    | <a href="Experimenter_Administration.php">Experimenter Administration</a>
                    | <a href="logout.php">Logout</a> |</div>
                  </td>
                </tr>
              </table>
              
<?
}

function get_poolco_info($login, $poolname){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select email, firstName, lastName from poolCoordinator where pool='$poolname'";
	$rs = $db->query($query);
    $info[0] = $rs->fields[email];
    $info[1] = $rs->fields[firstName];
    $info[2] = $rs->fields[lastName];
    return $info;
}



function get_deadline($pool, $year, $semester){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select deadline from pool where id='$pool' AND year='$year' AND semester='$semester'";
	$rs = $db->query($query);
        $deadline = $rs->fields[deadline];
        if ($deadline=="")
        	$deadline=14;        
        return $deadline;
}

// Used in search.php to show all experimenters
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


function isPool($expid){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	
	$query="select target from experiment where id=$expid";
	$rs = $db->query($query);
	$target = $rs->fields[target];
	$target = explode("->", $target);
	if ($target[0]=="pool"){
		return true;
	}else{
		return false;
	}
}


function list_sessions($id,$mode,$sessions){
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	for ( $i=1; $i<= $sessions; $i++){
		if ($i <10){ $sessionid = $id."0$i";}
		else{ $sessionid = $id."$i";}
		$defaulttitle = $sessionid;
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
		?>
		  <tr>
                    <td width="13%" class="normal"><? echo $sessionid; ?><br>
                      <? //if ( $title == $defaulttitle ) echo ""; else{ echo $title; }?></td>
                    <!--<td width="11%" class="normal"><? echo "Description"; ?>(more)</td>-->                  	
                    <td width="9%" class="normal"><? echo $startdate; ?></td>
                    <td width="9%" class="normal"><? echo $starttime; ?></td>
                    <td width="12%" class="normal"><? echo $Duration; ?></td>
                    <td width="6%" class="normal"><? echo $venue; ?></td>
                    <td width="6%" class="normal"><? echo $quota; ?></td>                    
                    <td width="16%" class="normal"><? echo $rewardstr; ?></td>
                  </tr>
                  <?
                } 
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
		$returnstr = $reward[1]." amount of ".$reward[2]." AND ".$reward[3]."number of ".$reward[4]." credit(s) will be given to each participant.";
		return $returnstr;
	}
	else { return ""; }
}

function show_prereq($preRequisite){
	if($preRequisite !="no"){
		$preReqStr = explode("->", $preRequisite);
		$preRequisite = $preReqStr[0];
	
		$pre1    = $preReqStr[1];	// exp./inexp.
		$any_all = $preReqStr[2];	// Any or All
		$pre2    = $preReqStr[3];	// participant past experiments
		$pre3    = $preReqStr[4];	// and / or
		$pre4    = $preReqStr[5];	// exp./inexp.
		$any_all2= $preReqStr[6];	// Any or All
		$pre5    = $preReqStr[7];	// participant past experiments		
	
?>
	The target subjects should :
                  <br>
                  <? echo strtoupper($pre1); ?> to <? echo strtoupper($any_all); ?> of session(s):
                <? echo $pre2; ?> 
                <? if(trim($pre3)!=""){
                	echo strtoupper($pre3);
                ?>
                       <? echo strtoupper($pre4); ?> to <? echo strtoupper($any_all2); ?> of session(s):                   	                        
                <? 	echo $pre5; 
                   }                
                ?>                          
<?	
	}
	else{
		echo "No";
	}
}	

function experimentersstr($experimenters){
	$experimenter = split("->",$experimenters);
	$db = new phpDB();
	$db->pconnect() or die ("Can't connect to database server or select database");
	$query = "select firstName,lastName from experimenter where loginName = '$experimenter[0]' ";
	$rs = $db->query($query);	
	$firstName = $rs->fields[firstName];
	$lastName = $rs->fields[lastName];
	$fullName = $firstName." ".$lastName;
	$experimenter[0] = $fullName;
	if ( substr($experimenters,strlen($experimenters)-2,strlen($experimenters)) != "->")$newexperimenters = implode(", ",$experimenter); else $newexperimenters = $experimenter[0];
	$rs->close();
	$db->close();
	return $newexperimenters;
}

function is_in_array($needle,$haystack) {
	$needleFound = false;
	$returnValue = false;
	reset($haystack);
	while ((list($key,$value) = each($haystack)) && !$needleFound) {
		if ($needle == $value) {
			$needleFound = true;
			$returnValue = $key;
		}
	}
	return $returnValue;
}

function show_num_enrolled($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select quota from session where id=$sessionid";
	$rs=$db->query($query);
	$rs->firstRow();
	$quota = $rs->fields[quota];
	
	$query_enrolled = "select loginName from waitingList where sessionid=$sessionid order by signOn limit 0, $quota";
	//echo $query;
	$rs = $db->query($query_enrolled);			
	$numOfRows = $rs->getNumOfRows();
	return $numOfRows;
}

function show_num_waiting($sessionid){
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	$query = "select quota from session where id=$sessionid";
	$rs=$db->query($query);
	$rs->firstRow();
	$quota = $rs->fields[quota];
	
	$query = "select count(*) as num from waitingList where sessionid=$sessionid";
	$rs = $db->query($query);
	$num_sub_signed = $rs->fields[num];
	
	$query_wait = "select loginName from waitingList where sessionid=$sessionid order by signOn limit $quota, $num_sub_signed";
	$rs = $db->query($query_wait);	
	$numOfRows1 = $rs->getNumOfRows();
	return $numOfRows1;
}

?>