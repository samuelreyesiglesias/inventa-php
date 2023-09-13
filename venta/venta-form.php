<?php
require_once 'conexion.php';
ini_set ('display_errors', 1);
// Obtener todos los productos del inventario

//crear funcion para obtener inventario
function obtenerInventario() {
  global $conn;
  $stmt = $conn->prepare('SELECT * FROM Inventario INNER JOIN Productos ON Inventario.id_producto = Productos.id');
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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
//obtenerClientes
function obtenerClientes() {
  global $conn;
  $stmt = $conn->prepare('SELECT * FROM Clientes');
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$inventario = obtenerInventario();

// Si se reciben datos del formulario, procesar la venta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $productos_vendidos = array();
  $total = 0;
  foreach ($_POST as $key => $value) {
    if (substr($key, 0, 8) === 'producto') {
      $id_producto = substr($key, 8);
      $cantidad = intval($value);
      if ($cantidad > 0) {
        $producto = obtenerProductoPorId($id_producto);
        $subtotal = $producto['precio'] * $cantidad;
        $total += $subtotal;
        $productos_vendidos[] = array(
          'id_producto' => $id_producto,
          'cantidad' => $cantidad,
          'subtotal' => $subtotal
        );
      }
    }
  }
  if ($total > 0) {
    // Agregar la venta a la tabla de Ventas
    $id_venta = agregarVenta($total);

    // Agregar los productos vendidos a la tabla de Productos_Vendidos
    foreach ($productos_vendidos as $producto_vendido) {
      $id_producto = $producto_vendido['id_producto'];
      $cantidad = $producto_vendido['cantidad'];
      $subtotal = $producto_vendido['subtotal'];
      agregarProductoVendido($id_venta, $id_producto, $cantidad, $subtotal);

      // Actualizar la cantidad disponible en el inventario
      actualizarCantidadDisponible($id_producto, -$cantidad);
    }

    // Redirigir a la página principal para mostrar los cambios
    header('Location: index.php');
  }
}

// Obtener todos los clientes para mostrarlos en el formulario de venta
$clientes = obtenerClientes();
$titulo = 'Nueva venta';
include 'header.php';
?>
 

    <!-- Formulario para agregar productos al carrito -->
    <form method="POST">
      <table class="table table-dark">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad disponible</th>
            <th>Cantidad a comprar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($inventario as $producto): ?>
            <tr> 
              <td><?php echo $producto['nombre'] ?></td>
              <td>$<?php echo number_format($producto['precio'], 2) ?></td>
              <td><?php echo $producto['cantidad_disponible'] ?></td>
              <td class="col-2">
                <input type="number" class="form-control" name="producto<?php echo $producto['id'] ?>" min="0" max="<?php echo $producto['cantidad_disponible'] ?>">
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- Selección de cliente y botón para procesar la venta -->
      <div>
      <div class=row>
      <div class="col-9"> 
        <select class="form-control" name="id_cliente" id="id_cliente" required>
          <option value="">Seleccione un cliente</option>
          <?php foreach ($clientes as $cliente): ?>
            <option value="<?php echo $cliente['id'] ?>"><?php echo $cliente['nombre'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-3">
        <button type="submit" class="btn btn-dark">Comprar</button>
        </div>
        </div>
    </div>
    </form>

    <?php include 'footer.php'; ?>