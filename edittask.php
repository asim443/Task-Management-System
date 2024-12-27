<?php
include "connection.php";

$task = [
    'taskid' => '',
    'title' => '',
    'description' => '',
    'duedate' => ''
];

if (isset($_GET['taskid']) && !empty($_GET['taskid'])) {
    $id = intval($_GET['taskid']);
    $sql = "SELECT * FROM tasks WHERE taskid = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Task not found!";
        exit;
    }
} else {
    echo "No task ID provided!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $due_date = $_POST['due_date'];

    $update_sql = "UPDATE tasks SET title='$title', description='$description', duedate='$due_date' WHERE taskid=$id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: admindashboard.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
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

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        textarea {
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

        button {
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>
<div class="container">
    <h2>Edit Task</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($task['taskid']); ?>">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required><br><br>

        <label>Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($task['description']); ?></textarea><br><br>

        <label>Due Date:</label>
        <input type="date" name="due_date" value="<?php echo htmlspecialchars($task['duedate']); ?>" required><br><br>

        <button type="submit">Save</button>
    </form>
</div>
</body>
</html>
