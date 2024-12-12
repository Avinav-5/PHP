<?php
// Include necessary files for database connection
include('Connection.php');
include('header.php'); // Assuming you have a header file for navigation

// Get the artist user_id from the URL parameter (for example, artist_profile.php?user_id=1)
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 3;

// Fetch artist details from the database
if ($user_id > 0) {
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if artist exists
    if ($result->num_rows > 0) {
        $artist = $result->fetch_assoc();
    } else {
        echo "<h2>Artist not found!</h2>";
        exit;
    }

    // Fetch artworks by the artist
    $artworks_query = "SELECT * FROM artworks WHERE artist_id = ?";
    $artworks_stmt = $conn->prepare($artworks_query);
    $artworks_stmt->bind_param("i", $user_id); // Assuming artist_id refers to user_id
    $artworks_stmt->execute();
    $artworks_result = $artworks_stmt->get_result();
} else {
    echo "<h2>Invalid artist ID!</h2>";
    exit;
}
?>

<div class="container">
    <h1><?php echo htmlspecialchars($artist['username']); ?>'s Profile</h1>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($artist['email']); ?></p>

    <h2>Artworks</h2>
    <div class="artwork-gallery">
        <?php while ($artwork = $artworks_result->fetch_assoc()): ?>
            <div class="artwork-item">
                <img src="uploads\<?php echo htmlspecialchars($artwork['image_path']); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>" />
                <h3><?php echo htmlspecialchars($artwork['title']); ?></h3>
                <p><?php echo htmlspecialchars($artwork['description']); ?></p>
                <p><strong>Price:</strong> Rs<?php echo htmlspecialchars($artwork['price']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('footer.php'); ?>
