<?
$title="Past Experiments";

include("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}
			
function content($title){
	global $expprofile;
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


              <form method="POST" action="pastexp_expdetails.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr> 
                    <td height="39" colspan="2"> 
                      <div align="right" class="normal"><!--<a href="upcomingexp.php">Click Here 
                        for Upcoming Experiments</a>--></div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="24" bgcolor="ffffcc" colspan="2"> 
                      <div class="normal"> 
                        <div align="left">You can view experiments that have been added to e-Recruit some time ago here. But they are no longer available for signing up.
                           </div>
                      </div>
                    </td>
                  </tr>
                  <? if(is_ust()){ ?>
                  
                  <!--
                  <tr> 
                    <td height="39" class="normal" width="5%"> 
                      <input type="checkbox" name="postchoosepool">
                    </td>
                    <td height="39" class="normal" width="95%">
                     <font color="#FF0000">ANY</font> <font color="#FF0000">Marketing</font> 
                      course in <font color="#FF0000">Fall99 </font>
                      Experiments restricted for
                          <select name="postpool" >
             		   <option selected value="-1">Choose One Pool</option>
            		    <?
           		     	show_all_pool();
           		     ?>
           		  </select>
                      <hr noshade align="center" width="98%" size="1">
                    </td>
                  </tr>
                   -->
                  <tr> 
                    <td height="39" class="normal"> 
                      <input type="radio" name="choose_exp" value="course_exp" checked>
                    </td>
                    <td height="39" class="normal">Experiment(s) for <? echo ORG_SHORT; ?> students to fulfill course requirement of  
         		 <select name="postcourse" >
             		   <option selected value="-1">Choose One Course</option>
            		    <?
           		     	show_all_course();
           		     ?>
           		   </select>
                      <hr noshade align="center" width="98%" size="1">
                    </td>
                  </tr>
                  <?}?>
                  <tr> 
                    <td height="39" class="normal"> 
                      <input type="radio" name="choose_exp" value="open_exp">
                    </td>
                    <td height="39" class="normal">Experiment(s) for <? echo ORG_SHORT; ?> and/or non-<? echo ORG_SHORT; ?> participants 
                      <hr noshade align="center" width="98%" size="1">
                    </td>
                  </tr>
                  <tr> 
                    <td height="39" class="normal" colspan="2"> 
                      <div align="left">
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
if(isset($subjectprofile)){
	if(false){
	}
	else{
		content($title);
	}
}else{
	warningx(W0002);
}
?>
