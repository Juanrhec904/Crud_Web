<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>

<div class="placa">
    <span class="tornillo tl"></span>
    <span class="tornillo bl"></span>
    <div class="contenedor" style="padding:0;">
        <h1>Nuevo empleado</h1>
        <div class="subtitulo">Registro de personal en obra</div>
    </div>
</div>

<div class="contenedor">
    <form action="procesar_crear.php" method="POST" class="formulario-obra">
        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cédula</label>
            <input type="text" name="cedula" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cargo</label>
            <select name="cargo" class="form-control" required>
                <option value="">Selecciona un cargo</option>
                <option value="Albañil">Albañil</option>
                <option value="Maestro de obra">Maestro de obra</option>
                <option value="Ayudante">Ayudante</option>
                <option value="Supervisor">Supervisor</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Obra asignada</label>
            <input type="text" name="obra_asignada" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Salario</label>
            <input type="number" step="0.01" name="salario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-control">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-obra btn-nuevo">Guardar empleado</button>
        <a href="empleados.php" class="btn btn-obra btn-cancelar">Cancelar</a>
    </form>
</div>

</body>
</html>