<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once "../config/config.php";
    require_once "../classes/Database.php";
    require_once "../classes/User.php";

    $message = "";

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new Database();
        $user = new User($db);

        $user->setIdentifier($_POST['identifier']);
        $user->setPlainPassword($_POST['password']);

        if ($user->login()) {
            $message = "Login Successful! You are now logged in.";
        } else {
            $message = "Invalid username/email or password.";
        }

     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username Or Email:</label><br>
        <input type="text" name="identifier" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>