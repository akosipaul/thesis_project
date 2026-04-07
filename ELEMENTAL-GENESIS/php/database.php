<?php
// database.php
$host = "localhost";
$dbname = "elemental-genesis";
$user = "root";  // your MySQL username
$pass = "";      // your MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>