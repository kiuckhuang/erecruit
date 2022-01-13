<?
$clear = "";
setcookie("choosepool",$clear,time() + 3600);
setcookie("choosecourse",$clear,time() + 3600);
setcookie("chooseopen",$clear,time() + 3600);
setcookie("pool",$clear,time() + 3600);
setcookie("course",$clear,time() + 3600);
$title=" Upcoming Experiments";

include("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}
			
function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
		?>
 		
              </table>
              
                </div>
              </div>


              <form method="POST" action="upcomingexp_expdetails.php">
              <!--<form method="POST" action="setcookieforexpdetails.php">-->
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td height="39" colspan="2"> 
                      <div align="right" class="normal"><a href="pastexp.php">
                        </a></div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="24" bgcolor="ffffcc" colspan="2"> 
                      <div class="normal"> 
                        <div align="left">
<?
     if (is_ust()){
	  echo "If you see the name of the course you are taking in the box below, your instructor should have given you the appropriate sign up code(s). Only experiments open to both ".ORG_SHORT." and/or non-".ORG_SHORT." participants do not require sign up codes. Please choose one button:"; 
	 } else {
	  echo "Please press \"go\"";
	 }
 ?>
</div>
                      </div>
                    </td>
                  </tr>
                  <? if(is_ust()){ ?>
                  <tr> 
                    <td height="39" class="normal"> 
                      <input type="radio" name="choose_exp" value="course_exp" <? if(is_ust()){ echo "checked"; } ?>>
                    </td>
                    <td height="39" class="normal">Experiments for <? echo ORG_SHORT; ?> students to fulfill course requirement of  
         		 <select name="postcourse" >
             		   <option selected value="-1">Choose One Course</option>
            		    <?
           		     	show_all_course_upcoming();
           		     ?>
           		   </select>
                      <hr noshade align="center" width="98%" size="1">
                    </td>
                  </tr>
                  <?}?>
                  <tr> 
                    <td height="39" class="normal"> 
                      <input type="radio" name="choose_exp" value="open_exp" <? if(!is_ust()){ echo "checked"; } ?>>
                    </td>
                    <td height="39" class="normal">Experiments for <? echo ORG_SHORT; ?> and/or non-<? echo ORG_SHORT; ?> participants 
                      <hr noshade align="center" width="98%" size="1">
                    </td>
                  </tr>
                  <tr> 
                    <td height="39" class="normal" colspan="2"> 
                      <div>
                        <input type="submit" name="go" value="Go">
                      </div>
                    </td>
                  </tr>
                </table>
              </form>

              
<? foot_menu();?>

<?
	foot();
}
?>

<?
if(!isset($subjectprofile)){
	warningx("Sorry, <a href='index.php'>Log in</a> first!");
	exit();
}
if(isset($subjectprofile)){
	if(false){
	}
	else{
		content($title);
	}
}else{

}
?>
