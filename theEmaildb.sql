create schema theEmaildb;

use theEmaildb;

create table Person (
	perID int primary key auto_increment,
    fname varchar(15),
    lname varchar(15),
    gender enum("Male", "Female"),
    dob date,
    address varchar(255),
    email varchar(255),
    password varchar(15)
);

create table Telephone (
    perID int primary key,
    number1 varchar(15),
    number2 varchar(15),
    foreign key (perID) references Person (perID)
);

create table Major (
	majorID tinyint auto_increment,
    name varchar(50),
    primary key(majorID)
);

create table Student (
	studentID int auto_increment primary key,
    perID int,
    majorID tinyint,
    class varchar(4),
    hostel varchar(50),
    foreign key (perID) references Person (perID),
    foreign key (majorID) references major (majorID)
);

create table Department (
	depID tinyint auto_increment primary key,
    name varchar(50)
);

create table Employee (
	staffID int auto_increment primary key,
    perID int,
    depID tinyint,
    salary decimal(8, 2) not null,
    room varchar(15),
    hireDate date,
    foreign key (perID) references Person(perID),
    foreign key (depID) references Department (depID)
);

create table Faculty (
	facultyID int primary key,
    employmentStatus enum ("Full Time", "Adjunct"),
    foreign key (facultyID) references Employee(staffID)
);

create table FI (
	fiID int primary key,
    employmentStatus enum ("Full Time", "NSS"),
    foreign key (fiID) references Employee(staffID)
);

create table Staff (
	nonTeachingID int primary key,
    jobName varchar(50),
    foreign key (nonTeachingID) references Employee(staffID)
);

create table Email_Group (
	groupID tinyint auto_increment primary key,
    name varchar(50)
);

create table Person_Email (
	perID int,
    groupID tinyint,
    foreign key (perID) references Person (perID),
    foreign key (groupID) references Email_Group(groupID)
);

create table Course (
	courseID varchar(15) primary key,
    courseName varchar(50),
    credit decimal(2, 1)
);

create table Manages (
	courseID varchar(15),
    facultyID int,
    fiID int,
    semester enum ("1", "2"),
    cohort char(1),
    foreign key (courseID) references Course (courseID),
    foreign key (facultyID) references Faculty (facultyID),
    foreign key (fiID) references FI (fiID)
);

create table Course_Major (
	majorID tinyint,
    courseID varchar(15),
    foreign key (majorID) references Major (majorID),
    foreign key (courseID) references Course(courseID)
);

create table Email_Sent (
	emailID int auto_increment primary key,
	perID int,
    subject varchar(255),
    content text,
    dateSent date,
    timeSent time,
    foreign key (perID) references Person (perID)
);

create table Email_Recipient (
	perID int,
    emailID int,
    foreign key (perID) references Person(perID),
    foreign key (emailID) references Email_Sent(emailID)
);

create table EmailGroup_Recipient (
	groupID tinyint,
    emailID int,
    foreign key (groupID) references Email_Group(groupID),
    foreign key (emailID) references Email_Sent(emailID)
);

#INSERTIONS
insert into Person (fname, lname, gender, dob, address, email) values ("Antoinette", "Okyere", "Female", "1990-05-23", "Kwaku Moffat Close Dansoman Estates", "antoinette.okine@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Akua", "Ampah", "Female", "1991-04-26", "Jerry Hansen Street Tema Community 5", "akua.ampah@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Rejoice", "Agbleta", "Female", "1985-03-12", "Total Filling Station Baatsona", "rejoice.agbleta@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Affum", "Alhassan", "Male", "1988-01-31", "Ring Road Central Accra", "affum.alhassan@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Michael", "Quansah", "Male", "1993-06-15", "Straight Road Asylum Down", "michael.quansah@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Andrew", "Duncan", "Male", "2000-05-23", "Orange Trail Street East Legon", "andrew.duncan@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Burtina", "Graham", "Female", "2001-10-26", "Apple Grove Road Spintex", "burtina.graham@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Derek", "Jacobs", "Male", "1999-05-23", "Steven Hawking Rd Cantonments", "derek.jacobs@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Marie", "Aime", "Female", "1998-11-19", "Kwame Nkrumah St High Street", "marie.aimee@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Madoc", "Quaye", "Male", "2001-12-16", "Movenpick Avenue Accra Central", "madoc.quaye@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Ayorkor", "Korsah", "Female", "1987-01-01", "Pizza Inn Street West Legon", "ayorkor.korsah@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Patrick", "Dwumfuor", "Male", "1989-07-04", "A&C Mall East Legon", "patrick.dwumfuor@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Eric", "Ocran", "Male", "1989-07-13", "Brown Road Kwabenya", "eric.ocran@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Jewel", "Thompson", "Female", "1988-02-23", "Diamond Street Tema Community 1", "jewel.thompson@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Takako", "Mino", "Female", "1987-02-16", "Lime Broom Road Spintex", "antoinette.okine@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Araba", "Toffah", "Female", "1995-09-18", "Coca-Cola Roundabout Spintex", "araba.toffah@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Jojoe", "Ainoo", "Male", "1997-04-21", "White Bridge St Weija", "jojoe.ainoo@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Edinam", "Akporkavie", "Female", "1996-11-16", "Mango City Rd Airport Central", "edinam.akporkavie@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Ethel", "Adongo", "Female", "1995-08-03", "Flower Mangrove St McCarthy Hill", "ethel.adongo@ashesi.edu.gh");
insert into Person (fname, lname, gender, dob, address, email) values ("Frederick", "Plange", "Male", "1996-03-31", "Blue Ivy St East Legon", "frederick.plange@ashesi.edu.gh");


