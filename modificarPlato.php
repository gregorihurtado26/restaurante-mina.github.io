<?php
session_start();
?>
<html>
<head>
<link href="css/estilos.css" rel="stylesheet" type="text/css"> 
<link rel="shortcut icon" href="imagenes/icono.ico">  
    <title>Modificar Plato - Puzzle</title>
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
            <SCRIPT language="JavaScript" type="text/javascript"> 
            function validacion(campo) {
                       var valor = campo.value;
                       if( valor == null || valor.length==0 ){
                           alert("El campo no puede estar vac�o");
                           campo.focus();
                           return false;
                       }
                       return true;
                   }
            function validacionLista(campo) {
                        var valor = campo.value;
                        if( valor == null || valor == 0 || valor == "0"){
                            alert("El campo tiene que tener una opci�n seleccionada");
                            campo.focus();
                            return false;
                        }
                        return true;
                    }
            function validarTodo(){ 
                var bien=true;
                var frm = document.getElementById("form1");
                for (var i=0;i<frm.elements.length;i++)
                { 
                    if(frm.elements[i].value=="" || frm.elements[i].value==0 || frm.elements[i].value==99){
                        bien=false;
                        alert("Tienes que rellenar todos los campos.");
                        frm.elements[i].focus();
                        return false;
                    }  
                }
                if(bien==true){
                    form1.submit();
                    return true;
            }
            
}
            </script>
            <body>
            <h1>Actualizar un plato</h1>

            <form method="POST" action="modificarPlato2.php" name="form1" id="form1">
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
                                print "Tenemos ".mysqli_affected_rows($conectar)." plato/s. Elige cual actualizar:<br><br>";
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
                <button onclick="return validarTodo();" value="submit">Seleccionar plato</button>
</form>
            </body>
