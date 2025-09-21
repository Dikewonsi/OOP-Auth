<?php
    // User class to handle authentication
    class User {
        private $pdo;
        private $id;
        private $username;
        private $email;
        private $password;

        public function __construct($db) {
            $this->pdo = $db->connect();
        }

        // Magic method to set properties
        public function setUsername($username) {
            $this->username = trim($username);
        }

        public function setEmail($email) {
            $this->email = strtolower(trim($email));
        }

        public function setPassword($password) {
            $this->password = password_hash($password, PASSWORD_BCRYPT);
        }

        // TODO: Register user
        public function register() {
            if ($this->findByEmail($this->email)) {
                return false; // This means email already exists
            }

            $stmt = $this->pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $success = $stmt->execute([$this->username, $this->password, $this->email]);

            return $success;
        }

        public function findByEmail($email) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // TODO: Login user
        public function login() {}

        // TODO: Logout user
        public function logout() {}
    }
