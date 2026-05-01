<?php
session_start();
require_once './php/conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'alumno') {
    header("Location: Login.php");
    exit();
}

$id_alumno = $_SESSION['id'];

// Traer materias del alumno
$query_materias = "SELECT m.id, m.nombre, c.nombre AS carrera,
                CONCAT(u.nombre, ' ', u.apellido) AS profesor
                FROM inscripciones i
                JOIN materias m ON i.id_materia = m.id
                JOIN carreras c ON m.id_carrera = c.id
                JOIN usuarios u ON m.id_profesor = u.id
                WHERE i.id_alumno = ?";
$stmt = mysqli_prepare($conexion, $query_materias);
mysqli_stmt_bind_param($stmt, "i", $id_alumno);
mysqli_stmt_execute($stmt);
$resultado_materias = mysqli_stmt_get_result($stmt);
$materias = mysqli_fetch_all($resultado_materias, MYSQLI_ASSOC);

// Traer anuncios de las materias del alumno
$query_anuncios = "SELECT a.titulo, a.contenido, a.fecha, m.nombre AS materia
                FROM anuncios a
                JOIN materias m ON a.id_materia = m.id
                JOIN inscripciones i ON i.id_materia = m.id
                WHERE i.id_alumno = ?
                ORDER BY a.fecha DESC
                LIMIT 5";
$stmt2 = mysqli_prepare($conexion, $query_anuncios);
mysqli_stmt_bind_param($stmt2, "i", $id_alumno);
mysqli_stmt_execute($stmt2);
$resultado_anuncios = mysqli_stmt_get_result($stmt2);
$anuncios = mysqli_fetch_all($resultado_anuncios, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula Virtual — Alumno</title>
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
            <a href="dashboard-alumno.php" class="sidebar-link activo">🏠 Inicio</a>
            <a href="#" class="sidebar-link">📚 Mis Materias</a>
            <a href="#" class="sidebar-link">📢 Anuncios</a>
            <a href="#" class="sidebar-link">📁 Materiales</a>
        </nav>
        <a href="./php/cerrar-sesion.php" class="sidebar-cerrar">Cerrar sesión</a>
    </div>

    <main class="dashboard-main">

        <div class="dashboard-bienvenida">
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</h1>
            <p>Este es tu panel de alumno. Desde acá podés ver tus materias y anuncios.</p>
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
                    <p class="dash-card-label">Anuncios recientes</p>
                    <p class="dash-card-valor"><?php echo count($anuncios); ?></p>
                </div>
            </div>
            <div class="dash-card">
                <div class="dash-card-icono">📁</div>
                <div>
                    <p class="dash-card-label">Materiales</p>
                    <p class="dash-card-valor">—</p>
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
                            <th>Profesor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materias as $materia): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($materia['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($materia['carrera']); ?></td>
                            <td><?php echo htmlspecialchars($materia['profesor']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="sin-datos">No tenés materias inscriptas todavía.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Anuncios -->
        <div class="dashboard-seccion">
            <h2 class="seccion-titulo">Anuncios Recientes</h2>
            <?php if (count($anuncios) > 0): ?>
                <?php foreach ($anuncios as $anuncio): ?>
                <div class="anuncio-card">
                    <div class="anuncio-header">
                        <span class="anuncio-materia">📚 <?php echo htmlspecialchars($anuncio['materia']); ?></span>
                        <span class="anuncio-fecha"><?php echo date('d/m/Y H:i', strtotime($anuncio['fecha'])); ?></span>
                    </div>
                    <h3 class="anuncio-titulo"><?php echo htmlspecialchars($anuncio['titulo']); ?></h3>
                    <p class="anuncio-contenido"><?php echo htmlspecialchars($anuncio['contenido']); ?></p>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="sin-datos">No hay anuncios todavía.</p>
            <?php endif; ?>
        </div>
<!-- Materiales -->
<?php
$query_materiales = "SELECT mat.titulo, mat.tipo, mat.url, mat.fecha, m.nombre AS materia
                    FROM materiales mat
                    JOIN materias m ON mat.id_materia = m.id
                    JOIN inscripciones i ON i.id_materia = m.id
                    WHERE i.id_alumno = ?
                    ORDER BY mat.fecha DESC";
$stmt3 = mysqli_prepare($conexion, $query_materiales);
mysqli_stmt_bind_param($stmt3, "i", $id_alumno);
mysqli_stmt_execute($stmt3);
$resultado_materiales = mysqli_stmt_get_result($stmt3);
$materiales = mysqli_fetch_all($resultado_materiales, MYSQLI_ASSOC);
?>
<div class="dashboard-seccion">
    <h2 class="seccion-titulo">📁 Materiales</h2>
    <?php if (count($materiales) > 0): ?>
        <?php foreach ($materiales as $mat): ?>
        <div class="material-card">
            <div class="material-info">
                <span class="material-icono"><?php echo $mat['tipo'] == 'archivo' ? '📄' : '🔗'; ?></span>
                <div>
                    <p class="material-titulo"><?php echo htmlspecialchars($mat['titulo']); ?></p>
                    <p class="material-materia">📚 <?php echo htmlspecialchars($mat['materia']); ?></p>
                </div>
            </div>
            <a href="<?php echo $mat['tipo'] == 'archivo' ? '../' . $mat['url'] : htmlspecialchars($mat['url']); ?>"
               target="_blank" class="btn-material">
                <?php echo $mat['tipo'] == 'archivo' ? 'Descargar' : 'Abrir link'; ?>
            </a>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="sin-datos">No hay materiales disponibles todavía.</p>
    <?php endif; ?>
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