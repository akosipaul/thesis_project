<?php
require 'database.php';
session_start();
header('Content-Type: application/json');

if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['success'=>false,'message'=>'Access denied']);
    exit;
}

$id = $_POST['id'] ?? 0;
$key = $_POST['key'] ?? '';
$value = $_POST['value'] ?? '';

if ($key === 'password') {
    $value = password_hash($value, PASSWORD_DEFAULT);
}

$stmt = $conn->prepare("UPDATE users SET $key=? WHERE id=?");
if ($stmt->execute([$value,$id])) {
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false,'message'=>'Update failed']);
}
?>