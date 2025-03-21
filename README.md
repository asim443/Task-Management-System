# Task Management System

## Overview
This repository contains a web-based **Task Management System**. The system has two main modules:
- **Admin**: Can create, update, delete tasks, and view completed tasks.
- **User**: Can view assigned tasks, mark tasks as completed, and view completed tasks.

## Technologies Used
- **HTML**
- **CSS**
- **PHP**
- **MySQL** (via XAMPP Control Panel)

## Database Structure
The project uses MySQL as the database, consisting of three tables: `users`, `tasks`, and `completedtasks`.

### Users Table
```sql
CREATE TABLE users (
    userid INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(255),
    username VARCHAR(255),
    password VARCHAR(255),
    role VARCHAR(10)
);
```

### Tasks Table
```sql
CREATE TABLE tasks (
    taskid INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    description VARCHAR(255),
    duedate DATE,
    userid INT,
    employeeid INT,
    status VARCHAR(50) DEFAULT 'pending',
    FOREIGN KEY(employeeid) REFERENCES users(userid)
);
```

### Completed Tasks Table
```sql
CREATE TABLE completedtasks (
    taskid INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    description VARCHAR(255),
    duedate DATE,
    userid INT,
    employeeid INT,
    FOREIGN KEY(employeeid) REFERENCES users(userid)
);
```

## How to Set Up and Use the Project
1. Install [XAMPP](https://www.apachefriends.org/index.html) if not already installed.
2. Start the **Apache** and **MySQL** servers from the XAMPP Control Panel.
3. Open **phpMyAdmin** and create a new database.
4. Run the above SQL queries to create the required tables.
5. Place all project files in a new folder inside the `htdocs` directory of XAMPP.
6. Open a web browser and navigate to `http://localhost/your_project_folder/` to start using the application.

## Features
- **Admin:**
  - Create, update, and delete tasks
  - View completed tasks
- **User:**
  - View assigned tasks
  - Mark tasks as completed
  - View completed tasks

## License
This project is open-source and free to use for educational and personal purposes.

