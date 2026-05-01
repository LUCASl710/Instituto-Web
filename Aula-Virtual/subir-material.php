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

// Traer materias del profesor
$query_materias = "SELECT id, nombre FROM materias WHERE id_profesor = ?";
$stmt = mysqli_prepare($conexion, $query_materias);
mysqli_stmt_bind_param($stmt, "i", $id_profesor);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$materias = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo']);
    $tipo = $_POST['tipo'];
    $id_materia = intval($_POST['id_materia']);

    if ($tipo == 'link') {
        $url = trim($_POST['url']);

        if (!empty($titulo) && !empty($url) && $id_materia > 0) {
            $query = "INSERT INTO materiales (titulo, tipo, url, id_materia, id_profesor) VALUES (?, 'link', ?, ?, ?)";
            $stmt2 = mysqli_prepare($conexion, $query);
            mysqli_stmt_bind_param($stmt2, "ssii", $titulo, $url, $id_materia, $id_profesor);
            $mensaje_ok = mysqli_stmt_execute($stmt2);
            if (!$mensaje_ok) $mensaje_error = true;
        } else {
            $mensaje_error = true;
        }

    } else if ($tipo == 'archivo') {
        // Verificar que se subió un archivo
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
            $extension = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));

            if ($extension == 'pdf') {
                // Crear carpeta de uploads si no existe
                $carpeta = "../Assets/Uploads/";
                if (!is_dir($carpeta)) mkdir($carpeta, 0777, true);

                $nombre_archivo = time() . '_' . basename($_FILES['archivo']['name']);
                $ruta = $carpeta . $nombre_archivo;

                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
                    $url_guardada = "Assets/Uploads/" . $nombre_archivo;
                    $query = "INSERT INTO materiales (titulo, tipo, url, id_materia, id_profesor) VALUES (?, 'archivo', ?, ?, ?)";
                    $stmt2 = mysqli_prepare($conexion, $query);
                    mysqli_stmt_bind_param($stmt2, "ssii", $titulo, $url_guardada, $id_materia, $id_profesor);
                    $mensaje_ok = mysqli_stmt_execute($stmt2);
                    if (!$mensaje_ok) $mensaje_error = true;
                } else {
                    $mensaje_error = true;
                }
            } else {
                $mensaje_error = true;
            }
        } else {
            $mensaje_error = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Material — C&P SOFT</title>
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
            <a href="subir-material.php" class="sidebar-link activo">📁 Subir Material</a>
            <a href="./alumnos.php" class="sidebar-link">👥 Alumnos</a>
        </nav>
        <a href="./php/cerrar-sesion.php" class="sidebar-cerrar">Cerrar sesión</a>
    </div>

    <main class="dashboard-main">

        <div class="dashboard-bienvenida">
            <h1>📁 Subir Material</h1>
            <p>Subí un PDF o pegá un link para tus alumnos.</p>
        </div>

        <?php if ($mensaje_ok): ?>
        <div class="alerta-ok">
            ✅ Material subido correctamente.
            <a href="dashboard-profesor.php">Volver al inicio</a>
        </div>
        <?php endif; ?>

        <?php if ($mensaje_error): ?>
        <div class="alerta-error">
            ❌ Hubo un error. Revisá los campos e intentá de nuevo. Solo se aceptan archivos PDF.
        </div>
        <?php endif; ?>

        <div class="dashboard-seccion">
            <div class="form-dashboard">
                <form action="subir-material.php" method="POST" enctype="multipart/form-data">

                    <div class="mb-4">
                        <label class="form-dash-label">Materia</label>
                        <select name="id_materia" class="form-dash-input" required>
                            <option value="" disabled selected>— Seleccioná una materia —</option>
                            <?php foreach ($materias as $materia): ?>
                            <option value="<?php echo $materia['id']; ?>">
                                <?php echo htmlspecialchars($materia['nombre']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-dash-label">Título del material</label>
                        <input type="text" name="titulo" class="form-dash-input" placeholder="Ej: Guía de ejercicios unidad 3" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-dash-label">Tipo de material</label>
                        <div class="tipo-selector">
                            <label class="tipo-opcion">
                                <input type="radio" name="tipo" value="archivo" checked onchange="toggleTipo(this.value)">
                                📄 Subir PDF
                            </label>
                            <label class="tipo-opcion">
                                <input type="radio" name="tipo" value="link" onchange="toggleTipo(this.value)">
                                🔗 Pegar Link
                            </label>
                        </div>
                    </div>

                    <div class="mb-4" id="campo-archivo">
                        <label class="form-dash-label">Archivo PDF</label>
                        <input type="file" name="archivo" class="form-dash-input" accept=".pdf">
                    </div>

                    <div class="mb-4" id="campo-link" style="display:none;">
                        <label class="form-dash-label">URL del material</label>
                        <input type="url" name="url" class="form-dash-input" placeholder="https://drive.google.com/...">
                    </div>

                    <button type="submit" class="btn-dash-submit">Subir material</button>

                </form>
            </div>
        </div>

    </main>

    <script>
        function toggleTipo(valor) {
            document.getElementById('campo-archivo').style.display = valor === 'archivo' ? 'block' : 'none';
            document.getElementById('campo-link').style.display = valor === 'link' ? 'block' : 'none';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>