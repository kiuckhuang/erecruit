<?
include("../fun/exp_functions.inc");
checkLogin();

$title="Experiment ID Search";
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
      <hr noshade align="center" width="98%" size="1">
	<table width="100%" cellpadding="2" border="1" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC">
              <tr bgcolor="#000099"> 
                
                <td width="15%" class="tablecolumn" bgcolor="#000099"> Experiment 
                  ID </td>
                <td width="18%" class="tablecolumn">Experiment Title </td>
                <td width="45%" class="tablecolumn">Description </td>
                <td width="16%" class="tablecolumn">Created on</td>
              </tr>
              <?
              	show_all_experiment();
              	?>
            </table>
            <hr noshade align="center" width="98%" size="1">
            
<?

foot();
?>
