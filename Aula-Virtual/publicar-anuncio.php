<?php
session_start();
require_once './php/conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor') {
    header("Location: Login.php");
    exit();
}

$id_profesor = $_SESSION['id'];
$mensaje_ok = false;
$mensaje_error = false;

// Traer materias del profesor para el select
$query_materias = "SELECT m.id, m.nombre FROM materias m WHERE m.id_profesor = ?";
$stmt = mysqli_prepare($conexion, $query_materias);
mysqli_stmt_bind_param($stmt, "i", $id_profesor);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$materias = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

// Si viene la materia preseleccionada desde el dashboard
$materia_preseleccionada = isset($_GET['materia']) ? intval($_GET['materia']) : 0;

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $id_materia = intval($_POST['id_materia']);

    if (!empty($titulo) && !empty($contenido) && $id_materia > 0) {
        $query_insert = "INSERT INTO anuncios (titulo, contenido, id_materia, id_profesor) VALUES (?, ?, ?, ?)";
        $stmt2 = mysqli_prepare($conexion, $query_insert);
        mysqli_stmt_bind_param($stmt2, "ssii", $titulo, $contenido, $id_materia, $id_profesor);

        if (mysqli_stmt_execute($stmt2)) {
            $mensaje_ok = true;
        } else {
            $mensaje_error = true;
        }
    } else {
        $mensaje_error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Anuncio — C&P SOFT</title>
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
            <a href="publicar-anuncio.php" class="sidebar-link activo">📢 Publicar Anuncio</a>
            <a href="#" class="sidebar-link">📁 Subir Material</a>
            <a href="./alumnos.php" class="sidebar-link">👥 Alumnos</a>
        </nav>
        <a href="./php/cerrar-sesion.php" class="sidebar-cerrar">Cerrar sesión</a>
    </div>

    <main class="dashboard-main">

        <div class="dashboard-bienvenida">
            <h1>📢 Publicar Anuncio</h1>
            <p>Escribí un anuncio para tus alumnos. Lo verán en su dashboard.</p>
        </div>

        <?php if ($mensaje_ok): ?>
            <div class="alerta-ok">
                ✅ Anuncio publicado correctamente.
                <a href="dashboard-profesor.php">Volver al inicio</a>
            </div>
        <?php endif; ?>

        <?php if ($mensaje_error): ?>
            <div class="alerta-error">
                ❌ Hubo un error. Completá todos los campos.
            </div>
        <?php endif; ?>

        <div class="dashboard-seccion">
            <div class="form-dashboard">
                <form action="publicar-anuncio.php" method="POST">

                    <div class="mb-4">
                        <label class="form-dash-label">Materia</label>
                        <select name="id_materia" class="form-dash-input" required>
                            <option value="" disabled selected>— Seleccioná una materia —</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?php echo $materia['id']; ?>"
                                    <?php echo ($materia['id'] == $materia_preseleccionada) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($materia['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-dash-label">Título del anuncio</label>
                        <input type="text" name="titulo" class="form-dash-input" placeholder="Ej: Cambio de fecha del parcial" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-dash-label">Contenido</label>
                        <textarea name="contenido" class="form-dash-input" rows="5" placeholder="Escribí el contenido del anuncio acá..." required></textarea>
                    </div>

                    <button type="submit" class="btn-dash-submit">Publicar anuncio</button>

                </form>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>