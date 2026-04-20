<?php
session_start();
require_once './php/conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor') {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula Virtual — Profesor</title>
    <link rel="stylesheet" href="../Aula-Virtual/dashboard.css">
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
            <a href="dashboard-profesor.php" class="sidebar-link activo">🏠 Inicio</a>
            <a href="#" class="sidebar-link">📚 Mis Materias</a>
            <a href="#" class="sidebar-link">📢 Publicar Anuncio</a>
            <a href="#" class="sidebar-link">📁 Subir Material</a>
            <a href="#" class="sidebar-link">👥 Alumnos</a>
        </nav>

        <a href="./php/cerrar-sesion.php" class="sidebar-cerrar">Cerrar sesión</a>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="dashboard-main">

        <div class="dashboard-bienvenida">
            <h1>Bienvenido, Prof. <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</h1>
            <p>Este es tu panel de profesor. Desde acá podés gestionar materias, anuncios y materiales.</p>
        </div>

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
                    <p class="dash-card-label">Anuncios publicados</p>
                    <p class="dash-card-valor">—</p>
                </div>
            </div>

            <div class="dash-card">
                <div class="dash-card-icono">👥</div>
                <div>
                    <p class="dash-card-label">Alumnos inscriptos</p>
                    <p class="dash-card-valor">—</p>
                </div>
            </div>

        </div>

        <div class="dashboard-seccion">
            <h2 class="seccion-titulo">Mis datos</h2>
            <div class="info-card">
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']); ?></p>
                <p><strong>Rol:</strong> Profesor</p>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>