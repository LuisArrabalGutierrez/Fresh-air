<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  session_start();
  $variables=array();

  if(isset($_SESSION['identificado'])){
    $variables=getUsuario($_SESSION['nombreUsuario']);
  
    $usuario=$variables['nombre'];
    $correo=$variables['correo'];
    $contraseña=$variables['contraseña'];
    $registrado=$variables['registrado'];
    $moderador=$variables['moderador'];
    $gestor=$variables['gestor'];
    $root=$variables['root'];
    $identificado=true;

    $users = getUsuarios();
    
  }

  
  if($identificado){
    echo $twig->render('perfil.html', ['users'=>$users,'usuario' => $usuario, 'correo' => $correo,'contraseña' => $contraseña,'registrado' => $registrado, 'moderador' => $moderador, 'gestor' => $gestor, 'root' => $root  ]);

  }
  else{
    $registrado=false;
    echo $twig->render('portada.html', [ 'registrado' => $registrado]);
  }

  
?>
