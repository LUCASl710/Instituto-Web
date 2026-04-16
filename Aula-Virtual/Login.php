<?php session_start();?>
<?php require_once './conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula Virtual — C&P SOFT</title>
    <link rel="stylesheet" href="../login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
</head>
<body class="body-login">
<div class="login-wrapper">

        <!-- Logo y nombre -->
        <div class="login-header">
            <img class="login-logo" src="../Assets/Img/fff.png" alt="Logo C&P SOFT">
            <div class="titulo-header">
                <span class="titulo-cp">C&P</span>
                <span class="titulo-soft">SOFT</span>
            </div>
            <p class="login-subtitulo">Aula Virtual</p>
        </div>

        <!-- Card del formulario -->
        <div class="login-card">
            <h2 class="login-titulo">Iniciar sesión</h2>
            <p class="login-descripcion">Ingresá con tu DNI y contraseña</p>

            <!-- Acá va el action cuando conectemos PHP -->
            <?php if (isset($_GET['error'])): ?>
    <div class="alert-error">
        DNI o contraseña incorrectos. Intentá de nuevo.
    </div>
            <?php endif; ?>
            <form action="./autenticar.php" method="POST">

                <div class="mb-3">
                    <label for="dni" class="form-label label-login">DNI / Usuario</label>
                    <input type="text" class="form-control input-login" id="dni" name="dni" placeholder="Ej: 40123456" required>
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label label-login">Contraseña</label>
                    <input type="password" class="form-control input-login" id="contrasena" name="contrasena" placeholder="Tu contraseña" required>
                </div>

                <button type="submit" class="btn-login">Ingresar</button>

            </form>

            <a href="../index.html" class="login-volver">← Volver al inicio</a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>