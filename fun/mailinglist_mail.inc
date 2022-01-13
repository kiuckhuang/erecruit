<?


function subscribe_mail($email, $link){
$link = ereg_replace(" ", "_", $link);	
$subject = "Confirmation of e-Recruit Mailing List Subscription";
	
$message="
This email is to confirm that you want to *subscribe* to our 
mailing list. To make sure that you have entered the correct email 
address, please access the following link to activate your subscription:
 
****
$link
**** 

If you click on the link above and you see an error message, it's 
likely that your browser does not display the above link properly. In 
that case, please cut the lines between the asterisk lines **** and 
paste them into one line. Then use Internet Explorer to open(CTRL-O) 
the location using this line. 

Regards,
System Administrator
";


mail($email, "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: ".ADMIN_MAIL."\nX-Mailer: PHP/".phpversion());
$msg = "Thank you for subscribing to our mailing list.<br>\nPlease check your mail now to activate your subscription.";
message($msg, RECRUIT_URL);

exit;
}


function unsubscribe_mail($email, $link){
$link = ereg_replace(" ", "_", $link);	
$subject = "Confirmation of e-Recruit Mailing List Unsubscription";
	
$message="
This email is to confirm that you want to *unsubscribe* from our mailing list.
To make sure that you have entered the correct email address,
please access the following link to remove it from our list:

****
$link
**** 

If you click on the link above and you see an error message, it's 
likely that your browser does not display the above link properly. In 
that case, please cut the lines between the asterisk lines **** and 
paste them into one line. Then use Internet Explorer to open(CTRL-O) 
the location using this line. 

Regards
System Administrator
";


mail($email, "$subject", "$message", "From: ".ADMIN_MAIL."\nReply-To: ".ADMIN_MAIL."\nX-Mailer: PHP/".phpversion());

$msg = "Please check your mail now to confirm us that you have input the correct email address.";
message($msg, RECRUIT_URL);

exit;
}
