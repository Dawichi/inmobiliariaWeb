<!DOCTYPE html>
<!--
Actualiza el precio de un registro
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inmobiliaria: actualizar precio</title>
        <link type="text/css" rel="stylesheet" href="../css/styles.css">
        <link type="text/css" rel="stylesheet" href="../css/registro.css">
    </head>
    <body>
        <nav>
            <a href="../index.php">Inicio</a>
        </nav>
        <?php

        include 'usuario.php';
        $referencia = filter_input(INPUT_GET, "opcion", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (isset($_POST['submit'])) {

            $errores = "";

            if (empty($_POST["precio"])) { //Precio vacío
                $errores .= "Precio es requerido<br>";
            }

            if (!is_numeric($_POST['precio'])) { //Precio no numérico
                $errores .= "Precio debe ser un número<br>";
            }

            if (empty($errores)) {

                $precio = $_POST['precio'];
                try {
                    $pdo = new PDO(DSN, USUARIO, CONTRASEÑA);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Ejecutar consulta
                    $sql = "UPDATE viviendas SET precio = $precio WHERE viviendas.referencia = $referencia";
                    $pdo->query($sql);

                } catch (PDOException $ex) { // Control errores
                    echo '<span>Ocurrió un error al acceder a la base de datos.</span><br>';
                    exit;
                }

                // Cerrar conexión
                $pdo = null;

            } else {
                echo "<span>$errores</span>";
            }
        }

        if (isset($referencia)) :

            try {
                $pdo = new PDO(DSN, USUARIO, CONTRASEÑA);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Ejecutar consulta
                $sql = "SELECT * FROM viviendas WHERE referencia=$referencia";
                $viviendas = $pdo->query($sql);

            } catch (PDOException $ex) { // Control errores
                echo '<span>Ocurrió un error al acceder a la base de datos.</span><br>';
                exit;
            }

            // Cerrar conexión
            $pdo = null;

            while ($vivienda = $viviendas->fetch(PDO::FETCH_ASSOC)) : ?>
            <div class="form">
                <h3>Modificar precio:</h3><hr>
                <form name="actualización" action="#" method="post">
                    <label for="tipo_vivienda">Tipo de vivienda:</label>
                    <input type="text" name="tipo_vivienda" readonly value="<?php echo $vivienda['tipo']; ?>"><br>

                    <label for="localidad">Localidad:</label>
                    <input type="text" name="localidad" readonly value="<?php echo $vivienda['localidad']; ?>"><br>


                    <label for="habitaciones">Habitaciones:</label>
                    <input type="text" name="habitaciones" readonly value="<?php echo $vivienda['habitaciones']; ?>"><br>

                    <label for="precio">Precio (€):</label>
                    <input type="text" name="precio" required size="5" value="<?php echo $vivienda['precio']; ?>"><br>

                    <label for="superficie">Superficie (m²):</label>
                    <input type="text" name="superficie" readonly value="<?php echo $vivienda['superficie']; ?>"><br>

                    <label for="extras">Extras:</label>
                    <input type="text" name="extras" readonly value="<?php echo $vivienda['extras']; ?>"><br><hr>

                    <label for="submit">Actualizar precio:</label>
                    <input type="submit" name="submit" value="Actualizar"><br>
                    <?php
                    if (isset($_POST['submit'])) {
                        echo "El precio ha sido actualizado correctamente";
                    }
                    ?>
                </form>
            </div>
            <?php
            endwhile;
        endif;
        ?>
    </body>
</html>
