
<?php
include('header.php');

    echo "<div class='container1'>";
    echo "<h2>Access Denied</h2>";
    echo "<p>You must log in as an artist to upload artworks.</p>";
    echo "<a href='login.php'><button>Login as Artist</button></a>";; // Link to login page
    echo "</div>";

include('footer.php'); // Include the footer
?>