<?php

    class Accounts {
        private $pdo;
        private $id;
        private $user_id;
        private $balance;
        private $account_number;


        // Constructor to initialize DB connection
        public function __construct($db, $user_id) {
            $this->pdo = $db->connect();
            $this->user_id = $user_id;

            //Load account details or create new account
            $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE user_id = ?");
            $stmt->execute([$this->user_id]);
            $account = $stmt->fetch(PDO::FETCH_ASSOC);

            if($account) {
                $this->id = $account['id'];
                $this->balance = $account['balance'];
                $this->account_number = $account['account_number'];
            } else {
                 // Generate a unique account number
                $genAcctNumber = $this->generateAccountNumber();

                // Create new account with zero balance
                $stmt = $this->pdo->prepare("INSERT INTO accounts (user_id, account_number, balance) VALUES (?, ?, 0)");
                $stmt->execute([$this->user_id, $genAcctNumber]);
                $this->id = $this->pdo->lastInsertId();
                $this->balance = 0;
                $this->account_number = $genAcctNumber;
            }
        }

        // Get account balance
        public function getBalance() {
            return $this->balance;
        }

        // Get account number
        public function getAccountNumber() {
            return $this->account_number;
        }

        // Deposit funds
        public function deposit($amount) {
            if($amount <= 0) {
                throw new Exception("Deposit amount must be greater than zero.");
            }

            $this->balance += $amount;
            $this->updateBalance();
            $this->logTransaction('deposit', $amount);

            return $this->balance;
        }

        // Withdraw funds
        public function withdraw($amount) {
            if ($amount <= 0) {
                throw new Exception("Withdrawal amount must be greater than zero.");
            }

            if ($amount > $this->balance) {
                throw new Exception("Insufficient funds.");
            }

            $this->balance -= $amount;
            $this->updateBalance();
            $this->logTransaction('withdraw', $amount);

            return $this->balance;
        }

        public function getLastTransaction($limit = 5) {
            $stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE account_id = ? ORDER BY created_at DESC LIMIT ?");
            $stmt->bindValue(1, $this->id, PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        private function updateBalance() {
            $stmt = $this->pdo->prepare("UPDATE accounts SET balance = ? WHERE id = ?");
            $stmt->execute([$this->balance, $this->id]);
        }

        private function logTransaction($type, $amount) {
            $stmt = $this->pdo->prepare("INSERT INTO transactions (account_id, type, amount) VALUES (?, ?, ?)");
            $stmt->execute([$this->id, $type, $amount]);
        }

        private function generateAccountNumber() {
            // Example: 10-digit account number
            do {
                $number = mt_rand(1000000000, 9999999999); // 10-digit
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM accounts WHERE account_number = ?");
                $stmt->execute([$number]);
                $exists = $stmt->fetchColumn();
            } while ($exists > 0);

            return (string)$number;
        }
    }