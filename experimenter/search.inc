<?
function searchby($arg1,$what,$page,$orderby,$passarg){
	global $PHP_SELF;
	$passarg = split("&",$passarg);
	$passarg[8] = "orderby=id";
	$passarg_id = implode("&",$passarg);
	$passarg[8] = "orderby=title";
	$passarg_title = implode("&",$passarg);
	$passarg[8] = "orderby=mode";
	$passarg_mode = implode("&",$passarg);
	$passarg[8] = "orderby=sessions";
	$passarg_sessions = implode("&",$passarg);
	$passarg[8] = "orderby=dateCreated";
	$passarg_dateCreated = implode("&",$passarg);
	$db = new phpDB();
	$db->connect() or die ("Can't connect to database server or select database");
	//if(!is_ust()){ $target = " and target = 'open' " ;} else { $target = "" ;}
	if($orderby == "") $orderby = "id";
	if($what == "ExperimentID"){
		$query="select id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated, experimenters, mode, sessions, software, preRequisite, target, category from experiment where id = '$arg1' and enable = 'y' $target order by $orderby ASC";		
	}
	if($what == "NumOfSessions"){
		$query="select id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated, experimenters, mode, sessions, software, preRequisite, target, category from experiment where sessions = '$arg1' and enable = 'y' $target order by $orderby ASC";				
	}
	if($what == "ExpTitle"){
		$query="select id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated, experimenters, mode, sessions, software, preRequisite, target, category from experiment where title like '%$arg1%' and enable = 'y' $target order by $orderby ASC";	
	}
	if($what == "Experimenters"){
		$query="select id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated, experimenters, mode, sessions, software, preRequisite, target, category from experiment where experimenters like '%$arg1%' and enable = 'y' $target order by $orderby ASC";	
	}
	if($what == "KeyWords"){
		$keyword = split("->",$arg1);//keyword{0,1,2} = keywords1, logic, keywords2 where logic = AND,OR
		$arg1 = $keyword[0];
		$logic = $keyword[1];
		$arg2 = $keyword[2];
		if ($arg1 == "" || $arg2 == "" ){
			$logic = "OR";
		}
		$searchbykeyword = "((title like '%$arg1%' $logic title like '%$arg2%')or( description like '%$arg1%' $logic  description like '%$arg2%' ))";
		$query="select id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated, experimenters, mode, sessions, software, preRequisite, target, category from experiment where $searchbykeyword and enable = 'y' $target order by $orderby ASC";	
	}
	if($what == "FromDate"){
		$query="select id, title, description, UNIX_TIMESTAMP(dateCreated) as dateCreated, experimenters, mode, sessions, software, preRequisite, target, category from experiment where dateCreated = '$arg1' and enable = 'y' $target order by $orderby ASC";	
	}
	$rs = $db->query($query);
	$numOfRows = $rs->getNumOfRows();
	?>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td class="normal" width="48%">
              <ul>
              <li>
              To sort the table according to a particular column, please click on the corresponding header. 
              </li>
              <li>
              Click on the experiment title to find out the session IDs.
              </li>
              </ul>
              </td></tr>
              <!--
              <tr>
               <td width="52%"> 
                <div align="right" class="normal"> More Search Results:
                  | <a href="<? echo $PHP_SELF; ?>">1</a> 
                  | <a href="<? echo $PHP_SELF; ?>">2</a> | <a href="<? echo $PHP_SELF; ?>">3</a> | <a href="<? echo $PHP_SELF; ?>">4</a> 
                  | <a href="<? echo $PHP_SELF; ?>">5</a> 
                  |</div>
              </td>
            </tr>
            -->
          </table>
        </div>
      </div>
      <div v:shape="_x0000_s3074" class="O"> 
        <div style="text-align:center;mso-line-spacing:&quot;100 50 0&quot;;mso-char-wrap:1;
mso-kinsoku-overflow:1" class="pagetitle"> 
          <hr noshade align="center" width="98%" size="1">
          <form method="post" action="">
            <table width="100%" cellpadding="3" cellspacing="0">
              <tr> 
                <td colspan="3" class="normal" height="16"> 
                  <table width="100%" cellpadding="2" cellspacing="0" border="1" bordercolorlight="#CCCCCC" bordercolordark="#CCCCCC" bordercolor="#CCCCCC">
                    <tr>
                      <td width="24%" class="tablecolumn" bgcolor="#ffffcc" valign="top" height="21"><a href="<? echo "$PHP_SELF?$passarg_id"; ?>">Experiment ID</a></td>
                      <td width="27%" class="tablecolumn" bgcolor="#ffffcc" valign="top" height="21"><a href="<? echo "search_result.php?$passarg_title"; ?>">Experiment Title</a></td>
                      <!--<td width="14%" class="tablecolumn" bgcolor="#ffffcc" valign="top" height="21"><a href="<? echo "search_result.php?$passarg_mode"; ?>">Mode</a></td>-->
                      <!--<td width="17%" class="tablecolumn" bgcolor="#ffffcc" valign="top" height="21"><a href="<? echo "search_result.php?$passarg_sessions"; ?>">No. of Sessions</a></td>-->
                      <td width="18%" class="tablecolumn" bgcolor="#ffffcc" valign="top" height="21"><a href="<? echo "search_result.php?$passarg_dateCreated"; ?>">Created/Modified On</a></td>
                    </tr>
	<?
	if ( $numOfRows == 0 ){
	?>
	<tr>
	<td colspan=3 width="26%" class="normal" bgcolor="ffffcc">No experiment is available.</td>	
	</tr>
	<?
	$rs->close();		
	$db->close();	/*	optional	*/
	return 0;
	}
	for($i=0; $i <$numOfRows; $i++){
		$rs->moveRow($i);
		$id = $rs->fields[id];
		$title = $rs->fields[title];
		$description = $rs->fields[description];
		$experimenters = $rs->fields[experimenters];
		$dateCreated = $rs->fields[dateCreated];
		$mode = $rs->fields[mode];
		$sessions = $rs->fields[sessions];
		$dateCreatedshow = date("j M,Y",$dateCreated);
		
		//$query = "select sessions from experiment where id = '$id'";
        
	        //$rs1 = $db->query($query);
	        //$rs1->firstRow();
	        //$expsessionno = $rs1->fields[sessions];
        
		$query = "select count(id) as total from session where id like '$id%'";
        
       		$rs2 = $db->query($query);
	        $rs2->firstRow();
        	$total = $rs2->fields[total];
                
	        if($total == $sessions){
		?>
		    <tr> 
                      <td width="24%" valign="top"><? echo $id; ?></td>
                      <td width="27%" class="normal" valign="top"> <!-- a href="expdetails_exptitle.php?id=<? echo $id; ?>" -->
                      <a href="expdetails.php?id=<? echo $id; ?>"><? echo $title; ?></a>
                      </a></td>
                      <!--<td width="14%" class="normal" valign="top"><? echo $mode; ?></td>-->
                      <!--<td width="17%" class="normal" valign="top"><? echo $sessions; ?></td>-->
                      <td width="18%" class="normal" valign="top"><? echo $dateCreatedshow; ?></td>
                    </tr>
                <?
		}
		//$rs1->close();
		$rs2->close();               
	}
	$rs->close();		
	$db->close();	/*	optional	*/
	return 0;
}
?>
