<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $whatsapp = trim($_POST['whatsapp']);
    $carrera = trim($_POST['carrera']);
    $asunto = trim($_POST['asunto']);
    $mensaje = trim($_POST['mensaje']);

    if (!empty($nombre) && !empty($correo)) {
        $query = "INSERT INTO consultas (nombre, correo, whatsapp, carrera_interes, asunto, mensaje) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $correo, $whatsapp, $carrera, $asunto, $mensaje);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../../index.php");
        } else {
            header("Location: ../../index.php?error=1");
        }
        exit();
    } else {
        header("Location: ../index.html?error=1");
        exit();
    }
}
?>