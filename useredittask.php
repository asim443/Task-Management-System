<?php
session_start();
include "connection.php";

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tasks WHERE taskid = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Task not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    if ($status == 'completed') {
        $insert_sql = "INSERT INTO completedtasks (taskid, title, description,duedate, userid,employeeid) 
                       SELECT taskid, title, description, duedate, userid,employeeid 
                       FROM tasks WHERE taskid = $id";
        
        if ($conn->query($insert_sql) === TRUE) {
            $delete_sql = "DELETE FROM tasks WHERE taskid = $id";
            
            if ($conn->query($delete_sql) === TRUE) {
                echo "<script>alert('Task moved to completed tasks!');</script>";
                header("Location: userdashboard.php");
                exit();
            } else {
                echo "Error deleting task: " . $conn->error;
            }
        } else {
            echo "Error inserting task into completed_tasks: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Task Management System</title>
    <link rel="shortcut icon" href="img/search.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #4b1e73;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 50%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4b1e73;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        textarea,
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }

        textarea {
            height: 100px;
            resize: none;
        }

        select {
            cursor: pointer;
        }

        button {
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Task Status</h2>
        <form method="POST" action="">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" readonly>

            <label>Description:</label>
            <textarea name="description" readonly><?php echo htmlspecialchars($task['description']); ?></textarea>

            <label>Status:</label>
            <select name="status" required>
                <option value="completed">Completed</option>
            </select>

            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>
