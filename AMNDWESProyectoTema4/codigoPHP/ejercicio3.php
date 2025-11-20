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
        <h2><b>Ejercicio 3</b></h2>
        
        <?php
        
                /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 30/10/2025
         * Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.
         */
            // Incluimos la librería de validación de formularios
            require_once 'libreriaValidacionFormulario.php';

            // Incluimos el archivo de configuración de la base de datos
            require_once '../config/confDBPDO.php';

            /* ==================== Conexión a la base de datos ==================== */
            try {
                // Crear un objeto PDO con la conexión usando RUTA, USUARIO y PASS definidos en confDBPDO.php
                $miDB = new PDO(RUTA, USUARIO, PASS);

                // Configura PDO para que lance excepciones cuando ocurra un error
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $ex) {
                // Si hay un error de conexión, se muestra el mensaje y el código de error y se detiene la ejecución
                echo "Error de conexión a la base de datos: " . $ex->getMessage() . "<br>";
                echo "Código de error: " . $ex->getCode();
                exit;
            }

            /* ==================== Inicialización de arrays ==================== */
            // Array para almacenar los posibles mensajes de error de cada campo
            $aErrores = [
                "T02_CodDepartamento" => "",
                "T02_DescDepartamento" => "",
                "T02_VolumenNegocio" => ""
            ];

            // Array para almacenar los valores válidos ingresados por el usuario
            $aRespuesta = [
                "T02_CodDepartamento" => "",
                "T02_DescDepartamento" => "",
                "T02_VolumenNegocio" => ""
            ];

            // Variable que indica si todos los datos del formulario son correctos
            $entradaOK = true;

            /* ==================== Procesamiento del formulario ==================== */
            if (isset($_REQUEST['submit'])) { // Si se ha pulsado el botón de enviar
                // Recogemos los datos enviados por el usuario
                $T02_CodDepartamento = $_REQUEST['T02_CodDepartamento'] ?? '';
                $T02_DescDepartamento = $_REQUEST['T02_DescDepartamento'] ?? '';
                $T02_VolumenNegocio = $_REQUEST['T02_VolumenNegocio'] ?? '';

                // Validamos los campos usando la librería de validación
                // Comprobamos que sea alfabético, longitud máxima y obligatorio
                $aErrores['T02_CodDepartamento'] = validacionFormularios::comprobarAlfabetico($T02_CodDepartamento, 3, 0, 1);
                $aErrores['T02_DescDepartamento'] = validacionFormularios::comprobarAlfabetico($T02_DescDepartamento, 255, 0, 1);

                // Convertimos comas a punto en el número decimal
                $volumenNegocio = str_replace(',', '.', $T02_VolumenNegocio);
                // Comprobamos que sea un número decimal válido
                $aErrores['T02_VolumenNegocio'] = validacionFormularios::comprobarFloat($volumenNegocio);

                // Recorremos el array de errores para saber si hay algún error
                foreach ($aErrores as $valor) {
                    if (!empty($valor)) {
                        $entradaOK = false; // Si hay algún error, la entrada no es válida
                    }
                }

                /* ==================== Comprobar si el departamento ya existe ==================== */
                if ($entradaOK && empty($aErrores['T02_CodDepartamento'])) {
                    try {
                        // Consulta preparada para comprobar si ya existe el departamento con el mismo código
                        $sql = "SELECT * FROM T02_Departamento WHERE T02_CodDepartamento = ?";
                        $query = $miDB->prepare($sql);
                        $query->bindParam(1, $T02_CodDepartamento); // Se enlaza el parámetro
                        $query->execute(); // Ejecuta la consulta

                        $registro = $query->fetch(PDO::FETCH_ASSOC); // Obtiene el primer registro encontrado

                        // Si se encuentra un registro con el mismo código, se marca como error
                        if ($registro && $registro['T02_CodDepartamento'] == $T02_CodDepartamento) {
                            $aErrores['T02_CodDepartamento'] = "El departamento que intenta introducir ya existe en la base de datos.";
                            $entradaOK = false;
                        }
                    } catch (PDOException $ex) {
                        // Captura errores al comprobar duplicados
                        echo "Error al comprobar duplicados: " . $ex->getMessage();
                    }
                }

                /* ==================== Inserción en la base de datos ==================== */
                if ($entradaOK) { // Si todos los datos son correctos
                    try {
                        // Guardamos los valores válidos en el array de respuesta
                        $aRespuesta['T02_CodDepartamento'] = $T02_CodDepartamento;
                        $aRespuesta['T02_DescDepartamento'] = $T02_DescDepartamento;
                        $aRespuesta['T02_VolumenNegocio'] = ($volumenNegocio === '') ? 0 : $volumenNegocio;

                        // Consulta preparada con parámetros nombrados para insertar el nuevo departamento
                        $sql = <<<EOT
                            INSERT INTO T02_Departamento (
                                T02_CodDepartamento,
                                T02_DescDepartamento,
                                T02_FechaCreacionDepartamento,
                                T02_VolumenNegocio,
                                T02_FechaBajaDepartamento
                            ) VALUES (
                                :cod,
                                :desc,
                                NOW(),
                                :volumen,
                                NULL
                            )
                        EOT;

                        $stmt = $miDB->prepare($sql);
                        $stmt->execute([
                            ':cod' => $aRespuesta['T02_CodDepartamento'],
                            ':desc' => $aRespuesta['T02_DescDepartamento'],
                            ':volumen' => $aRespuesta['T02_VolumenNegocio']
                        ]);

                        // Mensaje de éxito
                        echo "<p style='color:green; font-weight:bold;'>Departamento insertado correctamente.</p>";
                    } catch (PDOException $ex) {
                        // Captura errores al insertar en la base de datos
                        echo "Error al insertar: " . $ex->getMessage();
                    }
                }
            }

            /* ==================== Mostrar el formulario si no se envió o hay errores ==================== */
            if (!isset($_REQUEST['submit']) || !$entradaOK) {
                ?>
                <div id="formulario">
                    <h1 style="text-align:center;">Inserción de nuevo departamento</h1>
                    <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
                        <table>
                            <!-- Código del Departamento -->
                            <tr>
                                <td><label for="T02_CodDepartamento">Código del Departamento:</label></td>
                                <td><input type="text" name="T02_CodDepartamento" id="T02_CodDepartamento"
                                           style="background-color: lightgoldenrodyellow"
                                           value="<?= (empty($aErrores['T02_CodDepartamento'])) ? ($_REQUEST['T02_CodDepartamento'] ?? '') : ''; ?>"/></td>
                                <td><span style="color:red;"><?= $aErrores["T02_CodDepartamento"] ?></span></td>
                            </tr>

                            <!-- Descripción -->
                            <tr>
                                <td><label for="T02_DescDepartamento">Descripción:</label></td>
                                <td><input type="text" name="T02_DescDepartamento" id="T02_DescDepartamento"
                                           style="background-color: lightgoldenrodyellow"
                                           value="<?= (empty($aErrores['T02_DescDepartamento'])) ? ($_REQUEST['T02_DescDepartamento'] ?? '') : ''; ?>"/></td>
                                <td><span style="color:red;"><?= $aErrores["T02_DescDepartamento"] ?></span></td>
                            </tr>

                            <!-- Volumen de negocio -->
                            <tr>
                                <td><label for="T02_VolumenNegocio">Volumen de Negocio:</label></td>
                                <td><input type="number" step="0.01" name="T02_VolumenNegocio" id="T02_VolumenNegocio"
                                           style="background-color: lightgoldenrodyellow"
                                           value="<?= (empty($aErrores['T02_VolumenNegocio'])) ? ($_REQUEST['T02_VolumenNegocio'] ?? '') : ''; ?>"/></td>
                                <td><span style="color:red;"><?= $aErrores["T02_VolumenNegocio"] ?></span></td>
                            </tr>

                            <!-- Botones -->
                            <tr>
                                <td><input type="submit" value="Insertar" name="submit"></td>
                                <td><input type="reset" value="Cancelar" name="reset"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            }

            /* ==================== Mostrar la tabla con todos los departamentos ==================== */
            try {
                $query = $miDB->query("SELECT * FROM T02_Departamento");

                if ($query->rowCount() > 0) {
                    // Inicia la tabla HTML
                    echo "<table border='2' style='border-collapse: collapse;'>";
                    echo "<tr style='background-color: lightsteelblue; font-weight: bold;'>";

                    // Genera los encabezados de columna automáticamente
                    for ($i = 0; $i < $query->columnCount(); $i++) {
                        $nomColumna = $query->getColumnMeta($i)["name"];
                        echo "<th>{$nomColumna}</th>";
                    }
                    echo "</tr>";

                    // Recorre los registros y muestra los valores de cada columna
                    while ($registro = $query->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>";
                        foreach ($registro as $valor) {
                            echo "<td style='padding:5px;'>$valor</td>";
                        }
                        echo "</tr>";
                    }

                    echo "</table>";
                    // Muestra el número total de registros
                    echo "<h3 style='text-align:center;'>Hay {$query->rowCount()} registros.</h3>";
                } else {
                    echo "<p>No hay departamentos en la base de datos.</p>";
                }
            } catch (PDOException $ex) {
                // Captura errores al mostrar los datos
                echo "Error al mostrar departamentos: " . $ex->getMessage();
            } finally {
                // Cierra la conexión para liberar recursos
                unset($miDB);
            }
            ?>
    </main>
</body>
</html>