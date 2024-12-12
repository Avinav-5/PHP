<?php include('header.php'); ?>

<section class="login-form">
    <h2>Login to Your Account</h2>
    <form action="login_process.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</section>

<?php include('footer.php'); ?>
