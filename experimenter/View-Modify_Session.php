<?
require("../fun/exp_functions.inc");

checkLogin();
if(!checkexpid($expid)){
	warning(T0073);
	exit();	
}
$title="View/Modify Session";



head($title);

?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
               <?
                $where="index.php||Log In->Experimenter_Administration.php||Experimenter Administration->Session_Management.php||Session Management->";
                $where .= basename($PHP_SELF)."||".$title;
                position("$where");
            ?>
            </tr>
          </table>
        </div>
      </div>
      <div v:shape="_x0000_s3074" class="O">
        <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle">
          <form method="post" action="Check_Session.php">
          	<!-- input type="hidden" name="confirm" value="notyet" -->
<?

view_session_layout($sessionid);


?>                      
          </form>
<?
foot_menu();
foot();
?>
