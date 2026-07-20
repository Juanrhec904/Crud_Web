<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT * FROM empleados ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados - Albañilería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Empleados</h1>
    <a href="crear.php" class="btn btn-success mb-3">+ Nuevo Empleado</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Cargo</th>
                <th>Obra Asignada</th>
                <th>Teléfono</th>
                <th>Fecha Ingreso</th>
                <th>Salario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($empleados) > 0): ?>
                <?php foreach ($empleados as $emp): ?>
                <tr>
                    <td><?= $emp['id'] ?></td>
                    <td><?= htmlspecialchars($emp['nombre']) ?></td>
                    <td><?= htmlspecialchars($emp['cedula']) ?></td>
                    <td><?= htmlspecialchars($emp['cargo']) ?></td>
                    <td><?= htmlspecialchars($emp['obra_asignada']) ?></td>
                    <td><?= htmlspecialchars($emp['telefono']) ?></td>
                    <td><?= $emp['fecha_ingreso'] ?></td>
                    <td>$<?= number_format($emp['salario'], 2) ?></td>
                    <td>
                        <span class="badge bg-<?= $emp['estado'] == 'activo' ? 'success' : 'secondary' ?>">
                            <?= $emp['estado'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="editar.php?id=<?= $emp['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEliminar"
                                data-id="<?= $emp['id'] ?>"
                                data-nombre="<?= htmlspecialchars($emp['nombre']) ?>">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="10" class="text-center">No hay empleados registrados aún.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal de confirmación para eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar a <strong id="nombreEmpleado"></strong>? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btnConfirmarEliminar" class="btn btn-danger">Sí, eliminar</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modalEliminar = document.getElementById('modalEliminar');
    modalEliminar.addEventListener('show.bs.modal', function (event) {
        const boton = event.relatedTarget; // el botón que abrió el modal
        const id = boton.getAttribute('data-id');
        const nombre = boton.getAttribute('data-nombre');

        document.getElementById('nombreEmpleado').textContent = nombre;
        document.getElementById('btnConfirmarEliminar').href = 'eliminar.php?id=' + id;
    });
</script>
</body>
</html>