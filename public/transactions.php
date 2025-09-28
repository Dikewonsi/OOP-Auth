<?php
    require "../config/config.php";
    require "../classes/Database.php";
    require "../classes/Accounts.php";

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $db = new Database();
    $account = new Accounts($db, $_SESSION['user_id']);
    $transactions = $account->getLastTransaction();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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
            <a href="deposit.php" class="block px-4 py-2 rounded-lg hover:bg-gray-800">💸 Deposit</a>
            <a href="withdraw.php" class="block px-4 py-2 rounded-lg hover:bg-gray-800">💰 Withdraw</a>
            <a href="transactions.php" class="block px-4 py-2 rounded-lg hover:bg-gray-800">📈 Transactions</a>
            <a href="logout.php" class="block px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700">🚪 Logout</a>
        </nav>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-8 text-gray-100 overflow-y-auto">
        <header class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Transactions</h1>
        <a href="index.php" class="text-sm bg-gray-700 px-4 py-2 rounded-lg hover:bg-gray-600">⬅ Back to Dashboard</a>
        </header>
        
        <section>
            <h2 class="text-xl font-semibold mb-4"> Transactions</h2>
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
                    <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $txn): ?>
                        <tr class="border-b border-gray-700 hover:bg-gray-800">
                        <td class="px-6 py-4"><?= htmlspecialchars($txn['created_at']) ?></td>
                        <td class="px-6 py-4"><?= ucfirst(htmlspecialchars($txn['type'])) ?></td>
                        <td class="px-6 py-4 <?= $txn['type'] === 'deposit' ? 'text-green-500' : 'text-red-500' ?>">
                            <?= $txn['type'] === 'deposit' ? '+ ' : '- ' ?>$<?= number_format($txn['amount'], 2) ?>
                        </td>
                        <td class="px-6 py-4">Completed</td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">No transactions yet</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>