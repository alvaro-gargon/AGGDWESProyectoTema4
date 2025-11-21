<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Álvaro García González</title>
    <link rel="stylesheet" href="../webroot/css/estilos.css"/>
</head>
<body>
    <?php /*
     * Nombre: Alvaro Garcia Gonzalez
     * Fecha: 07/11/2025
     * Uso: Conexión base de datos */ ?>
    <header>
        <h1>Ejercico 3 Tema 4</h1>
        <a href="../indexProyectoTema4.php"><button name="Volver">Volver</button></a>
    </header>
        
    <?php
    
    /*
     * @author: Alvaro Garcia Gonzalez
     * @since: 07/11/2025
     * Uso:Construir un formulario para recoger un cuestionario realizado a una persona y mostrar en la misma página las preguntas 
     * y las respuestas recogidas; en el caso de que alguna respuesta esté vacía o errónea volverá a salir el formulario con el mensaje correspondiente, 
     * pero las respuestas que habíamos tecleado correctamente aparecerán en el formulario y no tendremos que volver a teclearlas.
     */
        
    //definimos y usamos las constantes dbname,username y password de la base de datos
    //dsn tiene el valor del host y del nombre de la base de datos. 
    //const DSN= 'mysql:host=192.168.1.134;dbname:DBAGGDWESProyectoTema4';
    const DSN= 'mysql:host=10.199.9.114;dbname:DBAGGDWESProyectoTema4';
    const USERNAME= 'userAGGDWESProyectoTema4';
    const PASSWORD= 'paso';
    //$DSNN='mysql:host='.$_SERVER['SERVER_ADDR'].';dbname:DBAGGDWESProyectoTema4';
    //array con los nombres de los atributos de PDO
    
    
        try{
            //conexion base de datos
            $miDB = new PDO(DSN,USERNAME,PASSWORD);
            $miDB->exec("use DBAGGDWESProyectoTema4;");
            //$miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $fecha= new DateTime("now",new DateTimeZone('Europe/Madrid'));
            $fecha_formateada=$fecha->format("N-m-Y");
            //llamamiento a la libreria
            require_once '../core/231018libreriaValidacion.php';
            //establecimiento de la zon horaria
            date_default_timezone_set("Europe/Madrid");
            //declaracion de las variables
            $aErrores=
            [
                'codigoDepartamento' =>null,
                'descripcionDepartamento' =>null,
                'volumenDepartamento' =>null,
                'codigoExiste' =>null
            ];
            $aRespuestas=
            [
                'codigoDepartamento' =>null,
                'descripcionDepartamento' =>null,
                'volumenDepartamento' =>null
            ];
            
            
            //insert del departamento correspondiente
            $qinssertSQL="insert into T02_Departamento values
            ('{$aRespuestas['codigoDepartamento']}','{$aRespuestas['descripcionDepartamento']}',{$aRespuestas['volumenDepartamento']},now(),null);";
            
     
            $fecha_actual = new DateTime("now",new DateTimeZone('Europe/Madrid'));
            $entradaOK=true; //variable boolean para enviar el formulario
            //consulta para buscar si el departamento ya existe con el codigo recibido
            
            
            
            $departamentoExiste=true;//variable boolean que controla si el departamento ya existe
            //array donde recojo los mensajes de error de cada campo
            
            
            
            if(isset($_REQUEST['enviar'])){
            $aErrores['codigoDepartamento']=validacionFormularios::comprobarAlfabetico($_REQUEST['codigoDepartamento'],3,3,1);
            $aErrores['descripcionDepartamento']=validacionFormularios::comprobarAlfabetico($_REQUEST['descripcionDepartamento'], obligatorio: 1);    
            $aErrores['volumenDepartamento']=validacionFormularios::comprobarFloat($_REQUEST['volumenDepartamento'], obligatorio: 1);
            foreach ($aErrores as $clave => $valor){
                if($valor!=null){
                    $entradaOK=false;
                }else{
                    if(empty($_REQUEST["$clave"])){
                        $aRespuestas[$clave]='No se ha rellenado';
                    }else{
                        $aRespuestas[$clave]=$_REQUEST["$clave"];
                    }
                }
            }
                                                                                            //el %...% es para que si esta vacio, muestre todos
            $consultasql=$miDB->query("SELECT * FROM T02_Departamento WHERE T02_CodDepartamento='%{$aRespuestas['codigoDepartamento']}%'");//->fetchAll(PDO::FETCH_OBJ);
            $resultado=$consultasql;
            if(($resultado->rowCount())>0){
                $departamentoExiste= true;
                $aErrores['codigoExiste']='Este codigo ya existe';
            }else{
                $departamentoExiste=false;
            }
        }
        
        
        if(isset($_REQUEST['enviar']) && $entradaOK==true && $departamentoExiste==false){
            //codigo que se ejecuta cuando envias el formulario
            $miDB->query($qinssertSQL);
            $qConsulta = $miDB->query('select * from T02_Departamento');
            echo '<table class="departamento">';
            echo '<tr>';
            echo '<th>T02_CodDepartamento</th>';
            echo '<th>T02_DescDepartamento</th>';
            echo '<th>T02_VolumenDeNegocio</th>';
            echo '<th>T02_FechaCreacionDepartamento</th>';
            echo '<th>T02_FechaBajaDepartamento</th>';
            echo '</tr>';
            //el bucle while se ejecuta hasta que se acaban las filas, ya que cuando eso ocurre fetch() devuelve false
            //declaramos la variable $registro  para poder trabajar con los valores
            while ($registro = $qConsulta->fetchObject()) {
                echo '<tr>';
                echo '<td>'.$registro['T02_CodDepartamento'].'</td>';
                $sDescripcion= strtoupper($registro["T02_DescDepartamento"]); //strtoupper convierte el texto en mayusculas
                echo '<td>'.$sDescripcion.'</td>';
                // formateamos el float para que se vea en €
                echo '<td>'.number_format($registro["T02_VolumenDeNegocio"],2,',','.').' €</td>';
                echo '<td>'.$registro["T02_FechaCreacionDepartamento"].'</td>';
                echo '<td>'.$registro["T02_FechaBajaDepartamento"].'</td>';
                echo '</tr>';
            }
            echo '</table>';
            
            //forma incorrecta (con claves de array nombradas con comas)
            /*foreach ($aRespuestas as $clave =>$valor){
                $aPalabras= explode(',', $clave);
                echo ('<p class="saltar">');
                foreach ($aPalabras as $palabra) {
                    echo ($palabra.' ');
                }
                echo(': '.$valor);
                echo ('</p>');
            }*/
        }else{
            //codigo que se ejecuta antes de enviar el formulario
            ?>
            
    <div class="formulario">       
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="centrar">
            <p class="error"><?php echo($aErrores['codigoExiste'])?></p>
            <p>
              <label>1. Codigo del departamento (3 letras en mayuscula)</label><br>
              <input class="obligatorio" type="text" name="codigoDepartamento" 
                     value="<?php echo (isset($_REQUEST['codigoDepartamento'])?$_REQUEST['codigoDepartamento']:''); ?>" 
                     placeholder="ABC">
              <p class="error"><?php echo($aErrores['codigoDepartamento'])?></p>
            </p>

            <p>
              <label>2. Descripcion del departamento</label><br>
              <input class="obligatorio" type="text" name="descripcionDepartamento"
                     value="<?php echo (isset($_REQUEST['descripcionDepartamento'])?$_REQUEST['descripcionDepartamento']:''); ?>">
              <p class="error"><?php echo($aErrores['descripcionDepartamento'])?></p>
            </p>

            <p>
              <label>3. Volumen de negocio inicial (se permiten 2 decimales)</label><br>
              <input class="obligatorio" type="number" name="volumenDepartamento" min="0" step="0.01" value="<?php echo (isset($_REQUEST['volumenDepartamento'])?$_REQUEST['volumenDepartamento']:''); ?>">
              <p class="error"><?php echo($aErrores['volumenDepartamento'])?></p>
            </p>
            
            <p>
              <label>4. Fecha de creacion inical</label><br>
              <input type="date" name="fechaInicial" disabled placeholder="<?php echo($fecha_actual->format("N-m-Y")); ?>">
            </p>
            
            <div id="enviarCancelar">
                <p>
                  <input type="submit" name="enviar" value="enviar">
                  <p class="error"><?php echo($aErrores['codigoExiste'])?></p>
                </p>
                <a href="../indexProyectoTema4.php"><button name="Cancelar">Cancelar</button></a>
            </div>
        </div>
    </form>
    </div> 
        <?php
        }
        ?>
        <?php
        } catch (PDOException $miExceptionPDO){
            echo'Error: '.$miExceptionPDO->getMessage();
            echo '<br>';
            echo'Código de error: '.$miExceptionPDO->getCode();
        } finally {
            unset($miDB);
        }
        ?>
    <footer>
        <p><a href="../../index.html">Álvaro García González</a></p>
        <p>Última actualización <time datetime="2025-11-10">10/11/2025</time></p>
    </footer>
</body>
</html>