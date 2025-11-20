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
        <h2><b>Ejercicio 03</b></h2>
        
        <?php
        /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 09/10/2025
         * 
         */
        
        // Establece la zona horaria a utilizar para funciones de fecha y hora.
        // "Europe/Madrid" indica que se usará la hora oficial de España.
        
        date_default_timezone_set("Europe/Madrid");
        
        // Crea un nuevo objeto DateTime con la fecha y hora actuales del sistema.
        // El objeto $fechaYhora permite manipular y formatear fechas de forma sencilla.
        $fechaYhora=new DateTime();
        
        // Imprime un mensaje concatenado con la fecha y hora actual formateada.
        // ->format("d-m-Y h:i:s") convierte el objeto DateTime en un string con el formato:
        // día-mes-año horas:minutos:segundos (en formato 12h porque se usa "h" en lugar de "H").
        echo "La fecha y hora actual es: ".$fechaYhora->format("d-m-Y h:i:s");    
        
        ?>
        
    </main>
</body>
</html>