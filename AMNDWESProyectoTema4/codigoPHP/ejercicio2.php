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
	main{
	text-align:center;
	justify-content:center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
	}
        a{
            text-decoration: none;
            color:purple;
        }
        
        table{
            border-collapse: collapse;
            width: 800px;
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
        <h2><b>Ejercicio 2</b></h2>
        
        <?php
        
                /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 03/11/2025
         * Mostrar el contenido de la tabla Departamento y el número de registros
         */
        
        // Incluye el archivo de configuración con los datos de conexión
        require_once '../config/confDBPDO.php';

        try {
            // Crear una nueva conexión PDO usando los datos de configuración
            $miDB = new PDO(RUTA, USUARIO, PASS);

            // Ejecuta la consulta para obtener todos los registros de la tabla T02_Departamento
            $tabla1 = $miDB->query("SELECT * FROM T02_Departamento");

            // Recupera todos los resultados en un array asociativo
            $resultadoTabla = $tabla1->fetchAll(PDO::FETCH_ASSOC);

            // Inicia una tabla HTML para mostrar los resultados
            echo "<table border=2px>";

            // Fila de encabezado con nombres de columnas
            echo "<tr style='background-color:lightblue;'>";
                echo "<td>T02_CodDepartamento</td>";
                echo "<td>T02_DescDepartamento</td>";
                echo "<td>T02_FechaCreacionDepartamento</td>";
                echo "<td>T02_VolumenNegocio</td>";
                echo "<td>T02_FechaBajaDepartamento</td>";
            echo "</tr>";

            // Recorre cada fila del resultado y la muestra en la tabla HTML
            foreach ($resultadoTabla as $fila) {
                echo "<tr>";
                echo "<td>{$fila['T02_CodDepartamento']}</td>";
                echo "<td>{$fila['T02_DescDepartamento']}</td>";
                echo "<td>{$fila['T02_FechaCreacionDepartamento']}</td>";
                echo "<td>{$fila['T02_VolumenNegocio']}€</td>";
                echo "<td>{$fila['T02_FechaBajaDepartamento']}</td>";
                echo "</tr>";
            }

            echo "</table><br><br>";

            // Ejecuta otra consulta para contar el número de registros de la tabla
            $numReg = $miDB->query("SELECT COUNT(*) FROM T02_Departamento");

            // Recupera el resultado como un valor simple
            $resultadoReg = $numReg->fetchColumn();

            // Muestra el número total de registros
            echo "<h3>Número de registros: " . $resultadoReg . "</h3>";

        } catch (PDOException $ex) {
            // Captura errores de conexión o consulta y muestra el mensaje
            echo $ex->getMessage();
        }

        // Cierra la conexión para liberar recursos
        unset($miDB);
        ?>
    </main>
</body>
</html>