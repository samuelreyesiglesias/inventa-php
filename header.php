<?php global $titulo;?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $titulo;?></title> 
  <!--cnd de bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<!--detect active page-->
<?php
function active($current_page){
  $url_array = explode('/', $_SERVER['REQUEST_URI']);
  $url = end($url_array); 
  if($current_page == $url){
      echo " class='active' "; //class name in css
  } 
}
?>
  <div class="container">
    <h1><?php echo $titulo?></h1>
    <nav>
        <ul class="nav nav-pills">
            <li role="presentation"><a href="producto-form.php" <?php active("producto-form.php");?>>Inicio</a></li>
            <li role="presentation"><a href="cliente-form.php" <?php active("cliente-form.php");?>>Clientes</a></li>
            <li role="presentation"><a href="producto-form.php" <?php active("producto-form.php");?>>Productos</a></li>
            <li role="presentation"><a href="venta-form.php" <?php active("venta-form.php");?>>Ventas</a></li>
        </ul>
</nav>

