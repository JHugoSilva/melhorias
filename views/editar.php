<?php
require_once '../vendor/autoload.php'; 
use DAO\Area;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Agenda</a>
</nav>
<div class="position-relative" style="margin-top: 20px">
<?php 
if(isset($_POST['desc']) && !empty($_POST['desc'])){
    $areaTarefa = Area::getInstance()->areaTarefaExite($_POST['id_area']);
   if (!$areaTarefa) {
        Area::getInstance()->areaUpdate($_POST['id_area'], $_POST['desc']);
        header('Location:../?p=areas');
   } else {
    echo '<div id="msg" style="margin-left:500px;color:red">Área está vinculada a uma tarefa operação não permitida ;(</div>';
   }   
}
?>
<div class="container">
  <form class="col-sm-12 col-md-6" method="POST">
    <div class="form-row">
      <div class="form-group col-sm-12">
        <div class="form-group">
            <label for="exampleFormControlInput1">Editar Área</label>
            <input type="hidden" name="id_area" value="<?= $_GET['id'] ?>">
            <input type="text" class="form-control" name="desc" value="<?=  $_GET['desc'] ?>">
        </div>
      </div>
    </div>
    <button type="submit" name="btn_update" class="btn btn-success">Editar</button>
    <a type="button" id="btn_cancel" class="btn btn-danger" href="../?p=areas">Voltar</a>
  </form>

</div>
</body>
</html> 
