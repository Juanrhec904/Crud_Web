<?php
session_start();
require_once 'config/database.php';

$correo = trim($_POST['correo']);
$password = $_POST['password'];

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT * FROM usuarios WHERE correo = :correo";
$stmt = $conn->prepare($query);
$stmt->bindParam(':correo', $correo);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificamos que el usuario exista Y que la contraseña coincida con el hash guardado
if ($usuario && password_verify($password, $usuario['password'])) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_correo'] = $usuario['correo'];
    header("Location: empleados.php");
    exit();
} else {
    header("Location: index.php?error=1");
    exit();
}