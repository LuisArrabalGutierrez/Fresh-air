<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  // Comprobación si el valor de 'ac' es numérico
  if (isset($_GET['ac']) && is_numeric($_GET['ac'])) {
    $idAc = $_GET['ac'];
  } else {
    // En caso de que no sea numérico o no esté definido, asignar un valor por defecto
    $idAc = 1;
  }

   
  $actividad = getActividad($idAc);
  

  echo $twig->render('imprimir_actividad.html', ['actividad' => $actividad ]);
?>
