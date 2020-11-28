create schema emailDB;

use emailDB;

create table Person (
	perID int primary key auto_increment,
    fname varchar(15),
    lname varchar(15),
    gender enum("Male", "Female"),
    dob date,
    address varchar(255),
    email varchar(255),
    username varchar(255),
    password varchar(255)
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

