<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth();

$db = new Database();
$conn = $db->getConnection();

$query = "SELECT * FROM testimonials ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Testimonials</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="../../index.php" class="btn btn-primary mb-3 float-end me-3">Back</a>

<div class="container mt-5">
    <h1>Manage Testimonials</h1>
    <a href="create.php" class="btn btn-primary mb-3">Add Testimonial</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Testimony</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($testimonials as $testimonial): ?>
            <tr>
                <td><?= htmlspecialchars($testimonial['id']) ?></td>
                <td><?= htmlspecialchars($testimonial['name']) ?></td>
                <td><?= htmlspecialchars($testimonial['testimony']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $testimonial['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $testimonial['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
