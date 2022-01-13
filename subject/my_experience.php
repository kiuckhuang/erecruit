<?
require("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

$title="My Experience";

	$Loginstr = split("-", $subjectprofile);
	$loginName = $Loginstr[0];

function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $id,$loginName;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<? /*
 		$where = "index.php||Log In->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where"); */ ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
              <? /*
              <table width="100%" cellpadding="0">
                <tr bgcolor="ffffcc"> 
                  <td class="normal"> You have either signed up or have been placed on the waiting
                    list(s) for the following experiment(s). <!--To sort the table according to a particular column, please click on the corresponding header. --></td>
                </tr>
              </table>
                 */
              ?>
              <?
              	$db = new phpDB();
		$db->pconnect() or die ("Can't connect to database server or select database");
		$query="select * from attendancy where loginName = '$loginName' order by date";
	
		$rs = $db->query($query);
		$numOfRows = $rs->getNumOfRows();	
             	 ?>
              <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                <tr bgcolor="#000099" valign="top"> 
                  <td width="" class="tablecolumn">Experiment ID</td>
                  <td width="" class="tablecolumn">Session ID</td>
                  <td width="" class="tablecolumn" bgcolor="#000099"> Experiment Title </td>                  
                  <td width="" class="tablecolumn">Experience</td>
                  
                </tr>
                <?
          if ($numOfRows!=0){		
		for($i=0; $i <$numOfRows; $i++){
			$rs->moveRow($i);
			
			$attendancy = $rs->fields[attendancy];			
			if ($attendancy=="no"){
				$attendancy = "inexperienced";	
			}			
			$sessionid = $rs->fields[sessionid];
			$expid = substr("$sessionid", 0, 8);
			
			$query2 = "select title from experiment where id = '$expid' ";
			$rs2 = $db->query($query2);
			$exptitle = $rs2->fields[title];										
		?>
                <tr> 
                  <td width="" valign="top" class="normal"><? echo $expid;?></td>
                  <td width="" valign="top" class="normal"><? echo $sessionid;?></td>
                  <td width="" valign="top" class="normal"><? echo $exptitle;?></td>                  
                  <td width="" valign="top" class="normal"><? echo $attendancy;?></td>
                </tr>
                <?                
       		 } //for
       	   }
       	   else{
       	   	?>
       	   	<tr>
       	   	<td class="normal" colspan="3">
       	   	    You don't have any experience.
       	   	</td>
       	   	</tr>
        	
                <?
           } //if num of records is zero
           	?>

              </table>                                                            
              <br>
To go back to the previous page, you may want to close this window when you are done. 
<? 
	/* foot_menu();
	*/
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
	warningx(W0002);
}
?>
