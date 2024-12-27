<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Username already exists! Please choose another username.');
                window.location.href = 'register.html';
              </script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (fullname, username, password, role) 
                VALUES ('$fullname', '$username', '$hashed_password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Successfully Registered');
                    window.location.href = 'login.html';
                  </script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }

    $conn->close();
}
?>
