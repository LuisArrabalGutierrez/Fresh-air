<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    // Verificar si se ha enviado un formulario POST para iniciar sesión
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $usuario = $_POST['name'];

        $contraseña = $_POST['password'];


        // Verificar las credenciales del usuario
        if (checkLogin($usuario, $contraseña)) {
            session_start();
            $_SESSION['nombreUsuario'] = $usuario;  // Guardar en la sesión el nombre del usuario
            $_SESSION['identificado']=true; 
            header('Location: portada.php');
            exit();
        }

        
    }

    // Renderizar el formulario de inicio de sesión
    echo $twig->render('iniciar_sesion.html', []);
?>