<?php
// Permitir solicitudes desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
// Establecer el tipo de contenido como JSON
header("Content-Type: application/json");

// Incluir la configuración de la base de datos
require_once("../config/database.php");

// Obtener los datos enviados en el cuerpo de la solicitud y decodificarlos desde JSON
$data = json_decode(json: file_get_contents("php://input"));

// Verificar si se recibió el ID del producto
if (!isset($data->id)) {
    echo json_encode(["mensaje" => "Falta el ID del producto"]);
    exit;
}

// Crear una instancia de la base de datos y conectar
$database = new Database();
$db = $database->conectar();

// Preparar la consulta SQL para eliminar el producto por ID
$sql = "DELETE FROM productos WHERE id = :id";
$stmt = $db->prepare($sql);
// Asignar el valor del ID al parámetro de la consulta
$stmt->bindParam(":id", $data->id);

// Ejecutar la consulta y devolver el resultado en formato JSON
if ($stmt->execute()) {
    echo json_encode(["mensaje" => "Producto eliminado correctamente"]);
} else {
    echo json_encode(["mensaje" => "No se pudo eliminar el producto"]);
}
?>
