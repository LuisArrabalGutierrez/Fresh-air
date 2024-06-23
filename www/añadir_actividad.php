<?php
include("bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST['nombre']) && isset($_POST['primer_titulo']) &&
    isset($_POST['segundo_titulo']) && isset($_POST['primer_li']) && 
    isset($_POST['segundo_li']) && isset($_POST['tercer_li']) && 
    isset($_POST['cuarto_li']) && isset($_POST['enganchadilla']) && 
    isset($_POST['precio']) && isset($_POST['fecha']) && isset($_POST['material']) && 
    isset($_POST['accion']) && isset($_FILES['img1']) && isset($_FILES['img2'])) {

    $accion = $_POST['accion'];

    if ($accion === 'añadir_actividad') {
        $nombre = $_POST['nombre'];
        $primer_titulo = $_POST['primer_titulo'];
        $segundo_titulo = $_POST['segundo_titulo'];
        $primer_li = $_POST['primer_li'];
        $segundo_li = $_POST['segundo_li'];
        $tercer_li = $_POST['tercer_li'];
        $cuarto_li = $_POST['cuarto_li'];
        $enganchadilla = $_POST['enganchadilla'];
        $precio = $_POST['precio'];
        $fecha = $_POST['fecha'];
        $material = $_POST['material'];

        $img1 = $_FILES['img1']['name'];
        $img2 = $_FILES['img2']['name'];

        $file_ext1 = strtolower(pathinfo($img1, PATHINFO_EXTENSION));
        $file_ext2 = strtolower(pathinfo($img2, PATHINFO_EXTENSION));

        $allowed_extensions = array("jpeg", "jpg", "png");

        if (!in_array($file_ext1, $allowed_extensions) || !in_array($file_ext2, $allowed_extensions)) {
            echo "extension not allowed, please choose a JPEG or PNG file.";
            exit();
        } else {
            $img1_target = "./Imgs/" . basename($img1);
            $img2_target = "./Imgs/" . basename($img2);

            if (!is_dir('./Imgs')) {
                mkdir('./Imgs', 0777, true);
            }

            if (move_uploaded_file($_FILES['img1']['tmp_name'], $img1_target) && move_uploaded_file($_FILES['img2']['tmp_name'], $img2_target)) {
                añadirActividad($nombre, $primer_titulo, $segundo_titulo, $primer_li, $segundo_li, $tercer_li, $cuarto_li, $enganchadilla, $precio, $fecha, $material, $img1, $img2);
            } else {
                echo "Failed to upload images.";
            }
        }
    }
} else {
    echo "Error en la petición";
}

?>
