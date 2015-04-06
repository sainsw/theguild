<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php // Example 26-3: setup.php
  require_once 'functions.php';

  createTable('Student',
              'StudentID int(11) unsigned NOT NULL AUTO_INCREMENT,
              FName varchar(255) NOT NULL DEFAULT \'\',
              LName varchar(255) NOT NULL DEFAULT \'\',
              Gender char(1) DEFAULT \'\',
              Email varchar(255) NOT NULL DEFAULT \'\',
              Pass varchar(255) NOT NULL DEFAULT \'\',
              PRIMARY KEY (StudentID),
              UNIQUE KEY Email (Email, Pass)');

  createTable('Club', 
              'ClubID int(11) unsigned NOT NULL AUTO_INCREMENT,
              Title varchar(255) NOT NULL DEFAULT \'\',
              Class varchar(255) NOT NULL DEFAULT \'\',
              Leader int(11) unsigned DEFAULT NULL,
              PRIMARY KEY (ClubID),
              UNIQUE KEY Title (Title),
              KEY LeaderID (Leader),
              CONSTRAINT LeaderID FOREIGN KEY (Leader) REFERENCES Student (StudentID) 
              ON DELETE SET NULL ON UPDATE CASCADE');

  createTable('ClubMember', 
              'SID int(11) unsigned NOT NULL,
              CID int(11) unsigned NOT NULL,
              Position varchar(255) DEFAULT NULL,
              Rep tinyint(1) NOT NULL,
              PRIMARY KEY (SID,CID),
              KEY CMem (CID),
              CONSTRAINT CMem FOREIGN KEY (CID) REFERENCES Club (ClubID) 
              ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT SMem FOREIGN KEY (SID) REFERENCES Student (StudentID) 
              ON DELETE CASCADE ON UPDATE CASCADE');

  createTable('Building', 
              'BuildingID int(11) unsigned NOT NULL AUTO_INCREMENT,
              Name varchar(255) NOT NULL DEFAULT '',
              Address int(11) NOT NULL,
              PRIMARY KEY (BuildingID)');

  createTable('Locations', 
              'RoomID int(11) unsigned NOT NULL AUTO_INCREMENT,
              RoomNo varchar(255) NOT NULL DEFAULT '',
              Building int(11) unsigned NOT NULL,
              Capacity int(11) DEFAULT NULL,
              PRIMARY KEY (RoomID),
              KEY BuildingID (Building),
              CONSTRAINT BuildingID FOREIGN KEY (Building) REFERENCES Building (BuildingID) 
              ON DELETE CASCADE ON UPDATE CASCADE');

  createTable('Staff', 
              'StaffID int(11) unsigned NOT NULL AUTO_INCREMENT,
              FName varchar(255) NOT NULL DEFAULT '',
              LName varchar(255) NOT NULL DEFAULT '',
              Gender char(1) DEFAULT '',
              Email varchar(255) NOT NULL DEFAULT '',
              Pass varchar(255) NOT NULL DEFAULT '',
              Manager tinyint(1) NOT NULL,
              PRIMARY KEY (StaffID),
              UNIQUE KEY Email (Email,Pass)');

  createTable('Event', 
              'EventID int(11) unsigned NOT NULL AUTO_INCREMENT,
              Title varchar(255) NOT NULL DEFAULT '',
              STime datetime NOT NULL,
              ETime datetime NOT NULL,
              Creator int(11) unsigned DEFAULT NULL,
              Capacity int(11) DEFAULT NULL,
              CID int(11) unsigned NOT NULL,
              RID int(11) unsigned DEFAULT NULL,
              Type int(11) NOT NULL,
              Approval int(11) unsigned DEFAULT NULL,
              PRIMARY KEY (EventID),
              UNIQUE KEY Title (Title),
              KEY CreatorID (Creator),
              KEY ClubE (CID),
              KEY Approval (Approval),
              KEY Location (RID),
              CONSTRAINT Approval FOREIGN KEY (Approval) REFERENCES Staff (StaffID) 
              ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT ClubE FOREIGN KEY (CID) REFERENCES Club (ClubID) 
              ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT CreatorID FOREIGN KEY (Creator) REFERENCES Student (StudentID) 
              ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT Location FOREIGN KEY (RID) REFERENCES Locations (RoomID) 
              ON DELETE SET NULL ON UPDATE CASCADE');

  createTable('BookedLocations', 
              'RID int(11) unsigned NOT NULL,
              EID int(11) unsigned NOT NULL,
              STime datetime NOT NULL,
              ETime datetime NOT NULL,
              PRIMARY KEY (RID,EID),
              KEY BookE (EID),
              CONSTRAINT BookE FOREIGN KEY (EID) REFERENCES Event (EventID) 
              ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT BookLoc FOREIGN KEY (RID) REFERENCES Locations (RoomID) 
              ON DELETE CASCADE ON UPDATE CASCADE');

    createTable('PublicAttending', 
              'BookingID int(11) unsigned NOT NULL AUTO_INCREMENT,
              EID int(10) unsigned NOT NULL,
              FName varchar(255) NOT NULL DEFAULT '',
              LName varchar(255) NOT NULL DEFAULT '',
              Email varchar(255) DEFAULT '',
              Telephone varchar(255) NOT NULL DEFAULT '',
              PRIMARY KEY (BookingID),
              KEY PEBook (EID),
              CONSTRAINT PEBook FOREIGN KEY (EID) REFERENCES Event (EventID) 
              ON DELETE CASCADE ON UPDATE CASCADE');

    createTable('StudentAttending', 
              'SID int(11) unsigned NOT NULL,
              EID int(10) unsigned NOT NULL,
              PRIMARY KEY (SID,EID),
              KEY EventAtt (EID),
              CONSTRAINT EventAtt FOREIGN KEY (EID) REFERENCES Event (EventID) 
              ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT StuAtt FOREIGN KEY (SID) REFERENCES Student (StudentID) 
              ON DELETE CASCADE ON UPDATE CASCADE');



?>

    <br>...done.
  </body>
</html>
