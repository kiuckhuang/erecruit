<?
require("../fun/exp_functions.inc");
checkLogin();
//echo $expid;

/*
if ($confirm=="yes"){
	$queryStr = array("$expid", "$title", "$reward", "$fromdate", "$durationEnd", "$vennue", "$quota","$submit", "yes");
	add_session($queryStr);
}
else if ($confirm=="no"){
	$queryStr = array("$expid", "$title", "$reward", "$fromdate", "$durationEnd", "$vennue", "$quota","$submit", "no");
	add_session($queryStr);
}
*/

//check_session_no($expid);

if(trim($title)==""){
	$no = show_session_no($expid);
	$title="Session $no";
}


if($reward =="money"){
	if($money1==""){
		warning(T0040);
		exit();
	}
	if(trim($money2)==""){
		warning(T0041);
		exit();
	}
}
	
if($reward =="credit"){
	if($credit1==""){
		warning(T0042);
		exit();
	}
	if(trim($credit2)==""){
		warning(T0043);
		exit();
	}
	if(isset($credit2) && !eregi("^[0-9]+$",$credit2)){
		warning(T0044);
	}
	
}
if($reward =="creditmoney" ){
	if($creditmoney1==""){
		warning(T0045);
		exit();
	}
	if($creditmoney2==""){
		warning(T0046);
		exit();
	}
	if($creditmoney3==""){
		warning(T0047);
		exit();
	}
	if(trim($creditmoney4)==""){
		warning(T0048);
		exit();
	}
	if(isset($creditmoney4) && !eregi("^[0-9]+$",$creditmoney4)){
		warning(T0049);
	}
	
}
if (trim($starthour)=="" || trim($startmin)==""){
	warning(T0050);
	exit();
}
/*	
if(!ereg("^[0-2][0-9]:[0-5][0-9]$", $starttime)){
	warning("Incorrect time format of Start Time!");
	exit();
}
*/

if(trim($date)=="" || trim($month)=="" || trim($year)==""){
	warning(T0051);
	exit();
}

if( !checkdate(trim($month+0),trim($date+0),trim($year+0)) ){
	warning(T0052);
	exit();
}


$inputstamp = mktime($starthour, $startmin, 0, $month, $date, $year);
$nowstamp = time();
if($nowstamp > $inputstamp){
	warning(T0053);
	exit;
}
	


	
if(trim($duration1)==""){
	warning(T0054);
	exit();
}
if(trim($duration2)==""){
	warning(T0055);
	exit();
}
if(trim($duration3)==""){
	warning(T0056);
	exit();
}
if(trim($duration2) > 23){
	warning(T0057);
	exit();
}
if(trim($duration3) > 59){
	warning(T0058);
	exit();
}

if(isset($quota) && trim($quota)==""){
	
	warning(T0059);
}

if(isset($quota) && !eregi("^[0-9]+$",$quota)){
	
	warning(T0060);
}


if(trim($vennue)==""){
	
	warning(T0061);
}



//$query="insert into session (id, title, reward, fromdate, durationEnd ,vennue, quota ,enrolled ,dateCreated 
if($reward == "money"){
	$reward .="->".$money1."->".$money2;
}
if($reward == "credit"){
	$reward .="->".$credit1."->".$credit2;
}
if($reward == "creditmoney"){
	$reward .="->".$creditmoney1."->".$creditmoney2."->".$creditmoney3."->".$creditmoney4;
}
    
//$starttimeStr = explode(":", $starttime);
//$starttime0  = $starttimeStr[0];
//$starttime1  = $starttimeStr[1];

//echo $starttime0.":".$starttime1;

/*
if($starttime0+0 > 23 ||$starttime0+0 <0 ||$starttime1+0 > 59 ||$starttime1+0 <0 ){
	warning("Incorrect Time Format!");
	exit();
}
*/

/*
if($starthour+0 <10){
	//echo $starthour."<br>";
	$starthour = "0".$starthour;
}

if($startmin+0 <10){
	//echo $starttime1."<br>";
	$startmin = "0".$startmin;
}
*/

//echo "$year $month $date $starthour $startmin END";
$fromdate = $year.$month.$date.$starthour.$startmin."00";


//echo $fromdate."<br>";
$durationEnd = $duration1."-".$duration2."-". $duration3;
if(isset($sessionid) && $sessionid!="" && $submit!="Add"){
	$submit .="-".$sessionid;
}

/*
for ($i=0; $i<=count($queryStr); $i++){
	echo "$queryStr[$i]<br>";
}
*/
/*
if ($submit=="Add"){
	$queryStr = array("$expid", "$title", "$reward", "$fromdate", "$durationEnd", "$vennue", "$quota","$submit");
	add_session($queryStr);
}
else{
	if ($confirm=="notyet"){
		$msg = "Do you want to send email to notify the subjects about the modification?";
		$link_yes = $PHP_SELF."?confirm=yes";
		$link_no = $PHP_SELF."?confirm=no";
		yesno($msg, $link_yes, $link_no);
	}
}
*/
$queryStr = array("$expid", "$title", "$reward", "$fromdate", "$durationEnd", "$vennue", "$quota","$submit", "$sendmail");
add_session($queryStr);
/*
$money1="A fixed";
$money2=
$credit1="A fixed";
$credit2=
$creditandmoney1="A fixed";
$creditandmoney2=
$creditandmoney3="A fixed";
$creditandmoney4=
$date=1
$month=1
$year=2000
$starttime1=
$starttime2=AM
$duration1=
$duration2=
$duration3=
$venue=
$Submit=Add

*/

?>
