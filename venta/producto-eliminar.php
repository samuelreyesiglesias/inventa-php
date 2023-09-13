<?php
// Incluye el archivo de funciones CRUD y la conexión a la base de datos
require_once 'conexion.php';
 
require_once 'producto-crud.php';

// Obtiene el ID del producto a eliminar de la URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Si no se proporciona un ID válido, redirige al usuario a la página de la tabla de productos
if (!$id) {
  header('Location: productos.php');
  exit;
}

// Conecta a la base de datos

// Prepara la consulta SQL para eliminar el producto correspondiente al ID proporcionado
$stmt = $conn->prepare("DELETE FROM Productos WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

// Redirige al usuario de vuelta a la página de la tabla de productos
header('Location: producto-form.php');
exit;
?>