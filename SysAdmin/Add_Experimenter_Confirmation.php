<?
include("../fun/admin_functions.inc");

if($loginName == ""){
	$loginName = $exlogin;
}


if(isset($sendtoexp) && $sendtoexp=="Send to Experimenter"){
	send_experimenter_detail($loginName, $tmpexppasswd);
}

if(isset($gotoexp) && $gotoexp=="Go to Experimenter Management"){
	header("Location: Experimenter_Management.php");
	exit;
}


$title = "Add Experimenter Confirmation";
head($title);

?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
  <?
		$where = "index.php||Home->Experimenter_Management.php||Experimenter Management->Add_Experimenter.php||Add Experimenter->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
?>
              </tr>
              </table>
              <hr noshade align="center" width="98%" size="1">
              <form name="form1" method="post" action="<? echo "$PHP_SELF"; ?>">
		<?
			//$loginName = "Ken";
			confirm_experimenter_info($loginName, $tmpexppasswd);
		?>
               </form>
               <p class="notes"><i>* denotes optional fields</i></p>
<?

foot();
?>