<?

if(isset($credit_courseID)){
	setcookie("credit_courseID", $courseID, time()-3600);
}

include("../fun/poolcoor_functions.inc");
checkLogin();

if(isset($submit) && $submit == "Log Out"){
	header("Location: logout.php");
	exit;
}

if(isset($submit) && $submit != "Change My Password"){
	if(isset($total) && $total >=0 ){
		$k=0;
		for($j=0; $j<$total; $j++){
			if($checkbox[$j] == "on"){
				$k++;
			}
		}
		if($k <= 0 ){
			warning(P0025);
			exit;
		}
	}
}

	
	
if(isset($submit) && $submit == "Change My Password"){
	header("Location: Change_Password.php");
	exit;
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
			warning(P0026);
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
			$delpoolID = $pools[$i];
			$poolStr .= $delpoolID."->";
		}
	}
	if($poolStr !=""){
		$poolStr = substr($poolStr, 0, strlen($poolStr) -2);
		$msg = ereg_replace("->", "<br>\n<li>", $poolStr);
		$msg = ereg_replace("--", "  ", $msg);
		$msg = "(Message no.P1010)Do you really want to delete the following pool(s):<br>\n<li>".$msg;
		$delpools = explode("->", $poolStr);
		for($k=0; $k< sizeof($delpools); $k++){
			setcookie( "delpools[$k]", $delpools[$k], time()+60);
		}
		
		$link = "Del_Pool.php";
		confirm($msg, $link);
		exit();
	}
	
}


if(isset($submit) && $submit == "Manage Pool Courses"){
	if(isset($total) && $total >= 0 ){
		$k=0;
		for($j=0; $j<$total; $j++){
			if($checkbox[$j] == "on"){
				$k++;
			}
		}
		if($k >1 ){
			warning(P0026);
			exit;
		}
		for($i=0; $i<$total; $i++){
			if($checkbox[$i] == "on"){
				$pool = $pools[$i];
				setcookie( "pool", $pool, time()+6000);
				header("Location: ./PM_Courses.php");
				exit();
			}
		}
	}
	
}
if(isset($submit) && $submit == "Manage Pool Experiments"){
	if(isset($total) && $total >= 0 ){
		$k=0;
		for($j=0; $j<$total; $j++){
			if($checkbox[$j] == "on"){
				$k++;
			}
		}
		if($k >1 ){
			warning(P0026);
			exit;
		}
		
		for($i=0; $i<$total; $i++){
			if($checkbox[$i] == "on"){
				$pool = $pools[$i];
				setcookie( "pool", $pool, time()+6000);
				header("Location: ./PM_Experiments.php");
				exit();
			}
		}
	}
	
}
$cookie_val = $pool;
setcookie( "pool", $cookie_val, time()-36000); 


$title="$poolname Pool Management";

head($title);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Log on->";
		$where .= basename($PHP_SELF)."||".$title;
                position("$where");
                ?>
		</tr>
              </table>

              <hr noshade align="center" width="98%" size="1">

              <table width="100%" border="0" cellspacing="0" cellpadding="3">

                <tr>
                  <td width="100%">
                    <div align="right" class="normal">Click <a href="PM_Add_Pool.php"><img src="images/but_here.gif" border="0" align="absmiddle"></a> 
                      to add pool</div>
                  </td>
                </tr>
                
                  
                
              </table>

              <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">

                <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
                  <tr bgcolor="#000099" valign="top"> 
                    <td width="10%" class="tablecolumn">Select</td>
                    <td width="30%" class="tablecolumn" bgcolor="#000099"> Pool</td>
                    <td width="30%" class="tablecolumn">Pool Sign-Up Code</td>
                    <td width="30%" class="tablecolumn">Pool Authorization Code</td>
                  </tr>
                  <?
                  	$no = show_subject_pool($poolname, $selectall);
                  	if($no == 0){
                  	?>
                  	<tr>
    				<td width="100%" colspan="4">No Pool available</td>
  			</tr>
			<?
			}
                  ?>
                </table>
<br>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td> 

                      <div align="left">

                        <input type="submit" name="selectall" value="Select All Pools">

                        <input type="submit" name="submit" value="Modify Pool">

                        <input type="submit" name="submit" value="Delete Pool(s)">
                        <input type="submit" name="submit" value="Manage Pool Courses">
                        <input type="submit" name="submit" value="Manage Pool Experiments">
                       <!--
                        <input type="submit" name="submit" value="Change My Password">
                        <input type="submit" name="submit" value="Log Out">
                       -->
                      </div>

                    </td>

                  </tr>

                </table>
	</form>
	
<?
foot_link();
?>