<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); 

$db = new Database();
$conn = $db->getConnection();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "INSERT INTO about (title, content, created_at) VALUES (:title, :content, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to the index page after success
        exit;
    } else {
        $error = "Failed to create the content.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create About</title>
    <!-- Bootstrap CSS -->
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4">Create New About Content</h1>

        <a href="index.php" class="btn btn-secondary mb-3">Back to Manage About</a>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="">
                    <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea name="content" id="content" rows="5" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Create About</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
