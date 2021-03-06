<html>
<head>
<link href="css/estilos.css" rel="stylesheet" type="text/css"> 
<link rel="shortcut icon" href="imagenes/icono.ico"> 
<script type="text/javascript" src="js//validarDesplegable.js"></script> 
    <title>Borrar Plato - Puzzle</title>
</head>
<style>
    h1#resultado{
	margin:5%;
        text-decoration: none;
        text-transform: uppercase;
    }  
    input#atras{
        margin:0 5% 5%;        
    }
</style>
 <?php
    if(!(isset($_REQUEST['enviar'])))
    {//no se ha enviado el formulario
    ?>
<h1>Borrar un plato</h1>

<form method="POST" action="borrarPlato.php" name="form1" id="form1">
                <?php
                //LISTAR LOS PLATOS EXISTENTES.
                        #incluimos unas variables con el nombre de la tabla
                        $tabla="plato";

                        include "conectar.php";

                        #conexion, seleccion de tabla y verificacion de errores
                        $conectar =mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password,$nombre_bd);

                        if(!$conectar){
                            echo "<br>No ha podido realizarse la conexion <br>";
                            print "<i>Error numero</i>".mysqli_connect_errno()."<i>equivalente a:</i>".mysqli_connect_error();
                            exit();
                        }

                        #escribimos la sentencia MYSQL
                        $sentenciaMYSQL="SELECT `nombre-plato` FROM $tabla";

                        #tenemos completa la sentencia MYSQL solo falta ejecutarla crear la conexion y ejecutarla
                        $sentencia=  mysqli_query($conectar,$sentenciaMYSQL);
                        if($sentencia){
                            if(mysqli_affected_rows($conectar)>0){
                                print "Tenemos ".mysqli_affected_rows($conectar)." plato/s. Elige cual eliminar:<br><br>";
                                echo "Nombre:<span>*</span>";
                                echo "<select name='nombre' onchange='validacionLista(this);'>";
                                echo "<option value='0'>Seleccione el plato</option>";  
                                while($registro=mysqli_fetch_row($sentencia)){
                                    foreach ($registro as $clave){
                                        echo "<option value='".$clave."'>".$clave."</option>";
                                    }
                                }
                                echo "</select>";
                               }     
                               
                            
                        }
                        else{
                            print"<br>No ha podido mostrar ningun plato de la tabla $tabla.<br>"; 
                            print"<i>Error: </i>".mysqli_error($conectar);
                            exit();
                        }

                        #cerramos la conexion con la base de datos y comprobamos si da errores.
                        if(!mysqli_close($conectar)){
                            print"<br>No ha podido cerrarse la conexion, mediante procesos, con el servidor de bases de datos. <br>."; 
                        }
                ?>
         <button name="enviar" onclick="return validarTodo();" value="submit">Borrar Plato</button>
</form>
<body>
<?php
}
else{//si se ha enviado
        #incluimos unas variables con el nombre de la tabla
        $nombrePlato=$_REQUEST['nombre'];
        $tabla="plato";

        include "conectar.php";

        #conexion, seleccion de tabla y verificacion de errores
        $conectar =mysqli_connect($cfg_servidor, $cfg_usuario, $cfg_password,$nombre_bd);

        if(!$conectar){
            echo "<br>No ha podido realizarse la conexion <br>";
            print "<i>Error numero</i>".mysqli_connect_errno()."<i>equivalente a:</i>".mysqli_connect_error();
            exit();
        }

        #escribimos la sentencia MYSQL
        $sentenciaMYSQL="DELETE FROM $tabla WHERE `nombre-plato` = '$nombrePlato'";

        #tenemos completa la sentencia MYSQL solo falta ejecutarla crear la conexion y ejecutarla
        $sentencia=  mysqli_query($conectar,$sentenciaMYSQL);
        if($sentencia){
             print "<div id='contenedor'>";
            print"<h1 id='resultado'>Se ha eliminado el plato \"$nombrePlato\".</h1>";
            print"<input id='atras' type=\"button\" value=\"Volver al Men&uacute;\" onclick=\"history.back(-1)\" />";
            print "</div>";
        }
        else{
            print "<div id='contenedor'>";
            print"<h1 id='resultado'>No ha podido eliminar el plato \"$nombrePlato\".</h1>";
            print"<input id='atras' type=\"button\" value=\"Volver al Men&uacute;\" onclick=\"history.back(-1)\" />";
            print "</div>";           
            exit();
        }

        #cerramos la conexion con la base de datos y comprobamos si da errores.
        if(!mysqli_close($conectar)){
            print "<div id='contenedor'>";
            print"<h1 id='resultado'>No ha podido cerrarse la conexion, mediante procesos, con el servidor de bases de datos.</h1>";
            print"<input id='atras' type=\"button\" value=\"Volver al Men�\" onclick=\"history.back(-1)\" />";
            print "</div>";
        }
}
?>
</body>
<script>