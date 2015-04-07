<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php // Example 26-3: setup.php
  require_once 'functions.php';


  //Set up required tables using create table function from functions.php
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
              Name varchar(255) NOT NULL DEFAULT \'\',
              Address varchar(255) NOT NULL,
              PRIMARY KEY (BuildingID)');

  createTable('Locations', 
              'RoomID int(11) unsigned NOT NULL AUTO_INCREMENT,
              RoomNo varchar(255) NOT NULL DEFAULT \'\',
              Building int(11) unsigned NOT NULL,
              Capacity int(11) DEFAULT NULL,
              PRIMARY KEY (RoomID),
              KEY BuildingID (Building),
              CONSTRAINT BuildingID FOREIGN KEY (Building) REFERENCES Building (BuildingID) 
              ON DELETE CASCADE ON UPDATE CASCADE');

  createTable('Staff', 
              'StaffID int(11) unsigned NOT NULL AUTO_INCREMENT,
              FName varchar(255) NOT NULL DEFAULT \'\',
              LName varchar(255) NOT NULL DEFAULT \'\',
              Gender char(1) DEFAULT \'\',
              Email varchar(255) NOT NULL DEFAULT \'\',
              Pass varchar(255) NOT NULL DEFAULT \'\',
              Manager tinyint(1) NOT NULL,
              PRIMARY KEY (StaffID),
              UNIQUE KEY Email (Email,Pass)');

  createTable('Event', 
              'EventID int(11) unsigned NOT NULL AUTO_INCREMENT,
              Title varchar(255) NOT NULL DEFAULT \'\',
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


  createTable('Timeslots', 
              'SlotNo int(11) unsigned NOT NULL AUTO_INCREMENT,
              STime time NOT NULL,
              ETime time NOT NULL,
              PRIMARY KEY (SlotNo)');


  createTable('BookedLocations', 
              'RID int(11) unsigned NOT NULL,
              EID int(11) unsigned NOT NULL,
              TS int(11) unsigned NOT NULL,
              Date datetime NOT NULL,
              PRIMARY KEY (RID,EID),
              KEY BookE (EID),
              KEY BookedTimeslot (TS),
              CONSTRAINT BookE FOREIGN KEY (EID) REFERENCES Event (EventID) 
              ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT BookLoc FOREIGN KEY (RID) REFERENCES Locations (RoomID) 
              ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT BookedTimeslot FOREIGN KEY (TS) REFERENCES Timeslots (SlotNo) 
              ON DELETE CASCADE ON UPDATE CASCADE');

  createTable('PublicAttending', 
              'BookingID int(11) unsigned NOT NULL AUTO_INCREMENT,
              EID int(10) unsigned NOT NULL,
              FName varchar(255) NOT NULL DEFAULT \'\',
              LName varchar(255) NOT NULL DEFAULT \'\',
              Email varchar(255) DEFAULT \'\',
              Telephone varchar(255) NOT NULL DEFAULT \'\',
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

    
    //Clear Timeslots

    queryMysql("DELETE FROM Timeslots;");

    //Reset increment on timeslots so we always count to 24

    queryMysql("ALTER TABLE Timeslots AUTO_INCREMENT = 1");

    //Insert records for the standard timeslots for booking rooms

    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('00:00:00', '01:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('01:00:00', '02:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('02:00:00', '03:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('03:00:00', '04:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('04:00:00', '05:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('05:00:00', '06:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('06:00:00', '07:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('07:00:00', '08:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('08:00:00', '09:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('09:00:00', '10:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('10:00:00', '11:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('11:00:00', '12:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('12:00:00', '13:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('13:00:00', '14:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('14:00:00', '15:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('15:00:00', '16:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('16:00:00', '17:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('17:00:00', '18:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('18:00:00', '19:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('19:00:00', '20:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('20:00:00', '21:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('21:00:00', '22:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('22:00:00', '23:00:00');");
    queryMysql("INSERT INTO Timeslots (STime, ETime) VALUES ('23:00:00', '24:00:00');");
    echo "Timeslots reset to standard.";

?>
    <br>
    <br>...done.
  </body>
</html>
