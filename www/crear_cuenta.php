<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    global $mysqli;

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $contraseña = $_POST['contraseña'];
        $correo = $_POST['correo'];

        crearCuenta($nombre, $correo, $contraseña);

    }

    // Renderizar el formulario de inicio de sesión
    echo $twig->render('crear_cuenta.html', []);
?>