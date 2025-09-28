<?php
    require_once "../config/config.php";
    require_once "../classes/Database.php";
    require_once "../classes/User.php";

    $errors = [];
    $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new Database();
        $user = new User($db);

        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = $_POST['password'];

        // Input validation
        if (strlen($username) < 3) {
            $errors[] = "Username must be at least 3 characters.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
        if (strlen($password) < 4) {
            $errors[] = "Password must be at least 4 characters.";
        }

        // Only try register if no validation errors
        if (empty($errors)) {
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);

            if ($user->register()) {
                $success = "Registration Successful! You can now <a href='login.php' class='underline hover:text-gray-900'>login</a>.";
            } else {
                $errors[] = "Email already exists.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-black via-gray-900 to-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md transform transition-all duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-6 animate-fade-in">Create an Account</h2>

        <!-- Success message -->
        <?php if (!empty($success)): ?>
            <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg animate-bounce">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Error messages -->
        <?php if (!empty($errors)): ?>
            <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg animate-shake">
                <ul class="list-disc ml-5">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-5">
            <div>
                <label class="block text-gray-700 font-medium">Username</label>
                <input type="text" name="username" required
                       value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"
                       class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-gray-900 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Email</label>
                <input type="email" name="email" required
                       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                       class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-gray-900 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-gray-900 focus:outline-none transition">
            </div>

            <button type="submit"
                    class="w-full py-2 px-4 bg-black text-white rounded-lg hover:bg-gray-800 transition transform hover:scale-105">
                Register
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600">
            Already have an account?
            <a href="login.php" class="text-black font-semibold hover:underline">Login</a>
        </p>
    </div>

    <!-- Tailwind Animations -->
    <style>
        @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fade-in 1s ease-in-out; }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .animate-shake { animation: shake 0.3s ease-in-out; }
    </style>
</body>
</html>
