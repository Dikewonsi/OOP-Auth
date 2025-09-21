<?php
    require_once "../config/config.php";
    require_once "../classes/Database.php";
    require_once "../classes/User.php";

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new Database();
        $user = new User($db);

        $user->setUsername($_POST['username']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);

        if ($user->register()) {
            $message = "Registration Successful! You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Email already exists.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
</head>
<body>
    <h2>Register</h2>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>


