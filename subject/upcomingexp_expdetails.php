<?
$title=" Experiment Details";

require("../fun/subject_functions.inc");
//$LOCALTIME = "Hong Kong Time";

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}		

function content($title){
	global $PHP_SELF;
	global $isNon;
	global $choose_exp,$postcourse,$page,$order,$choose_belongto_exptype,$belongto;

	head($title);
	?>
<script language=Javascript>
function changePage(obj) {

    i = obj.redirect.selectedIndex;

    parent.location = obj.redirect.options[i].value;

}
</script>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<?
 		$where = "index.php||Log In->upcomingexp.php|| Upcoming Experiments->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where"); ?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              <form method="POST" action="<? echo $PHP_SELF; ?>">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  	<tr>
                  		<td class="normal" width="50%">
                  			
                  		</td>
                  		<td class="normal" width="50%">
                  			<div align="right">
                  			Sort Experiments by: 
                  			<select name=redirect onChange=changePage(this.form)>
                        		<option value="<? echo basename($PHP_SELF).'?choose_exp='.$choose_exp.'&postcourse='.$postcourse.'&choose_belongto_exptype='.$choose_belongto_exptype.'&belongto='.$belongto;?>">--Choose one--
					<!--<option value="<? echo basename($PHP_SELF).'?order=experimenters&choose_exp='.$choose_exp.'&postcourse='.$postcourse.'&choose_belongto_exptype='.$choose_belongto_exptype.'&belongto='.$belongto;?>">Experimenter-->
					<option value="<? echo basename($PHP_SELF).'?order=title&choose_exp='.$choose_exp.'&postcourse='.$postcourse.'&choose_belongto_exptype='.$choose_belongto_exptype.'&belongto='.$belongto;?>">Title
					<option value="<? echo basename($PHP_SELF).'?order=dateCreated&choose_exp='.$choose_exp.'&postcourse='.$postcourse.'&choose_belongto_exptype='.$choose_belongto_exptype.'&belongto='.$belongto;?>">Last Modified
					</select>
                  			</div>
                  		</td>
                  	</tr>     
                  	<tr>
                  		<td  class="normalbigger" width="50%">                  	 	
                  		</td>
                  		<td class="normal" width="50%">
                  		<div align="right">
                  		<? echo LOCALTIME; ?> : <? print(date( "d M Y h:i a" )); ?>
                  		</div>
                  		<? //echo " choose_exp = $choose_exp , order = $order , orderby= ".$orderby." ifpath = ".$ifpath; ?>	
                  		</td>                                  	
                  	</tr>                              
                  </table>                  
                  </form>
                <!-- /div -->
              <!-- /div -->
<!-- input type="hidden" name="choose_exp" value="<? echo $choose_exp;?>" -->
<!-- input type="hidden" name="postcourse" value="<? echo $postcourse;?>" -->
		<form>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  
                  <tr> 
                    <td width="100%" class="normalbigger">                
                     <b>Click on the experiment title for more details or to sign up.</b>
                    </td>
                  </tr>
                  
                  <? if (is_ust()){ ?>
                  <? if ($choose_exp == "course_exp" ){ ?>
                  <tr>
                    <td width="100%" class="tablecolumn" bgcolor="000099" ><b><font size="3"> Course: 
                    <? $usepostcourse = ereg_replace("__"," ",$postcourse);?>
                    <? $showcourse = ereg_replace("--"," ",$usepostcourse); ?>
                    <? echo $showcourse; ?></font>                                                                          
                    </td>
                  </tr>
                  <tr><td width="100%">
                  <? 
                if($belongto == "Belong_to_Course" || (isset($choose_belongto_exptype) && $choose_belongto_exptype == "course_exptype")){
                     $usepostcourse = ereg_replace("__"," ",$postcourse);
                     $course = split("--",$usepostcourse);//$postcourse == Econ 214 L1 SPRING 2000 
                     //$inputcourse = $course[2]."--".$course[1]."--".$course[0]; //$inputcourse == 2000--SPRING--Econ 214 L1 
                     $inputcourse = $course[0]."--".$course[1]."--".$course[2]; //$inputcourse == Econ 214 L1--2000--SPRING 
                     $result_course = list_all_exp_from($inputcourse,"course",'y',$page,$order);
                     echo $result_course;
                     
                }elseif($belongto == "Belong_to_Pool" || (isset($choose_belongto_exptype) && $choose_belongto_exptype == "pool_exptype")){
                     $usepostcourse = ereg_replace("__"," ",$postcourse);
                     $pool = find_pool_name($usepostcourse);
                     //echo $pool;//COMP--2000--SPRING 
                     $pool = split("--",$pool);//target.experiment pool->MGTO--2008--SPRING
                     $inputpool = $pool[0]."--".$pool[1]."--".$pool[2];
                     $result_pool = list_all_exp_from($inputpool,"pool",'y',$page,$order);  
                     echo $result_pool;
                }else{
                	echo "belongto = $belongto";
                }
                  ?>
                  </td></tr>
                  <? } ?>

                  <? } ?>
                  <? if ( $choose_exp == "open_exp" ) {?>
                  <tr>
                    <td width="100%" class="tablecolumn" bgcolor="000099" ><b><font size="3">Experiments 
                      open to <? echo ORG_SHORT; ?>and/or Non-<? echo ORG_SHORT; ?> participants</font></b></td>
                  </tr>
                  <tr><td>
		<?
		list_all_open_exp('y',$page,$order);
		?>
		  </td></tr>
                <? }?>  
                </table>
                </form>