insert into Telephone values (1, "0201234567", "0244123455");
insert into Telephone values (2, "0507473937", "0208726472");
insert into Telephone values (3, "0231344117", "0207960802");
insert into Telephone values (4, "0244125897", "0208822141");
insert into Telephone values (5, "0544234650", "0204960806");
insert into Telephone values (6, "0561739561", "0208829841");
insert into Telephone values (7, "0201297543", "0247990808");
insert into Telephone values (8, "0551234567", "0244828341");
insert into Telephone values (9, "0509646564", "0200660809");
insert into Telephone values (10, "0561343834", "0244820941");
insert into Telephone values (11, "0201223845", "0200960807");
insert into Telephone values (12, "0241274592", "0244829808");
insert into Telephone values (13, "0541202843", "0544123455");
insert into Telephone values (14, "0244238459", "0564123455");
insert into Telephone values (15, "0231223521", "0504412255");
insert into Telephone values (16, "0551234525", "0244123535");
insert into Telephone values (17, "0562340934", "0204123935");
insert into Telephone values (18, "0262343453", "0264121011");
insert into Telephone values (19, "0202346642", "0554124940");
insert into Telephone values (20, "0244234356", "0564123532");


insert into Major (name) values ("Computer Science");
insert into Major (name) values ("Business Administration");
insert into Major (name) values ("Management Information Systems");
insert into Major (name) values ("Mechanical Engineering");
insert into Major (name) values ("Electrical Engineering");
insert into Major (name) values ("Computer Engineering");


insert into Student (studentID, perID, majorID, class, hostel) values("12342022", 6, 1, 2022, "Dufie");
insert into Student (studentID, perID, majorID, class, hostel) values("56782022", 7, 3, 2022, "Hosanna");
insert into Student (studentID, perID, majorID, class, hostel) values("52682022", 8, 2, 2021, "Charlotte");
insert into Student (studentID, perID, majorID, class, hostel) values("92832022", 9, 6, 2020, "Dufie");
insert into Student (studentID, perID, majorID, class, hostel) values("62832022", 10, 1, 2023, "Campus");


insert into Department (name) values("Student Life Engagement");
insert into Department (name) values("Career Services");
insert into Department (name) values("Finance Department");
insert into Department (name) values("Office Of Diversity and International Programs");
insert into Department (name) values("Registry");
insert into Department (name) values("Health Centre");
insert into Department (name) values("Computer Science");
insert into Department (name) values("Business Administration");
insert into Department (name) values("Engineering");
insert into Department (name) values("Humanities and Social Sciences");


