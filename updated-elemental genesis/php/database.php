<?php
// database.php
$host = "sql100.infinityfree.com";
$user = "if0_41321204";
$pass = "NbBs2osuRm7ZEAJ";
$dbname = "if0_41321204_elementalgenesis";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>