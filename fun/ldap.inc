<?php

class LdapConn {

var $first_name;
var $last_name;
var $email;

function LdapConn($netid) {
	
$ldapinfo = exec("/usr/local/bin/ldscan $netid");
if($ldapinfo=="::") 
{
		//authenticate();
		//exit();
}
$params = explode(":", $ldapinfo);
$this->email = $params[0];
$this->first_name = $params[2];
$this->last_name = $params[1];

}

function getFirstName() {
	return $this->first_name;
}
function getLastName() { 
	return $this->last_name;
	}
function getEmail() { 
	return $this->email;
	}
	

}



?>
