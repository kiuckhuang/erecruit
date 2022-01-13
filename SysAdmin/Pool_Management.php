<?
setcookie("credit_courseID", $courseID, time()-3600);
include("../fun/admin_functions.inc");

if(isset($sendmail) && $sendmail=="Send Mail"){
	sendmail("Pool Coordinator");
	
}

if(isset($submit) && $submit!="Select All Pools"){
	$k=0;
	for($j=0; $j<$total; $j++){
		if($checkbox[$j] == "on"){
			$k++;
		}
	}
	if($k <=0 ){
		warning(S0023);
		exit;
	}
}
	
		
	
if(isset($submit) && $submit == "Modify Pool"){
	if(isset($total) && $total >=0 ){
		$k=0;
		for($j=0; $j<$total; $j++){
			if($checkbox[$j] == "on"){
				$k++;
			}
		}
		if($k >1 ){
			warning(S0024);
			exit;
		}
		
		
		for($i=0; $i<$total; $i++){
			if($checkbox[$i] == "on"){
				$pool = $pools[$i];
				setcookie( "pool", $pool, time()+6000);
				header("Location: ./PM_Modify_Pool.php");
				exit();
			}
		}
	}
}

if(isset($submit) && $submit == "Delete Pool(s)"){
	for($i=0; $i<$total; $i++){
		if($checkbox[$i] == "on"){
			$poolID = $pools[$i];
			$poolID = ereg_replace("_", " ", $poolID);
			//del_pool($poolID);
			$poolStr .= $poolID."->";
		}
	}
	if($poolStr !=""){
		
		
		$poolStr = substr($poolStr, 0, strlen($poolStr) -2);
		//echo $poolStr;
		$msg = ereg_replace("->", "<br>\n<li>", $poolStr);
		$msg = ereg_replace("--", "  ", $msg);
		$msg = "(Message no.S1006)Do you really want to delete the following pool(s):<br>\n<li>".$msg;
		$poolStr = urlencode($poolStr);
		$link = "Del_Pool.php?poolStr=$poolStr";
		confirm($msg, $link);
		exit();
	}
	
}


$cookie_val = $pool;
setcookie( "pool", $cookie_val, time()-36000); 


$title="Subject Pool Management";

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

                    <div align="right" class="normal">Click <a href="PM_Add_Pool.php"><img src="images/but_here.gif" border="0" align="absmiddle"></a> 
                      to add pool</div>

                  </td>

                </tr>

              </table>

              <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">

                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td width="6%" class="tablecolumn">Select</td>
                    <td width="18%" class="tablecolumn" bgcolor="#000099"> Pool</td>
                    <td width="16%" class="tablecolumn">Coordinator <br>
                      First Name (s) </td>
                    <td width="17%" class="tablecolumn">Coordinator<br>
                      Last Name</td>
                    <td width="18%" class="tablecolumn">Coordinator Email</td>
                   
                  </tr>
                   <?
                  	$no = show_pool($selectall);
                  	if($no == 0){
                  	?>
                  	<tr>
    				<td width="100%" colspan="5">No Pool is available</td>
  			</tr>
			<?
			}
                  ?>
                </table>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td> 

                      <div align="left">
                        <input type="submit" name="selectall" value="Select All Pools">
                        <input type="submit" name="submit" value="Modify Pool">
                        <input type="submit" name="submit" value="Delete Pool(s)">
                      </div>
                    </td>
                 </tr>
                </table>
            <hr width="98%" size="1" noshade align="center">
<?
mail_form("pool coordinator");
?>
             
              </form>

<?
foot();
?>