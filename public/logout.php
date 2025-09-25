<?php

    require_once '../config/config.php';
    require_once '../classes/User.php';
    require_once '../classes/Database.php';

    $user = new Database();
    $user = new User($user);

    //Call logout function
    $user->logout();

    