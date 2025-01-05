<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth();

$db = new Database();
$conn = $db->getConnection();

$query = "SELECT * FROM portfolio ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$portfolios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Portfolio</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="../../index.php" class="btn btn-primary mb-3 float-end me-3">Back</a>
<div class="container mt-5">
    <h1>Portfolio</h1>
    <a href="create.php" class="btn btn-primary mb-3">Add Project</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($portfolios as $portfolio): ?>
            <tr>
                <td><?= htmlspecialchars($portfolio['id']) ?></td>
                <td><?= htmlspecialchars($portfolio['project_name']) ?></td>
                <td><?= htmlspecialchars($portfolio['description']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $portfolio['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $portfolio['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
