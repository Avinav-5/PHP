<?php
session_start();
include('Connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['role'] == 'artist') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $artist_id = $_SESSION['user_id'];

    // Handle file upload
    $image_name = basename($_FILES['image']['name']);
    $target_dir = "uploads/";
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO artworks (title, description, price, image_path, artist_id)
                VALUES ('$title', '$description', '$price', '$image_name', '$artist_id')";

        if (mysqli_query($conn, $sql)) {
            header('Location: artist_profile.php'); // Redirect to artist profile after successful upload
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed!";
    }
} 
?>
