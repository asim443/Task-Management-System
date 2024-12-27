<?php
include "connection.php";
session_start();

$userid = $_SESSION['userid'];

$sql2 = "SELECT COUNT(*) AS total_tasks FROM tasks WHERE employeeid = $userid";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$total_tasks = $row2['total_tasks'];

$sql3 = "SELECT COUNT(*) AS due_today FROM tasks WHERE employeeid = $userid AND duedate = CURDATE()";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();
$due_today = $row3['due_today'];

$sql4 = "SELECT COUNT(*) AS pending_tasks FROM tasks WHERE employeeid = $userid AND status = 'pending'";
$result4 = $conn->query($sql4);
$row4 = $result4->fetch_assoc();
$pending_tasks = $row4['pending_tasks'];

$sql5 = "SELECT COUNT(*) AS completed_tasks FROM completedtasks WHERE employeeid = $userid";
$result5 = $conn->query($sql5);
$row5 = $result5->fetch_assoc();
$completed_tasks = $row5['completed_tasks'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="userdashboard.css">
    <title>Task Management System</title>
    <link rel="shortcut icon" href="img/search.png" type="image/x-icon">
    <style>
        
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #4C1F7A;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.main {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
  max-width: 1200px;
  margin: 20px auto;
}

.card {
  width: calc(33.33% - 20px);
  background-color: #fff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  border-radius: 8px;
  text-align: center;
  transition: transform 0.2s ease-in-out;
}

.card:hover {
  transform: translateY(-5px);
}

.card-body {
  padding: 20px;
}

.card-body i {
  font-size: 2.5rem;
  color: #007bff;
  margin-bottom: 10px;
}

.card-title {
  font-size: 1.2rem;
  font-weight: bold;
  color: #333;
}

@media (max-width: 992px) {
  .card {
      width: calc(50% - 20px); 
  }
}

@media (max-width: 600px) {
  .card {
      width: 100%;
  }
}
.navbar {
  display: flex;
  align-items: center;
  padding: 15px;
  background-color: #131418;
  color: #fff;
  font-size: 1.2rem;
}

.navbar h2 {
  margin-left: 15px;
  color: #007bff;
}

.toggle-btn {
  font-size: 1.5rem;
  cursor: pointer;
  color: #fff;
}

.sidebar {
  width: 300px;
  height: 100vh;
  background-color: #1d1f24;
  color: #fff;
  position: fixed;
  top: 0;
  left: -300px; 
  transition: left 0.3s;
  display: flex;
  flex-direction: column;
}

.sidebar.active {
  left: 0px;
}

.profile-section {
  text-align: center;
  padding: 20px 0;
}

.profile-pic {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  margin-bottom: 10px;
}

.user-name {
  font-size: 1.1rem;
  color: #ccc;
  margin-top: 5px;
}

.sidebar-nav {
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.sidebar-nav li {
  display: flex;
  align-items: center;
  padding: 15px 20px;
  font-size: 1rem;
  color: #ccc;
  cursor: pointer;
  transition: background 0.3s;
}

.sidebar-nav li i {
  margin-right: 15px;
  font-size: 1.2rem;
}

.sidebar-nav li:hover {
  background-color: #333;
  color: #007bff;
}

.main {
  margin-left: 0;
  transition: margin-left 0.3s;
  padding: 20px;
}

.sidebar.active + .main {
  margin-left: 250px; 
}

/* Card Styling */
.card {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin: 20px;
  padding: 20px;
  text-align: center;
}

.card i {
  font-size: 2rem;
  color: #007bff;
}

.card-title {
  font-size: 1.2rem;
  margin-top: 10px;
}

@media (max-width: 768px) {
  .sidebar {
      width: 200px;
  }

  .sidebar.active + .main {
      margin-left: 200px;
  }
}
.link{
  text-decoration: none;
}
    </style>
</head>
<body>
    <div class="navbar">
        <i class="fa fa-bars toggle-btn" onclick="toggleSidebar()"></i>
        <h2>Task Management System</h2>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="profile-section">
            <img src="img/istockphoto-1300845620-612x612.jpg" alt="User Profile" class="profile-pic">
            <p class="user-name"><?php echo $_SESSION['username'];?></p>
        </div>
        <ul class="sidebar-nav">
            <a href="#" class="link"><li><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
            <a href="useralltasks.php" class="link"><li><i class="fa fa-tasks"></i> All Tasks</li></a>
            <a href="usercompletedtasks.php" class="link"><li><i class="fa-solid fa-list"></i> Completed Tasks</li></a>
            <a href="login.html" class="link"><li><i class="fa fa-sign-out-alt"></i> Logout</li></a>
        </ul>
    </div>
    <div class="main">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <i class="fa-solid fa-list-check"></i>
                    <h5 class="card-title"><?php echo $pending_tasks+$completed_tasks;?> My Tasks</h5>
                </div>
          </div>
          <div class="card" style="width: 18rem;">
            <div class="card-body">
                <i class="fa-solid fa-timeline"></i>
                <h5 class="card-title"><?php echo $due_today;?> Deadline</h5>
            </div>
            </div>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <i class="fa-solid fa-clock"></i>
                    <h5 class="card-title"><?php echo $pending_tasks;?> Pending</h5>
                </div>
          </div>
          <div class="card" style="width: 18rem;">
            <div class="card-body">
                <i class="fa-solid fa-list"></i>
                <h5 class="card-title"><?php echo $completed_tasks;?> Completed</h5>
            </div>
        </div>
        
        </div>
        <script>
            function toggleSidebar() {
                document.getElementById("sidebar").classList.toggle("active");
            }
        </script>
</body>
</html>
