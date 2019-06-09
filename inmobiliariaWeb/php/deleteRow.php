<!DOCTYPE html>
<!--
Elimina un registro referenciado
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inmobiliaria: vivienda eliminada</title>
        <link type="text/css" rel="stylesheet" href="../css/styles.css">
        <link type="text/css" rel="stylesheet" href="../css/eliminar.css">
    </head>
    <body>
        <nav>
            <a href="../index.php">Inicio</a>
        </nav>
        <?php
        include 'usuario.php';
        $referencia = filter_input(INPUT_GET, "opcion", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Elimina la fila referenciada de la bbdd
        try {
            $pdo = new PDO(DSN, USUARIO, CONTRASEÑA);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "DELETE FROM viviendas WHERE viviendas.referencia=$referencia";
            $pdo->query($sql);

        } catch (PDOException $ex) {
            echo '<span>Ocurrió un error al acceder a la base de datos.</span><br>';
            exit;
        }
        ?>
        <div class="delMsg">
            <p>La vivienda con código <?php echo $referencia ?> ha sido eliminada.</p>
        </div>
    </body>
</html>
