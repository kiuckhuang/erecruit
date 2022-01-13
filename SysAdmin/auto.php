<?
include("../fun/admin_functions.inc");
//auto mail to subjects/experimenters to attend the session
attend_session();

//auto mail to sysadmin about end of semester day
ack_semesterday();


//auto blocking, unblocking
block_subjects();



?>
end
