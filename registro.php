<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: empleados.php");
    exit();
}

$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse - Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>

<div class="placa">
    <span class="tornillo tl"></span>
    <span class="tornillo bl"></span>
    <div class="contenedor" style="padding:0;">
        <h1>Crear cuenta</h1>
        <div class="subtitulo">Construcciones &amp; Albañilería — Registro de acceso</div>
    </div>
</div>

<div class="contenedor" style="display:flex; justify-content:center;">
    <form action="procesar_registro.php" method="POST" class="formulario-obra" style="width:100%; max-width:420px;">

        <?php if ($error == 'existe'): ?>
            <div class="alert alert-danger py-2" style="font-size:0.85rem;">
                Ese correo ya está registrado. Intenta iniciar sesión.
            </div>
        <?php elseif ($error == 'noigual'): ?>
            <div class="alert alert-danger py-2" style="font-size:0.85rem;">
                Las contraseñas no coinciden.
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" minlength="6" required>
                <button type="button" class="btn btn-obra btn-cancelar toggle-password" data-target="password">Ver</button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <div class="input-group">
                <input type="password" name="password2" id="password2" class="form-control" minlength="6" required>
                <button type="button" class="btn btn-obra btn-cancelar toggle-password" data-target="password2">Ver</button>
            </div>
        </div>

        <button type="submit" class="btn btn-obra btn-nuevo w-100 mb-3">Registrarme</button>

        <p class="text-center" style="font-size:0.9rem;">
            ¿Ya tienes cuenta? <a href="index.php" style="color:var(--acero); font-weight:600;">Inicia sesión</a>
        </p>
    </form>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(function (boton) {
        boton.addEventListener('click', function () {
            const inputId = boton.getAttribute('data-target');
            const input = document.getElementById(inputId);

            if (input.type === 'password') {
                input.type = 'text';
                boton.textContent = 'Ocultar';
            } else {
                input.type = 'password';
                boton.textContent = 'Ver';
            }
        });
    });
</script>

</body>
</html>