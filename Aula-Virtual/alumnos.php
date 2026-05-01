<?php
session_start();
require_once './php/conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor') {
    header("Location: Login.php");
    exit();
}

$id_profesor = $_SESSION['id'];

// Traer alumnos inscriptos en las materias del profesor
$query = "SELECT u.nombre, u.apellido, u.dni, u.correo, m.nombre AS materia
          FROM inscripciones i
          JOIN usuarios u ON i.id_alumno = u.id
          JOIN materias m ON i.id_materia = m.id
          WHERE m.id_profesor = ?
          ORDER BY m.nombre, u.apellido";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $id_profesor);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$alumnos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

// Agrupar por materia
$por_materia = [];
foreach ($alumnos as $alumno) {
    $por_materia[$alumno['materia']][] = $alumno;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos — C&P SOFT</title>
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
            <a href="dashboard-profesor.php" class="sidebar-link">🏠 Inicio</a>
            <a href="#" class="sidebar-link">📚 Mis Materias</a>
            <a href="publicar-anuncio.php" class="sidebar-link">📢 Publicar Anuncio</a>
            <a href="subir-material.php" class="sidebar-link">📁 Subir Material</a>
            <a href="alumnos.php" class="sidebar-link activo">👥 Alumnos</a>
        </nav>
        <a href="./php/cerrar-sesion.php" class="sidebar-cerrar">Cerrar sesión</a>
    </div>

    <main class="dashboard-main">

        <div class="dashboard-bienvenida">
            <h1>👥 Alumnos inscriptos</h1>
            <p>Estos son los alumnos inscriptos en tus materias.</p>
        </div>

        <?php if (count($por_materia) > 0): ?>
            <?php foreach ($por_materia as $nombre_materia => $lista): ?>
            <div class="dashboard-seccion">
                <h2 class="seccion-titulo">📚 <?php echo htmlspecialchars($nombre_materia); ?></h2>
                <div class="tabla-wrapper">
                    <table class="tabla-dashboard">
                        <thead>
                            <tr>
                                <th>Apellido y Nombre</th>
                                <th>DNI</th>
                                <th>Correo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista as $alumno): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($alumno['apellido'] . ', ' . $alumno['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($alumno['dni']); ?></td>
                                <td><?php echo htmlspecialchars($alumno['correo']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="sin-datos">No hay alumnos inscriptos todavía.</p>
        <?php endif; ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>