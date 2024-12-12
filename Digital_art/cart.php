<?php
ob_start();
session_start();
include('Connection.php');
include('header.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle Add to Cart functionality
if (isset($_POST['art_id'])) {
    $art_id = intval($_POST['art_id']); // Ensure art_id is an integer

    // Check if the artwork already exists in the cart
    $check_sql = "SELECT * FROM cart1 WHERE user_id = ? AND artwork_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $art_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If artwork is already in the cart, update the quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + 1;

        $update_sql = "UPDATE cart1 SET quantity = ? WHERE user_id = ? AND artwork_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $art_id);
        $update_stmt->execute();
    } else {
        // If artwork is not in the cart, add it
        $insert_sql = "INSERT INTO cart1 (user_id, artwork_id, quantity) VALUES (?, ?, ?)";
        $quantity = 1;
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $user_id, $art_id, $quantity);
        $insert_stmt->execute();
    }
}

// Handle Remove item from cart functionality
if (isset($_POST['remove_art_id'])) {
    $remove_art_id = intval($_POST['remove_art_id']); // Ensure art_id is an integer

    $delete_sql = "DELETE FROM cart1 WHERE user_id = ? AND artwork_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ii", $user_id, $remove_art_id);
    $delete_stmt->execute();
}

// Handle Clear Cart functionality
if (isset($_POST['clear_cart'])) {
    $clear_sql = "DELETE FROM cart1 WHERE user_id = ?";
    $clear_stmt = $conn->prepare($clear_sql);
    $clear_stmt->bind_param("i", $user_id);
    $clear_stmt->execute();
}

// Fetch cart items for the logged-in user
$sql = "SELECT artworks.art_id, artworks.title, artworks.price, cart1.quantity
        FROM cart1
        JOIN artworks ON cart1.artwork_id = artworks.art_id
        WHERE cart1.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="cart">
    <h2>Your Cart</h2>
    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $item_total = $row['price'] * $row['quantity'];
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>$" . number_format($row['price'], 2) . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>$" . number_format($item_total, 2) . "</td>";
                        echo "<td>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='remove_art_id' value='" . $row['art_id'] . "'>
                                    <button type='submit'>Remove</button>
                                </form>
                             </td>";
                        echo "</tr>";
                        $total += $item_total;
                    }
                } else {
                    echo "<tr><td colspan='5'>Your cart is empty.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
        <button type="submit" name="clear_cart" class="btn-clear">Clear Cart</button>
    </form>
    <a href="checkout.php" class="btn">Proceed to Checkout</a>
</section>

<?php include('footer.php'); ?>
<?php ob_end_flush(); ?>
