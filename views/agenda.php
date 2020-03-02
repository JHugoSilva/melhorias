<?php

use DAO\Area;
use DAO\Urgencia;
use DAO\Gravidade;
use DAO\Tendencia;
use DAO\Melhoria;

$mInicial = 1;
$mFinal   = 12;

if(!empty($_GET['meses'])) {
  if(strpos($_GET['meses'], '-') !== false ) {
    list($mInicial, $mFinal) = explode('-', $_GET['meses']);
  } else {
    $mInicial = $mFinal = $_GET['meses'];
  }
}

if(!empty($_GET['area'])) {
  $areas[] = Area::getInstance()->filtrarPorId($_GET['area']);
} else {
  $areas = Area::getInstance()->getAll();
}

$gravidadesAll = Gravidade::getInstance()->order('id')->getAll();
$urgenciasAll  = Urgencia::getInstance()->order('id')->getAll();
$tendenciasAll = Tendencia::getInstance()->order('id')->getAll();

$urgencias = Urgencia::getInstance()->order('id', 'desc')->getAll(3);
$melhoriasAgenda = Melhoria::getInstance()
    ->order('prazo_legal')
    ->order('prazo_acordado')
    ->order('gut', 'desc')
    ->order('id')
    ->filtrarPorUrgencia([0,1,2,3,4], ['*', '(coalesce(gravidade, 1) * coalesce(urgencia, 1) * coalesce(tendencia, 1)) as gut']);

$melhorias = [];

