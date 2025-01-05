<?php
session_start();  // Start the session to handle login state

require_once 'auth.php';
require_once '../includes/Database.php';

// Initialize Database connection
$db = new Database();
$conn = $db->getConnection();  // Get the PDO connection

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch the admin by username
    $query = "SELECT * FROM admin WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Check if the admin exists in the database
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password using password_verify (assuming the password is hashed in the database)
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a session for the user
            $_SESSION['admin_id'] = $user['id'];  // Store admin's ID in the session
            $_SESSION['admin_username'] = $user['username'];  // Store username in session

            // Redirect to the admin dashboard (or any other page you choose)
            header('Location: /Portfolio/admin/index.php');

            exit();  // Make sure the script ends after the redirection
        } else {
            // Incorrect password
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
        // User does not exist
        $error_message = "Username not found. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Link to the correct CSS file -->
    <link rel="stylesheet" href="../admin/css/style.css">
</head>
<body>
    <div class="admin-login-container">
        
        <?php
        if (isset($error_message)) {
            echo "<div class='admin-error-message'>$error_message</div>";
        }
        ?>

        <form action="login.php" method="POST" class="admin-login-form">
            <div class="admin-input-group">
                <label for="admin-username" class="admin-label">Username</label>
                <input type="text" name="username" id="admin-username" class="admin-input" required>
            </div>
            <div class="admin-input-group">
                <label for="admin-password" class="admin-label">Password</label>
                <input type="password" name="password" id="admin-password" class="admin-input" required>
            </div>
            <button type="submit" class="admin-login-btn">Login</button>
        </form>
    </div>

    <!-- Link to the specific JS for the admin login page -->
    <script src="../admin/js/login.js"></script>
</body>
</html>
