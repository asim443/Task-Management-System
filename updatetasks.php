<?php
session_start();
include "connection.php";

if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    exit();
}

$userid = $_SESSION['userid'];

$sql = "SELECT t.taskid, t.title, t.description, t.duedate, t.status, u.username AS assigned_to
        FROM tasks t
        JOIN users u ON t.employeeid = u.userid
        WHERE t.userid = '$userid'";

$result = $conn->query($sql);
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
            background-color: #4C1F7A;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.8;
        }
        .edit-button {
            background-color: green;
            color: white;
        }
        .delete-button {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if($row['status'] == 'completed') {
                        continue;
                    }
                    echo "<tr>";
                    echo "<td>" . $row['taskid'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['assigned_to'] . "</td>";
                    echo "<td>" . $row['duedate'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>
                            <a href='edittask.php?taskid=" . $row['taskid'] . "'>
                                <button class='edit-button'>Edit</button>
                            </a>
                            <a href='deletetasks.php?taskid=" . $row['taskid'] . "' onclick='return confirm(\"Are you sure you want to delete this task?\")'>
                                <button class='delete-button'>Delete</button>
                            </a>
                         </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No tasks found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
