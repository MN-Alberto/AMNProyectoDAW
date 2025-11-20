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
        <h2><b>Ejercicio 7</b></h2>
        
        <?php
        
                /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 13/11/2025
         * Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla Departamento de nuestra base de datos.
         * (IMPORTAR). El fichero importado se encuentra en el directorio .../tmp/ del servidor.
         */
        
        
        require_once '../config/confDBPDO.php'; 
        // Incluye la configuración de conexión: constantes RUTA, USUARIO, PASS

        /* ==================== Conexión a la base de datos ==================== */
        try {
            $miDB = new PDO(RUTA, USUARIO, PASS); // Crear objeto PDO
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            // Configura PDO para lanzar excepciones si hay errores

        } catch (PDOException $ex) {
            echo "Error de conexión a la base de datos: " . $ex->getMessage() . "<br>";
            echo "Código de error: " . $ex->getCode();
            exit;
        }

        /* ==================== Leer fichero JSON ==================== */
        $jsonFile = "../tmp/departamentos.json"; // Ruta al fichero JSON

        if (!file_exists($jsonFile)) {
            die("El fichero JSON no existe en la carpeta tmp.");
        }

        // Leemos el contenido del fichero JSON
        $jsonData = file_get_contents($jsonFile);

        // Convertimos el JSON en array de objetos o arrays asociativos
        $aDepartamentos = json_decode($jsonData, true); // true para array asociativo

        if (!$aDepartamentos) {
            die("Error al decodificar el fichero JSON.");
        }

        /* ==================== Insertar datos en la base de datos ==================== */
        try {
            $miDB->beginTransaction(); // Iniciamos transacción

            // Consulta preparada con parámetros
            $sql = "INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenNegocio, T02_FechaBajaDepartamento) 
                    VALUES (:cod, :desc, NOW(), :vol, NULL)";
            $stmt = $miDB->prepare($sql);

            // Recorremos cada departamento del JSON y lo insertamos
            foreach ($aDepartamentos as $departamento) {
                $cod = $departamento['T02_CodDepartamento'] ?? '';
                $desc = $departamento['T02_DescDepartamento'] ?? '';
                $vol = $departamento['T02_VolumenDepartamento'] ?? 0;

                // Ejecutamos la consulta preparada
                $stmt->execute([
                    ':cod' => $cod,
                    ':desc' => $desc,
                    ':vol' => $vol
                ]);
            }

            $miDB->commit(); // Confirmamos la transacción
            echo "<h2>Departamentos importados correctamente desde JSON.</h2>";

        } catch (PDOException $ex) {
            $miDB->rollBack(); // Cancelamos la transacción si hay error
            echo "Error al insertar datos: " . $ex->getMessage() . "<br>";
            echo "Código de error: " . $ex->getCode();
        } finally {
            unset($miDB); // Cerramos la conexión
        }
        ?>
    </main>
</body>
</html>