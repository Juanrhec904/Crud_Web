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

$query = "SELECT * FROM empleados WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$emp = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$emp) {
    echo "Empleado no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>

<div class="placa">
    <span class="tornillo tl"></span>
    <span class="tornillo bl"></span>
    <div class="contenedor" style="padding:0;">
        <h1>Editar empleado</h1>
        <div class="subtitulo">Actualizando ficha de <?= htmlspecialchars($emp['nombre']) ?></div>
    </div>
</div>

<div class="contenedor">
    <form action="procesar_editar.php" method="POST" class="formulario-obra">
        <input type="hidden" name="id" value="<?= $emp['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($emp['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cédula</label>
            <input type="text" name="cedula" class="form-control" value="<?= htmlspecialchars($emp['cedula']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cargo</label>
            <select name="cargo" class="form-control" required>
                <?php foreach (['Albañil', 'Maestro de obra', 'Ayudante', 'Supervisor'] as $c): ?>
                    <option value="<?= $c ?>" <?= $emp['cargo'] == $c ? 'selected' : '' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Obra asignada</label>
            <input type="text" name="obra_asignada" class="form-control" value="<?= htmlspecialchars($emp['obra_asignada']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($emp['telefono']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" value="<?= $emp['fecha_ingreso'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Salario</label>
            <input type="number" step="0.01" name="salario" class="form-control" value="<?= $emp['salario'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-control">
                <option value="activo" <?= $emp['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                <option value="inactivo" <?= $emp['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-obra btn-editar">Actualizar empleado</button>
        <a href="empleados.php" class="btn btn-obra btn-cancelar">Cancelar</a>
    </form>
</div>

</body>
</html>