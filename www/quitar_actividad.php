<?php

    include("bd.php");
    //quitar la actividad 
    //<form action="../quitar_actividad.php" method="post">
    //  <input type="hidden" name="id" value="{{ imagen.id }}">
    //  <button type="submit" name="accion" value="borrar_actividad" class="eliminar-boton">
    //      <img src="../Imgs/eliminar.png" alt="Borrar actividad">
    //  </button>
    //</form>

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'borrar_actividad') {
            $id = $_POST['id'];
            quitarActividad($id);
        }
    } else {
        echo "Error en la petición";
    }

























?>