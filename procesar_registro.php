<?php
require_once 'config/database.php';

$correo = trim($_POST['correo']);
$password = $_POST['password'];
$password2 = $_POST['password2'];

// 1. Validar que las contraseñas coincidan
if ($password !== $password2) {
    header("Location: registro.php?error=noigual");
    exit();
}

$database = new Database();
$conn = $database->getConnection();

// 2. Validar que el correo no exista ya
$query = "SELECT id FROM usuarios WHERE correo = :correo";
$stmt = $conn->prepare($query);
$stmt->bindParam(':correo', $correo);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: registro.php?error=existe");
    exit();
}

// 3. Hashear la contraseña (NUNCA se guarda en texto plano)
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// 4. Guardar el nuevo usuario
$query = "INSERT INTO usuarios (correo, password) VALUES (:correo, :password)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':password', $password_hash);

if ($stmt->execute()) {
    header("Location: index.php?registrado=1");
    exit();
} else {
    echo "Error al registrar el usuario.";
}