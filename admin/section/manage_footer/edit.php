<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

// Check if the ID parameter is passed for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing data for the footer record
    $query = "SELECT * FROM footer WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Fetch the result
    $footer = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no data found, redirect to index
    if (!$footer) {
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
    $footer_content = $_POST['footer_content'];
    $social_links = $_POST['social_links'];

    // Update the footer record
    $query = "UPDATE footer SET footer_content = :footer_content, social_links = :social_links WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':footer_content', $footer_content);
    $stmt->bindParam(':social_links', $social_links);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to index after success
        exit;
    } else {
        $error = "Failed to update the footer content.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Footer</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Edit Footer</h1>

    <a href="index.php" class="btn btn-secondary mb-3">Back to Manage Footer</a>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                <div class="mb-3">
                    <label for="footer_content" class="form-label">Footer Content</label>
                    <textarea name="footer_content" id="footer_content" rows="5" class="form-control" required><?php echo htmlspecialchars($footer['footer_content']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="social_links" class="form-label">Social Links</label>
                    <textarea name="social_links" id="social_links" rows="3" class="form-control"><?php echo htmlspecialchars($footer['social_links']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Update Footer</button>
            </form>
        </div>
    </div>
</div>

<script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
