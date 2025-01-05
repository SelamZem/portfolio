<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); 

$db = new Database();
$conn = $db->getConnection();


if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
    $query = "SELECT * FROM faq WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();


    $faq = $stmt->fetch(PDO::FETCH_ASSOC);

  
    if (!$faq) {
        header("Location: index.php");
        exit;
    }
} else {
   
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

  
    $query = "UPDATE faq SET question = :question, answer = :answer WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':answer', $answer);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to the index page after success
        exit;
    } else {
        $error = "Failed to update the FAQ.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit FAQ</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Edit FAQ</h1>

    <a href="index.php" class="btn btn-secondary mb-3">Back to Manage FAQ</a>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <input type="text" name="question" id="question" class="form-control" value="<?php echo htmlspecialchars($faq['question']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="answer" class="form-label">Answer</label>
                    <textarea name="answer" id="answer" rows="5" class="form-control" required><?php echo htmlspecialchars($faq['answer']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Update FAQ</button>
            </form>
        </div>
    </div>
</div>

<script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
