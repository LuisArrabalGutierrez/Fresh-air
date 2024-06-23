<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    // Verificar si se ha enviado un formulario POST para cambiar la contraseña
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        $usuario = $_SESSION['nombreUsuario'];
        $contraseña = $_POST['password'];

        // Cambiar la contraseña
        cambiarContraseña($usuario, $contraseña);
        // Redirigir a la página de perfil
       
    }
    header("Location: perfil.php");
    exit();
?>
