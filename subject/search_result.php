<?
require("../fun/subject_functions.inc");

if (is_ust())$isNon = "";
else{ $isNon = "Non-";}

$title=" Search Results";

function content($title){
	global $subjectprofile;
	global $PHP_SELF;
	global $isNon;
	global $expid,$exptitle,$experimenters,$keywords,$sessions,$ck1,$year,$month,$date,$page,$orderby;
	global $keywords1,$logic,$keywords2;
	
	if($keywords == "" || !isset($keywords)){$keywords = $keywords1."->".$logic."->".$keywords2;}
	$fromDate = $year.$month.$date;	
	
	head($title);
	?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
 		<? 
 		$where = "index.php||Log In->search.php|| Search->";
		$where .= basename($PHP_SELF)."||".$title;
		
		position("$where");
		
		//echo $expid,$exptitle,$sessions,$ck1,$year,$month,$date,$page,$orderby;
		$passarg = "expid=$expid&exptitle=$exptitle&sessions=$sessions&ck1=$ck1&year=$year&month=$month&date=$date&page=$page&orderby=$orderby&experimenters=$experimenters&keywords=$keywords";
		?>
 		
              </table>
              <hr noshade align="center" width="98%" size="1">
              
        
			
                    <? if($ck1 == "ExperimentID") searchby($expid,"ExperimentID",$page,$orderby,$passarg);?>
                    <? //if($ck1 == "NumOfSessions") searchby($sessions,"NumOfSessions",$page,$orderby,$passarg); ?>
                    <? if($ck1 == "ExpTitle") searchby($exptitle,"ExpTitle",$page,$orderby,$passarg); ?>
                    <? if($ck1 == "Experimenters") searchby($experimenters,"Experimenters",$page,$orderby,$passarg); ?>
                    <? if($ck1 == "KeyWords") searchby($keywords,"KeyWords",$page,$orderby,$passarg); ?>
                    <? if($ck1 == "FromDate") searchby($fromDate,"FromDate",$page,$orderby,$passarg); ?>
                    <input type="hidden" name="id" value="<? echo $id; ?>">
                    <input type="hidden" name="orderby" value="<? echo $orderby; ?>">
                    <!--
                    <tr> 
                      <td width="24%" valign="top"> 100000014 </td>
                      <td width="27%" class="normal" valign="top"> <a href="link">Bargain 
                        With Search </a></td>
                      <td width="14%" class="normal" valign="top">ANY</td>
                      <td width="17%" class="normal" valign="top">10</td>
                      <td width="18%" class="normal" valign="top">4Jan 2000 </td>
                    </tr>
                    -->
                  </table>
                </td>
              </tr>
            </table>
            <!--<hr noshade align="center" width="98%" size="1">-->
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
if(($ck1 != "ExperimentID") && ($ck1 != "ExpTitle") && ($ck1 != "FromDate") && ($ck1 != "Experimenters") && ($ck1 != "KeyWords")){
	warningx(W0021);exit;
}
if(($ck1 == "ExperimentID") && $expid == ""){
	warningx(W0037);exit;
}
if(($ck1 == "Experimenters") && $experimenters == -1){
	warningx(W0038);exit;
}
if(($ck1 == "KeyWords") && $keywords1 == "" && $keywords2 == "" && $keywords == ""){
	warningx(W0039);exit;
}
if(($ck1 == "ExpTitle") && $exptitle == ""){
	warningx(W0040);exit;
}
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