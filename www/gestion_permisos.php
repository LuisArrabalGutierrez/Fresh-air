<?php
    include 'bd.php';
    if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['accion']))
        && (isset($_POST['nombre-usuario'])) && (isset($_POST['correo-usuario']))) {

        $accion = $_POST['accion'];

       

        $nombre_usuario = $_POST['nombre-usuario']; 
        $correo_usuario = $_POST['correo-usuario'];

        if($accion === 'eliminar-usuario'){
            eliminarUsuario($nombre_usuario, $correo_usuario);
            header("Location: ../perfil.php");
        }
        elseif($accion === 'dar-moderador' || $accion === 'quitar-moderador' ){
            manejarModerador($nombre_usuario, $correo_usuario, $accion);
            header("Location: ../perfil.php");

        }
        elseif($accion === 'dar-gestor' || $accion === 'quitar-gestor' ){
            manejarGestor($nombre_usuario, $correo_usuario, $accion);
            header("Location: ../perfil.php");

        }
        elseif($accion === 'dar-root' || $accion === 'quitar-root' ){
            manejarRoot($nombre_usuario, $correo_usuario, $accion);
            header("Location: ../perfil.php");

        }
        else{
            echo "Acción no válida";
        }
    }
?>
