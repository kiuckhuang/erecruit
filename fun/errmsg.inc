<?
DEFINE("W0001", "(Message no.W0001)<br>\nWarning!");

//LOGIN
DEFINE("W0002", "(Message no.W0002)<br>\nSorry, <a href='index.php'>login</a> first."); //login first err_msg
DEFINE("W0003", "(Message no.W0003)<br>\nindex.php");
DEFINE("W0004", "(Message no.W0004)<br>\nSorry, guest login is not authorized to access this page.");//signup_sessions.php
DEFINE("W0005", "(Message no.W0005)<br>\nSorry, you cannot use \"guest\" as the login name.");//Create_Account.php


//VALIDATION
DEFINE("W0006", "(Message no.W0006)<br>\nPlease type in Login Name.");//Create_Account.php,ChangePassword.php
DEFINE("W0007", "(Message no.W0007)<br>\nIncorrect e-mail format <br>\nPlease re-input e-mail with correct format.");//Create_Account.php
DEFINE("W0008", "(Message no.W0008)<br>\nPlease type in E-mail.");//Create_Account.php
DEFINE("W0009", "(Message no.W0009)<br>\nPlease select one sex.");//Create_Account.php
DEFINE("W0010", "(Message no.W0010)<br>\nPlease type in Last Name.");//Create_Account.php
DEFINE("W0011", "(Message no.W0011)<br>\nPlease type in First Name.");//Create_Account.php
DEFINE("W0012", "(Message no.W0012)<br>\nPlease type in a password with at least 4 characters.");//Create_Account.php,ChangePassword.php
DEFINE("W0013", "(Message no.W0013)<br>\nPlease type in Password.");//Create_Account.php,ChangePassword.php
DEFINE("W0014", "(Message no.W0014)<br>\nPlease confirm your password in 'Retype Password'.");//Create_Account.php,ChangePassword.php
DEFINE("W0015", "(Message no.W0015)<br>\nPassword and Retyped Password do not match.");//Create_Account.php,ChangePassword.php
DEFINE("W0016", "(Message no.W0016)<br>\nPlease type in your Student/Staff ID No.");//Create_Account.php,ChangePassword.php
DEFINE("W0017", "(Message no.W0017)<br>\nPlease confirm your Student/Staff ID in 'Retype Student ID No.'.");//Create_Account.php
DEFINE("W0018", "(Message no.W0018)<br>\nStudent/Staff ID Number and Retyped Student/Staff ID Number do not match.");//Create_Account.php
DEFINE("W0019", "(Message no.W0019)<br>\nSorry, the sign up code is wrong.");//signup_session.php
DEFINE("W0020", "(Message no.W0020)<br>\nSorry, please input the sign up code.");//signup_session.php
DEFINE("W0021", "(Message no.W0021)<br>\nSorry, please choose one session.");//signup_session.php, pastexp_expdetails.php

//
DEFINE("W0022", "(Message no.W0022)<br>\nThe Login Name has already been used by another user. Please choose another one."); //DOUBLE LOGIN NAME//Create_Account.php, ChangePassword.php
DEFINE("W0023", "(Message no.W0023)<br>\nYou cannot create more than one account in e-recruit."); //IF THE CHECKBIT IS SETTED//Create_Account.php
DEFINE("W0024", "(Message no.W0024)<br>\nThis Student/Staff ID already exists in e-Recruit. Please contact the system administrator."); //IF THE CHECKBIT IS SETTED//Create_Account.php
DEFINE("W0025", "(Message no.W0025)<br>\nSorry, this e-mail already exists. Please use another one.");//Double email account in the subject for the nonust create account//Create_Account.php

//prerequsite
DEFINE("W0026", "(Message no.W0026)<br>\nSorry, you have not fulfilled the prerequisites of this experiment.");//signup_session.php

//Blocking system
DEFINE("W0027", "(Message no.W0027)<br>\nSorry, you are blocked by our system.");//logon_member.php

//checking signup
DEFINE("W0028", "(Message no.W0028)<br>\nYou have signed up this experiment's session(s) before.");//signup_session.php

