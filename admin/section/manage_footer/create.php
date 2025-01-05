<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $footer_content = $_POST['footer_content'];
    $social_links = $_POST['social_links'];

    $query = "INSERT INTO footer (footer_content, social_links, created_at) VALUES (:footer_content, :social_links, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':footer_content', $footer_content);
    $stmt->bindParam(':social_links', $social_links);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to index after success
        exit;
    } else {
        $error = "Failed to create the footer content.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Footer</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Create Footer</h1>

    <a href="index.php" class="btn btn-secondary mb-3">Back to Manage Footer</a>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                <div class="mb-3">
                    <label for="footer_content" class="form-label">Footer Content</label>
                    <textarea name="footer_content" id="footer_content" rows="5" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="social_links" class="form-label">Social Links</label>
                    <textarea name="social_links" id="social_links" rows="3" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Create Footer</button>
            </form>
        </div>
    </div>
</div>

<script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
