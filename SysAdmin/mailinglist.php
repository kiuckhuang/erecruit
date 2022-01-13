<?
include("../fun/admin_functions.inc");



if(isset($sendmail) && $sendmail=="Send Mail"){
	mailinglist($list, $course_list);
}
if(isset($action)){
	if($email == ""){
		warning(S0029);
	}else{
		$cno = 0; 
		if($category[0] == "on"){
			$category[0] = "course";
			$cno++;
		}else{
			echo $category[0];
		}
		
		if($category[1] == "on"){
			$category[1] = "hkust";
			$cno++;
		}
		if($category[2] == "on"){
			$category[2] = "public";
			$cno++;
		}
		
		
		if($cno == 0){
			warning(S0030);
		}
	}




if($action == "subscribe"  && trim($email) != ""){
	$addmail = ereg_replace(" ", "", $email);
	$addmails = explode(",", $addmail);
		
	for($l = 0; $l< sizeof($addmails); $l++){
		
		if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $addmails[$l]) && trim($addmails[$l]) !="") {
  			warning(S0013);
		}
		
		if(trim($addmails[$l]) !=""){
			$addmaillist = $addmails[$l];
			$addmaillists .= $addmaillist.",";
		}
		
			
	}
	
	$addmaillists = substr($addmaillists, 0, strlen($addmaillists)-1);
	addmail2list($addmaillists, $category, $course);
	exit;
}



if($action == "unsubscribe" && trim($email) != ""){
	$delmail = ereg_replace(" ", "", $email);
	$delmails = explode(",", $delmail);
		
	for($l = 0; $l< sizeof($delmails); $l++){
		
		if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $delmails[$l]) && trim($delmails[$l]) !="") {
  			warning(S0013);
		}
		
		if(trim($delmails[$l]) !=""){
			$delmaillist = $delmails[$l];
			$delmaillists .= $delmaillist.",";
		}
		
			
	}
	
	$delmaillists = substr($delmaillists, 0, strlen($delmaillists)-1);
	delmail2list($delmaillists, $category, $course);
}


}
	




$title = "Mailing List Administration";
head($title);

?>

              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                <?
                
		$where = "index.php||Home->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");

		?>
                </tr>
              </table>
              
                <table border="0" width="800" align="center">
<div style="text-align:right;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;mso-kinsoku-overflow:1" class="pagetitle"> 
<b><font color="#996600" size=+2></font></b>
              <hr noshade align="center" width="98%" size="1">
            
          </div>
          <form method="post" action="<? echo $PHP_SELF; ?>">
	    <font class="normal">  
               <tr>
    <td>
       <table width="100%" border="0">
        <tr>
          <td width="50%">Please input the email address:</td>
          <td width="50%"><input type="text" name="email" value="" size="33"></td>
        </tr>
        <tr> 
          <td width="50%">Please select category(s) for the mailing list:</td>
        <td width="50%">
        <input type="checkbox" name="category[0]">
        
	<select name="course_list">
	
			<?
				select_course();
			?>
	  </td>

        </tr>
        <tr> 
          <td width="50%">&nbsp;</td>
            <td width="50%"><input type="checkbox" name="category[1]" >Experiments for <? echo ORG_SHORT; ?> staff/students only
            </td>
          
          
        </tr>
        <tr> 
          <td width="50%">&nbsp;</td>
            <td width="50%"><input type="checkbox" name="category[2]" >Experiments for all subjects
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


         <form method="post" action="<? echo $PHP_SELF; ?>">
              <hr width="98%" size="1" noshade align="center">
              <p class="tablerow"><b>Send E-Mail to the Mailing List:</b><br>
                <table width="100%" cellpadding="3" bordercolor="#CCCCCC" border="0" cellspacing="0">
                  <tr> 
                    <td width="14%" class="tablerow">From :</td>
                    <td width="86%">e-Recruit System Administrator
                    </td>
                  </tr>
                  
                  <tr> 
                    <td width="14%" class="tablerow">Subject :</td>
                    <td width="86%"> 
                      <input type="text" name="subject" value="">
                    </td>
                  </tr>
                  <tr> 
                    <td width="14%" class="tablerow">cc:</td>
                    <td width="86%"> 
                      <input type="text" name="cc" value="">
                    </td>
                  </tr>
                  <tr> 
            </table>
            <table width="100%" cellpadding="3" bordercolor="#CCCCCC" border="0" cellspacing="0">
          <td width="30%">Please select mailing list(s):</td>
        <td width="70%">
        <input type="checkbox" name="list[0]">
        <select name="course">
        <option value="all">All Course Lists</option>
			<?
				select_course();
			?>
	  </td>

        </tr>
        <tr> 
          <td width="30%">&nbsp;</td>
            <td width="70%"><input type="checkbox" name="list[1]" >Experiments for <? echo ORG_SHORT; ?> staff/students only
            </td>
          
          
        </tr>
        <tr> 
          <td width="30%">&nbsp;</td>
            <td width="70%"><input type="checkbox" name="list[2]" >Experiments for all subjects
            </td>
          
          
        </tr>
                  <tr> 
                    <td width="30%" class="tablerow">Message:</td>
                    <td width="70%">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td colspan="2"> 
                      <textarea name="message" rows="3" cols="70" value=""></textarea>
                      <input type="submit" name="sendmail" value="Send Mail">
                    </td>
                  </tr>
                </table>
              </form>
<?
foot();
?>