<?

include("../fun/exp_functions.inc");
checkLogin();
if(isset($view) && $view =="View/Modify Experiment" && $myexpid != ""){
	setcookie( "expid", $myexpid, time()+3600); 
	header("Location: ./View-Modify_Experiment.php");
	exit();
}
if(isset($view) && $view =="View/Modify Experiment" && $myexpid == ""){
	warning(T0086);	
	exit();
}
if(isset($del) && $del!="" && $myexpid!=""){
	setcookie( "delexpid", $myexpid, time()+3600);
	header("Location: ./Del_Experiment.php");
	exit(); 
}
if(isset($del) && $del!="" && $myexpid==""){
	warning(T0086);	
	exit(); 
	
}
if(isset($sessman) && $sessman=="Session Management" && $myexpid != ""){
	setcookie( "expid", $myexpid, time()+3600); 
	header("Location: ./Session_Management.php");
	exit();
	
}

if(isset($sessman) && $sessman=="Session Management" && $myexpid == ""){
	warning(T0086);	
	exit();
}
setcookie( "expid", $myexpid, time()-3600); 
setcookie( "sessionid", $sessionid, time()-3600); 


$title="Experimenter Administration";
head($title);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
             <?
                $where="index.php||Log In->";
                $where .= basename($PHP_SELF)."||".$title;
                position("$where");
            ?>
            </tr>
          </table>
        </div>
      </div>

      <div v:shape="_x0000_s3074" class="O"> 
        <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
          <hr noshade align="center" width="98%" size="1">

          <table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr bgcolor="ffffcc"> 
              <td colspan="2" class="normal" width="40%">Number of experiments you have created: <? number_of_experiment(); ?></td>
              <td class="normal" width="49%"> 
                <div align="right">Click <a href="Add_Experiment.php"><img src="images/but_here.gif" width="52" height="25" align="absmiddle" border="0"></a>to 
                  Add Experiment</div>
              </td>
            </tr>
          </table>
          <div align="right" class="normal"> </div>
          <form method="post" action="<? echo $PHP_SELF; ?>">
            <table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
              <tr bgcolor="#000099"> 
                <td width="6%" class="tablecolumn">Select</td>
                <td width="15%" class="tablecolumn" bgcolor="#000099"> Experiment 
                  ID </td>
                <td width="18%" class="tablecolumn">Experiment Title </td>
                <td width="45%" class="tablecolumn">Description </td>
                <td width="16%" class="tablecolumn">Created/Modified on</td>
              </tr>
              <?
              	show_my_experiment("");
              	?>
            </table>
            <br>
            <table width="100%" cellpadding="0">
              <tr> 
                <td colspan="2"> 
                  <div align="right">
                    <input type="submit" name="view" value="View/Modify Experiment">
                    <input type="submit" name="del" value="Delete Experiment">
                    <input type="submit" name="sessman" value="Session Management">
                  </div>
                  <div align="right"> </div>
                </td>
              </tr>
            </table>
            <br>
            <div align="center">
            
            <? foot_menu(); ?>
            </div>
          </form>
          
<?





foot();
?>

