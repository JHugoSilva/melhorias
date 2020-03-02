<?php

use DAO\Area;

$areas = Area::getInstance()->order('descricao')->getAll();
$meses = [];

for($m = 1; $m <= 12; $m++) {
  $meses[] = (object)[
    'id'         => $m,
    'descricao'  => date('F', mktime(0, 0, 0, $m)),
  ];
}

?>
<div class="container" id="agenda">
  <form class="col-sm-12 col-md-6">
    <div class="form-row">
      <div class="form-group col-sm-12">
        <label for="area">Áreas</label>
        <select class="form-control" id="area">
          <option value="0">Selecione</option>
        <?php foreach ($areas as $area) : ?>
          <option value="<?php echo $area->id; ?>"><?php echo $area->descricao; ?></option>
        <?php endforeach; ?>
        </select>
        <small id="areaHelp" class="form-text text-muted">Area de negócio da tarefa.</small>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-sm-12 col-md-5">
        <label for="mes_inicio">Período</label>
        <select class="form-control" id="mes_inicio">
          <option value="0">Selecione</option>
          <?php foreach ($meses as $mes) : ?>
            <option value="<?php echo $mes->id; ?>"><?php echo $mes->descricao; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group col-sm-12 col-md-2">
        <div>&nbsp;</div>
        <div class="separador-texto-combos">à</div>
      </div>
      <div class="form-group col-sm-12 col-md-5">
        <label for="mes_fim">&nbsp;</label>
        <select class="form-control" id="mes_fim">
          <option value="0">Selecione</option>
          <?php foreach ($meses as $mes) : ?>
            <option value="<?php echo $mes->id; ?>"><?php echo $mes->descricao; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <button type="button" id="btn_buscar" class="btn btn-primary">Buscar</button>
    <span><font color="red" id="erro"></font></span>
  </form>
</div>
<script type="text/javascript">
  document.querySelector('#btn_buscar').addEventListener('click', function(ev) {

    var form        = document.querySelector('form');
    var fields      = form.elements;
    var qryString   = '?path=agenda';
    var filtroMeses = [];

    if(document.querySelector('#mes_inicio').value > 0 && document.querySelector('#mes_inicio').value > 0){ 
      let mes1 = document.querySelector('#mes_inicio').value
      let mes2 = document.querySelector('#mes_fim').value
        if(mes2 <= mes1 ){
          erro.innerHTML = '<br><b>O primeiro mês não pode ser maior ou igual ao último ;(</b>';
          return false;
      }
    }
    
    for(let field of fields) {

      if(field.value > 0) {

        switch(field.id) {
          case 'area':

            qryString += '&';
            qryString += field.id;
            qryString += '=';
            qryString += field.value;
            break;

          case 'mes_inicio':
          case 'mes_fim':
            filtroMeses.push(field.value);
            break;
        }
      }
    }

    if(filtroMeses.length > 0) {
      qryString += '&meses='
      qryString += filtroMeses.join('-');
    }

    location.href = qryString;
  })
</script>