<?	
	foot_menu();
	foot();
}

function Choose_Exptype($title){
	global $PHP_SELF;
	global $isNon;
	global $choose_exp,$postcourse,$page,$order;
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


              <form method="POST" action="<? echo $PHP_SELF;?>">
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
                        <div align="left">Please choose one button :</div>
                      </div>
                    </td>
                  </tr>
                  <? //if(is_ust()){ ?>
                  <tr> 
                    <td height="39" class="normal"> 
                      <input type="radio" name="choose_belongto_exptype" value="course_exptype" checked>
                    </td>
                    <td height="39" class="normal">
                    Show experiments restricted to 
                    <? $usepostcourse = ereg_replace("__"," ",$postcourse); ?>
                    <? $showcourse = ereg_replace("--"," ",$usepostcourse); ?>
                    <? echo $showcourse; ?>
                      <hr noshade align="center" width="98%" size="1">
                    </td>
                  </tr>
                  <tr>
                    <td height="39" class="normal"> 
                      <input type="radio" name="choose_belongto_exptype" value="pool_exptype">
                    </td>
                    <td height="39" class="normal">
                    <? $usepostcourse = ereg_replace("__"," ",$postcourse); ?>
                    <? $showpoolname = find_pool_name($usepostcourse);?>
                    <? $showpoolname = split("--",$showpoolname);?>
                    <? $showpoolname = $showpoolname[0]." ".$showpoolname[2]." ".$showpoolname[1];?>
                      Show experiments restricted to <? echo $showpoolname; ?> subject pool
                      <hr noshade align="center" width="98%" size="1">
                    </td>
                  </tr>
                  <? //} ?>
                  
                  <tr> 
                    <td height="39" class="normal" colspan="2"> 
                      <div align="right">
                        <input type="submit" name="go" value="Go">
                      </div>
                    </td>
                  </tr>
                </table>
<input type="hidden" name="choose_exp" value="<? echo $choose_exp;?>">
<input type="hidden" name="postcourse" value="<? echo $postcourse;?>">
              </form>

              
<? foot_menu();?>
<?
	foot();
}
?>



<?
//------------ Main -------------------
if(!isset($choose_exp)){
	warningx(W0021); exit;
}
if(isset($choose_exp) && $choose_exp == "course_exp" && $postcourse == "-1"){
	warningx(W0036); exit;
}
if(isset($subjectprofile)){
	$usepostcourse = ereg_replace("__"," ",$postcourse);
	$belongto = belongto_exptype($usepostcourse);
	if($belongto == "Belong_to_Both" && !isset($choose_belongto_exptype)){
		Choose_Exptype($title);
	}elseif($belongto == "Belong_to_Both" && isset($choose_belongto_exptype)){
		content($title);
	}else{
		content($title);
	}
}else{
	warningx(W0002);exit;
}

?>
