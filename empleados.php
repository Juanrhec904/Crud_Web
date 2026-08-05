<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT empleados.*, usuarios.correo AS registrado_por 
          FROM empleados 
          LEFT JOIN usuarios ON empleados.usuario_id = usuarios.id 
          ORDER BY empleados.id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Empleados - Albañilería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body>

    <div class="placa">
        <span class="tornillo tl"></span>
        <span class="tornillo bl"></span>
        <div class="contenedor"
            style="padding:0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <div>
                <h1>Gestión de Empleados</h1>
                <div class="subtitulo">Construcciones &amp; Albañilería — Ficha de personal</div>
            </div>
            <div style="font-family:'IBM Plex Mono',monospace; font-size:0.8rem; color:#fff; text-align:right;">
                <?= htmlspecialchars($_SESSION['usuario_correo']) ?><br>
                <a href="logout.php" style="color:var(--amarillo); text-decoration:none;">Cerrar sesión</a>
            </div>
        </div>
    </div>

    <div class="contenedor">
        <div class="barra-superior mb-3">
            <a href="crear.php" class="btn btn-obra btn-nuevo">+ Nuevo empleado</a>

            <div class="buscador">
                <svg class="buscador-icono" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" id="inputBuscar" class="buscador-input" placeholder="Buscar por nombre o cédula...">
            </div>
        </div>

        <div class="ficha">
            <div class="tabla-scroll">
                <table class="tabla-obra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Cargo</th>
                            <th>Obra asignada</th>
                            <th>Teléfono</th>
                            <th>Ingreso</th>
                            <th>Salario</th>
                            <th>Estado</th>
                            <th>Registrado por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (count($empleados) > 0): ?>
                            <?php foreach ($empleados as $emp): ?>
                                <tr data-fila-empleado data-nombre="<?= htmlspecialchars($emp['nombre']) ?>"
                                    data-cedula="<?= htmlspecialchars($emp['cedula']) ?>">
                                    <td class="col-dato">
                                        <?= $emp['id'] ?>
                                    </td>
                                    <td class="col-nombre">
                                        <?= htmlspecialchars($emp['nombre']) ?>
                                    </td>
                                    <td class="col-dato">
                                        <?= htmlspecialchars($emp['cedula']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($emp['cargo']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($emp['obra_asignada']) ?>
                                    </td>
                                    <td class="col-dato">
                                        <?= htmlspecialchars($emp['telefono']) ?>
                                    </td>
                                    <td class="col-dato">
                                        <?= $emp['fecha_ingreso'] ?>
                                    </td>
                                    <td class="col-num">$
                                        <?= number_format($emp['salario'], 2) ?>
                                    </td>
                                    <td>
                                        <span
                                            class="tag-estado <?= $emp['estado'] == 'activo' ? 'tag-activo' : 'tag-inactivo' ?>">
                                            <?= $emp['estado'] ?>
                                        </span>
                                    </td>
                                    <td class="col-correo" style="font-size:0.78rem;"
                                        title="<?= $emp['registrado_por'] ? htmlspecialchars($emp['registrado_por']) : '' ?>">
                                        <?= $emp['registrado_por'] ? htmlspecialchars($emp['registrado_por']) : '—' ?>
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <a href="editar.php?id=<?= $emp['id'] ?>"
                                            class="btn btn-obra btn-editar btn-sm">Editar</a>
                                        <button type="button" class="btn btn-obra btn-eliminar btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEliminar" data-id="<?= $emp['id'] ?>"
                                            data-nombre="<?= htmlspecialchars($emp['nombre']) ?>">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="vacio">No hay empleados registrados aún.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:4px; border:none;">
                <div class="modal-header" style="background:var(--carbon); color:#fff; border-radius:4px 4px 0 0;">
                    <h5 class="modal-title"
                        style="font-family:'Oswald',sans-serif; text-transform:uppercase; letter-spacing:0.5px;">
                        Confirmar eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar a <strong id="nombreEmpleado"></strong>? Esta acción no se
                    puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-obra btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btnConfirmarEliminar" class="btn btn-obra btn-eliminar">Sí, eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>