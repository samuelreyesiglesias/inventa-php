<?php
require_once 'cliente-crud.php';

// Obtener todos los clientes
$clientes = obtenerClientes();

// Si se reciben datos del formulario, procesar solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id'])) {
    actualizarCliente($_POST);
  } else {
    agregarCliente($_POST);
  }
  // Redirigir a la página principal para mostrar los cambios
  header('Location: cliente-form.php');
}

// Si se proporciona un ID en la URL, obtener los datos del cliente correspondiente
if (isset($_GET['id'])) {
  $cliente = obtenerClientePorId($_GET['id']);
}

?>

<?php 
$titulo = isset($cliente) ? 'Actualizar' : 'Agregar';
include_once "header.php"; ?>
    <!-- Formulario para agregar o actualizar clientes -->
    <form method="POST">
      <?php if (isset($cliente)): ?>
        <input type="hidden" name="id" value="<?php echo $cliente['id'] ?>">
      <?php endif; ?>
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php if (isset($cliente)) echo $cliente['nombre'] ?>">
      </div>
      <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input type="text" class="form-control" name="direccion" id="direccion" value="<?php if (isset($cliente)) echo $cliente['direccion'] ?>">
      </div>
      <div class="form-group">
        <label for="correo_electronico">Correo electrónico:</label>
        <input type="email" class="form-control" name="correo_electronico" id="correo_electronico" value="<?php if (isset($cliente)) echo $cliente['correo_electronico'] ?>">
      </div>
      <div class="form-group">
        <label for="numero_telefono">Número de teléfono:</label>
        <input type="tel" class="form-control" name="numero_telefono" id="numero_telefono" value="<?php if (isset($cliente)) echo $cliente['numero_telefono'] ?>">
      </div>
      <div class="form-group">
        <label for="historial_compras">Historial de compras:</label>
        <textarea class="form-control" name="historial_compras" id="historial_compras"><?php if (isset($cliente)) echo $cliente['historial_compras'] ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary"><?php if (isset($cliente)) echo 'Actualizar'; else echo 'Agregar' ?></button>
    </form>

    <!-- Tabla con todos los clientes -->
    <table class="table mt-4">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Dirección</th>
          <th>Correo electrónico</th>
          <th>Número de teléfono</th>
          <th>Historial de compras</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clientes as $cliente): ?>
          <tr>
            <td><?php echo $cliente['id'] ?></td>
            <td><?php echo $cliente['nombre'] ?></td>
            <td><?php echo $cliente['direccion'] ?></td>
            <td><?php echo $cliente['correo_electronico'] ?></td>
            <td><?php echo $cliente['numero_telefono'] ?></td>
            <td><?php echo $cliente['historial_compras'] ?></td>
            <td>
              <a href="cliente-form.php?id=<?php echo $cliente['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="eliminar-cliente.php?id=<?php echo $cliente['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro que desea eliminar este cliente?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
<?php include_once "./footer.php"; ?>