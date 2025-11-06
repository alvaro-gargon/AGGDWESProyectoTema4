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
        <a href="ejercicio01.php"></a>
    </header>
        
    <?php
    //definimos y usamos las constantes dbname,username y password de la base de datos
    //dsn tiene el valor del host y del nombre de la base de datos. 
    //const DSN= 'mysql:host=192.168.1.134;dbname:DBAGGDWESProyectoTema4';
    const DSN= 'mysql:host=10.199.9.114;dbname:DBAGGDWESProyectoTema4';
    const USERNAME= 'userAGGDWESProyectoTema4';
    const password= 'paso';
    //$DSNN='mysql:host='.$_SERVER['SERVER_ADDR'].';dbname:DBAGGDWESProyectoTema4';
    //array con los nombres de los atributos de PDO
    
        echo ('<h2>Mostrar tabla departamento</h2>');
        try{
            $miDB = new PDO(DSN,USERNAME,password);
            $qConsulta=$miDB->query("select * from T02_Departamento");
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