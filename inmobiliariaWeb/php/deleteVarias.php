<!DOCTYPE html>
<!--
Elimina un registro referenciado
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inmobiliaria: viviendas eliminada</title>
        <link type="text/css" rel="stylesheet" href="../css/styles.css">
        <link type="text/css" rel="stylesheet" href="../css/eliminar.css">
    </head>
    <body>
        <nav>
            <a href="../index.php">Inicio</a>
        </nav>
        <?php
        include 'usuario.php';
        if (isset($_POST['eliminar'])) {
            $referencias = $_POST['eliminar'];
        }

        foreach ($referencias as $referencia) {

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
        }
        ?>
        <div class="delMsg">
            <p>Las viviendas seleccionadas han sido eliminadas.</p>
        </div>
    </body>
</html>
