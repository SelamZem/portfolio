<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

// Fetch the footer content from the database
$query = "SELECT * FROM footer ORDER BY created_at DESC LIMIT 1";  // Assuming only one footer record
$stmt = $conn->prepare($query);
$stmt->execute();
$footer = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Footer</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="../../index.php" class="btn btn-primary mb-3 float-end me-3">Back</a>
<div class="container mt-5">
    <h1 class="mb-4">Manage Footer</h1>
    <div class="card">
        <div class="card-body">
            <?php if ($footer): ?>
                <p><strong>Footer Content:</strong> <?php echo htmlspecialchars($footer['footer_content']); ?></p>
                <p><strong>Social Links:</strong> <?php echo htmlspecialchars($footer['social_links']); ?></p>
                <a href="edit.php?id=<?php echo $footer['id']; ?>" class="btn btn-warning btn-sm">Edit Footer</a>
                <button onclick="confirmDelete(<?php echo $footer['id']; ?>)" class="btn btn-danger btn-sm">Delete Footer</button>
            <?php else: ?>
                <p>No footer content available.</p>
                <a href="create.php" class="btn btn-primary mb-3">Create Footer</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Confirmation before deletion
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this footer content?')) {
            window.location.href = 'delete.php?id=' + id;
        }
    }
</script>

</body>
</html>
