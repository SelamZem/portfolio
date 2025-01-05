<?php
require_once 'includes/Database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);

  
    if (empty($username) || empty($password) || empty($email)) {
        echo "All fields are required!";
    } else {
        try {
          
            $db = new Database();
            $conn = $db->getConnection();

            
            $sql = "INSERT INTO admin (username, password, email) VALUES (:username, :password, :email)";
            $stmt = $conn->prepare($sql);

         
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

         
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);

           
            $stmt->execute();

            echo "Admin user added successfully!";
        } catch (PDOException $e) {
            // Handle any exceptions (errors)
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!-- HTML Form to Add Admin -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
</head>
<body>

    <h2>Add Admin User</h2>
    
    <form action="add_admin.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <button type="submit">Add Admin</button>
    </form>

</body>
</html>
