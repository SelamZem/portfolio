<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $query = "INSERT INTO faq (question, answer, created_at) VALUES (:question, :answer, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':answer', $answer);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to the index page after success
        exit;
    } else {
        $error = "Failed to create the FAQ.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create FAQ</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Create New FAQ</h1>

    <a href="index.php" class="btn btn-secondary mb-3">Back to Manage FAQ</a>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <input type="text" name="question" id="question" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="answer" class="form-label">Answer</label>
                    <textarea name="answer" id="answer" rows="5" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-success">Create FAQ</button>
            </form>
        </div>
    </div>
</div>

<script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
