<?
function head($title){
?>
<html>
<head>
<title><? echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
-->
</style>
<link rel="stylesheet" href="css.css">
</head>

<body bgcolor="#FFFFFF">
<table width="752" border="0" vspace="0" hspace="0" align="center">
  <tr> 
    <td> 
      <p>
      <map name="recruitlogo"><area href="<?echo RECRUIT_URL;?>" shape="rect" coords="667, 0, 748, 56"></map>
      <span lang="EN-US" style="mso-fareast-font-family:·s²Ó©úÅé;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-fareast-language:ZH-TW"><b><img src="images/top.gif" border="0" usemap="#recruitlogo" width="752" height="60" vspace="0" hspace="0"></b></span></p>
    </td>
  </tr>
  <tr> 
    <td> 
      <div v:shape="_x0000_s3074" class="O"> 
        <div style="mso-line-spacing:&quot;100 50 0&quot;"> 
          <div v:shape="_x0000_s3074" class="O"> 
            <div style="mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle">
            <?
}
        
function foot(){
	?>
            </div>
	</div>
          </div>
      </div>
    <hr noshade align="center" width="98%" size="1">
          <p class="notes"><i><? echo COPY_RIGHT; ?></i></p>
    </td>
     
  </tr>
 
</table>
<span class="normal"></span> 

</body>
</html>
<?

}

function warning($warningMSG){
	$title="Warning Message!";

head($title);
?>
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0" align="center">

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
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial">Warning !</font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo $warningMSG; ?></font></p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="right">
                            <hr noshade size="1" width="98%">
                            <a href="javascript:history.back()"><img src="images/but_ok.gif"  border="0"></a></div>
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
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
            
<?
foot();
exit();
}
        
function message($MSG, $link){
	$link = eregi_replace(" ", "+", $link);
	$title="Message!";
	head($title);
?>
	<div align="center">
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">

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
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial">Message:</font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo $MSG; ?></font></p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="right">
                            <hr noshade size="1" width="98%">
                            <a href="<? echo $link; ?>"><img src="images/but_ok.gif"  border="0"></a></div>
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
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
            </div>


	
<?
foot();
exit();
}

function confirm($MSG, $link){
	$link = eregi_replace(" ", "+", $link);
	$title="Confirmation!";
	head($title);
?>
             <div align="center">
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">

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
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial">Confirmation:</font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo $MSG; ?></font></p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <hr noshade size="1" width="98%">
                          <div align="right">
                            <a href="javascript:history.back()"><img src="images/but_no.gif"  border="0"></a>
                            <a href="<? echo $link; ?>"><img src="images/but_yes.gif"  border="0"></a></div>
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
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
            </div>


	
<?
foot();
exit();
}



//function to display the location at every page!
function position($posStr){
	$links = explode("->", $posStr);
	for($i =0; $i< sizeof($links); $i++){
		list($link, $description) = explode("||", $links[$i]);
		if($i != (sizeof($links) -1) ){
			print("<a href=\"$link\">$description</a>->");
		}
		else {
			print("$description");
		}
		
	}
}


function yesno($MSG, $link_yes, $link_no){
	$title="Confirmation!";
	head($title);
?>
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">

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
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial">Confirmation:</font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo $MSG; ?></font></p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <hr noshade size="1" width="98%">
                          <div align="right">
                            <a href="<? echo $link_no; ?>"><img src="images/but_no.gif"  border="0"></a>
                            <a href="<? echo $link_yes; ?>"><img src="images/but_yes.gif"  border="0"></a></div>
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
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
<?
foot();
exit();
}



