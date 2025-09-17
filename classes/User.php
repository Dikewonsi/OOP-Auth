<?php
    // User class to handle authentication
    class User {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        // TODO: Register user
        public function register($username, $password, $email) {}

        // TODO: Login user
        public function login($username, $password) {}

        // TODO: Logout user
        public function logout() {}
    }
