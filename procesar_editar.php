<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$cedula = $_POST['cedula'];
$cargo = $_POST['cargo'];
$obra_asignada = $_POST['obra_asignada'];
$telefono = $_POST['telefono'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$salario = $_POST['salario'];
$estado = $_POST['estado'];

$query = "UPDATE empleados SET 
            nombre = :nombre,
            cedula = :cedula,
            cargo = :cargo,
            obra_asignada = :obra_asignada,
            telefono = :telefono,
            fecha_ingreso = :fecha_ingreso,
            salario = :salario,
            estado = :estado
          WHERE id = :id";

$stmt = $conn->prepare($query);

$stmt->bindParam(':id', $id);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':cedula', $cedula);
$stmt->bindParam(':cargo', $cargo);
$stmt->bindParam(':obra_asignada', $obra_asignada);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
$stmt->bindParam(':salario', $salario);
$stmt->bindParam(':estado', $estado);

if ($stmt->execute()) {
    header("Location: empleados.php");
    exit();
} else {
    echo "Error al actualizar el empleado.";
}