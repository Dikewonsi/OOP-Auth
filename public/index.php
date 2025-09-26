<?php
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Banking Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gradient-to-br from-black via-gray-900 to-gray-800 flex">
  <!-- Sidebar -->
  <aside class="w-64 bg-gray-950 text-white flex flex-col">
    <div class="px-6 py-4 text-2xl font-bold border-b border-gray-800">
      MyBank
    </div>
    <nav class="flex-1 p-4 space-y-4">
      <a href="index.php" class="block px-4 py-2 rounded-lg hover:bg-gray-800">🏠 Dashboard</a>
      <a href="#" class="block px-4 py-2 rounded-lg hover:bg-gray-800">💳 Accounts</a>
      <a href="#" class="block px-4 py-2 rounded-lg hover:bg-gray-800">💸 Transfers</a>
      <a href="#" class="block px-4 py-2 rounded-lg hover:bg-gray-800">📑 Transactions</a>
      <a href="#" class="block px-4 py-2 rounded-lg hover:bg-gray-800">⚙️ Settings</a>
      <a href="logout.php" class="block px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700">🚪 Logout</a>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="flex-1 p-8 text-gray-100 overflow-y-auto">
    <!-- Top navbar -->
    <header class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold">Dashboard</h1>
      <div class="flex items-center space-x-4">
        <span class="text-gray-300">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-lg font-bold">
          <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
        </div>
      </div>
    </header>

    <!-- Account summary cards -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-gray-900 p-6 rounded-xl shadow-lg hover:scale-105 transform transition">
        <h2 class="text-lg font-semibold mb-2">Checking Account</h2>
        <p class="text-2xl font-bold">$5,430.75</p>
      </div>
      <div class="bg-gray-900 p-6 rounded-xl shadow-lg hover:scale-105 transform transition">
        <h2 class="text-lg font-semibold mb-2">Savings Account</h2>
        <p class="text-2xl font-bold">$12,890.10</p>
      </div>
      <div class="bg-gray-900 p-6 rounded-xl shadow-lg hover:scale-105 transform transition">
        <h2 class="text-lg font-semibold mb-2">Credit Card</h2>
        <p class="text-2xl font-bold">- $1,230.50</p>
      </div>
    </section>

    <!-- Recent transactions -->
    <section class="mt-10">
      <h2 class="text-xl font-semibold mb-4">Recent Transactions</h2>
      <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden">
        <table class="w-full text-left">
          <thead class="bg-gray-800 text-gray-300">
            <tr>
              <th class="px-6 py-3">Date</th>
              <th class="px-6 py-3">Description</th>
              <th class="px-6 py-3">Amount</th>
              <th class="px-6 py-3">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b border-gray-700 hover:bg-gray-800">
              <td class="px-6 py-4">2025-09-25</td>
              <td class="px-6 py-4">ATM Withdrawal</td>
              <td class="px-6 py-4 text-red-500">- $200.00</td>
              <td class="px-6 py-4">Completed</td>
            </tr>
            <tr class="border-b border-gray-700 hover:bg-gray-800">
              <td class="px-6 py-4">2025-09-24</td>
              <td class="px-6 py-4">Salary Deposit</td>
              <td class="px-6 py-4 text-green-500">+ $2,000.00</td>
              <td class="px-6 py-4">Completed</td>
            </tr>
            <tr class="hover:bg-gray-800">
              <td class="px-6 py-4">2025-09-22</td>
              <td class="px-6 py-4">Online Transfer</td>
              <td class="px-6 py-4 text-red-500">- $350.00</td>
              <td class="px-6 py-4">Pending</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>
</html>
