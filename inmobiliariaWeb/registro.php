<!DOCTYPE html>
<!--
Aplicación Web de una inmobiliaria en la que se registran viviendas con distintos datos y fotografías
Se genera una página con los datos que se acaban de cargar y un enlace a la imagen
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inmobiliaria: Registro</title>
        <link type="text/css" rel="stylesheet" href="css/styles.css">
        <link type="text/css" rel="stylesheet" href="css/registro.css">
    </head>
    <body>
        <?php include 'nav.html'; ?>
        <div class="form">
            <h3>Registrar una vivienda:</h3><hr>
            <form name="inmobiliaria" action="php/registrar.php" method="post" enctype="multipart/form-data">

                <label for="tipo_vivienda">Tipo de vivienda:</label>
                <select name="tipo_vivienda" size="1">
                    <option>Seleccionar</option>
                    <option value="Chalet">Chalet</option>
                    <option value="Piso">Piso</option>
                </select><br>

                <label for="localidad">Localidad:</label>
                <select name="localidad">
                    <option>Seleccionar</option>
                    <option value="Caldas">Caldas</option>
                    <option value="Cambados">Cambados</option>
                    <option value="Vilagarcía">Vilagarcía</option>
                </select><br>

                <label for="habitaciones">Habitaciones:</label>
                <input type="radio" name="habitaciones" value="1" checked>1
                <input type="radio" name="habitaciones" value="2">2
                <input type="radio" name="habitaciones" value="3">3
                <input type="radio" name="habitaciones" value="4">4
                <input type="radio" name="habitaciones" value="5">5<br>

                <label for="precio">Precio (€):</label>
                <input type="text" name="precio" required size="5" maxlength="8"><br>

                <label for="superficie">Superficie (m²):</label>
                <input type="text" name="superficie" required size="3" maxlength="5"><br>

                <label for="extras[]">Extras:</label>
                <input type="checkbox" name="extras[]" value="Garaje">Garaje
                <input type="checkbox" name="extras[]" value="Jardín">Jardín
                <input type="checkbox" name="extras[]" value="Piscina">Piscina<br>

                <label for="fichero">Foto:</label>
                <input id="choseFile" type="file" name="fichero" accept="image/png"><br><hr>

                <label for="submit">Subir los datos:</label>
                <input type="submit" name="submit" value="Cargar"><br>
            </form>
        </div>
    </body>
</html>
