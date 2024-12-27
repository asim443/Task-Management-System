# Task-Management-System
In this repository I have made web app of task management system.
In the task management system their are two modules one is admin and the other is user.
The admin has the access to create task, update task, delete task and also see his completed task, while on the other hand the user can only see his task that was assigned to him. He can commplete the task and also see completed tasks that was commpleted by him.
# Technologies used:
HTML
CSS
PHP
# How to use the project and how to access the database?
This project uses the database mysql through xampp control panel. 
This project contains three tables which are "users", "tasks" and "completedtasks".
# the users table will made like this:
create table users(
userid int primary key auto_increment,
fullname varchar(255),
username varchar(255),
password varchar(255),
role varchar(10));
# The structure of "tasks" table will look like this:
create table tasks(
taskid int primary key auto_increment,
title varchar(255),
description varchar(255),
duedate date,
userid int,
employeeid int,
status varchar(50) default "pending",
foreign key(employeeid) references users(userid));
# Now the completedtasks have the following structure:
create table completedtasks(
taskid int primary key auto_increment,
title varchar(255),
description varchar(255),
duedate date,
userid int,
employeeid int,
foreign key(employeeid) references users(userid));
# Now after making these tables you should make the folder and place all the files on that folder and then paste the folder into the folder of "htdocs" in xampp folder. After that run the server and start using.
