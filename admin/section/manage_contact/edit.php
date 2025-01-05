<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

// Check if the ID parameter is passed for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing data for the 'contact' record
    $query = "SELECT * FROM contact WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Fetch the result
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no data found, redirect to index
    if (!$contact) {
        header("Location: index.php");
        exit;
    }
} else {
    // If no ID is passed, redirect to index
    header("Location: index.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Update the contact record
    $query = "UPDATE contact SET name = :name, email = :email, message = :message WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to the index page after success
        exit;
    } else {
        $error = "Failed to update the contact.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <!-- Bootstrap CSS -->
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4">Edit Contact</h1>

        <a href="index.php" class="btn btn-secondary mb-3">Back to Manage Contacts</a>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="">
                    <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($contact['name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($contact['email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" id="message" rows="5" class="form-control" required><?php echo htmlspecialchars($contact['message']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Update Contact</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
