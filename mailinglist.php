<?
include("./fun/mailinglist.inc");

$title = "Mailing List Subscribe/Unsubcribe";
head($title);
?>

<table border="0" width="800" align="center">
<div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
<b><font color="#996600" size=+2>Mailing List Subscribe/Unsubcribe</font></b>
              <hr noshade align="center" width="98%" size="1">
            
          </div>
          <form method="post" action="mailinglist_check.php">
	    <font class="normal">  
               <tr>
    <td>
       <table width="90%" border="0">
        <tr> 
          <td colspan="2">Please join the e-Recruit mailing lists to receive information of upcoming experiments. You can subscribe to one mailing list at one time. To join more than one list, just visit this page again:</td> <p>
        </tr>
        <tr></tr>
        <tr> 
          <td width="100%">Your email address:<input type="text" name="email" value="" size="33"></td> 
        </tr>
        <tr></tr>
        <tr> 
          <td width="100%">
        <input type="radio" name="category" value="course">
        I'd like to receive information of experiments for the course:
			<?
				select_course();
			?>
	    </td>

        </tr>
        <tr> 
            <td width="100%"><input type="radio" name="category" value="org">
        I'd like to receive information of experiments for ALL <? echo ORG_SHORT; ?> courses
            
            </td>
          
          
        </tr>
        <tr> 
            <td width="100%"><input type="radio" name="category" value="public">
        I'd like to receive information of experiments open to <? echo ORG_SHORT; ?> and/or non-<? echo ORG_SHORT; ?> participants
            </td>
          
          
        </tr>
      </table>
      
      

    </td>
  </tr>
               <tr> 
                <td> 
                  <div align="center"> 
                    <input type="submit" value="subscribe" name="action">
                    <input type="submit" value="unsubscribe" name="action">
                    <input type="reset" value="Reset" name="reset">
                  </div>
                </td>
              </tr>
            </table>
          </form>
  

<?




foot();
?>

