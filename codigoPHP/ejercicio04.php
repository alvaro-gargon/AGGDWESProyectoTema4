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
        <h1>Ejercico 4 Tema 4</h1>
        <a href="../indexProyectoTema4.php"><button name="Volver">Volver</button></a>
    </header>
        
    <?php
    require_once "../core/231018libreriaValidacion.php"; // importamos nuestra libreria
    //definimos y usamos las constantes dbname,username y password de la base de datos
    //dsn tiene el valor del host y del nombre de la base de datos. 
    //const DSN= 'mysql:host=192.168.1.134;dbname:DBAGGDWESProyectoTema4';
    const DSN= 'mysql:host=10.199.9.114;dbname:DBAGGDWESProyectoTema4';
    const USERNAME= 'userAGGDWESProyectoTema4';
    const PASSWORD= 'paso';
    //$DSNN='mysql:host='.$_SERVER['SERVER_ADDR'].';dbname:DBAGGDWESProyectoTema4';
    //array con los nombres de los atributos de PDO
    $miDB; // variable para realizar la conexión a la base de datos
        $sql; // variable para guardar consulta para la base de datos
        $terminoBusqueda = '%%'; // termino de busqueda explicado al usarlo
        $consulta; // variable para recoger el resultado de la consulta a la base de datos 
        $aDepartamentos; // devolvemos la consulta en un array y lo guardamos aqui
        $registro; // al recorrer la consulta vamos obteniendo registros y los recogemos aquí
        $miExceptionPDO; // para recoger los errores al manejar la clase PDO
       
        $entradaOK = true; //Variable que nos indica que todo va bien
        $aErrores = [  //Array donde recogemos los mensajes de error
            'T02_DescDepartamento' => ''
        ];
        $aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
            'T02_DescDepartamento' => ''
        ]; 
        
        //Para cada campo del formulario: Validar entrada y actuar en consecuencia
        if (isset($_REQUEST["enviar"])) {//Código que se ejecuta cuando se envía el formulario

            // Solo queremos validar se introduce algo, sino mostraremos despues todos los registros
            if (!empty($_REQUEST['T02_DescDepartamento'])) {
                // Validamos los datos del formulario
                $aErrores['T02_DescDepartamento']= validacionFormularios::comprobarAlfabetico($_REQUEST['T02_DescDepartamento'],255,0,1);
                
                foreach($aErrores as $campo => $valor){
                    if(!empty($valor)){ // Comprobar si el valor es válido
                        $entradaOK = false;
                    } 
                }
            }
            
        } else {//Código que se ejecuta antes de rellenar el formulario
            $entradaOK = false;
        }


        //Tratamiento del formulario
        if($entradaOK){ //Cargar la variable $aRespuestas y tratamiento de datos OK
            
            // Recuperar los valores del formulario
            $aRespuestas['T02_DescDepartamento'] = $_REQUEST['T02_DescDepartamento'] ?? ''; // Usamos el operador ?? para asegurar un valor si no existe
           
            // Preparamos el término de búsqueda con comodines y en minúsculas para la búsqueda LIKE. 
            // Los % indica que puede tener cualquier cosa antes y después.
            // Si la descripción está vacía, el término será '%%', devolviendo todos los resultados.
            $terminoBusqueda = '%'.strtolower($aRespuestas['T02_DescDepartamento']).'%';
            // Usamos LOWER() en el campo de la DB y en el término de búsqueda para garantizar que la búsqueda sea insensible a mayúsculas/minúsculas.
            
        }

       ?>
        <h2>Buscar departamento</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <label for="T02_DescDepartamento">Introduce Departamento a Buscar: </label>
            <br>
            <input type="text" name="T02_DescDepartamento" class="obligatorio" value="<?php echo $_REQUEST['T02_DescDepartamento']??'' ?>">
            <span class="error"><?php echo $aErrores['T02_DescDepartamento'] ?></span>
            <br>
            <input type="submit" value="Buscar" name="enviar">
            <a href="../indexProyectoTema4.php" class="cancelar">Cancelar</a>
        </form>
    </main>
    
    <?php 
        try {
            $miDB = new PDO(DSN,USERNAME,PASSWORD);
            $miDB->exec("use DBAGGDWESProyectoTema4;");
            $sql = <<<sql
                select * from T02_Departamento
                where lower(T02_DescDepartamento) like ?
            sql;
            
            $consulta = $miDB->prepare($sql);
            $consulta->bindParam(1, $terminoBusqueda);
            $consulta->execute();

            echo '<table>';
            echo '<tr>';
            echo '<th>Código</th>';
            echo '<th>Departamento</th>';
            echo '<th>Fecha de Creacion</th>';
            echo '<th>Volumen de Negocio</th>';
            echo '<th>Fecha de Baja</th>';
            echo '</tr>';

            while ($registro = $consulta->fetch()) {
                echo '<tr>';
                echo '<td>'.$registro['T02_CodDepartamento'].'</td>';
                echo '<td>'.$registro["T02_DescDepartamento"].'</td>';
                // construimos la fecha a partir de la que hay en la bbdd y luego mostramos sólo dia mes y año
                $oFecha = new DateTime($registro["T02_FechaCreacionDepartamento"]);
                echo '<td>'.$oFecha->format('d/m/Y').'</td>';
                // formateamos el float para que se vea en €
                echo '<td>'.number_format($registro["T02_VolumenDeNegocio"],2,',','.').' €</td>';
                if (is_null($registro["T02_FechaBajaDepartamento"])) {
                    echo '<td></td>';
                } else {
                    $oFecha = new DateTime($registro["T02_FechaBajaDepartamento"]);
                    echo '<td>'.$oFecha->format('d/m/Y').'</td>';
                }
                echo '</tr>';
            }
            echo '</table>';

        } catch (PDOException $miExceptionPDO) {
            echo 'Error: '.$miExceptionPDO->getMessage();
            echo '<br>';
            echo 'Código de error: '.$miExceptionPDO->getCode();
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


