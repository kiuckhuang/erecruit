<?
include("../fun/admin_functions.inc");

if($Add == "Add"){
	$infoStr = $loginName."->".$firstName."->".$lastName."->".$password."->".$sid."->".$phone."->".$email."->".$remarks."->".$instructor."->".$hkust."->".$Add."->".$oldloginname."->".$oldpassword;

	$loginname=check_experimenter_info($infoStr);
	setcookie("tmpexppasswd", $password, time()+3600);
	
	$link = "Add_Experimenter_Confirmation.php?exlogin=$loginname";
	header("Location: $link");
	exit();

}

$title = "Add Experimenter";
head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
  <?
		$where = "index.php||Home->Experimenter_Management.php||Experimenter Management->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
?>
              </tr>
              </table>
              <hr noshade align="center" width="98%" size="1">
              <form name="form1" method="post" action="<? echo "$PHP_SELF"; ?>">
		<?
			
			show_experimenter_info($loginName, "");
		?>
               </form>
                 <p class="notes"><i>* denotes optional fields</i></p>
<?

foot();
?>