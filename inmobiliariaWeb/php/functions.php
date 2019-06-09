<?
// Sanitización de datos (Data Sanitization)
// Recibe un string, devuelve el texto sanitizado
function filtrado($datos){
    $datos = trim($datos); // Elimina espacios antes y después
    $datos = stripslashes($datos); // Elimina backslashes \
    $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
    return $datos;
}

// Valida que un archivo dado sea menor que el tamaño tope
// Devuelve true si $dato tiene menos bits de los indicados en $tope
function validar_size($archivo, $tope){
    if ($archivo <= $tope) {
        return true;
    } else {
        return false;
    }
}

// Valida que el archivo pasado como parámetro sea una imagen PNG
// Devuelve true si el archivo es tipo image/png
function validar_png($archivo){
    if ($_FILES['fichero']['type'] == "image/png") {
        return true;
    } else {
        return false;
    }
}

// Devuelve listado el contenido de un array recibido como parámetro
// Imprime los values del mismo seguidos de una coma
function print_array($ar_name){
    $resultado = "";
    foreach ($ar_name as $key => $value) {
        $resultado .= $value . ",";

    }
    return $resultado;
}
?>
