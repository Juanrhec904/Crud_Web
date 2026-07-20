<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$id = $_GET['id'];

$query = "DELETE FROM empleados WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: index.php");
exit();