<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
 include("bd.php");
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
 

  session_start();

  $imagenes = getPortada();
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

  //$actividades= getActividades();
  if($identificado){
    echo $twig->render('portada.html', ['imagenes' => $imagenes, 'usuario' => $usuario,'registrado' => $registrado, 'moderador' => $moderador, 'gestor' => $gestor, 'root' => $root]);

  }
  else{
    $registrado=false;
    echo $twig->render('portada.html', ['imagenes' => $imagenes, 'registrado' => $registrado]);
  }

?>

