<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . "/database.php";

echo "If you see this, PHP is working.<br>";

if ($conn) {
    echo "DATABASE CONNECTED!";
} else {
    echo "DATABASE FAILED!";
}
?>