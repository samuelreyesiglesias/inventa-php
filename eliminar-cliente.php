<?php
require_once 'cliente-crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  eliminarCliente($_GET['id']);
  // Redirigir a la página principal para mostrar los cambios
  header('Location: index.php');
}
?>