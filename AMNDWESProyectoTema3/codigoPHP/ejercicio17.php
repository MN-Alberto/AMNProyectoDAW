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
	main{
	text-align:center;
	justify-content:center;
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
        <h1><b>UT3: CARACTERÍSTICAS DEL LENGUAJE PHP</b></h1>
        <a href="../../AMNDWESProyectoDWES/indexProyectoDWES.php">Alberto Méndez Núñez | 03/10/2025</a>
        <p>Curso 2025/2026 - Grupo DAW2</p>
    </header>
    <main>
        <h2><b>Ejercicio 17</b></h2>
        
        <?php
        /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 17/10/2025
         * 17. Inicializar un array (bidimensional con dos índices numéricos) donde almacenamos el nombre de las personas que tienen reservado el
            asiento en un teatro de 20 filas y 15 asientos por fila. (Inicializamos el array ocupando únicamente 5 asientos). Recorrer el array con
            distintas técnicas (foreach(), while(), for()) para mostrar los asientos ocupados en cada fila y las personas que lo ocupan.
         */

        
                // Se definen el número de filas y asientos del "aula" o matriz.
        $filas = 20;      // Número de filas.
        $asientos = 15;   // Número de asientos por fila.

        // Se crea un array vacío que representará la matriz de asientos.
        $matriz = [];

        // Inicialización de la matriz con valores vacíos.
        // Se utiliza un bucle anidado para recorrer filas y columnas.
        for ($i = 0; $i < $filas; $i++) {
            for ($j = 0; $j < $asientos; $j++) {
                $matriz[$i][$j] = ""; // Inicializa cada asiento como vacío.
            }
        }

        // Se asignan nombres a algunos asientos específicos.
        $matriz[0][0] = "Juan";      // Primer asiento de la primera fila.
        $matriz[6][2] = "Mario";     // Fila 7, columna 3.
        $matriz[0][5] = "Pedro";     // Fila 1, columna 6.
        $matriz[2][4] = "Luis";      // Fila 3, columna 5.
        $matriz[3][2] = "Luigi";     // Fila 4, columna 3.

        /* ==================== Recorrido con foreach ==================== */
        echo "<span style='color:red;'>Array recorrida con foreach(): </span><br><br>";

        // Se inicia la tabla HTML.
        echo "<table>";

        // Primera fila de encabezados de columnas.
        echo "<tr><th></th>"; // Celda vacía superior izquierda.
        for ($j = 0; $j < $asientos; $j++) {
            echo "<th style='border:1px solid black; width:50px; background-color:#ccc;'>C" . ($j + 1) . "</th>";
        }
        echo "</tr>";

        // Recorre la matriz usando foreach.
        foreach ($matriz as $i => $fila) {
            echo "<tr>";
            // Encabezado de fila con el número de fila.
            echo "<th style='border:1px solid black; background-color:#ccc;'>F" . ($i + 1) . "</th>";

            // Recorre cada asiento de la fila.
            foreach ($fila as $nombre) {
                if ($nombre != "") {
                    // Asiento ocupado: fondo rojo y muestra el nombre.
                    echo "<td style='border:1px solid black; background-color:red; width:50px;'>$nombre</td>";
                } else {
                    // Asiento vacío: fondo verde.
                    echo "<td style='border:1px solid black; background-color:green; width:50px;'></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";

        /* ==================== Recorrido con while ==================== */
        echo "<br><span style='color:red;'>Array recorrida con while(): </span><br><br>";

        $i = 0; // Inicialización del índice de fila.
        echo "<table>";
        echo "<tr><th></th>";
        for ($j = 0; $j < $asientos; $j++) {
            echo "<th style='border:1px solid black; width:50px; background-color:#ccc;'>C" . ($j + 1) . "</th>";
        }
        echo "</tr>";

        // Bucle while para recorrer filas.
        while ($i < $filas) {
            echo "<tr>";
            echo "<th style='border:1px solid black; background-color:#ccc;'>F" . ($i + 1) . "</th>";

            $j = 0; // Inicialización del índice de columna.
            while ($j < $asientos) {
                if ($matriz[$i][$j] != "") {
                    echo "<td style='border:1px solid black; background-color:red; width:50px;'>" . $matriz[$i][$j] . "</td>";
                } else {
                    echo "<td style='border:1px solid black; background-color:green; width:50px;'></td>";
                }
                $j++; // Incrementa columna.
            }
            echo "</tr>";
            $i++; // Incrementa fila.
        }
        echo "</table>";

        /* ==================== Recorrido con for ==================== */
        echo "<br><span style='color:red;'>Array recorrida con for(): </span><br><br>";

        echo "<table>";
        echo "<tr><th></th>";
        for ($j = 0; $j < $asientos; $j++) {
            echo "<th style='border:1px solid black; width:50px; background-color:#ccc;'>C" . ($j + 1) . "</th>";
        }
        echo "</tr>";

        // Bucle for anidado para recorrer filas y columnas.
        for ($i = 0; $i < $filas; $i++) {
            echo "<tr>";
            echo "<th style='border:1px solid black; background-color:#ccc;'>F" . ($i + 1) . "</th>";

            for ($j = 0; $j < $asientos; $j++) {
                if ($matriz[$i][$j] != "") {
                    echo "<td style='border:1px solid black; background-color:red; width:50px;'>" . $matriz[$i][$j] . "</td>";
                } else {
                    echo "<td style='border:1px solid black; background-color:green; width:50px;'></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        ?>
        
    </main>
</body>
</html>