insert into Employee (perID, depID, salary, room, hireDate) values(1, 1, 8000.00, "S107", "2013-07-24");
insert into Employee (perID, depID, salary, room, hireDate) values(2, 2, 8000.00, "C102", "2015-08-20");
insert into Employee (perID, depID, salary, room, hireDate) values(3, 3, 8000.00, "F101", "2012-06-02");
insert into Employee (perID, depID, salary, room, hireDate) values(4, 5, 8000.00, "R103", "2014-05-15");
insert into Employee (perID, depID, salary, room, hireDate) values(5, 7, 8000.00, "PR1", "2013-05-01");
insert into Employee (perID, depID, salary, room, hireDate) values(11, 7, 9500.00, "Radichel 11", "2012-06-07");
insert into Employee (perID, depID, salary, room, hireDate) values(12, 9, 9500.00, "Radichel 8", "2011-07-04");
insert into Employee (perID, depID, salary, room, hireDate) values(13, 9, 9500.00, "Radichel 5", "2013-05-23");
insert into Employee (perID, depID, salary, room, hireDate) values(14, 10, 9500.00, "Radichel 107", "2012-12-09");
insert into Employee (perID, depID, salary, room, hireDate) values(15, 10, 9500.00, "Radichel 107", "2014-05-18");
insert into Employee (perID, depID, salary, room, hireDate) values(16, 10, 2000.00, "T104", "2019-07-19");
insert into Employee (perID, depID, salary, room, hireDate) values(17, 7, 2000.00, "T103", "2019-07-20");
insert into Employee (perID, depID, salary, room, hireDate) values(18, 8, 2000.00, "F101", "2019-07-20");
insert into Employee (perID, depID, salary, room, hireDate) values(19, 9, 2000.00, "T104", "2019-07-19");
insert into Employee (perID, depID, salary, room, hireDate) values(20, 7, 2000.00, "T103", "2019-07-21");


insert into Staff values (1, "Assistant Dean of Students & Community Affairs");
insert into Staff values (2, "Career Development Advisor");
insert into Staff values (3, "Finance Assistant");
insert into Staff values (4, "Senior Assistant Registrar");
insert into Staff values (5, "Senior Alumni and Public Relations Officer");

insert into Faculty values (6, "Full Time");
insert into Faculty values (7, "Full Time");
insert into Faculty values (8, "Full Time"); 
insert into Faculty values (9, "Full Time");
insert into Faculty values (10, "Adjunct"); 


insert into FI values (11, "NSS"); 
insert into FI values (12, "NSS"); 
insert into FI values (13, "Full Time");
insert into FI values (14, "NSS");
insert into FI values (15, "NSS"); 


insert into Email_Group (name) values ("Students");
insert into Email_Group (name) values ("Staff and Faculty");
insert into Email_Group (name) values ("Class of 2022");
insert into Email_Group (name) values ("Class of 2023");
insert into Email_Group (name) values ("Class of 2021");
insert into Email_Group (name) values ("Class of 2020");
insert into Email_Group (name) values ("Ashesi Community");
insert into Email_Group (name) values ("Data Structures");
insert into Email_Group (name) values ("Statistics");
insert into Email_Group (name) values ("Leadership");
insert into Email_Group (name) values ("Computer Engineering");


insert into Person_Email values (1, 2);
insert into Person_Email values (2, 2);
insert into Person_Email values (3, 2);
insert into Person_Email values (4, 2);
insert into Person_Email values (5, 2);
insert into Person_Email values (11, 2);
insert into Person_Email values (12, 2);
insert into Person_Email values (13, 2);
insert into Person_Email values (14, 2);
insert into Person_Email values (15, 2);
insert into Person_Email values (16, 2);
insert into Person_Email values (17, 2);
insert into Person_Email values (18, 2);
insert into Person_Email values (19, 2);
insert into Person_Email values (20, 2);
insert into Person_Email values (6, 2);
insert into Person_Email values (7, 3);
insert into Person_Email values (8, 5);
insert into Person_Email values (9, 6);
insert into Person_Email values (10, 4);
insert into Person_Email values (1, 7);
insert into Person_Email values (2, 7);
insert into Person_Email values (3, 7);
insert into Person_Email values (4, 7);
insert into Person_Email values (5, 7);
insert into Person_Email values (6, 7);
insert into Person_Email values (6, 8);
insert into Person_Email values (6, 9);
insert into Person_Email values (6, 10);
insert into Person_Email values (7, 7);
insert into Person_Email values (7, 9);
insert into Person_Email values (7, 10);
insert into Person_Email values (8, 7);
insert into Person_Email values (9, 7);
insert into Person_Email values (9, 11);
insert into Person_Email values (10, 7);
insert into Person_Email values (6, 1);
insert into Person_Email values (7, 1);
insert into Person_Email values (8, 1);
insert into Person_Email values (9, 1);
insert into Person_Email values (10, 1);


