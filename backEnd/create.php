<?php
// Permitir solicitudes desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
// Establecer el tipo de contenido como JSON
header("Content-Type: application/json");

// Incluir el archivo de configuración de la base de datos
require_once("../config/database.php");

// Obtener los datos enviados en el cuerpo de la solicitud (JSON)
$data = json_decode(file_get_contents("php://input"));

// Verificar que los campos requeridos estén presentes
if (!isset($data->nombre) || !isset($data->cantidad) || !isset($data->precio)) {
    echo json_encode(["mensaje" => "Faltan campos requeridos"]);
    exit;
}

// Crear una instancia de la base de datos y conectar
$database = new Database();
$db = $database->conectar();

// Preparar la consulta SQL para insertar un nuevo producto
$sql = "INSERT INTO productos (nombre, cantidad, precio) VALUES (:nombre, :cantidad, :precio)";
$stmt = $db->prepare($sql);

// Asignar los valores a los parámetros de la consulta
$stmt->bindParam(":nombre", $data->nombre);
$stmt->bindParam(":cantidad", $data->cantidad);
$stmt->bindParam(":precio", $data->precio);

// Ejecutar la consulta y devolver una respuesta en JSON
if ($stmt->execute()) {
    echo json_encode(["mensaje" => "Producto creado con éxito"]);
} else {
    echo json_encode(["mensaje" => "No se pudo crear el producto"]);
}
?>
