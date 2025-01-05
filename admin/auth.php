<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}


function checkAuth() {
    if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
        // If not authenticated, redirect to login page
        header("Location: login.php");
        exit;
    }
}

function loginAdmin($username, $user_id) {
    // Set session variables for logged-in status, username, and admin ID
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $username;
    $_SESSION['admin_id'] = $user_id;
}

function logoutAdmin() {
    // Unset all session variables and destroy the session
    session_unset(); 
    session_destroy(); 
    
    // Redirect to the login page after logout
    header("Location: login.php");
    exit;
}

?>
