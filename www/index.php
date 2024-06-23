<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
 include("bd.php");
 require_once "conexion.php";
 
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  echo $twig->render('inicio.html',[]);

?>
