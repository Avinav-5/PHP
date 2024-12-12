<?php include('header.php'); ?>
<?php include('Connection.php'); ?>

<section class="art-gallery">
    <h2>Featured Artworks</h2>
    <div class="art-grid">
        <?php
        // Fetch artworks from the database
        $sql = "SELECT * FROM artworks";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='art-item'>";
            echo "<img src='uploads/" . $row['image_path'] . "' alt='" . htmlspecialchars($row['title']) . "'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>Price: Rs" . number_format($row['price'], 2) . "</p>";
            
            // Add form for the 'Add to Cart' button
            echo "<form method='POST' action='cart.php'>";
            echo "<input type='hidden' name='art_id' value='" . $row['art_id'] . "'>"; // Hidden input with art_id
            echo "<button type='submit' onclick='alert(\"Item added successfully!\")'>Add to Cart</button>";
            echo "</form>";

            echo "</div>";
        }
        ?>
    </div>
</section>

<?php include('footer.php'); ?>
