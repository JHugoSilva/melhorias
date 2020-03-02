<?php 

namespace DAO;

class Database {
    
    protected $db;
    protected $order = [];

    /**
     * Representa a instancia a classe,
     * logo nas classes filhas esse atributo
     * deve ser sobrescrito de maneira que
     * mantenha em memória a instância correta
     *
     * @var Class
     * @access protected
     */
    protected static  $oInstance;

    public function __construct ($dbname = 'melhorias', $host = 'localhost', $port = '5432', $user = 'postgres', $pass = '123') 
    {
        $dsn = "pgsql:dbname={$dbname};host={$host};port={$port}";
        
        $this->db = new \PDO($dsn, $user, $pass);
    }

    /**
     * Retorna a instancia do repositório
     *
     * @return static
     */
    public static function getInstance()
    {
        if (empty(static::$oInstance)) {
            static::$oInstance = new static;
        }

        return static::$oInstance;
    }

    public function filtrarPorId($id, $fields = null)
    {
        $fields = $this->prepareFields($fields);

        $dbst = $this->db->prepare(" SELECT $fields FROM ". static::TABLE ." WHERE id = :id ");
        $dbst->bindValue(':id', $id, \PDO::PARAM_STR);

        return $this->execute($dbst);
    }

    public function filtrarPorDescricao($descricao, $fields = null)
    {
        $fields = $this->prepareFields($fields);
        
        $dbst = $this->db->prepare(" SELECT $fields FROM ". static::TABLE ." WHERE descricao ILIKE :descricao ");
        $dbst->bindValue(':descricao', $descricao, \PDO::PARAM_STR);

        return $this->execute($dbst);
    }

    protected function filtrar ($where, $whereValues, $fields = null)
    {
        $fields = $this->prepareFields($fields);

        $order = null;
        if(!empty($this->order)) {

            $ords = [];
            foreach($this->order as $ord => $dir) {

                $ords[] = "{$ord} {$dir}";
            }

            $order = ' ORDER BY ' . implode(',', $ords);
        }

        $dbst   = $this->db->prepare(" SELECT {$fields} FROM ". static::TABLE ." WHERE {$where} {$order} ");

        if(is_array($whereValues) && !empty($whereValues)) {

            foreach ($whereValues as $param => $value) {

                if(strpos($value, ',') === false) {
                    $typeParam = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
                    $dbst->bindValue(':'. $param, $value, $typeParam);
                } 
            }
        }

        return $this->execute($dbst);
    }

    public function getAll($limit = null)
    {
        if(!empty($limit)) {
            $limit = ' LIMIT ' . (int)$limit;
        }
        
        $order = null;
        if(!empty($this->order)) {

            $ords = [];
            foreach($this->order as $ord => $dir) {

                $ords[] = "{$ord} {$dir}";
            }

            $order = ' ORDER BY ' . implode(',', $ords);
        }

        $fields = $this->prepareFields();

        return $this->execute($this->db->prepare(" SELECT $fields FROM " . static::TABLE ." {$order} {$limit} "));
    }

    public function order($column, $direction = 'ASC')
    {
        if(!empty($column) && !empty($direction)) {
            $this->order[$column] = $direction;
        }

        return $this;
    }

    protected function execute($dbst)
    {
        $results = $dbst->execute();

        if($results === false) {
            throw new \Exception("Não foi possível executar a consulta\n". implode("\n", $dbst->errorInfo()));
        }

        if($dbst->rowCount() == 0) {
            return null;
        }

        if($dbst->rowCount() == 1) {
            return $dbst->fetchObject();
        }

        $res = [];
        while ($row = $dbst->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT)) {
            $res[] = (object)$row;
        } 

        return $res;
    }

    protected function prepareFields($fields = null)
    {
        if(empty($fields)) {
            $fields = '*';
        } else {

            if(is_array($fields)) {
                $fields = implode(', ', $fields);
            }
        }

        return $fields;
    }

    
    public function __destruct () 
    {
    }

    /**MEUS SCRIPTS */

    public function insert($desc)
    {
        \error_reporting(0);
        $sql="INSERT INTO area(descricao)VALUES(:descricao)";
        $sql=$this->db->prepare($sql);
        $sql->bindValue(':descricao',$desc);
        $sql->execute();
    }

    public function areaExist($area)
    {
        $sql="SELECT descricao FROM area WHERE descricao='{$area}'";
        $res = $this->db->query($sql);
        if($res->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function areaTarefaExite($id)
    {
        $sql="SELECT a.id FROM melhorias AS m, area AS a WHERE a.id='{$id}' AND m.area='{$id}'";
        $res = $this->db->query($sql);
        if($res->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function areaDelete($id)
    {
        $sql="DELETE FROM area WHERE id='{$id}'";
        $this->db->query($sql);
    }

    public function areaUpdate($id, $desc)
    {
        $sql="UPDATE area SET descricao='{$desc}' WHERE id='{$id}'";
        $this->db->query($sql);
    }

    public function inserirMelhoria($desc, $data_acord, $data_legal, $gravidade, $urgencia, $tendencia, $area)
    {
        $sql="INSERT INTO melhorias(descricao, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)VALUES ('{$desc}', '{$data_acord}', '{$data_legal}', '{$gravidade}', '{$urgencia}', '{$tendencia}', '{$area}')";
        $this->db->query($sql);
    }
    public function atualizarMelhoria($id, $desc, $data_acord, $data_legal, $gravidade, $urgencia, $tendencia, $area)
    {
        $sql="UPDATE melhorias SET descricao='{$desc}', prazo_acordado='{$data_acord}', prazo_legal='{$data_legal}', gravidade='{$gravidade}', urgencia='{$urgencia}', tendencia='{$tendencia}', area='{$area}' WHERE id='{$id}'";
        $this->db->query($sql);
    }
    public function excluirMelhorias($id)
    {
        $sql="DELETE FROM melhorias WHERE id='{$id}'";
        $this->db->query($sql);
    }
}
