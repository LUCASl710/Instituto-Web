<?php
session_start();

require_once './conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = trim($_POST['dni']);
    $contrasena = md5(trim($_POST['contrasena']));

    $consulta = "SELECT * FROM usuarios WHERE dni = ? AND contrasena = ? AND activo = 1";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "ss", $dni, $contrasena);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['apellido'] = $usuario['apellido'];
        $_SESSION['rol'] = $usuario['rol'];

        if ($usuario['rol'] == 'profesor') {
            header("Location: /Instituto-Web/Aula-Virtual/dashboard-profesor.php");
        } else {
            header("Location: /Instituto-Web/Aula-Virtual/dashboard-alumno.php");
        }
        exit();
    } else {
        header("Location: /Instituto-Web/Aula-Virtual/Login.php?error=1");
    }
}
?>