<?php
include "connection.php";
session_start();

$userid = $_SESSION['userid'];

$sql1 = "SELECT COUNT(*) AS employee_count FROM users WHERE role = 'user'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
$employee_count = $row1['employee_count'];

$sql2 = "SELECT COUNT(*) AS total_tasks FROM tasks WHERE userid = $userid";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$total_tasks = $row2['total_tasks'];

$sql3 = "SELECT COUNT(*) AS due_today FROM tasks WHERE userid = $userid AND duedate = CURDATE()";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();
$due_today = $row3['due_today'];

$sql4 = "SELECT COUNT(*) AS pending_tasks FROM tasks WHERE userid = $userid AND status = 'pending'";
$result4 = $conn->query($sql4);
$row4 = $result4->fetch_assoc();
$pending_tasks = $row4['pending_tasks'];

$sql5 = "SELECT COUNT(*) AS completed_tasks FROM completedtasks WHERE userid = $userid";
$result5 = $conn->query($sql5);
$row5 = $result5->fetch_assoc();
$completed_tasks = $row5['completed_tasks'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admindashboard.css">
    <link rel="shortcut icon" href="img/search.png" type="image/x-icon">
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
            
            <a href="createtasks.php" class="link"><li><i class="fa fa-plus"></i> Create Task</li></a>
            <a href="updatetasks.php" class="link"><li><i class="fa-solid fa-pen"></i> Update Task</li></a>
            <a href="admincompletedtasks.php" class="link"><li><i class="fa-solid fa-list"></i> Completed Tasks</li></a>
            <a href="login.html" class="link"><li><i class="fa fa-sign-out-alt"></i> Logout</li></a>
        </ul>
    </div>

    <div class="main">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <i class="fa-solid fa-users"></i>
                <h5 class="card-title"><?php echo $employee_count;?> Employees</h5>
            </div>
      </div>
      <div class="card" style="width: 18rem;">
        <div class="card-body">
            <i class="fa-solid fa-list-check"></i>
            <h5 class="card-title"><?php echo $completed_tasks+$pending_tasks;?> All tasks</h5>
        </div>
      </div>
      
        
      <div class="card" style="width: 18rem;">
        <div class="card-body">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <h5 class="card-title"><?php echo $due_today;?> Due today</h5>
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
                <script>
                    function toggleSidebar() {
                        document.getElementById("sidebar").classList.toggle("active");
                    }
                </script>
</body>
</html>
