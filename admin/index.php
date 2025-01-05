<?php
require_once 'auth.php'; 
checkAuth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/css/style.css"> 
    <script defer src="../admin/js/script.js"></script> 
</head>
<body>
    <div class="admin-header" id="admin-header">
        Welcome to Admin Dashboard
    </div>

    <div class="admin-dashboard-container" id="admin-dashboard-container">
        <h1 class="admin-dashboard-title" id="admin-dashboard-title">Manage Sections</h1>
        <div class="admin-cards-container" id="admin-cards-container">
            <div class="admin-card" id="admin-card-about">
                <a href="../admin/section/manage_about/index.php">About</a>
            </div>
            <div class="admin-card" id="admin-card-services">
                <a href="../admin/section/manage_services/index.php">Services</a>
            </div>
            <div class="admin-card" id="admin-card-portfolio">
                <a href="../admin/section/manage_portfolio/index.php">Portfolio</a>
            </div>
            <div class="admin-card" id="admin-card-testimonials">
                <a href="../admin/section/manage_testimonials/index.php">Testimonials</a>
            </div>
            <div class="admin-card" id="admin-card-blog">
                <a href="../admin/section/manage_blog/index.php">Blog</a>
            </div>
            <div class="admin-card" id="admin-card-contact">
                <a href="../admin/section/manage_contact/index.php">Contact</a>
            </div>
            <div class="admin-card" id="admin-card-faq">
                <a href="../admin/section/manage_faq/index.php">FAQ</a>
            </div>
            <div class="admin-card" id="admin-card-footer">
                <a href="../admin/section/manage_footer/index.php">Footer</a>
            </div>
        </div>

        <div class="admin-logout" id="admin-logout">
            <a href="../admin/login.php">Logout</a>
        </div>
    </div>
</body>
</html>
