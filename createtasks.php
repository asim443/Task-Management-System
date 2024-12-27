<?php
session_start();
include "connection.php";

$sql = "SELECT fullname FROM users WHERE role = 'user'";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $duedate = mysqli_real_escape_string($conn, $_POST['duedate']);
    $assigned_to = mysqli_real_escape_string($conn, $_POST['assigned_to']);
    $userid = $_SESSION['userid'];
    echo $_SESSION['userid'];
    $query = "SELECT userid FROM users WHERE fullname = '$assigned_to'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $employeeid = $row['userid'];

    $sql = "INSERT INTO tasks (title, description, duedate, userid, employeeid, status) 
            VALUES ('$title', '$description', '$duedate', '$userid', '$employeeid', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Task Created Successfully');</script>";
        header("Location:admindashboard.php");
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="shortcut icon" href="img/search.png" type="image/x-icon">
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #4B2883;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: #ffffff;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 350px;
}

h2 {
    margin-bottom: 20px;
    text-align: center;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
}

input[type="text"],
input[type="date"],
textarea,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    resize: none;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <h2>Create Task</h2>

            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Title" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" placeholder="Description" required></textarea>

            <label for="duedate">Due Date</label>
            <input type="date" name="duedate" id="duedate" required>

            <label for="assigned_to">Assigned to</label>
            <select name="assigned_to" id="assigned_to" required>
                <option value="">Select employee</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['fullname'] . "'>" . $row['fullname'] . "</option>";
                    }
                }
                ?>
            </select>

            <button type="submit">Create Task</button>
        </form>
    </div>
</body>
</html>
