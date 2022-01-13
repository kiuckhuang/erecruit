<!--To put this html into an existing HTML document, you must copy the JavaScript and-->
<!--paste it in a specific location within the destination HTML document. You must then copy-->
<!--and paste the table in a different location.-->
<?
require("../fun/subject_functions.inc");
?>
<html>
<head>
<title>Sign Up Confirmation Sheet</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="Fireworks Splice HTML">
<!-- Fireworks 3.0  Dreamweaver 3.0 target.  Created Thu Apr 13 19:37:12 GMT+0800 (HKT) 2000 -->

<link rel="stylesheet" href="../css.css">
</head>
<body bgcolor="#ffffff">
<table border="0" cellpadding="0" cellspacing="0" width="430" align="center">
  <!-- fwtable fwsrc="logo.png" fwbase="signupsucceedtable.gif" --> 
  <tr> <!-- Shim row, height 1. --> 
    <td width="539"><img src="../images/signup/shim.gif" width="539" height="1" border="0"></td>
    <td width="28"><img src="../images/signup/shim.gif" width="18" height="1" border="0"></td>
  </tr>
  <tr valign="top"><!-- row 2 --> 
    <td colspan="2"><img name="signupsucceedtable_r2_c1" src="../images/signup/signupsucceedtable_r2_c1.gif" width="557" height="61" border="0"></td>
  </tr>
  <tr valign="top"><!-- row 3 --> 
    <td width="539" bgcolor="ffffcc">
      <table width="95%" border="0" cellpadding="3" cellspacing="0" align="center">
        <tr> 
          <td class="normal">
          </td>
        </tr>

        <tr> 
	  <hr noshade size="1" width="98%">
          <td class="normal" align="center"><b>Sign Up Confirmation Sheet</b>  
            <hr noshade size="1" width="98%">
        </td></tr>
        <?	
		$Login = split("-",$subjectprofile);
		$loginName = $Login[0];
        	//global $subjectprofile,$mail,$firstName,$lastName
        	$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
        	$query="select title, reward, UNIX_TIMESTAMP(fromdate) AS fromdate, durationEnd, venue, quota, enrolled, UNIX_TIMESTAMP(dateCreated) as dateCreated from session where id like '$sessionid' ";
	
		$rs = $db->query($query);
		$sessiontitle = $rs->fields[title];
		$reward = $rs->fields[reward];
		$fromdate = $rs->fields[fromdate];
		$durationEnd = $rs->fields[durationEnd];
		$venue = $rs->fields[venue];
		$quota = $rs->fields[quota];
		$enrolled = $rs->fields[enrolled];
		$dateCreated = $rs->fields[dateCreated];
		
		$query="select target from experiment where id = '$id' ";
		$rs = $db->query($query);
		$target = $rs->fields[target];
		$target = split("->",$target);
		$show_course = ereg_replace("--"," ",$target[1]);
		if ($target[0] == "pool"){
			$query = "select AssignCreditsto from signupexp where expid ='$id' and loginName ='$loginName' ";
			$rs = $db->query($query);
			$AssignCreditsto = $rs->fields[AssignCreditsto];
			$show_row = $rs->getNumOfRows();
			$show_AssignCreditsto = ereg_replace("--"," ",$AssignCreditsto);
		}
		$starttime = date(TIMEFORMAT, $fromdate);
		$startdate = date(DATEFORMAT, $fromdate);
		$duration = split("-", $durationEnd);
		$Duration = $duration[0]." day(s) ".$duration[1]." hr(s) ".$duration[2]." min(s)";
		$rewardstr = rewardstr($reward);
		$nowtime = date(NOWTIMEFORMAT, time());
		$Loginstr = split("-", $subjectprofile);
		$loginName = $Loginstr[0];
		$query="select * from subject where loginName = '$loginName' ";
		$rs = $db->query($query);
		$firstName = $rs->fields[firstName];
		$lastName = $rs->fields[lastName];
		$stuID = $rs->fields[stuID];
		
		$expid = substr($sessionid,0,8);
		$query2="select * from experiment where id = '$expid' ";
		$rs = $db->query($query2);
		$exptitle = $rs->fields[title];
		
		$sessionnumber = substr($sessionid,8,2);
		if ($sessionnumber < 10) $sessionnumber = substr($sessionnumber,1,1);
		//$sessiontitle = "Session $sessionnumber: $sessiontitle";
		$sessiontitle = "$sessiontitle";
        ?>
        <tr> 
          <td> 
            <table width="65%" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr> 
                <td colspan="2" class="normal"></td>
              </tr>
              <tr> 
                <td width="45%" class="normal">First Name :</td>
                <td width="55%" class="tablerow"><? echo $firstName; ?></td>
              </tr>
              <tr> 
                <td width="45%" class="normal">Last Name :</td>
                <td width="55%" class="tablerow"><? echo $lastName; ?></td>
              </tr>
              <? if ( is_ust() ){?>
              <tr> 
                <td width="45%" class="normal">Student/Staff ID :</td>
                <td width="55%" class="tablerow"><? echo $stuID; ?></td>
              </tr>
              <? }?>
              <tr> 
                <td width="45%" class="normal">Experiment Title :</td>
                <td width="55%" class="tablerow"><? echo $exptitle; ?></td>
              </tr>
              <tr> 
                <td width="45%" class="normal">Experiment ID :</td>
                <td width="55%" class="tablerow"><? echo $id; ?></td>
              </tr>
              <tr> 
                <td width="45%" class="normal">Session Title:</td>
                <td width="55%" class="tablerow"><? echo $sessiontitle; ?></td>
              </tr>
              <!--
              <tr> 
                <td width="45%" class="normal">Session ID:</td>
                <td width="55%" class="tablerow"><? echo $sessionid; ?></td>
              </tr>
              -->
              <tr> 
                <td width="45%" class="normal">Start Date :</td>
                <td width="55%" class="tablerow"><? echo $startdate; ?></td>
              </tr>
              <tr> 
                <td width="45%" class="normal">Start Time :</td>
                <td width="55%" class="tablerow"><? echo $starttime; ?></td>
              </tr>
              <tr> 
                <td width="45%" class="normal">Approximate Duration : </td>
                <td width="55%" class="tablerow"><? echo $Duration; ?></td>
              </tr>
              <tr> 
                <td width="45%" class="normal">Venue :</td>
                <td width="55%" class="tablerow"><? echo $venue; ?></td>
              </tr>
              <? if($target[0]=="pool"){?>
              <tr> 
                <td width="45%" class="normal">Assign Credits to:</td>
                <td width="55%" class="tablerow"><? echo $show_AssignCreditsto; ?></td>
              </tr>
              <? }?>
              <!--
              <tr> 
                <td colspan="2" class="normal" height="2">Printed on <? echo $nowtime; ?></td>
              </tr>
              -->
            </table>
            <ul>
              <li class="normal">Please <font color="#FF0000">PRINT</font> 
                this page and present it to the experimenter when you arrive at the experiment venue. To print this page, you can use the print function in your browser. </li>
              <li class="normal">This sheet may be used as <b><i>proof
                for your attendance</i></b> in this session. Please <i><b>obtain the 
                experimenter's signature</b></i> by the end of the session. 
              </li>
              <!--
              <li class="normal">If you want to cancel the sign up, please click 
                <img src="../images/but_here.gif" width="52" height="25" align="absmiddle"></li>
                -->
            </ul>
	    
	    <table width="500">
	    <tr>
	    <td width = "250">
            <div align="left" class="normal"><br>
              Date: <br>
              <br>
              <br>
              ------------------------------------- </div>
 	    </td>
 	    <td width = "250">
            <div align="right" class="normal"><br>
              Experimenter's Signature: <br>
              <br>
              <br>
              ------------------------------------ </div>
            </td>
            </tr>
            </table>
            </td>
          </td>
        </tr>
        <tr> 
          <td> 
            <div align="right"> 
              <hr noshade size="1" width="98%">
            </div>
          </td>
        </tr>
      </table>
    </td>
    <td width="28"><img src="../images/signup/verticalbar.gif" width="21" height="580"></td>
  </tr>
  <tr valign="top"><!-- row 4 --> 
    <td colspan="2"><img name="signupsucceedtable_r4_c1" src="../images/signup/signupsucceedtable_r4_c1.gif" width="557" height="22" border="0"></td>
  </tr>
  <map name="m_null"> <area shape="rect" coords="149,228,150,229" href="#" > </map> 
  <!--   This table was automatically created with Macromedia Fireworks 3.0   --> 
  <!--   http://www.macromedia.com   --> 
</table>
</body>

</html>

