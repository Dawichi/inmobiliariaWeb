<?php
include 'usuario.php';


$referencia = filter_input(INPUT_GET, "opcion", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Recupera una imagen “png” de una base de datos y la visualiza
try {
    $pdo = new PDO(DSN, USUARIO, CONTRASEÑA);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT foto FROM viviendas WHERE referencia=:referencia";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindValue(':referencia', $referencia);
    $sentencia->execute();

} catch (PDOException $ex) {
    echo '<span>Ocurrió un error al acceder a la base de datos.</span><br>';
    exit;
}

$fila = $sentencia->fetch(PDO::FETCH_ASSOC);

if ($fila) {
    header("Content-type: image/png");
    echo $fila["foto"];
}

?>
