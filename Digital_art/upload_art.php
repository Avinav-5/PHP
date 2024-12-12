<?php
session_start();
if ($_SESSION['role'] != 'artist') {
    header('Location: customer_upload.php');
    exit;
}

else{
include('header.php');
?>

<section class="upload-art">
    <h2>Upload Your Art</h2>
    <form action="upload_process.php" method="post" enctype="multipart/form-data">
        <label for="title">Title</label>
        <input type="text" name="title" required><br>

        <label for="description">Description</label>
        <textarea name="description" required></textarea><br>

        <label for="price">Price</label>
        <input type="text" name="price" required><br>

        <label for="image">Upload Image</label>
        <input type="file" name="image" required><br>

        <button type="submit">Upload</button>
    </form>
</section>

<?php include('footer.php'); }?>

