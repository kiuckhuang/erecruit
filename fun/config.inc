<?

define("ORG", "Hong Kong University of Science and Technology");
define("ORG_SHORT", "HKUST");
define("BUG_MAIL", "bug@localhost");
define("BUG_MAIL_WITH_LINK", "<a href=\"mailto:". BUG_MAIL ."\">". BUG_MAIL ."</a>");


define("ADMIN_MAIL", "admin@localhost");
define("ADMIN_MAIL_WITH_LINK", "<a href=\"mailto:". ADMIN_MAIL ."\">". ADMIN_MAIL ."</a>");
define("ADMIN_MAIL_WITH_NAME", "e-Recruit System Administrator<".ADMIN_MAIL.">");
$copy_right = "eRecruit is distributed under the <a href=\"http://www.gnu.org/copyleft/gpl.html\" target=\"_blank\">General Public License</a>.
               It is originally developed by the Center for Experimental Business Research (<a href=\"http://cebr.ust.hk\" target=\"blank\"><img src=\"images/cebrlogo.gif\" border=\"0\" width=\"35\" height=\"15\" align=\"absmiddle\"></a>).
              ";

define("CURRENCY", "US$");  // the $$ currency

define("COPY_RIGHT", $copy_right);
define("RECRUIT_URL", "http://erecruit.sourceforge.net/");
define("LOCALTIME", "US (EST)");
define("TIMEFORMAT", "g:i a");//timeformat in subject
define("DATEFORMAT", "d M Y");//dateformat in subject
define("NOWTIMEFORMAT","d M Y g:i a");//now time format in subject
define("ITEMINPAGE", 5); //number of items in the expdatails_exptitle.php
define("SHOWREADYEXPONLY", 1);//this control the upcoming_exp set "1" exp all is showed 
				//if "0" on the exp have enough session can show ref.($total == $expsessionno || SHOWREADYEXPONLY)
				
define("DAYONE_MONTH", 1);
define("DAYONE_DAY", 1);
define("DAYTWO_MONTH", 7);
define("DAYTWO_DAY", 1);
				
define("ALL_SESSION_READY", false);//if true it will check the experiment wheather its all session is ready or not 
				//if false it will not check that and show all the experiment				
define("SHOWSIGNUPCODE", FALSE);//TRUE -> it will show the sign up code for debugging when the input sign up code is wrong.
define("TEXTFIELDWIDTH", 65);//it will set the width of the text field in upcomingexp_expdetails.php and pastexp_expdetails.php



define("NO_SHOW_BLOCK_COUNT", 2); // this is the number that to block a subject who do not show to session at this count
define("CANCEL_BLOCK_COUNT", 2); // this is the number that to block a subject who cancel the session at this count
define("CANCEL_B4_HOUR", 24 ); // this is the number of hour that a subject cancel b4 the session start
define("BLOCK_PERIOD", 21); // the number of days that a subject will be blocked!
define("IS_BLOCKING_SUBJECT", 0); // this is used by login_member.php and signup_sessions.php for testing the blocking mode for all the subject is blocked--> 1: turn on the blocking 0: turn off the blocking 



define("DEBUG_ISSESSIONEND", 0); // 1: this will turn on the debug mode for the sign up session( checking the session is ended or not)
define("DEBUG_ISSESSIONSTART", 0); // 1: this will turn on the debug mode for the cancel session( checking the session is started or not)
define("DEBUG_ISSESSIONSIGNEDUP", 0); // 1: this will turn on the debug mode for the signed up session( checking the session is signed up or not)
define("DEBUG_PREREQUSITE", 0); // 1: this will turn on the debug mode for the prerequisite of signed up session
define("DEBUG_SHOWSQL", 0); //1: this will turn on the degub mode for showing the query of the subject_function->list_all_open_exp which will used on upcomingexp_expdetails.php and pastexp_expdetails.php

//Display System Operation Hour
define("SHOW_OPEN_HOUR", "06");
define("SHOW_OPEN_MIN", "00");
define("SHOW_CLOSE_HOUR", "01");
define("SHOW_CLOSE_MIN", "00");

//System Operation Hour
define("OPEN_HOUR", 5);
define("OPEN_MIN", 00);
define("CLOSE_HOUR", 02);
define("CLOSE_MIN", 00);

function isAdminComp(){
	global $REMOTE_ADDR;
	$adminips = array("");
	for($i=0; $i < sizeof($adminips); $i++){
		if("$REMOTE_ADDR" == "$adminips[$i]"){
			return true;
		}
		
	}
	
	return false;
}

/*
$timeArr = getdate(time());
if($timeArr[hours] >= CLOSE_HOUR && $timeArr[hours] < OPEN_HOUR){
	if(!isAdminComp()){
		//echo $REMOTE_ADDR;
		header("Location: ".RECRUIT_URL."/OperationHour.php");
		exit;
	}
	
}*/
?>
