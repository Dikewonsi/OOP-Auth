<?php
    // User class to handle authentication
    class User {
        private $pdo;
        private $id;
        private $username;
        private $email;
        private $password;
        private $identifier; // Can be username or email for login

        // Constructor to initialize DB connection
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

        public function setIdentifier($identifier) {
            $this->identifier = trim($identifier);
        }

        public function setPlainPassword($password) {
            $this->password = $password;
        }

        public function findByEmail($email) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        //------------MAIN FUNCTIONS ------------------------------------

        // TODO: Register user
        public function register() {
            if ($this->findByEmail($this->email)) {
                return false; // This means email already exists
            }

            $stmt = $this->pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $success = $stmt->execute([$this->username, $this->password, $this->email]);

            return $success;
        }

        // TODO: Login user
        public function login() {
            // Check if identifier is email or username
            if (filter_var($this->identifier, FILTER_VALIDATE_EMAIL)) {
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            } else {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
            }
            $stmt->execute([$this->identifier]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($this->password, $user['password'])) {
                // Set user properties
                $this->id = $user['id'];
                
                // Start session and set session ID variable
                session_start();
                $_SESSION['user_id'] = $this->id;
                header("Location: ../public/index.php");
                exit;
            }
            return false;
        }

        // TODO: Logout user
        public function logout() {}
    }
