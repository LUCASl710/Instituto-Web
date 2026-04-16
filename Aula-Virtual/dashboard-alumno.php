<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'alumno') {
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
    <title>Dashboard Alumno - Aula Virtual</title>
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
            background-color: #1e293b;
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
            background-color: #334155;
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
        <h2>Alumno</h2>

        <a href="#">Inicio</a>
        <a href="#">Mis materias</a>
        <a href="#">Notas</a>
        <a href="#">Mensajes</a>
        <a href="#">Soporte</a>
        <a href="#">Perfil</a>

        <a href="./logout.php" class="btn-logout">Cerrar sesión</a>
    </div>

    <div class="main-content">
        <div class="welcome-box">
            <h1 class="mb-2">Bienvenido, <?php echo htmlspecialchars($nombreCompleto); ?></h1>
            <p>Este es tu panel principal del aula virtual. Acá vas a poder ver tus materias, tareas, notas y avisos importantes.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Mis materias</h5>
                    <p>Consultá las materias en las que estás inscrito y accedé a su contenido.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Próximas entregas</h5>
                    <p>Acá se mostrarán los próximos trabajos prácticos o actividades pendientes.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Notas</h5>
                    <p>Revisá tus calificaciones de cada materia de forma clara y ordenada.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Mensajes</h5>
                    <p>Recibí avisos y respuestas de tus profesores dentro del sistema.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Soporte</h5>
                    <p>Si tenés un problema técnico o administrativo, desde acá podrás pedir ayuda.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card-dashboard">
                    <h5>Contacto docente</h5>
                    <p>Accedé a la información de contacto de tus profesores cuando sea necesario.</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>