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
        <h2><b>Ejercicio 4</b></h2>
        
        <?php
        
                /*
         * Autor: Alberto Méndez Núñez
         * Fecha de ultima modificación: 13/11/2025
         * Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento,
         * si el usuario no pone nada deben aparecer todos los departamentos).
         */
        require_once 'libreriaValidacionFormulario.php'; // Librería para validar los campos del formulario
        require_once '../config/confDBPDO.php'; // Archivo con datos de conexión a la base de datos (RUTA, USUARIO, PASS)

        /* ==================== Conexión a la base de datos ==================== */
        try {
            // Creamos la conexión PDO a la base de datos
            $miDB = new PDO(RUTA, USUARIO, PASS);
            // Configuramos PDO para que lance excepciones en caso de error
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            // Si hay un error de conexión, lo mostramos y detenemos la ejecución
            echo "Error de conexión a la base de datos: " . $ex->getMessage() . "<br>";
            echo "Código de error: " . $ex->getCode();
            exit;
        }

        /* ==================== Inicialización de arrays ==================== */
        // Array que contendrá los mensajes de error de validación
        $aErrores = [
            "T02_DescDepartamento" => ""
        ];

        // Array que contendrá los datos válidos del formulario
        $aRespuesta = [
            "T02_DescDepartamento" => ""
        ];

        // Variable que indica si la entrada del formulario es correcta
        $entradaOK = true;

        /* ==================== Procesamiento del formulario ==================== */
        if (isset($_REQUEST['buscar'])) { // Si se pulsó el botón de búsqueda
            // Recogemos la descripción introducida por el usuario
            $T02_DescDepartamento = $_REQUEST['T02_DescDepartamento'] ?? '';

            // Validamos que la descripción sea alfabética (máximo 255 caracteres, obligatorio)
            $aErrores['T02_DescDepartamento'] = validacionFormularios::comprobarAlfabetico($T02_DescDepartamento, 255, 0, 1);

            // Comprobamos si hay errores
            foreach ($aErrores as $valor) {
                if (!empty($valor)) {
                    $entradaOK = false; // Si hay algún error, no procesamos la búsqueda
                }
            }

            // Si no hay errores, guardamos el valor introducido
            if ($entradaOK) {
                $aRespuesta["T02_DescDepartamento"] = ($_REQUEST["T02_DescDepartamento"]);
            }
        }

        /* ==================== Mostrar el formulario ==================== */
        if (!isset($_REQUEST['submit']) || !$entradaOK) {
            ?>
            <div id="formulario">
                <h1 style="text-align:center;">Buscar departamento por descripción</h1>
                <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
                    <table>
                        <tr>
                            <td><label for="T02_DescDepartamento">Descripción:</label></td>
                            <td><input type="text" name="T02_DescDepartamento" id="T02_DescDepartamento"
                                       value="<?= (empty($aErrores['T02_DescDepartamento'])) ? ($_REQUEST['T02_DescDepartamento'] ?? '') : ''; ?>"/></td>
                            <!-- Botón de búsqueda -->
                            <td><input type="submit" value="Buscar" name="buscar"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php
        }

        /* ==================== Consulta a la base de datos ==================== */
        try {
            if (empty($aRespuesta["T02_DescDepartamento"])) {
                // Si el usuario no introdujo nada, seleccionamos todos los departamentos
                $query = "SELECT * FROM T02_Departamento";
            } else {
                // Si se introdujo algo, buscamos coincidencias parciales con LIKE
                $RespuestasSql = "%" . $aRespuesta["T02_DescDepartamento"] . "%";
                $query = "SELECT * FROM T02_Departamento WHERE T02_DescDepartamento LIKE '$RespuestasSql'";
            }

            // Ejecutamos la consulta
            $resultadoConsulta = $miDB->query($query);

            // Creamos la tabla HTML para mostrar los resultados
            echo '<table border=1px>';
            echo '<tr style=background-color:lightblue;>';
            echo '<th>Código</th>';
            echo '<th>Descripción</th>';
            echo '<th>Fecha Creación</th>';
            echo '<th>Volumen Negocio</th>';
            echo '<th>Fecha Baja</th>';
            echo '</tr>';

            // Recorremos cada registro devuelto por la consulta
            while ($aRegistroArray = $resultadoConsulta->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $aRegistroArray["T02_CodDepartamento"] . "</td>";
                echo "<td>" . $aRegistroArray["T02_DescDepartamento"] . "</td>";

                // Convertimos la fecha de creación a formato d-m-Y
                $fechaCreacion = new DateTime($aRegistroArray["T02_FechaCreacionDepartamento"]);
                echo "<td>" . $fechaCreacion->format("d-m-Y") . "</td>";

                // Formateamos el volumen de negocio con dos decimales y símbolo €
                echo "<td>" . number_format($aRegistroArray["T02_VolumenNegocio"], 2, ',', '.') . '€</td>';

                // Comprobamos si la fecha de baja es nula
                if (!is_null($aRegistroArray["T02_FechaBajaDepartamento"])) {
                    $fechaBaja = new DateTime($aRegistroArray["T02_FechaBajaDepartamento"]);
                    echo "<td>" . $fechaBaja->format("d-m-Y") . "</td>";
                } else {
                    echo "<td></td>";
                }

                echo "</tr>";
            }

            // Mostramos el total de registros en la tabla
            $numReg = $miDB->query("SELECT count(*) FROM T02_Departamento");
            $totalReg = $numReg->fetchColumn();
            echo "Total de registros: " . $totalReg;

        } catch (PDOException $ex) {
            // Si ocurre un error en la base de datos lo mostramos
            echo '<p>Error en la base de datos:</p>';
            echo $ex->getMessage() . '<br>Código: ';
            echo $ex->getCode();
        } finally {
            // Cerramos la conexión a la base de datos
            unset($miDB);
        }
        ?>
    </main>
</body>
</html>