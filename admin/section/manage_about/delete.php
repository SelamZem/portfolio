<?php
require_once '../../auth.php';
require_once '../../../includes/Database.php';

checkAuth(); // Check if the user is authenticated

$db = new Database();
$conn = $db->getConnection();

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the DELETE query to remove the 'about' entry by ID
    $query = "DELETE FROM about WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Redirect back to the index page after successful deletion
        header("Location: index.php");
        exit;
    } else {
        // In case of failure (optional)
        echo "Error: Could not delete the content.";
    }
} else {
    // If no 'id' parameter is present, redirect back
    header("Location: index.php");
    exit;
}
?>
