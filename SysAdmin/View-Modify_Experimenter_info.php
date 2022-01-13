<?
include("../fun/admin_functions.inc");

if($Modify == "Modify"){
	$infoStr = $loginName."->".$firstName."->".$lastName."->".$password."->".$sid."->".$phone."->".$email."->".$remarks."->".$instructor."->".$hkust."->".$Modify."->".$oldloginname."->".$oldpassword;

	$loginname=check_experimenter_info($infoStr);
	$link = "Experimenter_Management.php";
	message(S0027, $link);
	exit();
}

if(isset($sendtoexp) && $sendtoexp=="Send to Experimenter"){
	if($password == $oldpassword){
		warning(S0028);
		exit;
	}
	if($password ==""){
		warning(S0018);
		exit;
	}
	
	
	send_experimenter_detail($loginName, $password);
}


$title = "View/Modify Experimenter Info";
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
			//$loginName = "Ken";
			show_experimenter_info($loginName, "");
		?>
               </form>
               <p class="notes"><i>* denotes optional fields</i></p>
<?

foot();
?>