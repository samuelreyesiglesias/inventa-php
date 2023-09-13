<?php
require_once 'conexion.php';

// Agregar una nueva venta y obtener su ID
function agregarVenta($total) {
  $conexion = conectar();
  $stmt = $conexion->prepare('INSERT INTO Ventas (fecha_venta, id_cliente, total) VALUES (?, ?, ?)');
  $stmt->bind_param('sid', $fecha_venta, $id_cliente, $total);
  $fecha_venta = date('Y-m-d');
  $id_cliente = $_POST['id_cliente'];
  $stmt->execute();
  $id_venta = $stmt->insert_id;
  $stmt->close();
  $conexion->close();
  return $id_venta;
}

// Agregar un producto vendido a la tabla de Productos_Vendidos
function agregarProductoVendido($id_venta, $id_producto, $cantidad, $subtotal) {
  $conexion = conectar();
  $stmt = $conexion->prepare('INSERT INTO Productos_Vendidos (id_venta, id_producto, cantidad, subtotal) VALUES (?, ?, ?, ?)');
  $stmt->bind_param('iiid', $id_venta, $id_producto, $cantidad, $subtotal);
  $stmt->execute();
  $stmt->close();
  $conexion->close();
}

// Actualizar la cantidad disponible de un producto en el inventario
function actualizarCantidadDisponible($id_producto, $cantidad) {
  $conexion = conectar();
  $stmt = $conexion->prepare('UPDATE Inventario SET cantidad_disponible = cantidad_disponible + ? WHERE id_producto = ?');
  $stmt->bind_param('ii', $cantidad, $id_producto);
  $stmt->execute();
  $stmt->close();
  $conexion->close();
}

// Obtener todos los productos vendidos de una venta por su ID
function obtenerProductosVendidosPorIdVenta($id_venta) {
  $conexion = conectar();
  $stmt = $conexion->prepare('SELECT p.nombre AS nombre_producto, pv.cantidad, pv.subtotal FROM Productos_Vendidos pv INNER JOIN Productos p ON pv.id_producto = p.id WHERE pv.id_venta = ?');
  $stmt->bind_param('i', $id_venta);
  $stmt->execute();
  $stmt->bind_result($nombre_producto, $cantidad, $subtotal);
  $productos_vendidos = array();
  while ($stmt->fetch()) {
    $productos_vendidos[] = array(
      'nombre_producto' => $nombre_producto,
      'cantidad' => $cantidad,
      'subtotal' => $subtotal
    );
  }
  $stmt->close();
  $conexion->close();
  return $productos_vendidos;
}

// Obtener todas las ventas
function obtenerVentas() {
  $conexion = conectar();
  $stmt = $conexion->prepare('SELECT v.id, v.fecha_venta, c.nombre AS nombre_cliente, v.total FROM Ventas v INNER JOIN Clientes c ON v.id_cliente = c.id ORDER BY v.fecha_venta DESC');
  $stmt->execute();
  $stmt->bind_result($id_venta, $fecha_venta, $nombre_cliente, $total);
  $ventas = array();
  while ($stmt->fetch()) {
    $ventas[] = array(
      'id_venta' => $id_venta,
      'fecha_venta' => $fecha_venta,
      'nombre_cliente' => $nombre_cliente,
      'total' => $total
    );
  }
  $stmt->close();
  $conexion->close();
  return $ventas;
}

?>