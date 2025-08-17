<?php
// Permitir solicitudes desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
// Establecer el tipo de contenido a JSON
header("Content-Type: application/json");

// Incluir el archivo de configuración de la base de datos
require_once("../config/database.php");

// Crear una instancia de la base de datos y conectar
$database = new Database();
$db = $database->conectar();

// Consulta SQL para obtener todos los productos ordenados por fecha de creación descendente
$sql = "SELECT * FROM productos ORDER BY creado_en DESC";
$stmt = $db->prepare($sql);
$stmt->execute();

// Obtener todos los resultados como un arreglo asociativo
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificar si hay resultados y devolverlos en formato JSON
if ($resultado) {
    echo json_encode($resultado);
} else {
    // Si no hay productos, devolver un mensaje en formato JSON
    echo json_encode(["mensaje" => "No hay productos"]);
}
?>