insert into Course values ("CS222", "Data Structures", 1);
insert into Course values ("MATH221", "Statistics", 1);
insert into Course values ("SOAN311", "Leadership 3", 0.5);
insert into Course values ("MATH300", "Differential Equations", 1);
insert into Course values ("ECON102", "Macroeconomics", 1);


insert into Course_Major values (1, "CS222");
insert into Course_Major values (1, "MATH221");
insert into Course_Major values (1, "SOAN311");
insert into Course_Major values (2, "MATH221");
insert into Course_Major values (2, "SOAN311");
insert into Course_Major values (2, "ECON102");
insert into Course_Major values (3, "MATH221");
insert into Course_Major values (3, "SOAN311");
insert into Course_Major values (3, "CS222");
insert into Course_Major values (3, "ECON102");
insert into Course_Major values (4, "MATH221");
insert into Course_Major values (4, "SOAN311");
insert into Course_Major values (4, "MATH300");
insert into Course_Major values (5, "MATH221");
insert into Course_Major values (5, "SOAN311");
insert into Course_Major values (5, "MATH300");
insert into Course_Major values (6, "MATH221");
insert into Course_Major values (6, "SOAN311");
insert into Course_Major values (6, "MATH300");
insert into Course_Major values (6, "CS222");


insert into Manages values ("CS222", 6, 12, "1", "A");
insert into Manages values ("CS222", 6, 15, "1", "B");
insert into Manages values ("MATH221", 7, 11, "1", "A");
insert into Manages values ("MATH221", 8, 14, "1", "B");
insert into Manages values ("SOAN311", 10, 13, "2", "A");
insert into Manages values ("SOAN311", 10, 11, "2", "B");
insert into Manages values ("MATH300", 7, 14, "2", "A");
insert into Manages values ("MATH300", 9, 14, "2", "B");
insert into Manages values ("ECON102", 8, 13, "2", "A");
insert into Manages values ("ECON102", 10, 15, "2", "B");

insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (1, "Townhall Meeting", "Are you ready for the townhall
 meeting at 3:40pm? Be There!", "2020-04-23", "15:00:21");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (1, "Townhall Meeting", "See you in a few! #Townhall", "2020-04-23", "15:15:21");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (3, "Bill Receipts", "Kindly find attached your receipt for bill payments, and take the necesaary actions to 
 address arrears", "2020-04-21", "11:38:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (1, "Townhall Meeting", "We start in 5 mintues!!! #townhall", "2020-04-23", "15:35:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (4, "Course Enrolment", "CAMU opens at 6pm for enrolment of courses for all majors
 and classes. Please endeavour to enrol into your required courses.", "2020-03-15", "12:00:21");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (11, "Lab Assignment 4", "our lab assignment 4 has been posted on canvas. Do not procrastinate
 because it is quite a handful.", "2020-04-23", "10:27:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (13, "Statistics Project", "This is to inform all of you that there will be PHD holders 
 and Masters Degree holders at the project exhibition. Use this information to go about your projects.", "2020-04-23", "8:03:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (20, "Lab Assignment 3", "Lab Assignment assignment 3 has been graded and recorded
 . Let me know if you have any issues and we will see how they can be resolved.", "2020-04-22", "14:00:21");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (1, "Townhall Meeting", "From SLE, we want to thank everyone to came out for townhall meeting and made
 it a success! We love you all!", "2020-04-24", "09:11:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (2, "Career Day!", "Career Services wants to send a big thank you to everyone made it a blast. From those
  involved in the competitions and our very lovely ushers. We would like to express our gratitude today at 3:40pm in Norton Motulsky. Come for a treat!", "2020-04-22", "10:30:00");
insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (6, "Help with Stats", "Hey Burtina, Sorry I couldn't make it this evening to help with the Stats. I had some 
trouble with my assignment as well. Can we reschedule?", "2020-04-24", "15:00:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (7, "Help with Stats", "Oh don't worry at all. I don't want to bother you, but we can always reschedule.
 Anytime at all.", "2020-04-24", "16:00:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (6, "Problem with Lab Assignment 3", "Hello Frederick, I encountered a mistake in the marking at number 
 3 of the lab assignment 3. Can you please check it out and get back to me? Because the code runs fine on my laptop. Thank you.", "2020-04-23", "14:20:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (10, "Python Assignment", "Yo Andrew, I really need some help with my programming assigment.
  Seems like I can't reach you on your phone that's why I'm sending this email.", "2020-04-22", "11:05:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (18, "Leadership Quiz", "There will be a quiz today at the beginning of class. Come prepared!", "2020-04-24", "8:00:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (6, "Finance Papers", "Hey Derek, do you have any of your mid sem papers for finance? 
 I want to use it to prepare for my exam.", "2020-04-21", "21:00:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (8, "Finance Papers", "Yeah I have one of them, I'll bring them over to your room this evening", "2020-04-21", "21:43:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (19, "Assignment 5", "Kindly find attached the handout for assignment 5.", "2020-04-24", "17:00:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (17, "Clarification on Assignment 3", "Hey Frederick, Dr. Korsah found some errors at number 3 in the assignment so alert your 
 students that we're making the necessary changes to their grades.", "2020-04-24", "09:17:00");
 insert into Email_Sent (perID, subject, content, dateSent, timeSent) values (15, "Appreciation Email", "Hey Burtina, I would like to commend you on your performance in the last deliverable. 
 I love how you strung everything together with consistency. I never lost focus or got bored, and the paper was really informative. You can give yourself a pat on the back for that one.", "2020-04-22", "14:15:21");

insert into Email_Recipient values (7, 11);
insert into Email_Recipient values (6, 12);
insert into Email_Recipient values (20, 13);
insert into Email_Recipient values (6, 14);
insert into Email_Recipient values (8, 16);
insert into Email_Recipient values (6, 17);
insert into Email_Recipient values (20, 19);
insert into Email_Recipient values (7, 20);

insert into EmailGroup_Recipient values (7, 1);
insert into EmailGroup_Recipient values (7, 2);
insert into EmailGroup_Recipient values (1, 3);
insert into EmailGroup_Recipient values (7, 4);
insert into EmailGroup_Recipient values (1, 5);
insert into EmailGroup_Recipient values (8, 6);
insert into EmailGroup_Recipient values (9, 7);
insert into EmailGroup_Recipient values (8, 8);
insert into EmailGroup_Recipient values (7, 9);
insert into EmailGroup_Recipient values (7, 10);
insert into EmailGroup_Recipient values (10, 15);
insert into EmailGroup_Recipient values (11, 18);


#Get the emails that contain specific words within a specific period
select * from Email_Sent
where dateSent > "2020-04-21" and dateSent < "2020-04-25"
and (subject like "%assignment%" or content like "%assignment%")
order by dateSent;

#Find the number of emails sent within a specific period
select count(*) as Number_of_Emails from Email_Sent
where dateSent > "2020-04-23" and dateSent < "2020-04-25";

#Find the person who has sent the most emails within a specific period
Select fname, lname
from Person
where perID = (Select perID from (Select perID, count(*) as count
from Email_Sent
group by perID
order by count DESC
limit 1) as T);

#Get the senders and recipients of emails within a specific period
select Email_Sent.emailID, Email_Sent.perID as SenderID,
	Email_Sent.dateSent, Email_Sent.timeSent,
    Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID
from Email_Sent
	left join Email_Recipient
	on Email_Sent.emailID = Email_Recipient.emailID
    left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID
    from Email_Sent
    inner join EmailGroup_Recipient
    on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T
    on Email_Sent.emailID = T.emailID
;

#Retrieve all emails sent by Staff
select * 
from Email_Sent
where perID in (select perID 
from Employee
inner join Staff
on staffID = nonTeachingID);

#Retrieve the overall information for email senders within a specific period
select Person.fname, Person.lname, Person.email, Telephone.number1, Email_Sent.subject,
 Email_Sent.content, Email_Sent.dateSent, Email_Sent.timeSent, Email_Recipient.fname, EmailGroupRecipients.name
from Email_Sent
inner join Telephone
on Email_Sent.perID = Telephone.perID
inner join Person
on Person.perID = Email_Sent.perID
left join (select fname, Email_Recipient.emailID from Person inner join Email_Recipient on Person.perID = Email_Recipient.perID) as Email_Recipient
	on Email_Sent.emailID = Email_Recipient.emailID
left join (select Email_Sent.emailID, EmailGroup_Recipient.name
    from Email_Sent
    inner join (select name, EmailGroup_Recipient.emailID from Email_Group inner join EmailGroup_Recipient on Email_Group.groupID = EmailGroup_Recipient.groupID) as EmailGroup_Recipient
    on Email_Sent.emailID = EmailGroup_Recipient.emailID) as EmailGroupRecipients
    on Email_Sent.emailID = EmailGroupRecipients.emailID
where dateSent > "2020-04-21" and dateSent < "2020-04-25";


