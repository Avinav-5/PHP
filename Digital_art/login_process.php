<?php
session_start();
include('Connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        if($user['role']=="artist")
        {
        header('Location: artist_profile.php?user_id=' . $user['user_id']);
        }
        else{
        header('Location: index.php');  
        }
    } else {
        echo "Invalid login details!";
    }
}
?>
