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
            max-width: 1200px;
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
            border: 0;
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
        
        input{
            border-radius: 5px;
        }
        
        #boton{
            border-radius: 5px;
            width: 150px;
            background-color: lightgreen;
        }
        
        label{
            font-weight: bold;
        }
        
        h3{
            text-decoration: underline;
        }
        
        #formulario table{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
        <h2><b>Ejercicio 5</b></h2>
        
        <?php
        
                /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 13/11/2025
         * Pagina web que añade tres registros a nuestra tabla Departamento 
         * utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.
         */

        require_once '../config/confDBPDO.php'; // Importamos la configuración de la base de datos (RUTA, USUARIO, PASS)

        /* ==================== Conexión a la base de datos ==================== */
        try {
            // Creamos la conexión PDO a la base de datos
            $miDB = new PDO(RUTA, USUARIO, PASS);
            // Configuramos PDO para que lance excepciones en caso de error
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            // Si hay un error de conexión, se muestra el mensaje y el código, y se detiene la ejecución
            echo "Error de conexión a la base de datos: " . $ex->getMessage() . "<br>";
            echo "Código de error: " . $ex->getCode();
            exit;
        }

        /* ==================== Consulta inicial (opcional) ==================== */
        // Se ejecuta una consulta inicial para obtener todos los registros (aunque no se usa para nada aquí)
        $resultadoConsulta = $miDB->query("SELECT * FROM T02_Departamento");

        /* ==================== Inicio de la transacción ==================== */
        $miDB->beginTransaction(); // Iniciamos la transacción para que todos los inserts se ejecuten juntos

        /* ==================== Primer INSERT ==================== */
        $query1 = "INSERT INTO T02_Departamento 
                   (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenNegocio, T02_FechaBajaDepartamento)
                   VALUES('AAA','Departamento transacción 1',NOW(),1234,NULL)";

        $miDB->query($query1); // Ejecutamos el primer INSERT

        /* ==================== Segundo INSERT ==================== */
        $query1 = "INSERT INTO T02_Departamento 
                   (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenNegocio, T02_FechaBajaDepartamento)
                   VALUES('BBB','Departamento transacción 2',NOW(),123,NULL)";

        $miDB->query($query1); // Ejecutamos el segundo INSERT

        /* ==================== Tercer INSERT ==================== */
        $query1 = "INSERT INTO T02_Departamento 
                   (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenNegocio, T02_FechaBajaDepartamento)
                   VALUES('CCC','Departamento transacción 3',NOW(),12,NULL)";

        $miDB->query($query1); // Ejecutamos el tercer INSERT

        /* ==================== Commit de la transacción ==================== */
        $miDB->commit(); // Confirmamos la transacción: los tres registros se añaden de forma atómica
        echo "Insertados correctamente";

        /* ==================== Mostrar los registros ==================== */
        try {
            $query = $miDB->query("SELECT * FROM T02_Departamento"); // Consultamos todos los registros

            if ($query->rowCount() > 0) { // Si hay registros
                echo "<table border='2' style='border-collapse: collapse;'>";
                echo "<tr style='background-color: lightsteelblue; font-weight: bold;'>";

                // Mostramos los nombres de las columnas
                for ($i = 0; $i < $query->columnCount(); $i++) {
                    $nomColumna = $query->getColumnMeta($i)["name"];
                    echo "<th>{$nomColumna}</th>";
                }
                echo "</tr>";

                // Recorremos cada registro y lo mostramos en la tabla
                while ($registro = $query->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    foreach ($registro as $valor) {
                        echo "<td style='padding:5px;'>$valor</td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";
                echo "<h3 style='text-align:center;'>Hay {$query->rowCount()} registros.</h3>";
            } else {
                echo "<p>No hay departamentos en la base de datos.</p>";
            }
        } catch (PDOException $ex) {
            // Mostramos errores de la consulta
            echo "Error al mostrar departamentos: " . $ex->getMessage();
        } finally {
            // Cerramos la conexión
            unset($miDB);
        }
        ?>
    </main>
</body>
</html>