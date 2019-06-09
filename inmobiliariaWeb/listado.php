<!DOCTYPE html>
<!--
Permite actualizar el precio de las viviendas de la bbdd
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inmobiliaria: listado</title>
        <link type="text/css" rel="stylesheet" href="css/styles.css">
        <link type="text/css" rel="stylesheet" href="css/listado.css">
    </head>
    <body>
        <?php include 'nav.html'; ?>
        <?php
        include 'php/usuario.php';

        try {
            $pdo = new PDO(DSN, USUARIO, CONTRASEÑA);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Ejecutar consulta
            $sql = "SELECT * FROM viviendas";
            $viviendas = $pdo->query($sql);

        } catch (PDOException $ex) { // Control errores
            echo '<span>Ocurrió un error al acceder a la base de datos.</span><br>';
            exit;
        }

        // Cerrar conexión
        $pdo = null;

        ?>
        <div class="table">
            <h3>Listado de viviendas registradas:</h3><hr>
            <table>
                <tr>
                    <th>Referencia</th>
                    <th>Tipo</th>
                    <th>Localidad</th>
                    <th>Habitaciones</th>
                    <th>Precio</th>
                    <th>Superficie</th>
                    <th>Extras</th>
                    <th>Foto</th>
                </tr>
                <?php
                while ($vivienda = $viviendas->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?php echo $vivienda["referencia"]; ?></td>
                        <td><?php echo $vivienda["tipo"]; ?></td>
                        <td><?php echo $vivienda["localidad"]; ?></td>
                        <td><?php echo $vivienda["habitaciones"]; ?></td>
                        <td><?php echo number_format($vivienda["precio"], 0, ',', '.'); ?> €</td>
                        <td><?php echo number_format($vivienda["superficie"], 0, ',', '.'); ?> m²</td>
                        <td><?php echo $vivienda["extras"]; ?></td>
                        <td>
                            <a href='php/showimage.php?opcion=<?php echo $vivienda["referencia"]; ?>'>
                                <img id='icon' src='imgs/camaraIcon.png'/>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </body>
</html>
