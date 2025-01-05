<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth();

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'] ?? null;
    $project_link = $_POST['project_link'] ?? null;

    $query = "INSERT INTO portfolio (project_name, description, image_url, project_link) 
              VALUES (:project_name, :description, :image_url, :project_link)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':project_name', $project_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':project_link', $project_link);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Failed to add project.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Add Project</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="project_name" class="form-label">Project Name</label>
            <input type="text" name="project_name" id="project_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="5" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image_url" class="form-label">Image URL</label>
            <input type="text" name="image_url" id="image_url" class="form-control">
        </div>
        <div class="mb-3">
            <label for="project_link" class="form-label">Project Link</label>
            <input type="text" name="project_link" id="project_link" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
</body>
</html>
