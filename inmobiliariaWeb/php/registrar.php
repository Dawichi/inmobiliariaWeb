<!DOCTYPE html>
<!--
Registra en el servidor los datos introducidos y guarda la imagen en ./imgs/
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inmobiliaria: listado</title>
        <link type="text/css" rel="stylesheet" href="../css/styles.css">
        <link type="text/css" rel="stylesheet" href="../css/registro.css">
    </head>
    <body>
        <nav>
            <a href="../index.php">Inicio</a>
        </nav>
        <?
            include 'functions.php';
            include 'usuario.php';

            const T_MAX = 655360; // Tamaño máximo del archivo: 640 KB (en bytes)

            if (isset($_POST['submit'])) {

                $errores = "";

                if (!isset($_POST['habitaciones'])) { //Habitaciones en blanco
                    $errores .= "Especifica el número de habitaciones<br>";
                }

                if (empty($_POST["precio"])) { //Precio vacío
                    $errores .= "Precio es requerido<br>";
                }

                if (!is_numeric($_POST['precio'])) { //Precio no numérico
                    $errores .= "Precio debe ser un número<br>";
                }

                if (empty($_POST["superficie"])) { //Superficie vacío
                    $errores .= "Superficie es requerido<br>";
                }

                if (!is_numeric($_POST['superficie'])) { //Superficie no numérico
                    $errores .= "Superficie debe ser un número<br>";
                }

                if (!($_FILES['fichero']['error'] === UPLOAD_ERR_OK)) { // Error $_FILES
                    $errores .= "Ha ocurrido un problema al cargar el fichero<br>";
                }

                if (!validar_png($_FILES['fichero']['size'])) { // Imagen no válida
                    $errores .= "El fichero no es un archivo.png<br>";
                }

                if (!validar_size($_FILES['fichero']['size'], T_MAX)) { // Imagen demasiado grande
                    $errores .= "El fichero ocupa más de 64KB<br>";
                }

                if (empty($errores)) {

                    // Recoger en variables el POST
                    $tipo = $_POST['tipo_vivienda'];
                    $localidad = $_POST['localidad'];
                    $habitacion = $_POST['habitaciones'];
                    $precio = filtrado($_POST['precio']);
                    $superficie = filtrado($_POST['superficie']);

                    // Definición de arrays
                    $tipos_vivienda = array('Chalet', 'Piso');
                    $localidades = array('Caldas', 'Cambados','Vilagarcía');
                    $habitaciones = array(1, 2, 3, 4, 5);
                    $ar_extras = array('Garaje', 'Jardín', 'Piscina');

                    // Comprobar las casillas de EXTRAS, validación y errores
                    if (isset($_POST['extras'])) {
                        $extras = $_POST['extras'];
                        $extras = array_intersect($extras, $ar_extras);
                        $extras = print_array($extras);
                    } else {
                        $extras = "-";
                    }

                    // Validar que las opciones recibidas se encuentran en los array guardados
                    if (in_array($tipo,$tipos_vivienda) and in_array($localidad,$localidades) and in_array($habitacion,$habitaciones)) {

                        // Abrir conexión a MySQL
                        try {
                            $pdo = new PDO(DSN, USUARIO, CONTRASEÑA);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Convertir la imagen a texto BLOB y almacenarla en $contenidoFichero
                            $contenidoFichero = file_get_contents($_FILES['fichero']['tmp_name']);

                            // Registrar datos
                            $sql = "INSERT INTO viviendas(tipo, localidad, habitaciones, precio, superficie, extras, foto) VALUES(:tipo, :localidad, :habitaciones, :precio, :superficie, :extras, :foto)";
                            $sentencia = $pdo->prepare($sql);
                            $sentencia->bindValue(':tipo',$tipo);
                            $sentencia->bindValue(':localidad',$localidad);
                            $sentencia->bindValue(':habitaciones',$habitacion, PDO::PARAM_INT);
                            $sentencia->bindValue(':precio',$precio, PDO::PARAM_INT);
                            $sentencia->bindValue(':superficie',$superficie, PDO::PARAM_INT);
                            $sentencia->bindValue(':extras',$extras);
                            $sentencia->bindValue(':foto', $contenidoFichero, PDO::PARAM_LOB);
                            $sentencia->execute();

                        } catch (PDOException $ex) { // Control errores
                            echo '<span>Ocurrió un error al acceder a la base de datos.</span><br>';
                            exit;
                        }

                        // Cerrar conexión
                        $pdo = null;


                        echo "<ul class='registrado'>";
                            echo "<h3>Se han registrado estos datos:</h3>";
                            echo "<li><em>Tipo de vivienda:</em> $tipo</li>";
                            echo "<li><em>Localidad:</em> $localidad</li>";
                            echo "<li><em>Habitaciones:</em> $habitacion</li>";
                            echo "<li><em>Precio: </em>" . number_format($precio,0,',','.') . "€</li>";
                            echo "<li><em>Superficie: </em>" . number_format($superficie,0,',','.') . " m²</li>";
                            echo "<li><em>Extras:</em> $extras</li>";
                        echo "</ul>";

                    } else {
                        echo "<span>Lo sentimos, ha ocurrido un error, inténtelo de nuevo<span>";
                    }
                } else {

                    echo "<span>$errores</span>";
                }
            }
        ?>
    </body>
</html>
