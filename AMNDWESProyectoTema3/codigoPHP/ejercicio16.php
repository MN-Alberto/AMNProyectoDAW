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
        <h2><b>Ejercicio 16</b></h2>
        
        <?php
        /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 17/10/2025
         * 16. Recorrer el array anterior utilizando funciones para obtener el mismo resultado.
         */

        
        // Se define una función llamada recorrerSueldoSemanal
        // que calcula y muestra el sueldo diario y el total semanal.
        function recorrerSueldoSemanal() {
            // Se crea un array asociativo $aSueldos con los días de la semana como claves
            // y el sueldo correspondiente a cada día como valor.
            $aSueldos = array(
                "lunes" => 50,
                "martes" => 40,
                "miercoles" => 60,
                "jueves" => 70,
                "viernes" => 20,
                "sabado" => 90,
                "domingo" => 150,
            );

            // Variable para acumular el total del sueldo semanal.
            $total = 0;

            // Recorre cada elemento del array asociativo.
            // $dia contendrá la clave (nombre del día) y $sueldo el valor (cantidad ganada).
            foreach ($aSueldos as $dia => $sueldo) {
                // Muestra cuánto se ha ganado cada día.
                echo "El " . $dia . " ha ganado: " . $sueldo . "€<br>";
                // Suma el sueldo del día al total acumulado.
                $total += $sueldo;
            }

            // Devuelve como resultado un string con el total del sueldo semanal.
            // Se utiliza <span> con color rojo para resaltar el total.
            return "<br>El total del sueldo semanal es: <span style='color:red;'>" . $total . "€";   
        }

        // Se llama a la función y se guarda el resultado (el total del sueldo) en la variable $mensaje.
        $mensaje = recorrerSueldoSemanal();

        // Se muestra el mensaje que contiene el total del sueldo semanal.
        echo $mensaje;
        ?>
        
    </main>
</body>
</html>