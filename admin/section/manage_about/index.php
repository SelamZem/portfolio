<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

// Fetch all 'about' content from the database
$query = "SELECT * FROM about ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$aboutContents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage About Content</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this content?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</head>
<body>
<a href="../../index.php" class="btn btn-primary mb-3 float-end me-3">Back</a>
<div class="container mt-5">
    <h1 class="mb-4">Manage About Content</h1>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($aboutContents as $about): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($about['title']); ?></td>
                            <td><?php echo substr($about['content'], 0, 100); ?>...</td>
                            <td>
                                <a href="edit.php?id=<?php echo $about['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button onclick="confirmDelete(<?php echo $about['id']; ?>)" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-primary mb-3">Create New "About" Content</a>
        </div>
        
    </div>   
</div>

</body>
</html>
