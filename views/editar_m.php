<?php
require_once '../vendor/autoload.php';
use DAO\Area;
use DAO\Gravidade;
use DAO\Urgencia;
use DAO\Tendencia;
use DAO\Melhoria;
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
  <a class="navbar-brand" href="../index.php">Agenda</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="true" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">   
        <a class="nav-link" href="../?p=areas">Áreas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../?p=tarefas">Tarefas</a>
      </li>
    </ul>
  </div>
</nav>
<div class="position-relative" style="margin-top: 20px">
<?php 
$id = $_GET['id'];

if(empty($id)){
    header('Location:../?p=tarefas');
}

$areas = Area::getInstance()->getAll();
$gravidades = Gravidade::getInstance()->getAll();
$urgencias = Urgencia::getInstance()->getAll();
$tendencias = Tendencia::getInstance()->getAll();
$melhorias = Melhoria::getInstance()->getAll();
$listId = Melhoria::getInstance()->filtrarPorId($id);

function inputs($value){
    if(isset($_POST[$value])){
        echo $_POST[$value];
    }else{
        echo '';
    }
}
function selectId($id, $value=''){
    if($id==$value){
        echo 'selected="selected"';
    }else{
        echo '';
    }
}

if(isset($_POST['btn-cad'])){

    $desc = isset($_POST ["desc"])?$_POST ["desc"]:'';
    $area = isset($_POST ["area"])?$_POST ["area"]:'';
    $data_legal = isset($_POST['data_legal'])?$_POST['data_legal']:'';
    $data_acord = isset($_POST['data_acord'])?$_POST['data_acord']:'';
    $gravidade = isset($_POST['gravidade'])?$_POST['gravidade']:'';
    $urgencia = isset($_POST['urgencia'])?$_POST['urgencia']:'';
    $tendencia = isset($_POST['tendencia'])?$_POST['tendencia']:'';

    if(empty($area)){
        echo '<div id="msgarea" style="margin-left:500px;color:red">* O Campo Área e Obrigátorio</div>';
    }
    
    if(empty($data_legal)){
        echo '<div id="msgdatalegla" style="margin-left:500px;color:red">* O Campo Data Legal e Obrigátorio</div>';
    }
    
    if(empty($gravidade)){
        echo '<div id="gravidade" style="margin-left:500px;color:red">* O Campo Gravidade e Obrigátorio</div>';
    }
    
    if(empty($urgencia)){
        echo '<div id="urgencia" style="margin-left:500px;color:red">* O Campo Urgência e Obrigátorio</div>';
    }
    
    if(empty($tendencia)){
        echo '<div id="tendencia" style="margin-left:500px;color:red">* O Campo Tendência e Obrigátorio</div>';
    }
    
    if(empty($desc)){
        echo '<div id="msgdesc" style="margin-left:500px;color:red">* O Campo Descrição e Obrigátorio</div>';
    }
    
    $data_legalE = explode('-',$data_legal);
    $nowY = date('Y'); 
    $nowM = date('m');
   if(!empty($data_legal) && $data_legalE[0] !== $nowY){
       echo '<div id="datalegal" style="margin-left:500px;color:red">* Ano informado esta inválido informe uma data com o ano corrente!</div>';
   }

   if(!empty($data_legal) && ($data_legalE[1] < $nowM)){
       echo '<div id="datalegal1" style="margin-left:500px;color:red">* O Primeiro Mês não pode ser maior que o ultimo!</div>';
   }
    if(!empty($area) && !empty($data_legal) && !empty($gravidade) && !empty($urgencia) && !empty($tendencia) && !empty($desc) && ($data_legalE[0] == $nowY) && ($data_legalE[1] >= $nowM)){
        Melhoria::getInstance()->atualizarMelhoria($id, $desc, $data_acord, $data_legal, $gravidade, $urgencia, $tendencia, $area);
        header('Location:../?p=tarefas');
    }
}

?>
<div class="container" id="agenda">
  <form  method="POST">
  <div class="form-row">
      <div class="form-group col-sm-12">

        <div class="row">
        <div class="col">
            <label for="area">Área</label>
            <select class="form-control" name="area">
            <option value="0">Selecione</option>
            <?php foreach ($areas as $area) : ?>
                <option value="<?php echo $area->id; ?>" <?php selectId($area->id,$listId->area)?>><?php echo $area->descricao; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="col">
                <label for="data_acord">Data Acordada</label>
                <input type="text" class="form-control" name="data_acord" id="data_acord" value="<?= date('d/m/Y')?>" readonly>
         </div>
         <div class="col">   
                <label for="data_legal">Data Legal</label>
                <input type="date" class="form-control" name="data_legal" value="<?= $listId->prazo_legal?>" id="data_legal">
           </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="mes_inicio">Gravidade</label>
                <select class="form-control" name="gravidade">
                <option value="0">Selecione</option>
                <?php foreach ($gravidades as $gravidade) : ?>
                    <option value="<?= $gravidade->id; ?>" <?php selectId($gravidade->id,$listId->gravidade)?>><?= $gravidade->descricao; ?></option>
                <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <label for="mes_inicio">Urgência</label>
                <select class="form-control" name="urgencia">
                <option value="0">Selecione</option>
                <?php foreach ($urgencias as $urgencia) : ?>
                    <option value="<?= $urgencia->id; ?>" <?php selectId($urgencia->id,$listId->urgencia)?>><?= $urgencia->descricao; ?></option>
                <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <label for="mes_inicio">Tendência</label>
                <select class="form-control" name="tendencia">
                <option value="0">Selecione</option>
                <?php foreach ($tendencias as $tendencia) : ?>
                    <option value="<?= $tendencia->id; ?>" <?php selectId($tendencia->id,$listId->tendencia)?>><?= $tendencia->descricao; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Descrição</label>
            <textarea class="form-control" name="desc" rows="3"><?= $listId->descricao;?></textarea>
        </div>

      </div>
    </div>
    <button type="submit" name="btn-cad" id="btn_buscar" class="btn btn-primary btn-block">Editar</button>
    <a href="../?p=tarefas" name="btn-cad" id="btn_buscar" class="btn btn-danger btn-block">Voltar</a>
  </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    $('#msg').delay(3000).hide(0);
    $('#msg2').delay(3000).hide(0);
    $('#msgarea').delay(3000).hide(0);
    $('#msgdesc').delay(3000).hide(0);
    $('#msgdatalegla').delay(3000).hide(0);
    $('#gravidade').delay(3000).hide(0);
    $('#urgencia').delay(3000).hide(0);
    $('#tendencia').delay(3000).hide(0);
    $('#datalegal').delay(3000).hide(0);
    $('#datalegal1').delay(3000).hide(0);

</script>
  </body>
  </html>