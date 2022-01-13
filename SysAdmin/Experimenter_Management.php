<?
include("../fun/admin_functions.inc");
setcookie("tmpexppasswd", $password, time()-3600);
if(isset($submit) && $submit!="Select All Boxes"){
	
	if(isset($total) && $total >=0 ){
		$k=0;
		for($j=0; $j<$total; $j++){
			if($checkbox[$j] == "on"){
				$k++;
			}
		}
		if($k <= 0 ){
			warning(S0019);
			exit;
		}
	}
	
	if($submit == "Delete"){
		for($i=0; $i<$total; $i++){
			$loginName = $loginNames[$i];
			if($loginName != "" && $checkbox[$i] == "on"){
				//delExperimenter($loginName);
				$expStr .= $loginName."->";
			}
		}
		if($expStr !=""){
			$expStr = substr($expStr, 0, strlen($expStr) -2);
			//echo $expStr;
			$msg = ereg_replace("->", "<br>\n<li>", $expStr);
		
			$msg = "(Message no.S1005)\nDo you really want to delete the following experimenters with Login Names:<br>\n<li>".$msg;
			$expStr = urlencode($expStr);
			$link = "Del_Experimenter.php?expStr=$expStr";
			confirm($msg, $link);
			exit();
		}
	
		
		
	}
	else if($submit =="View/Modify Experimenter Info"){
		if($k >1){
			warning(S0020);
		}
		
		for($i=0; $i <$total; $i++){
			if($checkbox[$i] == "on"){
				$loginStr = "loginName=".$loginNames[$i];
				header("Location: View-Modify_Experimenter_info.php?$loginStr");
				exit();
				
			}
		}
	}
	else if($submit =="View Experiments created by Experimenter"){
		if($k >1){
			warning(S0021);
		}
		
		for($i=0; $i <$total; $i++){
			if($checkbox[$i] == "on"){
				$loginStr = "loginName=".$loginNames[$i];
				header("Location: Experiments_By_Experimenter.php?$loginStr");
				exit();
				
			}
		}
	}
	

}
	
if(isset($sendmail) && $sendmail=="Send Mail"){
	sendmail("Experimenters");
}

$title = "Experimenter Management";
head($title);

?>

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr>

<?
		$where = "index.php||Home->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
		?>
		
                </tr>

              </table>

              <hr noshade align="center" width="98%" size="1">
              <table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td>
                    <div align="right" class="normal">Click <a href="Add_Experimenter.php"><img src="images/but_here.gif" border="0" align="absmiddle"></a> 
                      to add an experimenter</div>
                  </td>
                </tr>
              </table>

              <form name="experimenters" method="post" action="<? echo $PHP_SELF; ?>">
		
		
                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">

                  <tr bgcolor="#000099" valign="top">
                    <td width="6%" class="tablecolumn">Select</td>
                    <td width="6%" class="tablecolumn" >First Name(s)</td>
		    <td width="6%" class="tablecolumn" >Last Name</td>
                   <!--
                    <td width="10%" class="tablecolumn">Instructor of <br>
                      which Course(s)?</td>
                   -->
                    <td width="10%" class="tablecolumn">Login Name</td>
                    <td width="12%" class="tablecolumn">Staff/Student ID</td>
                    <td width="8%" class="tablecolumn">Phone</td>
                    <td width="12%" class="tablecolumn">Email </td>
                    <td width="25%" class="tablecolumn">Remarks</td>
                    <td width="4%" class="tablecolumn"><? echo ORG_SHORT; ?> Experimenter(s)*</td>
                  </tr>

                  <?
                  	
                  	if($submit != "")
                  		$no = show_all_experimenters($submit);
                  	else
                  		$no = show_all_experimenters("");
                  		
                  	if($no == 0){
                  	?>
                  	<tr>
    				<td width="100%" colspan="11">No Experimenter available</td>
  			</tr>
			<?
			}
                  ?>
                </table>
               <p align="left">
                  <input type="submit" name="submit" value="Select All Boxes">
                  
                  <input type="submit" name="submit" value="Delete">
                  <input type="submit" name="submit" value="View/Modify Experimenter Info">
                  <input type="submit" name="submit" value="View Experiments created by Experimenter">
                </p>

<?
		mail_form("experimenter");
	
?>	
	</form>
	<p class="notes"><i>*For <? echo ORG_SHORT; ?> experimenter(s), all information above except "First Name(s)", "Last Name", "Login Name" and "Email" was provided by the respective experimenter. For non-HKUST experimenter(s), all information was provided by them</i></p>
<?
foot();
?>