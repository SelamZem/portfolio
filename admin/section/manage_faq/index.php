<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); 

$db = new Database();
$conn = $db->getConnection();


$query = "SELECT * FROM faq ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$faqContents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage FAQ</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="../../index.php" class="btn btn-primary mb-3 float-end me-3">Back</a>
<div class="container mt-5">
    <h1 class="mb-4">Manage FAQ</h1>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faqContents as $faq): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($faq['question']); ?></td>
                            <td><?php echo substr($faq['answer'], 0, 100); ?>...</td>
                            <td>
                                <a href="edit.php?id=<?php echo $faq['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button onclick="confirmDelete(<?php echo $faq['id']; ?>)" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-primary mb-3">Create New FAQ</a>
        </div>
    </div>   
</div>

<script>
    // Confirmation before deletion
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this FAQ?')) {
            window.location.href = 'delete.php?id=' + id;
        }
    }
</script>

</body>
</html>
