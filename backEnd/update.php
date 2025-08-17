<?php
// Permitir solicitudes desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
// Establecer el tipo de contenido como JSON
header("Content-Type: application/json");

// Incluir la configuración de la base de datos
require_once("../config/database.php");

// Obtener los datos enviados en el cuerpo de la solicitud (JSON)
$data = json_decode(file_get_contents("php://input"));

// Verificar que todos los campos requeridos estén presentes
if (!isset($data->id) || !isset($data->nombre) || !isset($data->cantidad) || !isset($data->precio)) {
    echo json_encode(["mensaje" => "Todos los campos son obligatorios"]);
    exit;
}

// Crear una nueva instancia de la base de datos y conectar
$database = new Database();
$db = $database->conectar();

// Preparar la consulta SQL para actualizar el producto
$sql = "UPDATE productos SET nombre = :nombre, cantidad = :cantidad, precio = :precio WHERE id = :id";
$stmt = $db->prepare($sql);

// Asignar los valores a los parámetros de la consulta
$stmt->bindParam(":id", $data->id);
$stmt->bindParam(":nombre", $data->nombre);
$stmt->bindParam(":cantidad", $data->cantidad);
$stmt->bindParam(":precio", $data->precio);

// Ejecutar la consulta y devolver una respuesta en JSON
if ($stmt->execute()) {
    echo json_encode(["mensaje" => "Producto actualizado correctamente"]);
} else {
    echo json_encode(["mensaje" => "No se pudo actualizar el producto"]);
}
?>
