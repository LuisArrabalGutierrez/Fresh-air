<?php
    include 'bd.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if( (isset($_POST['nombre-nuevo']) && isset($_POST['accion']) && isset($_POST['nombre-usuario']))
            || (isset($_POST['correo-nuevo']) && isset($_POST['accion']) && isset($_POST['correo-usuario']))
            || (isset($_POST['contraseña-nueva']) && isset($_POST['accion']) && isset($_POST['nombre-usuario']))    
        ){

            $accion = $_POST['accion'];
            

            if($accion === 'cambiar-nombre'){
                
                $nombre_nuevo = $_POST['nombre-nuevo'];
                $nombre_usuario = $_POST['nombre-usuario'];
                cambiarNombre($nombre_nuevo, $nombre_usuario);
                header("Location: ../iniciar_sesion.php");

            } elseif($accion === 'cambiar-correo'){

                $correo_nuevo = $_POST['correo-nuevo'];
                $correo_usuario = $_POST['correo-usuario'];
                cambiarCorreo($correo_nuevo, $correo_usuario);
                header("Location: ../perfil.php");

            }elseif($accion === 'cambiar-contraseña'){
                $nombre_usuario = $_POST['nombre-usuario'];
                $contraseña_nueva = $_POST['contraseña-nueva'];
                cambiarContraseña($nombre_usuario, $contraseña_nueva);
                header("Location: ../iniciar_sesion.php");
            }
        }
    }
?>
