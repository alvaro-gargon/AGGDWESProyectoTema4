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
     * Fecha: 06/11/2025
     * Uso: Conexión base de datos */ ?>
    <header>
        <h1>Ejercico 2 Tema 4</h1>
        <a href="../indexProyectoTema4.php"><button name="Volver">Volver</button></a>
    </header>
        
    <?php
    //definimos y usamos las constantes dbname,username y password de la base de datos
    //dsn tiene el valor del host y del nombre de la base de datos. 
    //const DSN= 'mysql:host=192.168.1.134;dbname:DBAGGDWESProyectoTema4';
    const DSN= 'mysql:host=10.199.9.114;dbname:DBAGGDWESProyectoTema4';
    const USERNAME= 'userAGGDWESProyectoTema4';
    const PASSWORD= 'paso';
    //$DSNN='mysql:host='.$_SERVER['SERVER_ADDR'].';dbname:DBAGGDWESProyectoTema4';
    
        echo ('<h2>Mostrar tabla departamento</h2>');
        try{
            //establezco conexion
            $miDB = new PDO(DSN,USERNAME,PASSWORD);
            //uso el comando use porque sino, no detecta que estoy usando la base de datos
            $miDB->exec("use DBAGGDWESProyectoTema4;");
            $qConsulta = $miDB->query("select * from T02_Departamento"); //consulta para seleccionar todos los datos de la tabla
            echo '<table class="departamento">';
            echo '<tr>';
            echo '<th>T02_CodDepartamento</th>';
            echo '<th>T02_DescDepartamento</th>';
            echo '<th>T02_FechaCreacionDepartamento</th>';
            echo '<th>T02_VolumenDeNegocio</th>';
            echo '<th>T02_FechaBajaDepartamento</th>';
            echo '</tr>';
            //el bucle while se ejecuta hasta que se acaban las filas, ya que cuando eso ocurre fetch() devuelve false
            //declaramos la variable $registro  para poder trabajar con los valores
            while ($registro = $qConsulta->fetch()) {
                echo '<tr>';
                echo '<td>'.$registro['T02_CodDepartamento'].'</td>';
                $sDescripcion= strtoupper($registro["T02_DescDepartamento"]); //strtoupper convierte el texto en mayusculas
                echo '<td>'.$sDescripcion.'</td>';
                echo '<td>'.$registro["T02_FechaCreacionDepartamento"].'</td>';
                // formateamos el float para que se vea en €
                echo '<td>'.number_format($registro["T02_VolumenDeNegocio"],2,',','.').' €</td>';
                echo '<td>'.$registro["T02_FechaBajaDepartamento"].'</td>';
                echo '</tr>';
            }
            echo '</table>';
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
        <p>Última actualización <time datetime="2025-11-06">06/11/2025</time></p>
    </footer>
</body>
</html>