<?
require("../fun/exp_functions.inc");
checkLogin();

if(isset($view) && $view =="View/Modify Experiment"){
	setcookie( "expid", $expid, time()+3600); 
	header("Location: ./View-Modify_Experiment.php");
	exit();
}
if(isset($del) && $del!="" && $expid!=""){
	
	del_experiment($expid);
	message("T0066<br>Experiments with $expid have been deleted successfully!\n", "Experimenter_Administration.php");
	exit();
	

}
if(isset($sessman) && $sessman=="Session Management"){
	setcookie( "expid", $expid, time()+3600); 
	header("Location: ./Session_Management.php");
	exit();
}
header("Location: ./Experimenter_Administration.php");

?>