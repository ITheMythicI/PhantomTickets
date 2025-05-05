<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form name="form1" action="insertadb.php" method=post>
     Nombre: <input type="text" name="nombre"><br>
     Correo: <input type="mail" name="correo"><br>
     Tel: <input type="text" name="tel"><br>
     <input type="submit" value="enviar">
    </form>
    <form name="form2" action="borrardb.php" method=post>
     id: <input type="text" name="ide"><br>
          <input type="submit" value="enviar">
    </form>
</body>
</html>