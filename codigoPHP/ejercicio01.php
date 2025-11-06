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
        <h1>Ejercico 1 Tema 4</h1>
        <a href="../indexProyectoTema4.php"><button name="Volver">Volver</button></a>
        <a href="ejercicio01.php"></a>
    </header>
        
    <?php
    //definimos y usamos las constantes dbname,username y password de la base de datos
    //dsn tiene el valor del host y del nombre de la base de datos. 
    const DSN= 'mysql:host=192.168.1.134;dbname:DBAGGDWESProyectoTema4';
    //const DSN= 'mysql:host=10.199.9.114;dbname:DBAGGDWESProyectoTema4';
    const USERNAME= 'userAGGDWESProyectoTema4';
    const PASSWORD= 'paso';
    //$DSNN='mysql:host='.$_SERVER['SERVER_ADDR'].';dbname:DBAGGDWESProyectoTema4';
    //array con los nombres de los atributos de PDO
    $aattributes = array(
        "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
        "ORACLE_NULLS", "PERSISTENT", "PREFETCH", "SERVER_INFO", "SERVER_VERSION",
        "TIMEOUT"
    );
    
        echo ('<h2>Conexion correcta</h2>');
        try{
            $miDB = new PDO(DSN,USERNAME,PASSWORD);
            //$miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<p class="centrar">';            
            foreach ($aattributes as $valor) {
                try{
                
                echo "PDO::ATTR_$valor: ";
                echo '<br>';
                } catch (PDOException $miExceptionPDO){
                    echo'Error: '.$miExceptionPDO->getMessage();
                    echo '<br>';
                    echo'Código de error: '.$miExceptionPDO->getCode();
                }
            }
            echo '</p>';
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
        <p>Última actualización <time datetime="2025-11-03">03/11/2025</time></p>
    </footer>
</body>
</html>


