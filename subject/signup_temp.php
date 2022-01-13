<?
require("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

$title="Template";


function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $signup,$id,$mode,$sessions;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->logon_nonust.php||Log on(for non ".ORG_SHORT." participants)->createacc_nonust.php||Create Account(for HKUST students/staff)->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where"); ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              <? 
                //$mode == "All" || "One" || "Any"
                echo $mode;
	        if ( $mode == "All" ){
	        //insert into datebase 
	        $sessionid = 111;
	        $expid = 1;
	        $Loginstr = split("-",$subjectprofile);
	        $loginName = $Loginstr[0];
	        $db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query = "insert into waitingList (sessionid, loginName, signOn) values ('$sessionid','$loginName',now())";
		$query2 = "insert into signupexp (expid, loginName, signOn) values ('$expid','$loginName',now())";
		$rs = $db->query($query);
		$rs = $db->query($query2);
		$rs->close();		
		$db->close();
	        }
	        elseif ( $mode == "One" ){
	        }
	        elseif ( $mode == "Any" ){
	        }
	        else { 
	        }
        

        
              
              
              
              
              
              
              ?>

<?
	foot();
}
?>

<?
  //-------------main-----------
//content($title);
  //----------------------------
?>

<?

if(isset($subjectprofile)){
	if(false){

	}
	else{
		content($title);
	}
}else{
	warning("Sorry,  Login first!");
}
	
	


?>