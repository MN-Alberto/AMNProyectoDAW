<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CFGS - Desarrollo de Aplicaciones Web</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        header {
            background: #F59C27;
            color: white;
            padding: 15px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        main {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        ul {
            list-style: none;
            padding: 0;
        }
        footer{
            margin: auto;
            background-color: #F59C27;
            text-align: center;
            height: 150px;
	    color: white;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }
        a{
            text-decoration: none;
            color:purple;
        }
        
        table{
            border-collapse: collapse;
            width: 100%;
            border-width: 4px;
        }
        
        td{
            padding: 10px;
            border-width: 4px;
        }
        
        #encabezado{
            background-color: lightsteelblue;
            font-weight: bold;
        }
        
        .codigos{
            background-color: lightblue;
        }
        
        .mostrar{
            background-color: lightsalmon;
        }
        
        tr{
            height: 80px;
        }

    </style>
</head>
<body>
    <header>
        <h1><b>UT4: TÉCNICAS DE ACCESO A DATOS EN PHP</b></h1>
        <h4><a href="../../AMNDWESProyectoDWES/indexProyectoDWES.php">Alberto Méndez Núñez | 03/10/2025</a></h4>
        <p>Curso 2025/2026 - Grupo DAW2</p>
    </header>
    <main>
        <h2><b>Ejercicio 1</b></h2>
        
        <?php
        
                /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 30/10/2025
         * (ProyectoTema4) Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
            Utilizar excepciones automáticas siempre que sea posible en todos los ejercicios.
         */
        
        // Incluye el archivo de configuración donde se definen la ruta, usuario y contraseña de la base de datos.
        require_once '../config/confDBPDO.php';

        // Array con los nombres de los atributos de la conexión PDO que queremos mostrar.
        $aAtributos = array(
            'ATTR_AUTOCOMMIT',
            'ATTR_CASE',
            'ATTR_CLIENT_VERSION',
            'ATTR_CONNECTION_STATUS',
            'ATTR_DRIVER_NAME',
            'ATTR_ERRMODE',
            'ATTR_ORACLE_NULLS',
            'ATTR_PERSISTENT',
            'ATTR_SERVER_INFO',
            'ATTR_SERVER_VERSION',
            'ATTR_DEFAULT_FETCH_MODE'
        );

        /* ==================== Conexión correcta ==================== */
        try {
            // Crea una nueva conexión PDO usando los parámetros definidos en confDBPDO.php
            $miDB = new PDO(RUTA, USUARIO, PASS);

            echo "<h2>Conexión completada correctamente</h2>";
            echo "<h4>Atributos de la conexión:</h4>";

            // Recorre el array de atributos y los imprime usando getAttribute()
            foreach ($aAtributos as $atributo) {
                // constant("PDO::$atributo") convierte el nombre del atributo en constante PDO válida
                print "<b>Atributo '$atributo': </b>" . $miDB->getAttribute(constant("PDO::$atributo")) . "<br>";
            }

        } catch (PDOException $ex) {
            // Captura cualquier excepción relacionada con PDO y muestra el mensaje de error y código.
            echo "Error de conexión a la base de datos: " . $ex->getMessage();
            echo "Codigo de error: " . $ex->getCode();
        }

        /* ==================== Conexión con error de driver ==================== */
        echo "<h2>Conexión erronea por error al encontrar el driver</h2>";

        // Constantes con parámetros erróneos (driver incorrecto)
        const ruta2 = 'error:host=localhost;dbname=DBAMNDWESProyectoTema4';
        const usuario2 = 'userAMNDWESProyectoTema4';
        const pass2 = 'CD97ertvct$E';

        try {
            $miDB = new PDO(ruta2, usuario2, pass2);

            echo "<h2>Conexión completada correctamente</h2>";
            echo "<h4>Atributos de la conexión:</h4>";

            foreach ($aAtributos as $atributo) {
                print "<b>Atributo '$atributo': </b>" . $miDB->getAttribute(constant("PDO::$atributo")) . "<br>";
            }

        } catch (Exception $ex) {
            // Captura cualquier excepción (en este caso, error de driver)
            echo "Error " . $ex->getMessage() . "<br><br>";
            echo "Codigo de error: " . $ex->getCode();
        }

        /* ==================== Conexión con contraseña incorrecta ==================== */
        echo "<h2>Conexión erronea por contraseña incorrecta</h2>";

        // Constantes con contraseña incorrecta
        const ruta3 = 'mysql:host=localhost;dbname=DBAMNDWESProyectoTema4';
        const usuario3 = 'userAMNDWESProyectoTema4';
        const pass3 = 'gdfsghsdfg';

        try {
            $miDB = new PDO(ruta3, usuario3, pass3);

            echo "<h2>Conexión completada correctamente</h2>";
            echo "<h4>Atributos de la conexión:</h4>";

            foreach ($aAtributos as $atributo) {
                print "<b>Atributo '$atributo': </b>" . $miDB->getAttribute(constant("PDO::$atributo")) . "<br>";
            }

        } catch (PDOException $ex) {
            // Captura error de contraseña incorrecta
            echo "Password incorrecto: " . $ex->getMessage();
            echo "Codigo de error: " . $ex->getCode();
        }

        // Se destruye la conexión para liberar recursos
        unset($miDB);
        ?>        
    </main>
</body>
</html>