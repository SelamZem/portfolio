<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); 

$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $query = "SELECT * FROM blog WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if (!$blog) {
        header("Location: index.php"); 
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];

        
        $query = "UPDATE blog SET title = :title, content = :content, author = :author, updated_at = NOW() WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Failed to update the blog post.";
        }
    }
} else {
    header("Location: index.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link href="../../../static/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../static/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Blog Post</h1>
        <a href="index.php" class="btn btn-secondary mb-3">Back to Blog List</a>

        <form method="POST" action="">
            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $blog['title']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" rows="5" class="form-control" required><?php echo $blog['content']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" id="author" class="form-control" value="<?php echo $blog['author']; ?>" required>
            </div>

            <button type="submit" class="btn btn-warning">Update Blog</button>
        </form>
    </div>

</body>
</html>
