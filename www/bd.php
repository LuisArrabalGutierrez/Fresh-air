<?php
 
  require_once 'conexion.php';

  
/////////////////////////////////////////
// GETTERS GENERALES
  function getPortada(){
    
    global $mysqli; 
    $res = $mysqli->query("SELECT *  FROM imagenes");
    $imagenes=array();

    if($res->num_rows>0){
      while ($row = $res->fetch_assoc()) {
        $imagenes[] = array('id' => $row['id'], 'img1' => $row['img1'],
        'img2' => $row['img2']);
      }
    }


    return $imagenes;
  }

  function getActividad($idAc){

    global $mysqli; 


    $res = $mysqli->query("SELECT * FROM actividades WHERE id = $idAc ");

    $actividad=array();
    if($res->num_rows> 0){
      while ($row = $res->fetch_assoc()) {
        $actividad = array('id' => $row['id'], 'nombre' => $row['nombre'],
                               'primer_titulo' => $row['primer_titulo'], 'segundo_titulo' => $row['segundo_titulo'],
                               'primer_li' => $row['primer_li'],'segundo_li' => $row['segundo_li'],'tercer_li' => $row['tercer_li'],'cuarto_li' => $row['cuarto_li'], 
                               'enganchadilla' => $row['enganchadilla'], 'precio' => $row['precio'],
                               'fecha' => $row['fecha'],'material' => $row['material'], 'imprimir_actividad' => $row['imprimir_actividad']);
      }
    }

    return $actividad;
  }

  function getComentarios(){
    
    global $mysqli; 
    $res = $mysqli->query("SELECT * FROM comentarios");
    $comentarios=array();
    if($res->num_rows> 0){
      while ($row = $res->fetch_assoc()) {
        $comentarios[] = array('id'=>$row['id'],'autor' => $row['autor'], 'fecha' => $row['fecha'],
                               'comentario' => $row['comentario']);
      }
    }
    return $comentarios;
  }

  function getImagenes($idAc){
    
    global $mysqli; 
    $res = $mysqli->query("SELECT * FROM imagenes WHERE id = $idAc ");
    $imagenes=array();
    if($res->num_rows> 0){
      while ($row = $res->fetch_assoc()) {
        $imagenes = array('id' => $row['id'], 'img1' => $row['img1'],
                               'img2' => $row['img2']);
      }
    }

  
    return $imagenes;
  }

  function getPalabrasProhibidas() {
    global $mysqli;

    // Consulta SQL para obtener las palabras prohibidas
    $result = $mysqli->query("SELECT palabra FROM prohibidas");
    $palabrasProhibidas = array();

    // Verificar si la consulta fue exitosa
    if ($result) {
        // Iterar sobre los resultados y agregar las palabras prohibidas al array
        while ($row = $result->fetch_assoc()) {
            $palabrasProhibidas[] = $row['palabra'];
        }
    }

    // Devolver el array de palabras prohibidas como JSON
    return json_encode($palabrasProhibidas);
}


  function checkLogin($usuario, $contraseña){
    global $mysqli;

    $result = $mysqli->query("SELECT * FROM usuarios WHERE nombre = '$usuario' ");
   
    if ($result && $result->num_rows > 0) {
     
        $row = $result->fetch_assoc();
     
        // Verificar la contraseña utilizando password_verify
        if (password_verify($contraseña, $row["contraseña"])) { 
          
            return true;
        }

        
    }
    return false;
  }


  function getUsuario($usuario){
    global $mysqli;
    $result = $mysqli->query("SELECT * FROM usuarios where nombre = '$usuario'");
    if ($result && $result->num_rows > 0) {
        $row= $result->fetch_assoc();
        return $row;
    }
    return null;
}

  function getUsuarios(){
      global $mysqli;
      $result = $mysqli->query("SELECT * FROM usuarios");
      $usuarios=array();
      if($result->num_rows> 0){
        while ($row = $result->fetch_assoc()) {
          if($row['nombre'] != "root"){
            $usuarios[] = array('nombre' => $row['nombre'], 'correo' => $row['correo'],
                                'contraseña' => $row['contraseña'], 'registrado' => $row['registrado'],
                                'moderador' => $row['moderador'], 'gestor' => $row['gestor'], 'root' => $row['root']);
        
          }
          }
      }
      

      return $usuarios;
  }
  function getPermisos($usuario){
    global $mysqli;
    $permisos=array();

    $result = $mysqli->query("SELECT * FROM usuarios WHERE nombre = '" . $usuario . "'");
    if ($result && $result->num_rows > 0) {
        $row= $result->fetch_assoc();
        // Devolver los permisos como array asociativo
        $permisos = array('registrado' => $row['registrado'], 'moderador' => $row['moderador'],
                          'gestor' => $row['gestor'], 'root' => $row['root']);
        
        return $permisos;
    }
    return null;
}

