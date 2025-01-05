<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

// Fetch all contacts from the database
$query = "SELECT * FROM contact ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirmation before deletion
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this contact?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</head>
<body>
<a href="../../index.php" class="btn btn-primary mb-3 float-end me-3">Back</a>
<div class="container mt-5">
    <h1 class="mb-4">Manage Contacts</h1>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td><?php echo substr($contact['message'], 0, 100); ?>...</td>
                            <td><?php echo $contact['created_at']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $contact['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button onclick="confirmDelete(<?php echo $contact['id']; ?>)" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-primary mb-3">Create New Contact</a>
        </div>
    </div>
</div>

</body>
</html>
