<?
require("../fun/exp_functions.inc");

//if (is_ust())$isNon = "";
//else{ $isNon = "Non-";}

$title="Search";

function content($title){
	global $expprofile;
	global $PHP_SELF;
	//global $isNon;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Home->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where"); ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
<form method="post" action="search_result.php">
  <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0" align="center">
    <!-- fwtable fwsrc="logo.png" fwbase="table.gif" --> 
    <tr> <!-- Shim row, height 1. --> 
      <td><img src="images/shim.gif" width="630" height="1" border="0"></td>
      <td><img src="images/shim.gif" width="10" height="1" border="0"></td>
      <td><img src="images/shim.gif" width="1" height="1" border="0"></td>
    </tr>
    <tr valign="top"><!-- row 2 --> 
      <td colspan="2"><img name="table_r2_c2" src="images/table_r2_c2.gif" width="640" height="20" border="0"></td>
      <td><img src="images/shim.gif" width="1" height="20" border="0"></td>
    </tr>
    <tr valign="top"><!-- row 3 --> 
      <td bgcolor="ffffcc"> 
        <table width="95%" border="0" cellpadding="3" cellspacing="0" align="center">
          <tr> 
            <td colspan="3"><b><font color="#330099" face="Arial, Helvetica, sans-serif"> 
              Choose one category to search for more experiment details. Follow the instructions on the Search Results page for the session IDs . </font></b> 
              <hr noshade size="1" width="98%">
            </td>
          </tr>
          <tr> 
            <td width="26%" rowspan="11" valign="top"> 
              <p class="normal"></p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            </td>
            <td colspan="2"> 
              <p class="normal"> 
                <input type="radio" name="ck1" value="ExperimentID">
                Experiment ID:<br>
                <input type="text" name="expid">
              </p>
            </td>
          </tr>
          <!--
          <tr> 
            <td colspan="2" height="23"> 
              <hr noshade size="1" width="98%">
            </td>
          </tr>
          <tr> 
            <td colspan="2" class="normal"> 
              <input type="radio" name="ck1" value="NumOfSessions">
              Number(s) of Session of Experiments:<br>
              <input type="text" name="sessions">
            </td>
          </tr>
          -->
          <tr> 
            <td colspan="2" class="normal"> 
              <hr noshade size="1" width="98%">
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="52"> 
              <p class="normal"> 
                <input type="radio" name="ck1" value="ExpTitle">
                Experiment Title:<br>
                <input type="text" name="exptitle">
              </p>
            </td>
          </tr>
          <tr>
            <td colspan="2" height="2" valign="bottom">
              <hr noshade size="1" width="98%">
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="52"> 
              <p class="normal"> 
                <input type="radio" name="ck1" value="Experimenters">
                Experimenter:<br>
                <select name="experimenters">
                <? Select_experimenters();?>
                </select>
              </p>
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="2" valign="bottom">
              <hr noshade size="1" width="98%">
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="52"> 
              <p class="normal"> 
                <input type="radio" name="ck1" value="KeyWords">
                Keywords:<br>
                <input type="text" name="keywords1">
                <select name="logic">
                  <option>AND</option>
                  <option>OR</option>
                </select>
                <input type="text" name="keywords2">
              </p>
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="2" valign="bottom"> 
              <hr noshade size="1" width="98%">
            </td>
          </tr>
          <tr> 
            <td width="57%" class="normal" height="2"> 
              <input type="radio" name="ck1" value="FromDate">
              Experiment Created/Modified On :<br>
              <select name="date">
                <?
                  	for($i=1; $i<=31; $i++){
                  		if($i <10){
                  			$j = "0".$i;
                  		}
                  		else{
                  			$j = $i;
                  		}
                  		
                  		
                  		echo "<option value=\"$j\">$j</a>\n";
                  	}
                  ?> 
              </select>
              <select name="month">
                <?
                  	$month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                  
                  	for($i=0; $i<12; $i++){
                  		$j=$i+1;
                  		if($j <10)
                  			$k = "0".$j;
                  		else
                  			$k = $j;
                  		echo "<option value=\"$k\">$month[$i]</a>\n";
                  	}
                  ?> 
              </select>
              <select name="year">
                <?
                  	for($i=2000; $i<=2050; $i++){
                  		echo "<option value=\"$i\">$i</a>\n";
                  	}
                  ?> 
              </select>
            </td>
            <td width="17%" class="normal" valign="bottom" height="2"> 
              <div align="right"> 
                <input type="submit" name="searchbutton" value="Search">
              </div>
            </td>
          </tr>
          
        </table>
      </td>
      <td background="images/table_r3_c3.gif">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top"><!-- row 4 --> 
      <td colspan="2"><img name="table_r4_c2" src="images/table_r4_c2.gif" width="640" height="25" border="0"></td>
      <td><img src="images/shim.gif" width="1" height="25" border="0"></td>
    </tr>
    <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > </map> 
    <!--   This table was automatically created with Macromedia Fireworks 3.0   --> 
    <!--   http://www.macromedia.com   --> 
  </table>
</form>

<?
	foot_menu();
	foot();
}
?>

<?
  //-------------main-----------
//content($title);
  //----------------------------
?>

<?

if(isset($expprofile)){
	if(false){
		/*
		$condition = "$radio"."->"."$loginName";
			
		if(!checkexpid($condition)){
			warning("This experiment is not belong to you!");
			exit();	
		}
		
		
		if($adminaction== "View/Modify Experiment"){
			header("Location: ./View-Modify_Experiment.php?expid=$radio");
			exit();
		}
		else if($adminaction== "Delete Experiment"){
			header("Location: ./Delete_Exp.php?expid=$radio");
			exit();
		}
		else if($adminaction=="Session Management"){
			header("Location: ./Session_Management/index.php?expid=$radio");
			exit();
		}
		else{
			echo "testing";
			exit();
		}
		*/
	}
	else{
		content($title);
	}
}else{
	warning(T0067);
}
	
	


?>
