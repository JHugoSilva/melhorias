<?php 

namespace DAO;

class Melhoria extends Database {

    const TABLE = 'melhorias';
    protected static $oInstance;

    public function filtrarPorUrgencia($urgencia, $fields = null)
    {
        if(is_array($urgencia)) {
            return $this->filtrar('urgencia IN ('. implode(', ', $urgencia) .')', null, $fields);
        }

        $whereValues = [];

        $where                   = 'urgencia = :urgencia';
        $whereValues['urgencia'] = $urgencia;

        return $this->filtrar($where, $whereValues, $fields);
    }
}
