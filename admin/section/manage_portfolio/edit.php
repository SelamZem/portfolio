<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth();

$db = new Database();
$conn = $db->getConnection();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM portfolio WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$portfolio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$portfolio) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'] ?? null;
    $project_link = $_POST['project_link'] ?? null;

    $query = "UPDATE portfolio SET project_name = :project_name, description = :description, 
              image_url = :image_url, project_link = :project_link WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':project_name', $project_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':project_link', $project_link);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Failed to update project.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Project</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="project_name" class="form-label">Project Name</label>
            <input type="text" name="project_name" id="project_name" class="form-control" value="<?= htmlspecialchars($portfolio['project_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="5" class="form-control" required><?= htmlspecialchars($portfolio['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image_url" class="form-label">Image URL</label>
            <input type="text" name="image_url" id="image_url" class="form-control" value="<?= htmlspecialchars($portfolio['image_url']) ?>">
        </div>
        <div class="mb-3">
            <label for="project_link" class="form-label">Project Link</label>
            <input type="text" name="project_link" id="project_link" class="form-control" value="<?= htmlspecialchars($portfolio['project_link']) ?>">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
</body>
</html>
