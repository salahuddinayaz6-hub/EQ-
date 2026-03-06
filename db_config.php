<?php
// db_config.php - Database connection configuration
$host = 'localhost';
$db   = 'rsoa_rsoa276_16';
$user = 'rsoa_rsoa276_16';
$pass = '123456';
$charset = 'utf8mb4';
 
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
 
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // For development, show the error. In production, log it.
     // throw new \PDOException($e->getMessage(), (int)$e->getCode());
     die("Database connection failed. Please ensure the database is setup.");
}
?>
 
