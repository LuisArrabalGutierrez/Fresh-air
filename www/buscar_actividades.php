<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");
    require_once "conexion.php";

    $cadenaBusqueda = $_GET['q'];
    global $mysqli;


    $sql = "SELECT id, nombre FROM actividades WHERE nombre LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $param = "%" . $cadenaBusqueda . "%";// % es un comodín que significa "cualquier cosa" en la cadena

    $stmt->bind_param("s", $param);
    $stmt->execute();
    $result = $stmt->get_result();

    $actividades = [];
    while ($row = $result->fetch_assoc()) {
        $actividades[] = $row;
    }

    $stmt->close();
    $mysqli->close();

    header('Content-Type: application/json');
    echo json_encode($actividades);
?>
