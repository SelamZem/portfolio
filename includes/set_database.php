<?php
require_once 'includes/Database.php';

// Initialize Database connection
$db = new Database();
$conn = $db->getConnection(); // Get the PDO connection (updated method name)

// Function to run SQL from a file
function runSQLFile($file_path, $conn) {
    // Get the content of the .sql file
    $sql = file_get_contents($file_path);

    // Split the SQL file content into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql))); // Remove empty statements

    try {
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $conn->exec($statement);
            }
        }
        echo "SQL file '$file_path' executed successfully.<br>";
    } catch (PDOException $e) {
        echo "Error executing SQL file '$file_path': " . $e->getMessage() . "<br>";
    }
}

// Paths to the SQL files
$sql_files = [
    'tables/about.sql',
    'tables/admin.sql',
    'tables/services.sql',
    'tables/portfolio.sql',
    'tables/testimonials.sql',
    'tables/blog.sql',
    'tables/contact.sql',
    'tables/faq.sql',
    'tables/footer.sql'
];

// Loop through each SQL file and execute it
foreach ($sql_files as $file) {
    if (file_exists($file)) {
        runSQLFile($file, $conn);
    } else {
        echo "File '$file' not found.<br>";
    }
}

// Close the connection (optional with PDO)
$conn = null;
?>
