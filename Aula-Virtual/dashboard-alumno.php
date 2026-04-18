<?php
session_start();
require_once './php/conexion.php';

// Si no está logueado lo mandamos al login
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'alumno') {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula Virtual — Alumno</title>
    <link rel="stylesheet" href="../Assets/Estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
</head>
<body class="body-dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="./Assets/Img/diseño1.png" alt="Logo" class="sidebar-logo">
            <div class="titulo-header">
                <span class="titulo-cp">C&P</span>
                <span class="titulo-soft">SOFT</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="dashboard-alumno.php" class="sidebar-link activo">🏠 Inicio</a>
            <a href="#" class="sidebar-link">📚 Mis Materias</a>
            <a href="#" class="sidebar-link">📢 Anuncios</a>
            <a href="#" class="sidebar-link">📁 Materiales</a>
        </nav>

        <a href="./php/cerrar-sesion.php" class="sidebar-cerrar">Cerrar sesión</a>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="dashboard-main">

        <!-- Saludo -->
        <div class="dashboard-bienvenida">
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</h1>
            <p>Este es tu panel de alumno. Desde acá podés ver tus materias, anuncios y materiales.</p>
        </div>

        <!-- Cards resumen -->
        <div class="dashboard-cards">

            <div class="dash-card">
                <div class="dash-card-icono">📚</div>
                <div>
                    <p class="dash-card-label">Mis materias</p>
                    <p class="dash-card-valor">—</p>
                </div>
            </div>

            <div class="dash-card">
                <div class="dash-card-icono">📢</div>
                <div>
                    <p class="dash-card-label">Anuncios nuevos</p>
                    <p class="dash-card-valor">—</p>
                </div>
            </div>

            <div class="dash-card">
                <div class="dash-card-icono">📁</div>
                <div>
                    <p class="dash-card-label">Materiales disponibles</p>
                    <p class="dash-card-valor">—</p>
                </div>
            </div>

        </div>

        <!-- Info del alumno -->
        <div class="dashboard-seccion">
            <h2 class="seccion-titulo">Mis datos</h2>
            <div class="info-card">
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']); ?></p>
                <p><strong>Rol:</strong> Alumno</p>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>