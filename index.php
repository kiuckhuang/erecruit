<?
include "./fun/config.inc";
function have_cookie(){
	global $copy_right;
?>
<table width="752" border="0" vspace="0" hspace="0" align="center">
  <tr> 
    <td> 
      <p>
      <map name="recruitlogo"><area href="<?echo RECRUIT_URL;?>" shape="rect" coords="667, 0, 748, 56"></map>
      <span lang="EN-US" style="mso-fareast-font-family:新細明體;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-fareast-language:ZH-TW"><b><img src="images/top.gif" border="0" usemap="#recruitlogo" width="752" height="60" vspace="0" hspace="0"></b></span></p>
    </td>
  </tr>
  <tr> 
    <td> 
      <div v:shape="_x0000_s3074" class="O"> 
        <div style="mso-line-spacing:&quot;100 50 0&quot;"> 
          <div v:shape="_x0000_s3074" class="O"> 
            <div style="text-align:center;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
            </div>
          </div>
          <div v:shape="_x0000_s3074" class="O">
            <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">
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
                  <td bgcolor="ffffcc" height="250"> 
                    <table width="95%" border="0" cellpadding="3" cellspacing="0" align="center">
                      <tr> 
                        <td> 
                          <hr noshade size="1" width="98%">
                        </td>
                      </tr>
                      <tr valign="middle"> 
                        <td> 
                          <table width="319" border="0" cellpadding="2" align="center">
                           <tr bgcolor="#FFFFCC"> 
                              <td class="bigger_normal"> 
                                <div align="center">System Operation Hours: <? echo SHOW_OPEN_HOUR.":".SHOW_OPEN_MIN." -- ".SHOW_CLOSE_HOUR.":".SHOW_CLOSE_MIN; ?>
                                  </div>
                              </td>
                            </tr>
                            <tr bgcolor="#FFFFCC"> 
                              <td class="tablecolumn"> 
                                <div align="center" class="index"><a href="./subject/">Sign up for experiments 
                                  </a></div>
                              </td>
                            </tr>


                            <tr bgcolor="#FFFFCC"> 
                              <td class="tablecolumn"> 

                                <div align="center" class="index"><a href="./experimenter">Recruit subjects (Faculty Only)
                                  </a></div>
                              </td>
                            </tr>
			     <tr bgcolor="#FFFFCC"> 
                              <td class="tablecolumn"> 

                                <div align="center" class="index"><a href="./mailinglist.php">Join our mailing list 
                                  </a></div>
                              </td>
                            </tr>
                            <!--
                            <tr bgcolor="#FFFFCC"> 
                              <td class="tablecolumn"> 

                                <div align="center" class="index"><a href="http://cebr.ust.hk/cgi-bin/fom/">Frequently Asked Questions                             </a></div>
                              </td>
                            </tr>
                            -->
                          </table>
                        </td>
                      </tr>
                      
                      <tr> 
                        <td class="ack"> 
<hr noshade size="1" width="98%"><? echo $copy_right; ?>
<p>
Here is a <a href="developers.php">link</a>
of the development team. The porting of eRecruit to the New York
University is coordinated by Andrew Schotter and Benjamin H.F. Chiao.
The Internet Technology Services at NYU, especially Tom Cunningham, provides
server support and hosting. Godfrey Chun-Kiu Huang installed and
customized the program.
<P>
For bugs and suggestions, please direct them to <? echo BUG_MAIL_WITH_LINK; ?>.<br>
Center for Experimental Social Science (C.E.S.S.)


                         </td>
                     </tr> 
                    </table>
                  </td>
                  <td background="images/table_r3_c3.gif" height="250">&nbsp;</td>
                  <td height="250">&nbsp;</td>
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
<?
}

function havenot_cookie(){
?>
<table width="752" border="0" vspace="0" hspace="0" align="center">
<tr> 
    <td> 
      <p>
      <map name="recruitlogo"><area href="<?echo RECRUIT_URL;?>" shape="rect" coords="667, 0, 748, 56"></map>
      <span lang="EN-US" style="mso-fareast-font-family:新細明體;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-fareast-language:ZH-TW"><b><img src="images/top.gif" border="0" usemap="#recruitlogo" width="752" height="60" vspace="0" hspace="0"></b></span></p>
    </td>
  </tr>
  <tr> 
    <td> 
      <div v:shape="_x0000_s3074" class="O"> 
        <div style="mso-line-spacing:&quot;100 50 0&quot;"> 
          <div v:shape="_x0000_s3074" class="O"> 
            <div style="text-align:center;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
            </div>
          </div>
          <div v:shape="_x0000_s3074" class="O">
            <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
              <table border="0" cellpadding="0" cellspacing="0" width="628" vspace="0" hspace="0">
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
                  <td bgcolor="ffffcc" height="250"> 
                    <table width="95%" border="0" cellpadding="3" cellspacing="0" align="center">
                     <tr> 
                        <td class="normal"> <b><font size="+1" color="#FF0000">Cookies required.</font></b><br>
If the problem persists, please click on this url:
<b><a href="http://www.econ.nyu.edu/experiments/">http://www.econ.nyu.edu/experiments/</a></b>
<br>
<br>

The browser that you are using does not support Cookies, or you may have Cookies turned off.<br>
                          <u><b>Are you using a browser that doesn't support cookies, 
                          or do you have cookies disabled?</b></u><br> 

Your browser must support cookies, and the option must be enabled to sign in. 
<br><br>
<u><b>To enable cookies </b></u><br>
<br>
                          <font color="#3333FF"><b>Internet Explorer 5 </b></font><br>
<li>Click Tools, and then click Internet Options. 
<li>Click the Security tab. 
<li>Click the Internet zone. 
<li>Select a security level other than High. 
-or- 
<li>Click Custom Level, scroll to the Cookies section, and then click Enable for both cookie options. 
<br>
                            <font color="#3333FF"><b>Internet Explorer 4.x </b></font><br>
<li>Click View, and then click Internet Options. 
<li>Click the Advanced tab. 
<li>Scroll to the Security section. 
<li>Under Cookies, click Always accept cookies. 
<br>
                          <font color="#3333FF"><b>Netscape Communicator 4.6 </b></font><br>

<li>Click Edit
<li>then click Preferences...
<li>Select Advanced from Category
<li>Check Accept all cookies
<br>
                            <b><font color="#3333FF">Other browsers </font></b><br>
To see if your browser supports cookies, and for detailed instructions about how to enable this feature, see the online Help for your browser.<br>
If you see a message to notify you that a Web site is trying to send you a cookie when you try to sign in, you should choose to continue or you will not be able to sign in. <br>
<br>
If your browser does not support cookies, you can upgrade to a newer browser, such as Internet Explorer 5. <br>
                          
                        </td>
                      </tr>
                      <tr> 
                        <td class="ack"> 
                          <hr noshade size="1" width="98%"><? echo COPY_RIGHT; ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td background="images/table_r3_c3.gif" height="250">&nbsp;</td>
                  <td height="250">&nbsp;</td>
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
<?
}
?>
<html>
<head>

<title>Welcome To e-Recruit</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
-->
</style>
<link rel="stylesheet" href="css.css">
</head>
<body bgcolor="#FFFFFF" link="#0000CC" vlink="#0000CC">
<?
if($BROWSER != ""){
	have_cookie();
}
else{
	havenot_cookie();
}
?>

<span class="tablerow"></span> 
</body>
</html>


