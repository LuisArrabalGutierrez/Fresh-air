<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  $identificado=false;
  $palabrasProhibidas = getPalabrasProhibidas();

  // Comprobación si el valor de 'ac' es numérico
  if (isset($_GET['ac']) && is_numeric($_GET['ac']) && $_GET['ac'] > 0) {
    $idAc = $_GET['ac'];

    session_start();

    $variables=array();

    if(isset($_SESSION['identificado'])){
      $variables=getUsuario($_SESSION['nombreUsuario']);
  
      $usuario=$variables['nombre'];
      $registrado=$variables['registrado'];
      $moderador=$variables['moderador'];
      $gestor=$variables['gestor'];
      $root=$variables['root'];
      $identificado=true;

     

    }

  } else {
    // En caso de que no sea numérico o no esté definido, asignar un valor por defecto
    $idAc = 1;
  } 

  $actividad = getActividad($idAc);
  $comentarios = getComentarios();
  $imagenes = getImagenes($idAc);

  if($identificado){
    echo $twig->render('actividad.html', ['actividad' => $actividad , 'comentarios' => $comentarios , 'imagenes' => $imagenes,
                       'usuario' => $usuario,'registrado' => $registrado, 'moderador' => $moderador, 'gestor' => $gestor, 'root' => $root ,
                       'palabrasProhibidas' => $palabrasProhibidas]);

  }else{
    $registrado=false;
    echo $twig->render('actividad.html', ['actividad' => $actividad , 'comentarios' => $comentarios , 'imagenes' => $imagenes,
                       'registrado' => $registrado]);
  }

  
?>
