<?php
session_start();
require_once './php/conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor') {
    header("Location: Login.php");
    exit();
}

// Traer materias del profesor
$id_profesor = $_SESSION['id'];
$query_materias = "SELECT m.id, m.nombre, c.nombre AS carrera 
                   FROM materias m 
                   JOIN carreras c ON m.id_carrera = c.id 
                   WHERE m.id_profesor = ?";
$stmt = mysqli_prepare($conexion, $query_materias);
mysqli_stmt_bind_param($stmt, "i", $id_profesor);
mysqli_stmt_execute($stmt);
$resultado_materias = mysqli_stmt_get_result($stmt);
$materias = mysqli_fetch_all($resultado_materias, MYSQLI_ASSOC);

// Contar anuncios del profesor
$query_anuncios = "SELECT COUNT(*) AS total FROM anuncios WHERE id_profesor = ?";
$stmt2 = mysqli_prepare($conexion, $query_anuncios);
mysqli_stmt_bind_param($stmt2, "i", $id_profesor);
mysqli_stmt_execute($stmt2);
$resultado_anuncios = mysqli_stmt_get_result($stmt2);
$total_anuncios = mysqli_fetch_assoc($resultado_anuncios)['total'];

// Contar alumnos inscriptos en sus materias
$query_alumnos = "SELECT COUNT(DISTINCT i.id_alumno) AS total 
                  FROM inscripciones i 
                  JOIN materias m ON i.id_materia = m.id 
                  WHERE m.id_profesor = ?";
$stmt3 = mysqli_prepare($conexion, $query_alumnos);
mysqli_stmt_bind_param($stmt3, "i", $id_profesor);
mysqli_stmt_execute($stmt3);
$resultado_alumnos = mysqli_stmt_get_result($stmt3);
$total_alumnos = mysqli_fetch_assoc($resultado_alumnos)['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula Virtual — Profesor</title>
    <link rel="stylesheet" href="./dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
</head>
<body class="body-dashboard">

    <div class="sidebar">
        <div class="sidebar-header">
            <img src="../Assets/Img/diseño1.png" alt="Logo" class="sidebar-logo">
            <div class="titulo-header">
                <span class="titulo-cp">C&P</span>
                <span class="titulo-soft">SOFT</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard-profesor.php" class="sidebar-link activo">🏠 Inicio</a>
            <a href="#" class="sidebar-link">📚 Mis Materias</a>
            <a href="publicar-anuncio.php" class="sidebar-link">📢 Publicar Anuncio</a>
            <a href="#" class="sidebar-link">📁 Subir Material</a>
            <a href="#" class="sidebar-link">👥 Alumnos</a>
        </nav>
        <a href="./php/cerrar-sesion.php" class="sidebar-cerrar">Cerrar sesión</a>
    </div>

    <main class="dashboard-main">

        <div class="dashboard-bienvenida">
            <h1>Bienvenido, Prof. <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</h1>
            <p>Este es tu panel de profesor.</p>
        </div>

        <!-- Cards resumen -->
        <div class="dashboard-cards">
            <div class="dash-card">
                <div class="dash-card-icono">📚</div>
                <div>
                    <p class="dash-card-label">Mis materias</p>
                    <p class="dash-card-valor"><?php echo count($materias); ?></p>
                </div>
            </div>
            <div class="dash-card">
                <div class="dash-card-icono">📢</div>
                <div>
                    <p class="dash-card-label">Anuncios publicados</p>
                    <p class="dash-card-valor"><?php echo $total_anuncios; ?></p>
                </div>
            </div>
            <div class="dash-card">
                <div class="dash-card-icono">👥</div>
                <div>
                    <p class="dash-card-label">Alumnos inscriptos</p>
                    <p class="dash-card-valor"><?php echo $total_alumnos; ?></p>
                </div>
            </div>
        </div>

        <!-- Materias -->
        <div class="dashboard-seccion">
            <h2 class="seccion-titulo">Mis Materias</h2>
            <div class="tabla-wrapper">
                <?php if (count($materias) > 0): ?>
                <table class="tabla-dashboard">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Carrera</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materias as $materia): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($materia['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($materia['carrera']); ?></td>
                            <td>
                                <a href="publicar-anuncio.php?materia=<?php echo $materia['id']; ?>" class="btn-tabla">
                                    📢 Anuncio
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="sin-datos">No tenés materias asignadas todavía.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Info -->
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