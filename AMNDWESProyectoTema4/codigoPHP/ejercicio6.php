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
        <h2><b>Ejercicio 6</b></h2>
        
        <?php
        
                /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 13/11/2025
         * Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada.
         *  (Después de programar y entender este ejercicio,
         *  modificar los ejercicios anteriores para que utilicen consultas preparadas). 
         * Probar consultas preparadas sin bind, pasando los parámetros en un array a execute.
         */
        
        require_once '../config/confDBPDO.php'; // Importa configuración de conexión a la base de datos

        /* ==================== Definición de los nuevos departamentos ==================== */
        $aDepartamentos = [
            [
                'T02_CodDepartamento' => 'EDU',
                'T02_DescDepartamento' => 'Departamento de Educación Física',
                'T02_VolumenDepartamento' => 324.7
            ],
            [
                'T02_CodDepartamento' => 'LIT',
                'T02_DescDepartamento' => 'Departamento de literatura',
                'T02_VolumenDepartamento' => 6434.7
            ],
            [
                'T02_CodDepartamento' => 'ADE',
                'T02_DescDepartamento' => 'Departamento de administración de empresas',
                'T02_VolumenDepartamento' => 3523.7
            ]
        ];

        try {
            /* ==================== Conexión a la base de datos ==================== */
            $miDB = new PDO(RUTA, USUARIO, PASS); // Creamos objeto PDO
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Excepciones ante errores

            /* ==================== Iniciamos la transacción ==================== */
            $miDB->beginTransaction(); // Si algo falla, podemos revertir todos los inserts

            /* ==================== Preparación de la consulta ==================== */
            $query = <<<SQL
                INSERT INTO T02_Departamento(
                    T02_CodDepartamento,
                    T02_DescDepartamento,
                    T02_FechaCreacionDepartamento,
                    T02_VolumenNegocio,
                    T02_FechaBajaDepartamento
                )
                VALUES (:cod, :desc, NOW(), :vol, NULL)
            SQL;

            $consPreparada = $miDB->prepare($query); // Creamos la consulta preparada

            /* ==================== Inserción de cada departamento ==================== */
            foreach ($aDepartamentos as $departamento) {
                // Asignamos los valores del array a los parámetros de la consulta
                $consPreparada->bindParam(':cod', $departamento['T02_CodDepartamento']);
                $consPreparada->bindParam(':desc', $departamento['T02_DescDepartamento']);
                $consPreparada->bindParam(':vol', $departamento['T02_VolumenDepartamento']);

                $consPreparada->execute(); // Ejecutamos la consulta para cada departamento
            }

            $miDB->commit(); // Confirmamos la transacción: todos los registros se insertan de forma atómica

        } catch (PDOException $ex) {
            // En caso de error, se muestra mensaje y código, y se detiene la ejecución
            echo "Error de conexión a la base de datos o inserción: " . $ex->getMessage() . "<br>";
            echo "Código de error: " . $ex->getCode();
            exit;
        }

        /* ==================== Mostrar todos los registros de la tabla ==================== */
        try {
            $query = $miDB->query("SELECT * FROM T02_Departamento"); // Consulta de todos los registros

            if ($query->rowCount() > 0) { // Si hay registros
                echo "<table border='2' style='border-collapse: collapse;'>";
                echo "<tr style='background-color: lightsteelblue; font-weight: bold;'>";

                // Cabeceras de la tabla según las columnas
                for ($i = 0; $i < $query->columnCount(); $i++) {
                    $nomColumna = $query->getColumnMeta($i)["name"];
                    echo "<th>{$nomColumna}</th>";
                }
                echo "</tr>";

                // Recorremos todos los registros y mostramos cada uno en fila de la tabla
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
            // Manejo de errores en la consulta de lectura
            echo "Error al mostrar departamentos: " . $ex->getMessage();
        } finally {
            unset($miDB); // Cerramos la conexión
        }
        ?>
    </main>
</body>
</html>