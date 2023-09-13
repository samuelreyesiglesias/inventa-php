<?php
require_once 'conexion.php';

// Obtener todos los clientes
function obtenerClientes() {
  global $conn;
  $stmt = $conn->prepare('SELECT * FROM Clientes');
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener un cliente por su ID
function obtenerClientePorId($id) {
  global $conn;
  $stmt = $conn->prepare('SELECT * FROM Clientes WHERE id = :id');
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Agregar un nuevo cliente
function agregarCliente($cliente) {
  global $conn;
  $stmt = $conn->prepare('INSERT INTO Clientes (nombre, direccion, correo_electronico, numero_telefono, historial_compras) VALUES (:nombre, :direccion, :correo_electronico, :numero_telefono, :historial_compras)');
  $stmt->bindParam(':nombre', $cliente['nombre']);
  $stmt->bindParam(':direccion', $cliente['direccion']);
  $stmt->bindParam(':correo_electronico', $cliente['correo_electronico']);
  $stmt->bindParam(':numero_telefono', $cliente['numero_telefono']);
  $stmt->bindParam(':historial_compras', $cliente['historial_compras']);
  $stmt->execute();
}

// Actualizar los datos de un cliente existente
function actualizarCliente($cliente) {
  global $conn;
  $stmt = $conn->prepare('UPDATE Clientes SET nombre = :nombre, direccion = :direccion, correo_electronico = :correo_electronico, numero_telefono = :numero_telefono, historial_compras = :historial_compras WHERE id = :id');
  $stmt->bindParam(':nombre', $cliente['nombre']);
  $stmt->bindParam(':direccion', $cliente['direccion']);
  $stmt->bindParam(':correo_electronico', $cliente['correo_electronico']);
  $stmt->bindParam(':numero_telefono', $cliente['numero_telefono']);
  $stmt->bindParam(':historial_compras', $cliente['historial_compras']);
  $stmt->bindParam(':id', $cliente['id']);
  $stmt->execute();
}

// Eliminar un cliente existente
function eliminarCliente($id) {
  global $conn;
  $stmt = $conn->prepare('DELETE FROM Clientes WHERE id = :id');
  $stmt->bindParam(':id', $id);
  $stmt->execute();
}
?>