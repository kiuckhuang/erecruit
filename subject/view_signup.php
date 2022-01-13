<?
require("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

$title="My Experiments";

	$Loginstr = split("-", $subjectprofile);
	$loginName = $Loginstr[0];

function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $id,$loginName;
	global $order;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where"); ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
              <table width="100%" cellpadding="0">
                <tr bgcolor="ffffcc"> 
                  <td class="normal"> You have either signed up or have been placed on the waiting
                    list(s) for the following experiment(s). To sort the table according to a particular column, please click on the corresponding header. </td>
                </tr>
              </table>
              <?
              	$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
/*		
		perfect sql here :
select e.id as expid, e.title as exptitle, s.id as sessionid, UNIX_TIMESTAMP(s.fromdate) as Time
from session s, experiment e, waitingList w
where e.id = substring(s.id,1,length(s.id)-2)
and s.id = w.sessionid
and w.loginName = 'winson'
*/
		
		if (!isset($order)){
			$order = "s.fromdate";
		}
		//$order = "s\.fromdate";
		//$order = "e.title";
		$query="select e.id as expid, e.title as exptitle, s.id as sessionid, s.title as sessiontitle, UNIX_TIMESTAMP(s.fromdate) as fromdate from session s, experiment e, waitingList w where e.id = substring(s.id,1,length(s.id)-2) and s.id = w.sessionid and w.loginName = '$loginName' order by $order";
	
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();
		
              ?>
              <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                <tr bgcolor="#ffffcc" valign="top"> 
                  <td width="14%" class="tablehead"><a href="<? echo $PHP_SELF; ?>?order=e.id"> Experiment ID </a></td>
                  <td width="18%" class="tablehead"><a href="<? echo $PHP_SELF; ?>?order=e.title"> Experiment Title </a></td>
                  <!--<td width="49%" class="tablehead">Experiment Description</td>-->
                  <td width="19%" class="tablehead"><a href="<? echo $PHP_SELF; ?>?order=s.title"> Session Title </a></td>
                  <td width="15%" class="tablehead"><a href="<? echo $PHP_SELF; ?>?order=s.fromdate"> Session Start Date </a></td>
                  <td width="15%" class="tablehead"> Session Start Time </td>
                  <td width="19%" class="tablehead">View Details/Cancel Sign-up/Print Confirmation Sheet</td>
                </tr>
                
                <?
                for($i=0; $i < $numOfRows; $i++){
                	$rs->moveRow($i);
                	$expid = $rs->fields[expid];
                	$exptitle = $rs->fields[exptitle];
			$sessionid = $rs->fields[sessionid];
			$sessiontitle = $rs->fields[sessiontitle];
			$fromdate = $rs->fields[fromdate];
			$starttime = date("g:i a", $fromdate);
			$startdate = date("d M Y", $fromdate);
		?>
                
                <tr> 
                  <td width="14%" valign="top"> 
                    <div align="center" class="normal"><? echo $expid;?></div>
                  </td>
                  <td width="18%" valign="top" class="normal"><? echo $exptitle;?></td>
                  <!--
                  <td width="49%" valign="top" class="normal"><? echo $description;?></td>
                  -->
                  <td width="19%" valign="top" class="normal"><? echo $sessiontitle;?></td>
                  <td width="15%" valign="top" class="normal"><? echo $startdate;?></td>
                  <td width="15%" valign="top" class="normal"><? echo $starttime;?></td>
                  <td width="19%" valign="top" class="normal">
                  <a href="view_signup_sessions.php?id=<? echo $expid;?>">GO</a></td>
                </tr>
                <?
                }
                ?>
              </table>
              <br>
                <? if ( $numOfRows == 0 ){ ?>
                <table width="100%" cellpadding="0">
                <tr> 
                  <td width="14%" valign="top">                 
                  You haven't signed up any experiments.
                  </td>
                </tr>
                </table>
                <br>
                <?}?>

<?
	foot_menu();
	foot();
	$rs->close();
	$db->close();
}
?>

<?
  //-------------main-----------
//content($title);
  //----------------------------
?>

<?
if($loginName == "guest"){
	warningx(W0004); exit;
}
if(isset($subjectprofile)){
	if(false){

	}
	else{
		content($title);
	}
}else{
	warningx("Sorry, <a href='index.php'>Log in</a> first!");
}
?>
