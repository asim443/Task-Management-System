<?php
include 'connection.php';

if (isset($_GET['taskid'])) {
    $task_id = intval($_GET['taskid']);

    $query = "DELETE FROM tasks WHERE taskid = $task_id";
    
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Task deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting task:');</script>";
    }
    header("Location: admindashboard.php");
    $conn->close();
}
?>
