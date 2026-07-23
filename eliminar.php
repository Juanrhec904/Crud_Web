<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$id = $_GET['id'];

$query = "DELETE FROM empleados WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: empleados.php");
exit();