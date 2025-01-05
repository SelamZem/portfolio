<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the DELETE query to remove the blog post by ID
    $query = "DELETE FROM blog WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to the index page after successful deletion
        exit;
    } else {
        echo "Error: Could not delete the blog post.";
    }
} else {
    header("Location: index.php"); // Redirect if no 'id' parameter is provided
    exit;
}
