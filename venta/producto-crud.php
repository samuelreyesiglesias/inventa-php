<?php
// Incluye el archivo de conexión
require_once 'conexion.php';

// Función para obtener todos los productos
function obtenerProductos() {
  global $conn;

  $stmt = $conn->prepare("SELECT * FROM Productos");
  $stmt->execute();
  $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $productos;
}

// Función para obtener un producto por su id
function obtenerProductoPorId($id) {
  global $conn;

  $stmt = $conn->prepare("SELECT * FROM Productos WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $producto = $stmt->fetch(PDO::FETCH_ASSOC);

  return $producto;
}

// Función para agregar un nuevo producto
function agregarProducto($nombre, $descripcion, $precio, $categoria, $cantidad) {
  global $conn;

  $stmt = $conn->prepare("INSERT INTO Productos (nombre, descripcion, precio, categoria, cantidad) VALUES (:nombre, :descripcion, :precio, :categoria, :cantidad)");
  $stmt->bindParam(':nombre', $nombre);
  $stmt->bindParam(':descripcion', $descripcion);
  $stmt->bindParam(':precio', $precio);
  $stmt->bindParam(':categoria', $categoria);
  $stmt->bindParam(':cantidad', $cantidad);
  $stmt->execute();

  return $conn->lastInsertId();
}

// Función para actualizar un producto existente
function actualizarProducto($id, $nombre, $descripcion, $precio, $categoria, $cantidad) {
  global $conn;

  $stmt = $conn->prepare("UPDATE Productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, categoria = :categoria, cantidad = :cantidad WHERE id = :id");
  $stmt->bindParam(':nombre', $nombre);
  $stmt->bindParam(':descripcion', $descripcion);
  $stmt->bindParam(':precio', $precio);
  $stmt->bindParam(':categoria', $categoria);
  $stmt->bindParam(':cantidad', $cantidad);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  return $stmt->rowCount();
}

// Función para eliminar un producto existente
function eliminarProducto($id) {
  global $conn;

  $stmt = $conn->prepare("DELETE FROM Productos WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  return $stmt->rowCount();
}
?>