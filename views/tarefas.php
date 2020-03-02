<?php
require_once './vendor/autoload.php'; 
error_reporting(0);
use DAO\Area;
use DAO\Gravidade;
use DAO\Urgencia;
use DAO\Tendencia;
use DAO\Melhoria;

$areas = Area::getInstance()->getAll();
$gravidades = Gravidade::getInstance()->getAll();
$urgencias = Urgencia::getInstance()->getAll();
$tendencias = Tendencia::getInstance()->getAll();
$melhorias = Melhoria::getInstance()->getAll();

function inputs($value){
    if(isset($_POST[$value])){
        echo $_POST[$value];
    }else{
        echo '';
    }
}
function select($id, $value=''){
    if($id==$_POST[$value]){
        echo 'selected="selected"';
    }else{
        echo '';
    }
}

function limitarTexto($texto, $limite){
    if(strlen($texto) > 15){
        $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '...';
    }
    return $texto;
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
        Melhoria::getInstance()->inserirMelhoria($desc, $dateImplo, $data_legal, $gravidade, $urgencia, $tendencia, $area);
        header('Location:?p=tarefas');
    }
}

if(isset($_GET['d']) && !empty($_GET['d']) && !is_null($_GET['d'])){
    Melhoria::getInstance()->excluirMelhorias($_GET['d']);
    header('Location:?p=tarefas');
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
                <option value="<?php echo $area->id; ?>" <?php select($area->id,'area')?>><?php echo $area->descricao; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="col">
                <label for="data_acord">Data Acordada</label>
                <input type="text" class="form-control" name="data_acord" id="data_acord" value="<?= date('d/m/Y')?>" readonly>
         </div>
         <div class="col">   
                <label for="data_legal">Data Legal</label>
                <input type="date" class="form-control" name="data_legal" value="<?= inputs('data_legal')?>" id="data_legal">
           </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="mes_inicio">Gravidade</label>
                <select class="form-control" name="gravidade">
                <option value="0">Selecione</option>
                <?php foreach ($gravidades as $gravidade) : ?>
                    <option value="<?= $gravidade->id; ?>" <?php select($gravidade->id,'gravidade')?>><?= $gravidade->descricao; ?></option>
                <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <label for="mes_inicio">Urgência</label>
                <select class="form-control" name="urgencia">
                <option value="0">Selecione</option>
                <?php foreach ($urgencias as $urgencia) : ?>
                    <option value="<?= $urgencia->id; ?>" <?php select($urgencia->id,'urgencia')?>><?= $urgencia->descricao; ?></option>
                <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <label for="mes_inicio">Tendência</label>
                <select class="form-control" name="tendencia">
                <option value="0">Selecione</option>
                <?php foreach ($tendencias as $tendencia) : ?>
                    <option value="<?= $tendencia->id; ?>" <?php select($tendencia->id,'tendencia')?>><?= $tendencia->descricao; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Descrição</label>
            <textarea class="form-control" name="desc" rows="3"><?= inputs('desc')?></textarea>
        </div>

      </div>
    </div>
    <button type="submit" name="btn-cad" id="btn_buscar" class="btn btn-primary btn-block">Cadastrar</button>
  </form>
  <div style="margin-top:70px;"></div>
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th>COD</th>
      <th>DESCRIÇÃO</th>
      <th>AÇÕES</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($melhorias as $melhoria):?>
    <tr>
      <th scope="row"><?= $melhoria->id?></th>
      <td class="aling-itens"><?=  limitarTexto($melhoria->descricao,60) ?></td>
      <td>
        <a type="button" class="btn btn-primary" href="views/editar_m.php?id=<?= $melhoria->id ?>">Editar</a>
        <a type="button" class="btn btn-danger" href="?p=tarefas&d=<?= $melhoria->id ?>">Excluir</a>
      </td>
    </tr>
  <?php endforeach;?>
  </tbody>
</table>
</div>