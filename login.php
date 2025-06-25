<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/next.css">
</head>
<body>
    <h2>Silakan Login</h2>
    <?php
    if (isset($_GET['error'])) {
        echo "<p class='error-banner'>Username atau password salah.</p>";
    }
    ?>
    <form action="login_proses.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>