//////////////////////////////////////////////////
//CONTROL DE CUENTA Y PERFIL USUARIO NORMAL
  function crearCuenta($nombre, $correo, $contraseña){
    global $mysqli;

    // Verificar que no este duplicado correo o nombre
    $res = $mysqli->query("SELECT * FROM usuarios WHERE nombre = '$nombre' OR correo = '$correo'");
    if($res->num_rows> 0){
        echo "El nombre de usuario o correo ya existe";
        exit();
    }

    // Encriptar la contraseña
    $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (nombre,  correo, contraseña, registrado,moderador,gestor,root) VALUES ('$nombre',  '$correo','$contraseña', 1,0,0,0)";

    if ($mysqli->query($sql) === TRUE) {
        echo "Usuario creado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
  }

  function cambiarContraseña($usuario,  $contraseña_nueva){
    global $mysqli;

    $contraseña_n = password_hash($contraseña_nueva, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET contraseña = '$contraseña_n' WHERE nombre = '$usuario'";

    if ($mysqli->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
  }

  function cambiarCorreo($correo_nuevo, $correo_usuario){
    global $mysqli;

    //comprobar si ya hay un correo igual y dar error
    $res = $mysqli->query("SELECT correo FROM usuarios WHERE correo = '$correo_nuevo'");
    if($res->num_rows> 0){
        echo "El correo ya existe";
        exit();
    }
    else{
      $sql = "UPDATE usuarios SET correo = '$correo_nuevo' WHERE correo = '$correo_usuario'";

      if ($mysqli->query($sql) === FALSE) {
          echo "Error: " . $sql . "<br>" . $mysqli->error;
      }
    }
    
  }

  function cambiarNombre($usuario_nuevo, $nombre){
    global $mysqli;

    
    //comprobar si ya hay un nombre igual y dar error
    $res = $mysqli->query("SELECT nombre FROM usuarios WHERE nombre = '$usuario_nuevo'");
    if($res->num_rows> 0){
        echo "El nombre de usuario ya existe";
        exit();
    }
    else{
      $sql = "UPDATE usuarios SET nombre = '$usuario_nuevo' WHERE nombre = '$nombre'";

      if ($mysqli->query($sql) === FALSE) {
          echo "Error: " . $sql . "<br>" . $mysqli->error;
      }
    }
    
  }

//////////////////////////////////////////////
//CONTROL DE COMENTARIOS
  function borrarComentario($id){
    
    global $mysqli; 
    $res = $mysqli->query("DELETE FROM comentarios WHERE id = $id ");
    return 0;
  }

  function modificarComentario($id_comentario, $comentario_modificado) {
    global $mysqli;

    // Concatenar la cadena "(modificado por el moderador)" al comentario original
    $comentarioModificado = $comentario_modificado . " (modificado por el moderador)";
    

    // Realizar la actualización en la base de datos con el comentario modificado
    $res = $mysqli->query("UPDATE comentarios SET comentario = '$comentarioModificado' WHERE id = '$id_comentario' ");

    
    return 0;
}


  function insertarComentario($comentario, $autor, $fecha){
    global $mysqli;

    // Insertar el comentario en la base de datos
    $res= $mysqli->query("INSERT INTO comentarios ( autor,fecha,comentario) VALUES ('$autor', '$fecha','$comentario' )");
    
    if(!$res){
      echo "Comentario insertado incorrectamente";
    }
    

  }

  
////////////////////////////////////////////////////////
// CONTROL DE USUARIOS

function eliminarUsuario($nombre_usuario, $correo_usuario){
  global $mysqli;
  
  //comprobar si existen
  $res = $mysqli->query("SELECT * FROM usuarios WHERE nombre = '$nombre_usuario' AND correo = '$correo_usuario'");
  
  if($res->num_rows == 0){
      echo "El usuario no existe";
      exit();
  } else {
      $sql = "DELETE FROM usuarios WHERE nombre = '$nombre_usuario' AND correo = '$correo_usuario'";
      if ($mysqli->query($sql)) {
          header("Location: ../perfil.php");
      } else {
          echo "Error al eliminar usuario: " . $mysqli->error;
      }
  }
}

function manejarModerador($nombre_usuario,$correo_usuario,$accion){
  global $mysqli;

  if($accion === 'dar-moderador'){
      $sql = "UPDATE usuarios SET moderador = 1 WHERE nombre = '$nombre_usuario' AND correo = '$correo_usuario'";
  } else {
      $sql = "UPDATE usuarios SET moderador = 0 WHERE nombre = '$nombre_usuario' AND correo = '$correo_usuario'";
  }

  if ($mysqli->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $mysqli->error;
  }
}

function manejarGestor($nombre_usuario,$correo_usuario,$accion){
  global $mysqli;

  if($accion === 'dar-gestor'){
      $sql = "UPDATE usuarios SET gestor = 1 WHERE nombre = '$nombre_usuario' AND correo = '$correo_usuario'";
  } else {
      $sql = "UPDATE usuarios SET gestor = 0 WHERE nombre = '$nombre_usuario' AND correo = '$correo_usuario'";
  }

  if ($mysqli->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $mysqli->error;
  }
}

function manejarRoot($nombre_usuario,$correo_usuario,$accion){
  global $mysqli;

  if($accion === 'dar-root'){
      $sql = "UPDATE usuarios SET root = 1 WHERE nombre = '$nombre_usuario' AND correo = '$correo_usuario'";
  } else {
      $sql = "UPDATE usuarios SET root = 0 WHERE nombre = '$nombre_usuario' AND correo = '$correo_usuario'";
  }

  if ($mysqli->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $mysqli->error;
  }
}
/////////////////////////////////////////////////////////////
//CONTROL ACTIVIDADES


function añadirActividad($nombre, $primer_titulo, $segundo_titulo, $primer_li, $segundo_li, $tercer_li, $cuarto_li, $enganchadilla, $precio, $fecha, $material, $img1, $img2) {
  global $mysqli;

  $sql1 = "INSERT INTO actividades (nombre, primer_titulo, segundo_titulo, primer_li, segundo_li, tercer_li, cuarto_li, enganchadilla, precio, fecha, material) VALUES ('$nombre', '$primer_titulo', '$segundo_titulo', '$primer_li', '$segundo_li', '$tercer_li', '$cuarto_li', '$enganchadilla', '$precio', '$fecha', '$material')";

  if ($mysqli->query($sql1) === TRUE) {
      $id = $mysqli->insert_id;
      $img1 = "../../Imgs/" . $nombre . "/" . $img1;
      $img2 = "../../Imgs/" . $nombre . "/" . $img2;
      $sql2 = "INSERT INTO imagenes (id, img1, img2) VALUES ('$id', '$img1', '$img2')";
      if ($mysqli->query($sql2) === TRUE) {
          header ("Location: portada.php");
      
      } else {
          echo "Error: " . $sql2 . "<br>" . $mysqli->error;
      }
  } else {
      echo "Error: " . $sql1 . "<br>" . $mysqli->error;
  }
}

function quitarActividad($id){
  global $mysqli;

  $sql = "DELETE  FROM actividades WHERE id = '$id' ";
  if ($mysqli->query($sql) === TRUE) {
      
      $sql = "DELETE  FROM imagenes WHERE id = '$id' ";
      if ($mysqli->query($sql) === TRUE) {
          header("Location: portada.php");
      } else {
          echo "Error: " . $sql . "<br>" . $mysqli->error;
      }
  
  } else {
      echo "Error: " . $sql . "<br>" . $mysqli->error;
  }
}




?>
