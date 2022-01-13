<?
require("../fun/exp_functions.inc");

checkLogin();

if(!checkexpid($expid)){
	warning(T0073);
	exit();	
}

setcookie( "expid", $expid, time()+3600); 
$title="View/Modify Experiment";
head($title);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <?
                $where="index.php||Log In->Experimenter_Administration.php||Experimenter Administration->";
                $where .= basename($PHP_SELF)."||".$title;
                position("$where");
            ?>
              
              
            </tr>
          </table>
        </div>
      </div>
      <div v:shape="_x0000_s3074" class="O"><div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"><hr noshade align="center" width="98%" size="1">
        </div>
      </div>
      <form name="form1" method="post" action="Check_Experiment.php">
        <?
                experimentDetail($expid, $loginName);
        ?>
        
        
        <br>
      </form>
           <br>        
<?
foot_menu();
foot();
?>