DEFINE("W0029", "(Message no.W0029)<br>\nLogin Error!\n Your login name already exists.  Do you think you should enter e-Recruit again through the ".ORG_SHORT." Student/Staff gateway?\n");//subject_functions.inc
DEFINE("W0030", "(Message no.W0030)<br>\nSorry, you cannot sign up with guest login. Please create an account in e-Recruit to sign up for experiments.");
DEFINE("W0031", "(Message no.W0031)<br>\nPlease type in Login Name.");//ChangePersonalInformation.php
DEFINE("W0032", "(Message no.W0032)<br>\nWe can not find this login name. Please go back and type the Login Name again.");//forgetpassword.php
DEFINE("W0033", "(Message no.W0033)<br>\nThe Login Name already exists. Please choose another login name.");//forgetpassword.php
DEFINE("W0034", "(Message no.W0034)<br>\nLogin Error. Please go back and try again.");//login_member.php
DEFINE("W0035", "(Message no.W0035)<br>\nSorry, guest login is not authorized to access this page.");//login_member.php
DEFINE("W0036", "(Message no.W0036)<br>\nSorry, please choose one course.");//signup_session.php, pastexp_expdetails.php
DEFINE("W0037", "(Message no.W0037)<br>\nPlease input the Experiment ID.");//search_result.php
DEFINE("W0038", "(Message no.W0038)<br>\nPlease choose from experimenters in the list.");//search_result.php
DEFINE("W0039", "(Message no.W0039)<br>\nPlease input the search keywords.");//search_result.php
DEFINE("W0040", "(Message no.W0040)<br>\nPlease input the experiment title.");//search_result.php
DEFINE("W0041", "(Message no.W0041)<br>\nSorry, some sessions have ended. Please choose other sessions to sign up.");//signup_sessions.php
DEFINE("W0042", "(Message no.W0042)<br>\nSorry, you cannot cancel the sign up once a session is started.");//signup_sessions.php
DEFINE("W0043", "(Message no.W0043)<br>\nYou have entered a wrong login name or password.");//login_member.php
DEFINE("W0044", "(Message no.W0044)<br>\nSorry, the sign up is not successful because<br>\n -you cannot sign up for the same session more than once; or ,<br>\n-this experiment restricts you to sign up one of the sessions only but you are attempting to sign up for more than one session now.");//login_member.php 
DEFINE("W0045", "(Message no.W0045)<br>\n You have been blocked from 
accessing e-Recruit because you have violated our <a href=\"SignUpPolicy.php\">sign up 
policy.</a><br>\n<br>\n");//signup_sessions.php,login_member.php
DEFINE("W0046", "(Warning Message no.W0046)
If you must sign up for experiment in order to fulfill 
course requirement, please ask your course instructor to sign up a 
\"Request for access to e-Recruit system\" letter and put it to the mail 
box (located in the Department of Marketing) of the Center for 
Experimental Business Research. You can get the letter by clicking (<a 
href=\"request.php\">Here</a>)<br>\n<br>\nYou 
can contact e-Recruit system 
Administrater at ". ADMIN_MAIL_WITH_LINK ." for any further
enquiries.");//signup_sessions.php,login_member.php
DEFINE("W0047", "(Message no.W0047)<br>\nSorry, please enter numerical values in the phone number field.");//ChangPersonalInformation.php
DEFINE("W0048", "(Message no.W0048)<br>\nWe can not find your email. Please go back and type the email again.");//forgetpassword.php
DEFINE("W0049", "(Message no.W0049)<br>\nWe can not find your stuID. Please go back and type the stuID again.");//forgetpassword.php
DEFINE("W0050", "(Message no.W0050)<br>\nWe can not find your account. Please contact system administrator.");//forgetpassword.php



/* warning mesg for Pool Coordinator */
define("P0001", "(Message no.P0001)<br>\nLogin Name incorrect.");
define("P0002", "(Message no.P0002)<br>\nOld Password incorrect.");
define("P0003", "(Message no.P0003)<br>\nOld Password and New Password are the same.");
define("P0004", "(Message no.P0004)<br>\nNew Password and Confirm Password are different.");
define("P0005", "(Message no.P0005)<br>\nPlease input New Password.");
define("P0006", "(Message no.P0006)<br>\nCourse already exists.<br>\nPlease input another Course Name.");
define("P0007", "(Message no.P0007)<br>\nPlease input Course Name.");
define("P0008", "(Message no.P0008)<br>\nPlease input First Name.");
define("P0009", "(Message no.P0009)<br>\nPlease input Last Name.");
define("P0010", "(Message no.P0010)<br>\nPlease input E-Mail Address.");
define("P0011", "(Message no.P0011)<br>\nPlease input Sign up Code.");
define("P0012", "(Message no.P0012)<br>\nIncorrect e-mail format. <br>\nPlease re-input e-mail with the correct format.");
define("P0013", "(Message no.P0013)<br>\nIncorrect Login Name or Password.<br>\nPlease <a href=\"index.php\">login</a> again.<br>");
define("P0014", "(Message no.P0014)<br>\nPlease input Year.");
define("P0015", "(Message no.P0015)<br>\nPlease input Sign Up Code.");
define("P0016", "(Message no.P0016)<br>\nPlease input Sign Up Code with 8 characters.");
define("P0017", "(Message no.P0017)<br>\nPlease input Authorization Code.");
define("P0018", "(Message no.P0018)<br>\nPlease input the Authorization Code with 5 digits.");
define("P0019", "(Message no.P0019)<br>\nMail has been successfully sent.");
define("P0020", "(Message no.P0020)<br>\nPlease select at least one subject.");
define("P0021", "(Message no.P0021)<br>\nNo pool is selected.");
define("P0022", "(Message no.P0022)<br>\nPlease select at least one course.");
define("P0023", "(Message no.P0023)<br>\nPlease select only one course.");
define("P0024", "(Message no.P0024)<br>\nPlease select only one course.");
define("P0025", "(Message no.P0025)<br>\nPlease select at least one pool.");
define("P0026", "(Message no.P0026)<br>\nPlease select only one pool.");
define("P0027", "(Message no.P0027)<br>\nYou must enter a valid user name and password to access this resource.");
define("P0028", "(Message no.P0028)<br>\nPlease <a href=\"index.php\">login</a> first.");
define("P0029", "(Message no.P0029)<br>\nPassword has been successfully updated.<br>\nPlease <a href=\"./index.php\">login</a> again.");
define("P0030", "(Message no.P0030)<br>\nPlease input Login Name.");
define("P0031", "(Message no.P0031)<br>\nPlease input Password.");
define("P0032", "(Message no.P0032)<br>\nLogin Name already exists.");
define("P0033", "(Message no.P0033)<br>\nNo subject with such information was found. ");
define("P0034", "(Message no.P0034)<br>\nThe experiment ID is not under this pool.");



/* warning message for mailing list */
define("M0001", "(Message no.M0001)<br>\nPlease select one course.");
define("M0002", "(Message no.M0002)<br>\nPlease select any one of the categories.");
define("M0003", "(Message no.M0003)<br>\nThe email is already in our mailing list.");
define("M0004", "(Message no.M0004)<br>\nThe email is not in our mailing list.");
define("M0005", "(Message no.M0005)<br>\nPlease input a valid email address.");
define("M0006", "(Message no.M0006)<br>\nError e-mail format.<br>\nPlease input again.");
define("M0007", "(Message no.M0007)<br>\nYour email has been added to our mailing list.");
define("M0008", "(Message no.M0008)<br>\nPlease follow the link at the confirmation mail and do not modify anything.");
define("M0009", "(Message no.M0009)<br>\nYour mail has been removed from our mailing list.");






/* warning msg for System Admin */
define("S0001", "(Message no.S0001)<br>\nLogin Name incorrect.");
define("S0002", "(Message no.S0002)<br>\nOld Password incorrect.");
define("S0003", "(Message no.S0003)<br>\nOld Password and New Password are the same.");
define("S0004", "(Message no.S0004)<br>\nNew Password and Confirm Password are different.");
define("S0005", "(Message no.S0005)<br>\nPlease input New Password.");
define("S0006", "(Message no.S0006)<br>\nPassword has been successfully changed. Please close your browser and login again.");
define("S0007", "(Message no.S0007)<br>\nCourse already exists.<br>\nPlease input another Course Name.");
define("S0008", "(Message no.S0008)<br>\nPlease input Course Name.");
define("S0009", "(Message no.S0009)<br>\nPlease input First Name.");
define("S0010", "(Message no.S0010)<br>\nPlease input Last Name.");
define("S0011", "(Message no.S0011)<br>\nPlease input E-Mail Address.");
define("S0012", "(Message no.S0012)<br>\nPlease input the Sign up Code.");
define("S0013", "(Message no.S0013)<br>\nIncorrect e-mail format. <br>\nPlease re-input e-mail with correct format.");
define("S0014", "(Message no.S0014)<br>\nPlease input Course Authorization Code.");
define("S0015", "(Message no.S0015)<br>\nPlease input Course Authorization Code with 6 digits.");
define("S0016", "(Message no.S0016)<br>\nPlease input Pool Name.");
define("S0017", "(Message no.S0017)<br>\nPlease input Login Name.");
define("S0018", "(Message no.S0018)<br>\nPlease input Password.");
define("S0019", "(Message no.S0019)<br>\nPlease select at least one experimenter.");
define("S0020", "(Message no.S0020)<br>\nPlease select only one experimenter.");
define("S0021", "(Message no.S0021)<br>\nPlease select only one experimenter.");
define("S0022", "(Message no.S0022)<br>\nPlease input a valid pool coordinator login name.");
define("S0023", "(Message no.S0023)<br>\nPlease select at least one pool.");
define("S0024", "(Message no.S0024)<br>\nPlease select only one pool to modify.");
define("S0025", "(Message no.S0025)<br>\nPlease select at least one course.");
define("S0026", "(Message no.S0026)<br>\nPlease select only one course.");
define("S0027", "(Message no.S0027)<br>\nModifications updated successfully.");
define("S0028", "(Message no.S0028)<br>\nPlease modify the password in order to send the password to the experimenter.");
define("S0029", "(Message no.S0029)<br>\nPlease input at least one valid E-Mail address.");
define("S0030", "(Message no.S0030)<br>\nPlease select at least one category.");
define("S0031", "(Message no.S0031)<br>\nPlease input the staff/student ID with digits only.");
define("S0032", "(Message no.S0032)<br>\nLogin Name already exists.");
define("S0033", "(Message no.S0033)<br>\nNo subject with such information found.");
define("S0034", "(Message no.S0034)<br>\nMail has been successfully sent.");
define("S0035", "(Message no.S0035)<br>\nAll the login names are not exist at the block list. ");
define("S0036", "(Message no.S0036)<br>\nThe following subjects has been unblocked:\n<br><li>");
define("S0037", "(Message no.S0037)<br>\nInvalid date<br>Please input a valid date.");
define("S0038", "(Message no.S0038)<br>\nEnd of semester day saved successfully.");
define("S0039", "(Message no.S0039)<br>\nAttendance update successfully.");
define("S0040", "(Message no.S0040)<br>\nPlease select at least one subject.");
define("S0041", "(Message no.S0041)<br>\nMail has been successfully sent.");
define("S0042", "(Message no.S0042)<br>\nThe date is passed, please input a new date.");
define("S0043", "(Message no.S0043)<br>\n"); // The session id is not exist
define("S0044", "(Message no.S0044)<br>\nPlease input at least one session ID"); // The session id is not exist
define("S0045", "(Message no.S0045)<br>\nPlease input at least one session ID at the last input box"); // The session id is not exist
// message at experimenters
define("T0001", "(Message no.T0001)<br>\nPlease choose one course.");
define("T0002", "(Message no.T0002)<br>\nPlease input Course Authorization Code.");
define("T0003", "(Message no.T0003)<br>\nYour Course Authorization Code is invalid.");
define("T0004", "(Message no.T0004)<br>\nPlease choose one pool.");
define("T0005", "(Message no.T0005)<br>\nPlease input the Pool Authorization Code.");
define("T0006", "(Message no.T0006)<br>\nYour Pool Authorization Code is invalid.");
define("T0007", "(Message no.T0007)<br>\nPlease tell us whether you would like to modify the old experiment.");
define("T0008", "(Message no.T0008)<br>\nPlease fill in the Experiment ID.");
define("T0009", "(Message no.T0009)<br>\nPlease fill in a valid Experiment ID.");
define("T0010", "(Message no.T0010)<br>\nEmpty Title. Please input the title.");
define("T0011", "(Message no.T0011)<br>\nPlease choose Session Combination.");
define("T0012", "(Message no.T0012)<br>\nPlease choose the number of sessions.");
define("T0013", "(Message no.T0013)<br>\nPlease choose the student type.");
define("T0014", "(Message no.T0014)<br>\nPlease input the Experiment ID.");
define("T0015", "(Message no.T0015)<br>\n");//Add_Experiment.php
define("T0016", "(Message no.T0016)<br>\n");//Add_Experiment.php
define("T0017", "(Message no.T0017)<br>\nPlease input the second student type.");
define("T0018", "(Message no.T0018)<br>\nPlease input the second session ID.");
define("T0019", "(Message no.T0019)<br>\n");//Add_Experiment.php
define("T0020", "(Message no.T0020)<br>\n");//Add_Experiment.php
define("T0021", "(Message no.T0021)<br>\nPlease select one value for Session Combination.");
define("T0022", "(Message no.T0022)<br>\nThis experiment: $expid does not belong to you.");
define("T0023", "(Message no.T0023)<br>\n");
define("T0024", "(Message no.T0024)<br>\nLogin Name incorrect.");
define("T0025", "(Message no.T0025)<br>\n");//Change_Password.php
define("T0026", "(Message no.T0026)<br>\nOld Password and New Password are the same.");
define("T0027", "(Message no.T0027)<br>\nNew Password and Confirm Password are different.");
define("T0028", "(Message no.T0028)<br>\nPlease input New Password.");
define("T0029", "(Message no.T0029)<br>\nEmpty Title. Please input the title.");
define("T0030", "(Message no.T0030)<br>\nPlease input the necessary information since you have chosen \"Yes\" for prerequisites. ");
define("T0031", "(Message no.T0031)<br>\n");//Check_Experiment.php
define("T0032", "(Message no.T0032)<br>\n");//Check_Experiment.php
define("T0033", "(Message no.T0033)<br>\nPlease select one value for Session Combination.");
define("T0034", "(Message no.T0034)<br>\nPlease choose one course.");
define("T0035", "(Message no.T0035)<br>\nPlease choose one pool.");
define("T0036", "(Message no.T0036)<br>\nThis experiment does not belong to you.");
define("T0037", "(Message no.T0037)<br>\n");//Check_Experiment.php
define("T0038", "(Message no.T0038)<br>\n");//Check_Experiment.php
define("T0039", "(Message no.T0039)<br>\nIncorrect input Login Name or Password.<br>\nPlease <a href=\"index.php\">login</a> again.");
define("T0040", "(Message no.T0040)<br>\nPlease select one payment mode: fixed, maximum, minimum or average.");
define("T0041", "(Message no.T0041)<br>\nPlease input the amount of money.");
define("T0042", "(Message no.T0042)<br>\nPlease select one credit mode: fixed, maximum, minimum or average.");
define("T0043", "(Message no.T0043)<br>\nPlease input the amount of credit.");
define("T0044", "(Message no.T0044)<br>\nPlease input the amount of credit.");
define("T0045", "(Message no.T0045)<br>\nPlease select one payment mode: fixed, maximum, minimum or average.");
define("T0046", "(Message no.T0046)<br>\nPlease input the amount of money.");
define("T0047", "(Message no.T0047)<br>\nPlease select one credit mode: fixed, maximum, minimum or average.");
define("T0048", "(Message no.T0048)<br>\nPlease input the amount of credit.");
define("T0049", "(Message no.T0049)<br>\nPlease input the amount of credit.");
define("T0050", "(Message no.T0050)<br>\nIncorrect time format of Start Time.");
define("T0051", "(Message no.T0051)<br>\nIncorrect Date.");
define("T0052", "(Message no.T0052)<br>\nInvalid Date.");
define("T0053", "(Message no.T0053)<br>\nThe date you have input has passed.");
define("T0054", "(Message no.T0054)<br>\nPlease input the number of days.");
define("T0055", "(Message no.T0055)<br>\nPlease input the number of hours.");
define("T0056", "(Message no.T0056)<br>\nPlease input the number of minutes.");
define("T0057", "(Message no.T0057)<br>\nPlease input the correct number of hours.");
define("T0058", "(Message no.T0058)<br>\nPlease input the correct number of minutes.");
define("T0059", "(Message no.T0059)<br>\nPlease input the quota.");
define("T0060", "(Message no.T0060)<br>\nPlease input number in Quota field.");
define("T0061", "(Message no.T0061)<br>\nPlease input the venue.");
define("T0062", "(Message no.T0062)<br>\nPlease input the course code.");
define("T0063", "(Message no.T0063)<br>\nYour request has been successfully sent to the Administrator.");
define("T0064", "(Message no.T0064)<br>\n");//Del_Experiment.php
define("T0065", "(Message no.T0065)<br>\n");//Del_Experiment.php
define("T0066", "(Message no.T0066)<br>\nEA_action.php");
define("T0067", "(Message no.T0067)<br>\nSorry, please <a href=\"/experimenter\">login</a> first.");
define("T0068", "(Message no.T0068)<br>\nPlease choose one.");
define("T0069", "(Message no.T0069)<br>\nPlease input Experiment ID.");
define("T0070", "(Message no.T0070)<br>\nPlease choose the experimenters in the list.");
define("T0071", "(Message no.T0071)<br>\nPlease input the search keywords.");
define("T0072", "(Message no.T0072)<br>\nPlease input the experiment title.");
define("T0073", "(Message no.T0073)<br>\nThis experiment does not belong to you.");
define("T0074", "(Message no.T0074)<br>\nPlease input the number of credits where the subject is selected.");
define("T0075", "(Message no.T0075)<br>\nAttendance information has been sent to the System Administrator and the Pool Coordinator successfully.");
define("T0076", "(Message no.T0076)<br>\nThis table can only be sent ONCE. Are you sure you want to send?");
define("T0077", "(Message no.T0077)<br>\n");//Mod_Session.php
define("T0078", "(Message no.T0078)<br>\n");//Mod_Session.php
define("T0079", "(Message no.T0079)<br>\nYou have logged in.<br>\nPlease <a href=\"logout.php\">logout<a> first.");
define("T0080", "(Message no.T0080)<br>\nPlease input First Name.");
define("T0081", "(Message no.T0081)<br>\nPlease input Last Name.");
define("T0082", "(Message no.T0082)<br>\nPlease input e-mail.");
define("T0083", "(Message no.T0083)<br>\nIncorrect e-mail format, please re-input a correct one.");
define("T0084", "(Message no.T0084)<br>\nPlease input the staff/student ID.");
define("T0085", "(Message no.T0085)<br>\nPlease input the correct Staff/Student ID.");
define("T0086", "(Message no.T0086)<br>\nPlease select an experiment.");
define("T0087", "(Message no.T0087)<br>\nPlease choose one of the sessions.");
define("T0088", "(Message no.T0088)<br>\nPlease select at least one subject.");
define("T0089", "(Message no.T0089)<br>\nMail has been successfully sent.");
define("T0090", "(Message no.T0090)<br>\nPlease <a href=\"index.php\">login</a> first.");
define("T0091", "(Message no.T0091)<br>\nWarning, no more session can be added.");
define("T0092", "(Message no.T0092)<br>\nFailed to add the session.");
define("T0093", "(Message no.T0093)<br>\nPassword has been successfully updated.<br>\nPlease <a href=\"./index.php\">login</a> again.");
define("T0094", "(Message no.T0094)<br>\n");//exp_functions.inc
define("T0095", "(Message no.T0095)<br>\n");//exp_functions.inc
define("T0096", "(Message no.T0096)<br>\n");//exp_functions.inc 
define("T0097", "(Message no.T0097)<br>\nPlease input the course code!");
define("T0098", "(Message no.T0098)<br>\nYour request has been sent to the System Administrator successfully");
define("T0099", "(Message no.T0099)<br>\nAttendance information has been sent to the System Administrator successfully.");
define("T0100", "(Message no.T0100)<br>\nYou have already sent us the table. You cannot send it more than once.  Thank you. ");
define("T0101", "(Message no.T0101)<br>\nPlease input the name of the experimenter(s).");


?>
