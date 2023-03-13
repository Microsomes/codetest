<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$db = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

$db = new PDO("mysql:host=$host;dbname=$db", $user, $pass); //pdo

// Set the name of the table to create
$tableName = 'bookings';

// Define the structure of the table
$tableStructure = "
    CREATE TABLE IF NOT EXISTS $tableName (
        booking_id INT(11) NOT NULL AUTO_INCREMENT,
        organisation_id VARCHAR(255) NOT NULL,
        status VARCHAR(255) NOT NULL,
        PRIMARY KEY (booking_id)
    )
";

// Execute the query to create the table
$db->exec($tableStructure);

// Close the database connection
$db = null;
?>
