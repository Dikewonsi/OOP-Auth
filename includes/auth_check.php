<?php
// Session-based access control
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
