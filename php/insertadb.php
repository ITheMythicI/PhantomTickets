<?php
$dbhost="localhost"; //host donde esta la base de datos
$dbname="datos"; //nombre de BD
$dbuser="root"; // user name
$dbpass=""; // password de usuario

$nombre= $_POST["nombre"];
$correo= $_POST["correo"];
$tel= $_POST["tel"];

var_dump ($nombre);
var_dump ($correo);
var_dump ($tel);


/*
   echo $nombre;
   echo "<br>";
   echo $correo;
   echo "<br>";
   echo $tel;*/

   if (($nombre!="")&&($correo!=""))
   {	 
  
     $sql = "INSERT INTO `tabla` 
     ( `id` , `nombre` , `correo`, `tel`)
     VALUES('NULL', '$nombre', '$correo', '$tel');"; 
     $conexion=mysqli_connect
     ($dbhost,$dbuser,$dbpass,$dbname,"3306") or
      die("Problemas con la conexión");

     mysqli_query($conexion,"SELECT * FROM tabla");
     mysqli_query($conexion,$sql); 
      mysqli_close($conexion);
   }
?>