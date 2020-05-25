<?php


// database connection
$DB_HOST = 'localhost';
$DB_DBNAME = 'vci';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO('mysql:host=' . $DB_HOST . ';dbname=' . $DB_DBNAME, $DB_USER, $DB_PASS,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false));
} catch (PDOException $e) {
    die('Connection error: ' . $e->getMessage());
    exit;
}

?>