function warning_backtohome($warningMSG){
	$title="Warning Message!";

?>
<html>
<head>
<title><? echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
-->
</style>
<link rel="stylesheet" href="css.css">
</head>
<body bgcolor="#FFFFFF">
<table width="752" border="0" vspace="0" hspace="0" align="center">
  <tr> 
    <td> 
      <p><span lang="EN-US" style="mso-fareast-font-family:·s²Ó©úÅé;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-fareast-language:ZH-TW"><b><img src="images/top.gif" width="752" height="60" vspace="0" hspace="0"></b></span></p>
    </td>
  </tr>
  <tr> 
    <td height="243"> 
      <div v:shape="_x0000_s3074" class="O">
        <div style="mso-line-spacing:&quot;100 50 0&quot;"> 
          <div v:shape="_x0000_s3074" class="O">
           
            <div style="text-align:center;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">

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
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial">Warning !</font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo $warningMSG; ?></font></p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="right">
                            <hr noshade size="1" width="98%">
                            <a href="index.php"><img src="images/but_back.gif"  border="0"></a></div>
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
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
</table>
</body>
</html>

<?
}

function warning_backtocreateacc($warningMSG){
	$title="Warning Message!";

?>
<html>
<head>
<title><? echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
-->
</style>
<link rel="stylesheet" href="css.css">
</head>
<body bgcolor="#FFFFFF">
<table width="752" border="0" vspace="0" hspace="0" align="center">
  <tr> 
    <td> 
      <p><span lang="EN-US" style="mso-fareast-font-family:·s²Ó©úÅé;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-fareast-language:ZH-TW"><b><img src="images/top.gif" width="752" height="60" vspace="0" hspace="0"></b></span></p>
    </td>
  </tr>
  <tr> 
    <td height="243"> 
      <div v:shape="_x0000_s3074" class="O">
        <div style="mso-line-spacing:&quot;100 50 0&quot;"> 
          <div v:shape="_x0000_s3074" class="O">
           
            <div style="text-align:center;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">

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
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial">Warning !</font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo $warningMSG; ?></font></p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="right">
                            <hr noshade size="1" width="98%">
                            <a href="index.php"><img src="images/but_back.gif"  border="0">
                            </a>
                            <a href="Create_Account.php"><img src="images/but_create_acc.gif"  border="0">
                            </a>
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
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
</table>
</body>
</html>

<?
}

function warningx($warningMSG="Warning!!!",$warningtitle="Warning!",$linkto="javascript:history.back(1)"){
	global $PHP_SELF;
	if(!isset($warningMSG)){
		$warningMSG="Warning!!!";
	}	
	if(!isset($warningtitle)){
		$warningtitle="Warning!";
	}
	if(!isset($linkto)){
		$warningMSG="PHP_SELF";
	}
?>
<html>
<head>
<title><? echo $warningtitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
-->
</style>
<link rel="stylesheet" href="css.css">
</head>
<body bgcolor="#FFFFFF">
<table width="752" border="0" vspace="0" hspace="0" align="center">
  <tr> 
    <td> 
      <p><span lang="EN-US" style="mso-fareast-font-family:·s²Ó©úÅé;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-fareast-language:ZH-TW"><b><img src="images/top.gif" width="752" height="60" vspace="0" hspace="0"></b></span></p>
    </td>
  </tr>
  <tr> 
    <td height="243"> 
      <div v:shape="_x0000_s3074" class="O">
        <div style="mso-line-spacing:&quot;100 50 0&quot;"> 
          <div v:shape="_x0000_s3074" class="O">
           
            <div style="text-align:center;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">

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
                        <td class="normal"><b><font color="#FF0000" size="+1" face="Arial"><? echo $warningtitle; ?></font></b> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="normal"><font  face="Arial"><? echo $warningMSG; ?></font></p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="right">
                            <hr noshade size="1" width="98%">
                            <? if ($warningMSG != W0002){?> 
                            <a href="<? echo $linkto;?>"><img src="images/but_back.gif"  border="0"></a>
                	    <? } else {?>
                	    <? } ?>
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
                <map name="m_null"> <area shape="rect" coords="1,228,2,229" href="#" > 
                </map>
              </table>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
</table>
</body>
</html>

<?
}

?>