<?php
require_once 'includes/Database.php';


$db = new Database();
$conn = $db->getConnection(); // Get the PDO connection (updated method name)


function runSQLFile($file_path, $conn) {

    $sql = file_get_contents($file_path);

    $statements = array_filter(array_map('trim', explode(';', $sql)));

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


foreach ($sql_files as $file) {
    if (file_exists($file)) {
        runSQLFile($file, $conn);
    } else {
        echo "File '$file' not found.<br>";
    }
}


$conn = null;
?>
