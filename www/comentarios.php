<?php
    include 'bd.php';

    if( (isset($_POST['id']) && isset($_POST['accion']) && isset($_POST['id_actividad']))){

        

        $accion = $_POST['accion'];
        $id = $_POST['id'];
        $id_actividad = $_POST['id_actividad'];

        if($accion === 'borrar'){
            borrarComentario($id);
            header("Location: ../actividad.php?ac=$id_actividad");

        } elseif($accion === 'modificar'){

            $comentario_modificado = $_POST['comentario'];

            modificarComentario($id, $comentario_modificado);

            header("Location: ../actividad.php?ac=$id_actividad");
            
        }else{
            header("Location: ../actividad.php?ac=$id_actividad");
        }
    }
    elseif( isset($_POST['id_actividad']) && isset($_POST['autor']) && isset($_POST['comentario']) && isset($_POST['accion']) && isset($_POST['correo']) && isset($_POST['accion'])){
        $accion = $_POST['accion'];
        $fecha = date('Y-m-d H:i:s');
        $autor = $_POST['autor'];
        $comentario = $_POST['comentario']; // Obtener el comentario del formulario
        $id_actividad = $_POST['id_actividad'];

        if($accion ==='insertar'){
            
            insertarComentario($comentario, $autor, $fecha);
            header("Location: ../actividad.php?ac=$id_actividad");
        }
        else{
            header("Location: ../actividad.php?ac=$id_actividad");
        }
    }
?>