foreach($melhoriasAgenda as $melhoriaAgenda) {

    $prazoLegal = '';
    if (!empty($melhoriaAgenda->prazo_legal)) {
      list($anoPrazoLegal, $mesPrazoLegal, $diaPrazoLegal) = explode('-', $melhoriaAgenda->prazo_legal);
      $prazoLegal = date('d/m/Y', mktime(0,0,0, $mesPrazoLegal, $diaPrazoLegal, $anoPrazoLegal));
    }

    $prazoAcordado = '';
    if (!empty($melhoriaAgenda->prazo_acordado)) {
      list($anoPrazoAcordado, $mesPrazoAcordado, $diaPrazoAcordado) = explode('-', $melhoriaAgenda->prazo_acordado);
      $prazoAcordado = date('d/m/Y', mktime(0,0,0, $mesPrazoAcordado, $diaPrazoAcordado, $anoPrazoAcordado));
    }

    $mesEntregaMelhoria = preg_replace('/\d{4}-(\d{2})-\d{2}/', "$1", $melhoriaAgenda->prazo_legal);

    if(empty($mesEntregaMelhoria)) {
      $mesEntregaMelhoria = preg_replace('/\d{4}-(\d{2})-\d{2}/', "$1", $melhoriaAgenda->prazo_acordado);
    }
    $mesEntregaMelhoria = (int)$mesEntregaMelhoria;

    $melhoriaAgenda->title      = preg_replace('/([^ ]+ +[^ ]+ +[^ ]+ +).*/', "$1", $melhoriaAgenda->tarefa);
    $melhoriaAgenda->entrega_em = $mesEntregaMelhoria;
    $melhoriaAgenda->prazoLegal    = $prazoLegal;
    $melhoriaAgenda->prazoAcordado = $prazoAcordado;

    $melhorias[$melhoriaAgenda->area][$mesEntregaMelhoria][$melhoriaAgenda->urgencia][] = $melhoriaAgenda;
}
?>
<div class="container-fluid">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><a href="?path=agenda">#Áreas</a></th>
      <?php for($m = $mInicial; $m <= $mFinal; $m++) : ?>
        <th scope="col"><a href="?path=agenda&meses=<?php echo $m; ?>"><?php echo date("F", mktime(0, 0, 0, $m)); ?></a></th>
      <?php endfor; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach($areas as $area) : ?>
      <tr>
        <th scope="row"><a href="?path=agenda&area=<?php echo $area->id; ?>"><?php echo $area->descricao; ?></a></th>
        <?php for($m = $mInicial; $m <= $mFinal; $m++) : ?>
          <td>
            <table id="melhorias" class="table">
              <thead>
              </thead>
              <tbody>
                    <tr>
                        <?php foreach($urgencias as $urgencia) : ?>
                    <?php $melhoriasEncontradas = !empty($melhorias[$area->id][$m][$urgencia->id]) ? $melhorias[$area->id][$m][$urgencia->id] : null; ?>
                    <?php if(!empty($melhoriasEncontradas)) : ?>
                      <?php foreach($melhoriasEncontradas as $melhoria) : ?>
                                <td class="table-<?php echo $urgencia->id == 5 ? 'primary' : ($urgencia->id == 4 ? 'danger' : 'warning' ) ; ?>">

                                  <div class="wrapper-melhoria" id="wrapper_melhoria_<?php echo "{$area->id}_{$m}_{$melhoria->id}" ?>">
                                    <div class="card" style="width: 18rem;">
                                      <div class="card-body">
                                        <h5 class="card-title"><?php echo $melhoria->title; ?></h5>
                                        <p class="card-text"><?php echo $melhoria->tarefa ?></p>
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#melhoria_<?php echo $melhoria->id ?>">
                                          <i class="fas fa-plus"></i>
                                        </a>
                                      </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="melhoria_<?php echo $melhoria->id ?>" tabindex="-1" role="dialog" aria-labelledby="melhoria_<?php echo $melhoria->tarefa ?>" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="melhoria_<?php echo $melhoria->tarefa ?>"><?php echo $melhoria->title ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <form>
                                              <div class="form-group">
                                                  <label class="" for="descricao">Descrição</label>
                                                  <textarea class="form-control mb-2" id="descricao" rows="8" readonly><?php echo $melhoria->descricao ?></textarea>
                                                </div>
                                              <div class="form-group form-row">
                                                <div class="col">
                                                  <label  for="prazo_legal">Prazo legal</label>
                                                  <input type="text" class="form-control mb-2" id="prazo_legal" placeholder="Prazo legal" readonly value="<?php echo $prazoLegal ?>">
                                                </div>
                                                <div class="col">
                                                  <label for="prazo_acordado">Prazo acordado</label>
                                                  <input type="text" class="form-control" id="prazo_acordado" placeholder="Prazo acordado" readonly value="<?php echo $prazoAcordado ?>">
                                                </div>
                                                  </div>
                                              <div class="form-group form-row">
                                                <div class="col">
                                                  <label for="gravidade">Gravidade</label>
                                                  <select class="form-control" id="gravidade">
                                                    <option value='0'>Não informado</option>
                                                    <?php foreach ($gravidadesAll as $gravidade) : ?>
                                                      <option <?php echo $gravidade->id == $melhoria->gravidade ? 'selected' : '' ?> value="<?php echo $gravidade->id ?>"><?php echo $gravidade->descricao ?></option>
                                                    <?php endforeach; ?>
                                                  </select>
                                                </div>
                                                <div class="col">
                                                  <label for="urgencia">Urgência</label>
                                                  <select class="form-control" id="urgencia">
                                                    <option value='0'>Não informado</option>
                                                    <?php foreach ($urgenciasAll as $urgencia) : ?>
                                                      <option <?php echo $urgencia->id == $melhoria->urgencia ? 'selected' : '' ?> value="<?php echo $urgencia->id ?>"><?php echo $urgencia->descricao ?></option>
                                                    <?php endforeach; ?>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="form-group form-row">
                                                <div class="col">
                                                  <label for="tendencia">Tendência</label>
                                                  <select class="form-control" id="tendencia">
                                                    <option value='0'>Não informado</option>
                                                    <?php foreach ($tendenciasAll as $tendencia) : ?>
                                                      <option <?php echo $tendencia->id == $melhoria->tendencia ? 'selected' : '' ?> value="<?php echo $tendencia->id ?>"><?php echo $tendencia->descricao ?></option>
                                                    <?php endforeach; ?>
                                                  </select>
                                                </div>
                                                <div class="col">
                                                  <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="demanda_legal" readonly <?php echo (bool)$melhoria->demanda_legal ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="demanda_legal">Demanda Legal</label>
                                                  </div>
                                                </div>
                                              </div>
                                            </form>

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                      <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
              </tbody>
            </table>
          </td>
        <?php endfor; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<!-- class="table-default"> -->
<!-- class="table-secondary"> -->
<!-- class="table-success"> -->
<!-- class="table-danger"> -->
<!-- class="table-warning"> -->
<!-- class="table-info"> -->
<!-- class="table-light"> -->
