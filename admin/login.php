<?php
session_start();  

require_once 'auth.php';
require_once '../includes/Database.php';


$db = new Database();
$conn = $db->getConnection();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $query = "SELECT * FROM admin WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password using password_verify (assuming the password is hashed in the database)
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id']; 
            $_SESSION['admin_username'] = $user['username'];


            header('Location: /Portfolio/admin/index.php');

            exit(); 
        } else {
           
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
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
