<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the footer record
    $query = "DELETE FROM footer WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to index after success
        exit;
    } else {
        echo "Error: Could not delete the footer content.";
    }
} else {
    header("Location: index.php"); // Redirect if no ID is passed
    exit;
}
?>
