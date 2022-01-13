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
       <table width="100%" border="0">
        <tr> 
          <td colspan="2">Do you want to receive information of upcoming experiments 
            from e-Recruit? Please join the e-Recruit mailing list.</td>
        </tr>
        <tr> 
          <td width="60%">Please Input your Email Address:</td>
          <td width="40%"><input type="text" name="email" value="" size="33"></td>
        </tr>
        <tr> 
          <td width="60%">Please select one catetory for the mailing list:</td>
        <td width="40%"><input type="radio" name="category" value="pool">
				<?
					select_pool();
				?>
	  </td>
        
        
          
        </tr>
        <tr> 
        <td width="60%">&nbsp;</td>
          <td width="40%"><input type="radio" name="category" value="course">
			<?
				select_course();
			?>
	  </td>
          
        </tr>
        <tr> 
          <td width="60%">&nbsp;</td>
            <td width="40%"><input type="radio" name="category" value="all">All the pools and courses
            </td>
          
          
        </tr>
        <tr> 
          <td width="60%">&nbsp;</td>
            <td width="40%"><input type="radio" name="category" value="non">None of the pools and courses
            </td>
          
          
        </tr>
      </table>
      
      

    </td>
  </tr>
               <tr> 
                <td> 
                  <div align="right"> 
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

