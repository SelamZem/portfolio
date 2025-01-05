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
$query = "SELECT * FROM testimonials WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$testimonial = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$testimonial) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $testimony = $_POST['testimony'];

    $query = "UPDATE testimonials SET name = :name, testimony = :testimony WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':testimony', $testimony);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Failed to update testimonial.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Testimonial</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Testimonial</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($testimonial['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="testimony" class="form-label">Testimony</label>
            <textarea name="testimony" id="testimony" rows="5" class="form-control" required><?= htmlspecialchars($testimonial['testimony']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
</body>
</html>
