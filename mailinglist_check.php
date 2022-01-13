<?
include("./fun/mailinglist.inc");



if(isset($email)){
	check_mail_format($email);
	if($category != ""){
		if($category == "course"){
			if($course !=""){
				$name=$course;
			}
			else{
				warning(M0001);
				exit;
			}
		}
		
	}else{
		warning(M0002);
		exit;
	}
}


if($action =="subscribe"){
	if(mailexist($email, $category, $name)){
		warning(M0003);
		exit;
	}
	else{
		add2templist($email, $category, $name);
	}
	
}


if($action == "unsubscribe"){
	if(!mailexist($email, $category, $name)){
		warning(M0004);
		exit;
	}
	else{
		del2templist($email, $category, $name);
	}
}

if(eregi("^add", $action)){
	$str = explode(" ", $action);
	list($tmp, $email) = explode("=", $str[1]);
	list($tmp, $category) = explode("=", $str[2]);
	list($tmp, $name) = explode("=", $str[3]);
	list($tmp, $addcode) = explode("=", $str[4]);
	if(!mailexist($email, $category, $name)){
		warning(M0003);
		exit;
	}
	else{
		add2list($email, $category, $name, $addcode);
	}
	
	
}

if(eregi("^del", $action)){
	$str = explode(" ", $action);
	list($tmp, $email) = explode("=", $str[1]);
	list($tmp, $category) = explode("=", $str[2]);
	list($tmp, $name) = explode("=", $str[3]);
	list($tmp, $delcode) = explode("=", $str[4]);
	if(!mailexist($email, $category, $name)){
		warning(M0004);
		exit;
	}
	else{
		del2list($email, $category, $name, $delcode);
	}
	
}



?>