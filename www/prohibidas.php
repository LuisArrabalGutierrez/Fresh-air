<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  require_once "conexion.php";
  
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
    global $mysqli;

    $result = $mysqli->query("SELECT palabra FROM prohibidas");
    $prohibidas=[];

    while($row = $result->fetch_assoc()){
      $prohibidas[] = $row['palabra'];
    }

    echo json_encode($prohibidas);

  

?>