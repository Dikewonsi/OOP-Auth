<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once "../config/config.php";
  require_once "../classes/Database.php";
  require_once "../classes/Accounts.php";

  session_start();

  if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit;
  }

  $db = new Database();
  $account = new Accounts($db, $_SESSION['user_id']);

  $accountBalance = $account->getBalance();
  $accountNumber = $account->getAccountNumber();
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

    <!-- Account Summary -->
    <section class="bg-gray-900 p-6 rounded-xl shadow-lg mb-10">
      <h2 class="text-xl font-semibold mb-4">Your Account</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
       <div class="p-4 bg-gray-800 rounded-lg relative">
          <p class="text-gray-400 text-sm">Account Number</p>
          <div class="flex items-center justify-between">
            <p id="accountNumber" class="text-2xl font-bold tracking-widest">
              <?php echo htmlspecialchars($accountNumber); ?>
            </p>
            <button 
              onclick="copyAccountNumber()" 
              class="ml-3 px-3 py-1 text-sm bg-gray-700 hover:bg-gray-600 rounded-lg transition">
              Copy
            </button>
          </div>
        </div>

        <!-- Toast notification -->
        <div id="toast" class="hidden fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm opacity-0 transition-opacity duration-500">
          ✅ Account number copied!
        </div>
        <div class="p-4 bg-gray-800 rounded-lg">
          <p class="text-gray-400 text-sm">Available Balance</p>
          <p class="text-2xl font-bold text-green-400">$<?php echo number_format($accountBalance, 2); ?></p>
        </div>
      </div>
    </section>

    <!-- Recent transactions -->
    <section>
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
  <script>
  function copyAccountNumber() {
    const accountNumber = document.getElementById("accountNumber").innerText;
    navigator.clipboard.writeText(accountNumber).then(() => {
      const toast = document.getElementById("toast");
      toast.classList.remove("hidden");
      setTimeout(() => toast.classList.add("opacity-100"), 50); // fade in

      setTimeout(() => {
        toast.classList.remove("opacity-100"); // fade out
        setTimeout(() => toast.classList.add("hidden"), 500);
      }, 2000); // visible for 2s
    });
  }
</script>
</body>
</html>
