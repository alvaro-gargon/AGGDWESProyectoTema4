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
     * Fecha: 21/11/2025
     * Uso: Conexión base de datos */ ?>
    <header>
        <h1>Ejercico 6 Tema 4</h1>
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
    
        echo ('<h2>Inserts con  transcciones a la tabla departamento</h2>');
        
            //establezco conexion
            $miDB = new PDO(DSN,USERNAME,PASSWORD);
            //uso el comando use porque sino, no detecta que estoy usando la base de datos
            $miDB->exec("use DBAGGDWESProyectoTema4;");
            $aInsert = 
                    [
                        [
                        'codigoDepartamento' =>'PRU',
                        'descripcionDepartamento' =>'Insert de descripcion',
                        'volumenDepartamento' =>'100'  ],
                        [
                        'codigoDepartamento' =>'ARP',
                        'descripcionDepartamento' =>'cosa2 de descripcion',
                        'volumenDepartamento' =>'200'  ],
                        [
                        'codigoDepartamento' =>'NIN',
                        'descripcionDepartamento' =>'Nin de descripcion',
                        'volumenDepartamento' =>'300'  ]
                    ];
           
        try{
            $miDB->beginTransaction();
            foreach ($aInsert as $registro){
                $insertql='insert into T02_Departamento values (:codigoDepartamento,:descripcionDepartamento,:volumenDepartamento,now(),null)';
                $consulta = $miDB->prepare($insertql);
                $consulta->bindParam(":codigoDepartamento", $registro['codigoDepartamento']);
                $consulta->bindParam(":descripcionDepartamento", $registro['descripcionDepartamento']);
                $consulta->bindParam(":volumenDepartamento", $registro['volumenDepartamento']);
                $consulta->execute();
            }
            $miDB->commit();
            echo 'HA FUNCIONADO';
        } catch (PDOException $miExceptionPDO){
            $miDB->rollBack();
            echo'Error: '.$miExceptionPDO->getMessage();
            echo '<br>';
            echo'Código de error: '.$miExceptionPDO->getCode();
        } finally {
            unset($miDB);
        }


        ?>
    <footer>
        <p><a href="../../index.html">Álvaro García González</a></p>
        <p>Última actualización <time datetime="2025-11-21">21/11/2025</time></p>
    </footer>
</body>
</html>


