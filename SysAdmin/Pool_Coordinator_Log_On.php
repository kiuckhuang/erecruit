<?
include("../fun/admin_functions.inc");

if(isset($poolloginName) && $poolloginName != ""){
	if(isexist($poolloginName)){
		header("Location: ../poolCoor/Pool_Management.php");
		exit;
	
	}else{
		warning(S0022);
		exit;
	}
}

	

$title = "Pool Coordinator Log In";
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
              <hr noshade width="98%" size="1">
              <form method="post" action="<? echo $PHP_SELF; ?>">
                
                <table width="95%" border="0" cellspacing="0" cellpadding="3">
                  <tr bgcolor="ffffcc"> 
                    <td width="100%" height="27" class="tablerow"> 
                        Please input the Pool Coordinator's login name: 
                        <input type="text" name="poolloginName"  value="">
                        
                    </td>
                    
                  </tr>
                  <tr bgcolor="ffffcc"> 
                  <td width="100%"> 
                      <div align="right"> 
                        <input type="submit" value="Pool Coordinator Log In">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
 <?
 foot();
 ?>

