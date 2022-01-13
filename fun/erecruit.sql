CREATE TABLE attendancy (
   attendancy varchar(50) DEFAULT 'N' NOT NULL,
   sessionid int(10) DEFAULT '0' NOT NULL,
   loginName varchar(20) NOT NULL,
   date timestamp(8),
   PRIMARY KEY (sessionid, loginName)
);


CREATE TABLE blocklist (
   loginName varchar(50) NOT NULL,
   blockdate timestamp(8),
   unblockdate timestamp(8),
   cancel_count int(8) DEFAULT '0' NOT NULL,
   attend_count int(8) DEFAULT '0' NOT NULL,
   cancel_type char(1) NOT NULL,
   attend_type char(1) NOT NULL,
   PRIMARY KEY (loginName)
);


CREATE TABLE cancelList (
   sessionid int(10) DEFAULT '0' NOT NULL,
   loginName varchar(50) NOT NULL,
   canceltime timestamp(14),
   PRIMARY KEY (sessionid, loginName, canceltime)
);


CREATE TABLE course (
   id int(8) DEFAULT '0' NOT NULL auto_increment,
   courseID varchar(20) NOT NULL,
   firstName varchar(20) NOT NULL,
   lastName varchar(30) NOT NULL,
   email varchar(30) NOT NULL,
   signUpCode varchar(10) NOT NULL,
   enable char(1) DEFAULT 'y' NOT NULL,
   pool varchar(30) NOT NULL,
   semester varchar(12) DEFAULT 'FALL' NOT NULL,
   year int(4) DEFAULT '2000' NOT NULL,
   authcode varchar(6) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE credit (
   id int(10) DEFAULT '0' NOT NULL auto_increment,
   loginName varchar(50) NOT NULL,
   credit int(4) DEFAULT '0' NOT NULL,
   sessionid bigint(10) DEFAULT '0' NOT NULL,
   pool varchar(100) NOT NULL,
   course varchar(80) NOT NULL,
   date timestamp(8),
   PRIMARY KEY (id)
);


CREATE TABLE endsemesterdate (
   year char(4) NOT NULL,
   date timestamp(8),
   PRIMARY KEY (year, date)
);

CREATE TABLE experiment (
   id int(8) DEFAULT '0' NOT NULL auto_increment,
   title varchar(255) NOT NULL,
   description text NOT NULL,
   dateCreated timestamp(8),
   experimenters varchar(255) NOT NULL,
   mode varchar(10) DEFAULT 'All' NOT NULL,
   sessions tinyint(3) DEFAULT '0' NOT NULL,
   software text NOT NULL,
   preRequisite text NOT NULL,
   target varchar(255) NOT NULL,
   category int(2) DEFAULT '0' NOT NULL,
   enable char(1) DEFAULT 'y' NOT NULL,
   creditcoursesubmitdate timestamp(8),
   PRIMARY KEY (id)
);

INSERT INTO experiment (id, title, description, dateCreated, experimenters, mode, sessions, software, preRequisite, target, category, enable, creditcoursesubmitdate) VALUES (10000000, '', '', 00000000, '', '', 0, '', '', '', 0, '', 00000000);

CREATE TABLE experimenter (
   loginName varchar(50) NOT NULL,
   firstName varchar(20) NOT NULL,
   lastName varchar(30) NOT NULL,
   password varchar(13) NOT NULL,
   sid varchar(12) NOT NULL,
   instructor varchar(50) NOT NULL,
   phone varchar(30) NOT NULL,
   email varchar(50) NOT NULL,
   remarks text,
   id int(8) DEFAULT '0' NOT NULL auto_increment,
   hkust char(3) DEFAULT 'Yes' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE loginName (loginName)
);

CREATE TABLE mailinglist_course (
   email varchar(50) NOT NULL,
   course varchar(40) NOT NULL,
   addcode varchar(6) NOT NULL,
   delcode varchar(6) NOT NULL,
   PRIMARY KEY (email, course)
);

CREATE TABLE mailinglist_hkust (
   email varchar(50) NOT NULL,
   addcode varchar(6) NOT NULL,
   delcode varchar(6) NOT NULL,
   PRIMARY KEY (email)
);


CREATE TABLE mailinglist_public (
   email varchar(50) NOT NULL,
   addcode varchar(6) NOT NULL,
   delcode varchar(6) NOT NULL,
   PRIMARY KEY (email)
);


CREATE TABLE pool (
   id varchar(10) NOT NULL,
   signUpCode varchar(10) NOT NULL,
   deadline int(5),
   semester varchar(12) DEFAULT 'Fall' NOT NULL,
   year int(4) DEFAULT '2000' NOT NULL,
   authcode varchar(5) NOT NULL,
   message text NOT NULL,
   PRIMARY KEY (id, year, semester)
);


CREATE TABLE poolCoordinator (
   loginName varchar(50) NOT NULL,
   password varchar(13) NOT NULL,
   firstName varchar(20) NOT NULL,
   lastName varchar(30) NOT NULL,
   email varchar(50) NOT NULL,
   pool varchar(10) NOT NULL,
   UNIQUE loginName (loginName)
);

CREATE TABLE session (
   id int(10) DEFAULT '0' NOT NULL auto_increment,
   title varchar(50) NOT NULL,
   reward text NOT NULL,
   fromdate timestamp(14),
   durationEnd varchar(12) NOT NULL,
   enddate timestamp(14),
   venue varchar(255) NOT NULL,
   quota int(4) DEFAULT '0' NOT NULL,
   enrolled int(4) DEFAULT '0' NOT NULL,
   dateCreated timestamp(8),
   description text,
   PRIMARY KEY (id)
);


CREATE TABLE signupexp (
   expid int(8) DEFAULT '0' NOT NULL,
   loginName varchar(50) NOT NULL,
   signOn timestamp(14),
   AssignCreditsto varchar(80),
   PRIMARY KEY (expid, loginName)
);

CREATE TABLE subject (
   loginName varchar(50) NOT NULL,
   firstName varchar(20) NOT NULL,
   lastName varchar(30) NOT NULL,
   password varchar(13) NOT NULL,
   phone varchar(12) NOT NULL,
   email varchar(50) NOT NULL,
   hkust varchar(50) NOT NULL,
   id int(8) DEFAULT '0' NOT NULL auto_increment,
   sex char(1) DEFAULT 'M' NOT NULL,
   subscribe char(1) DEFAULT 'Y' NOT NULL,
   stuID varchar(20) NOT NULL,
   checkbit int(1) DEFAULT '1' NOT NULL,
   block char(1) DEFAULT 'N' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE loginName (loginName)
);

CREATE TABLE waitingList (
   sessionid int(10) DEFAULT '0' NOT NULL,
   loginName varchar(50) NOT NULL,
   signOn timestamp(14),
   PRIMARY KEY (sessionid, loginName)
);
