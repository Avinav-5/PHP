<?php include('header.php'); ?>

<section class="register-form">
    <h2>Create a New Account</h2>
    <form action="register_process.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <label for="role">Role</label>
        <select name="role" required>
            <option value="artist">Artist</option>
            <option value="customer">Customer</option>
        </select>

        <button type="submit">Register</button>
    </form>
</section>

<?php include('footer.php'); ?>
