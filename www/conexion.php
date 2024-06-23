<?php
//En mis archivos he tenido que cambiar el puerto para trabajar al 3307, porque el 3306 ya estaba ocupado por mysql
$mysqli = new mysqli("database", "root", "tiger", "docker");

if ($mysqli->connect_errno) {
  echo ("Fallo al conectar: " . $mysqli->connect_error);
}
?>
