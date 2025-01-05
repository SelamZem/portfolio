<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the contact record
    $query = "DELETE FROM contact WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to the index page after success
        exit;
    } else {
        echo "Error: Could not delete the contact.";
    }
} else {
    header("Location: index.php"); // Redirect if no ID is passed
    exit;
}
?>
