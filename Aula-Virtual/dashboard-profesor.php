<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor') {
    header("Location: ./Login.php");
    exit();
}

$nombreCompleto = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Profesor - Aula Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background-color: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #0f172a;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 20px;
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: #e2e8f0;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #1e293b;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .welcome-box {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .card-dashboard {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            padding: 20px;
            height: 100%;
            background: white;
        }

        .card-dashboard h5 {
            font-size: 18px;
            margin-bottom: 12px;
            color: #0f172a;
        }

        .card-dashboard p {
            margin: 0;
            color: #475569;
            font-size: 15px;
        }

        .btn-logout {
            background-color: #dc2626;
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-logout:hover {
            background-color: #b91c1c;
            color: white;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Profesor</h2>

        <a href="#">Inicio</a>
        <a href="#">Mis materias</a>
        <a href="#">Tareas</a>
        <a href="#">Exámenes</a>
        <a href="#">Mensajes</a>
        <a href="#">Perfil</a>

        <a href="./logout.php" class="btn-logout">Cerrar sesión</a>
    </div>

    <div class="main-content">
        <div class="welcome-box">
            <h1 class="mb-2">Bienvenido, <?php echo htmlspecialchars($nombreCompleto); ?></h1>
            <p>Este es tu panel principal como profesor. Desde acá vas a poder administrar tus materias, actividades, exámenes y consultas de alumnos.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Mis materias</h5>
                    <p>Visualizá las materias que tenés asignadas y entrá a gestionar su contenido.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Tareas por corregir</h5>
                    <p>Acá se mostrarán los trabajos prácticos entregados por los alumnos.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Exámenes</h5>
                    <p>Organizá evaluaciones, fechas y futuras calificaciones de cada materia.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Mensajes</h5>
                    <p>Respondé consultas privadas de tus alumnos y enviá avisos importantes.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Alumnos</h5>
                    <p>Consultá los alumnos vinculados a cada una de tus materias.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Material de clase</h5>
                    <p>Subí apuntes, consignas, archivos y novedades de tus clases.</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>