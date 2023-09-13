<?php
// Incluye el archivo de funciones CRUD
require_once 'producto-crud.php';

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtiene los datos del formulario
  $id = isset($_POST['id']) ? $_POST['id'] : '';
  $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
  $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
  $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
  $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
  $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';

  // Determina si se está agregando o actualizando un producto
  if (empty($id)) {
    $producto_id = agregarProducto($nombre, $descripcion, $precio, $categoria, $cantidad);
  } else {
    $producto_id = actualizarProducto($id, $nombre, $descripcion, $precio, $categoria, $cantidad);
  }

  // Redirige al listado de productos
  header('Location: producto-form.php');
  exit;
}

// Verifica si se ha recibido el id de un producto para actualizar
if (isset($_GET['id'])) {
  $producto = obtenerProductoPorId($_GET['id']);
}
?>

<?php
$titulo =  isset($producto) ? 'Actualizar' : 'Agregar';
include_once "header.php";?>
  <div class="table"> 
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
  <?php if (isset($producto)): ?>
    <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">
  <?php endif; ?>

  <div class="form-group">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo isset($producto) ? $producto['nombre'] : '' ?>" class="form-control" required>
  </div>

  <div class="form-group">
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" class="form-control"><?php echo isset($producto) ? $producto['descripcion'] : '' ?></textarea>
  </div>

  <div class="form-group">
    <label for="precio">Precio:</label>
    <input type="number" name="precio" step="0.01" min="0" value="<?php echo isset($producto) ? $producto['precio'] : '' ?>" class="form-control" required>
  </div>

  <div class="form-group">
    <label for="categoria">Categoría:</label>
    <input type="text" name="categoria" value="<?php echo isset($producto) ? $producto['categoria'] : '' ?>" class="form-control">
  </div>

  <div class="form-group">
    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" min="0" value="<?php echo isset($producto) ? $producto['cantidad'] : '' ?>" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-primary"><?php echo isset($producto) ? 'Actualizar' : 'Agregar' ?></button>
</form>
  </div>

<br>
<table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Categoría</th>
          <th>Cantidad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
         $productos = obtenerProductos();
        foreach ($productos as $producto): ?>
          <tr>
            <td><?php echo $producto['id'] ?></td>
            <td><?php echo $producto['nombre'] ?></td>
            <td><?php echo $producto['descripcion'] ?></td>
            <td><?php echo $producto['precio'] ?></td>
            <td><?php echo $producto['categoria'] ?></td>
            <td><?php echo $producto['cantidad'] ?></td>
            <td>
              <a href="producto-form.php?id=<?php echo $producto['id'] ?>" class="btn btn-primary">Editar</a>
              <a href="producto-eliminar.php?id=<?php echo $producto['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</body>
</html> 
  
<?php include_once "./footer.php"; ?>
<?php include_once "./footer.php"; ?>