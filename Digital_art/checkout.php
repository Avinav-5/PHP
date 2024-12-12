<?php
ob_start(); // Start output buffering
session_start();
include('header.php');
include('Connection.php');

// Retrieve user_id from session
$user_id = $_SESSION['user_id'];

// Fetch cart total
$sql = "SELECT SUM(artworks.price * cart1.quantity) AS total
        FROM cart1
        JOIN artworks ON cart1.artwork_id = artworks.art_id
        WHERE cart1.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total = $row['total'] ? $row['total'] : 0; // Set total to 0 if NULL

// Check if there are items in the cart
if ($total <= 0) {
    echo "<p>Your cart is empty.</p>";
    exit; // Exit if the cart is empty
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Place the order
    $sql = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $total); // Use "id" for user_id (integer) and total_price (decimal)
    
    if ($stmt->execute()) {
        // Clear the cart after the order
        $clear_sql = "DELETE FROM cart1 WHERE user_id = ?";
        $clear_stmt = $conn->prepare($clear_sql);
        $clear_stmt->bind_param("i", $user_id);
        $clear_stmt->execute();

        header('Location: index.php');
        exit;
    } else {
        echo "Error placing order: " . $stmt->error; // Output error if it occurs
    }
}
?>

<section class="checkout">
    <h2>Checkout</h2>
    <p>Total Price: $<?php echo number_format($total, 2); ?></p>
    <form action="checkout.php" method="post">
        <button type="submit">Place Order</button>
    </form>
</section>

<?php
include('footer.php');
ob_end_flush(); // End output buffering and flush the output
?>
