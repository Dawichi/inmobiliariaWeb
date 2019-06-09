<!DOCTYPE html>
<!--
Filtra el listado de viviendas
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inmobiliaria: buscador</title>
        <link type="text/css" rel="stylesheet" href="css/styles.css">
        <link type="text/css" rel="stylesheet" href="css/listado.css">
        <link type="text/css" rel="stylesheet" href="css/buscador.css">
    </head>
    <body>
        <?php include 'nav.html'; ?>
        <div class="buscador">
            <h4>Filtrar viviendas:</h4><hr>
            <form name="buscador" action="#" method="post">
                <label for="tipo_vivienda">Tipo de vivienda: </label>
                <select name="tipo_vivienda">
                    <option value="0">Seleccionar</option>
                    <option value="Chalet">Chalet</option>
                    <option value="Piso">Piso</option>
                </select><br>

                <label for="localidad">Localidad: </label>
                <select name="localidad">
                    <option value="0">Seleccionar</option>
                    <option value="Caldas">Caldas</option>
                    <option value="Cambados">Cambados</option>
                    <option value="Vilagarcía">Vilagarcía</option>
                </select><br><hr>

                <input id="submit" type="submit" name="submit" value="Buscar">
            </form>
        </div>

        <?php
        if (isset($_POST['submit'])) : #endif

            include 'php/usuario.php';

            // Definición de arrays
            $tipos_vivienda = array('0','Chalet', 'Piso');
            $localidades = array('0','Caldas', 'Cambados','Vilagarcía');

            // Recoger en variables el POST
            $tipo = $_POST['tipo_vivienda'];
            $localidad = $_POST['localidad'];

            // Comprueba los filtros vacíos para modificar la consulta
            if ($tipo === "0" AND $localidad === "0") { $opcion = 0; }
            if ($tipo === "0" AND $localidad !== "0") { $opcion = 1; }
            if ($tipo !== "0" AND $localidad === "0") { $opcion = 2; }
            if ($tipo !== "0" AND $localidad !== "0") { $opcion = 3; }

            if (in_array($tipo,$tipos_vivienda) and in_array($localidad,$localidades)) : #endif

                try {
                    $pdo = new PDO(DSN, USUARIO, CONTRASEÑA);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Ejecutar consulta
                    switch ($opcion) {
                        case 0:
                            $sql = "SELECT * FROM viviendas";
                            break;
                        case 1:
                            $sql = "SELECT * FROM viviendas WHERE localidad='$localidad'";
                            break;
                        case 2:
                            $sql = "SELECT * FROM viviendas WHERE tipo='$tipo'";
                            break;
                        case 3:
                            $sql = "SELECT * FROM viviendas WHERE tipo='$tipo' AND localidad='$localidad'";
                            break;
                    }
                    $viviendas = $pdo->query($sql);

                } catch (PDOException $ex) { // Control errores
                    echo '<span>Ocurrió un error al acceder a la base de datos.</span><br>';
                    exit;
                }

                // Cerrar conexión
                $pdo = null;
                ?>
                <div class="table">
                    <h3>Resultados:</h3><hr>
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
                        while ($vivienda = $viviendas->fetch(PDO::FETCH_ASSOC)) : #endwhile
                            ?>
                            <tr>
                                <td> <?php echo $vivienda["referencia"]; ?></td>
                                <td><?php  echo $vivienda["tipo"]; ?></td>
                                <td><?php  echo $vivienda["localidad"]; ?></td>
                                <td><?php  echo $vivienda["habitaciones"]; ?></td>
                                <td><?php  echo number_format($vivienda["precio"], 0, ',', '.'); ?> €</td>
                                <td><?php  echo number_format($vivienda["superficie"], 0, ',', '.'); ?> m²</td>
                                <td><?php  echo $vivienda["extras"]; ?></td>
                                <td>
                                    <a href='php/showimage.php?opcion=<?php  echo $vivienda["referencia"]; ?>'>
                                    <img id='icon' src='imgs/camaraIcon.png'/></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>

            <?php endif; ?>
        <?php endif; ?>
    </body>
</html>
