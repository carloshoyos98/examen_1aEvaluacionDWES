<?php
// conexion a la base de datos

$host = "localhost";
$db_name = "crud_tutorial";
$username = "carlos";
$password = "Carlos_98";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
} catch (PDOException $exception) {
    //Mostrar error
    echo "Connection error: " . $exception->getMessage();
}

?>