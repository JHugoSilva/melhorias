<?php 
use DAO\Area;

/**CARREGA A LIST */
if(!empty($_GET['p'])){
    $areasDB = Area::getInstance()->getAll();
}
/**REALIZA O INSERT */
if(isset($_POST['area']) && !empty($_POST['area'])){
    $area = trim(strip_tags($_POST['area']));
    /**
     * VERIFICA SE JA EXISTE AREA CADASTRADA 
     * OBS: AS INFORMAÇÕES DEVEM SER IDENTICAS PARA DAR MATCH
     */
    $areaEx = Area::getInstance()->areaExist(ucfirst($area));
    if(!$areaEx){
        Area::getInstance()->insert($_POST['area']);
        header('Location:?p=areas');
    }else{
        echo '<div id="msg" style="margin-left:500px;color:red">Área já cadastrada operação não permitida ;(</div>';
    }
}else{
    if(isset($_POST['btn-cad'])){
        echo '<div id="msg" style="margin-left:500px;color:red">Campo Cadastrar uma Nova Area e Obrigatório</div>';
    }
}

if(isset($_GET['d']) && !empty($_GET['d']) && !is_null($_GET['d'])){
    $areaTarefa = Area::getInstance()->areaTarefaExite($_GET['d']);
    if(!$areaTarefa){
        Area::getInstance()->areaDelete($_GET['d']);
        header('Location:?p=areas');
    }else{
        echo '<div id="msg2" style="margin-left:500px;color:red">A área está vinculada a uma tarefa operação não permitida ;(</div>';
    }
}

function inputs($value){
  if(isset($_POST[$value])){
      echo $_POST[$value];
  }else{
      echo '';
  }
}
?>
<div class="container" id="agenda">
  <form class="col-sm-12 col-md-6" method="POST">
    <div class="form-row">
      <div class="form-group col-sm-12">
        <div class="form-group">
            <label for="exampleFormControlInput1">Cadastrar uma Nova Area</label>
            <input type="text" class="form-control" name="area" value="<?= inputs('area')?>" id="area" placeholder="Informe a área desejada">
        </div>
      </div>
    </div>
    <button type="submit" name="btn-cad" id="btn_buscar" class="btn btn-primary">Cadastrar</button>
  </form>
<div style="margin-top:100px;"></div>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th>COD</th>
      <th>DESCRIÇÃO</th>
      <th>AÇÕES</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($areasDB as $area):?>
    <tr>
      <th scope="row"><?= $area->id?></th>
      <td class="aling-itens"><?= $area->descricao ?></td>
      <td>
        <a type="button" class="btn btn-primary" href="views/editar.php?id=<?= $area->id ?>&desc=<?= $area->descricao ?>">Editar</a>
        <a type="button" class="btn btn-danger" href="?p=areas&d=<?= $area->id ?>">Excluir</a>
      </td>
    </tr>
  <?php endforeach;?>
  </tbody>
</table>
</div>