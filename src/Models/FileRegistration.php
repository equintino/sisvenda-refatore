<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateCadArquivosTable;

class FileRegistration extends Model implements Models
{
    public static $entity = "CadArquivos";

    /** @var array */
    private $required = [];

    public function load(int $COD_ARQUIVO, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE COD_ARQUIVO=:COD_ARQUIVO", "COD_ARQUIVO={$COD_ARQUIVO}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Arquivo não encontrado";
            return null;
        }
        return $load->fetchObject(__CLASS__);
    }

    public function find(string $COD_DOCUMENTO, string $columns = "*")
    {
        if(filter_var($COD_DOCUMENTO, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE COD_DOCUMENTO=:COD_DOCUMENTO ", "COD_DOCUMENTO={$COD_DOCUMENTO}");
        }

        if($this->fail || empty($find)) {
            $this->message = "Arquivo não encontrado.";
            return null;
        }

        return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        //return $find->fetchObject(__CLASS__);
    }

    public function search(array $where)
    {
        $terms = "";
        $params = "";
        foreach($where as $k => $v) {
            $terms .= " {$k}=:{$k} AND";
            $params .= "{$k}={$v}&";
        }
        $terms = substr($terms, 0, -3);
        $params = substr($params, 0, -1);
        $data = $this->read("SELECT * FROM " . self::$entity . " WHERE {$terms} ", $params);
        return $data->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "COD_ARQUIVO"): ?array
    {
        $sql = "SELECT {$columns} FROM  " . self::$entity . " WHERE 1=1 " . $this->order($order);
        if($limit !== 0) {
            $all = $this->read($sql . $this->limit(), "limit={$limit}&offset={$offset}");
        } else {
            $all = $this->read($sql);
        }

        if($this->fail || !$all->rowCount()) {
            $this->message = "Sua consulta não retornou nenhum registro.";
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function activeAll(int $limit=30, int $offset=0, string $columns = "*", string $order = "COD_ARQUIVO"): ?array
    {
        $sql = "SELECT {$columns} FROM  " . self::$entity . " WHERE " . $this->order($order);
        if($limit !== 0) {
            $all = $this->read($sql . $this->limit(), "limit={$limit}&offset={$offset}");
        } else {
            $all = $this->read($sql);
        }

        if($this->fail || !$all->rowCount()) {
            $this->message = "Sua consulta não retornou nenhum registro.";
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function readDataTable(string $sql, ?array $where)
    {
        if(empty($where)) {
            return $this->activeAll();
        }
        //return $this->read($sql, $params);
    }

    public function save()
    {
        static::$safe = ["id","created_at","updated_at"];
        if(!$this->required()) {
            return null;
        }

        $this->validateFields();

        /** Update */
        if($this->COD_ARQUIVO) {
            return $this->update_();
        }

        /** Create */
        if(empty($this->COD_ARQUIVO)) {
            $this->create_();
        }
        return $this;
    }

    private function update_()
    {
        if(!empty($this->COD_ARQUIVO)) {
            $this->otherCompanies(["COD_ARQUIVO" => $this->COD_ARQUIVO]);
        }

        ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );

        return null;
    }

    public function create_()
    {
        if(!empty($this->COD_ARQUIVO) && $this->find($this->COD_ARQUIVO)) {
            $this->message = "<span class='warning'>Arquivo informado já está cadastrado</span>";
        } else {
            $COD_ARQUIVO = $this->otherCompanies(["COD_ARQUIVO" => $this->COD_ARQUIVO]);
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                return null;
            }
            $this->message = "<span class='success'>Arquivo salvo com sucesso</span>";

            $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE COD_ARQUIVO=:COD_ARQUIVO", "COD_ARQUIVO={$COD_ARQUIVO}")->fetch();
        }
        return null;
    }

    protected function otherCompanies(array $where=[], bool $autoincrement = true)
    {/** Identificar a empresa */
        $companys = (new Company())->all();
        $keys = array_keys($where);
        $terms = "";
        $params = "";

        foreach($keys as $key) {
            $terms .= "{$key}=:{$key},";
            $params .= "{$key}={$where[$key]},";
        }
        $terms = substr($terms, 0, -1);
        $params = substr($params, 0, -1);
        foreach($companys as $company) {
            $transport = $this->read("SELECT * FROM " . self::$entity . " WHERE {$terms} AND COD_EMPRESA={$company->ID}", $params);

            $this->data->COD_EMPRESA = $company->ID;

            if(!$transport->fetch()) {
                if(!$autoincrement) {
                    static::$safe = ["created_at","updated_at"];
                    $this->data->COD_ARQUIVO = $this->lastId();
                }
                $id = $this->create(self::$entity, $this->safe());
            } else {
                $this->update(self::$entity, $this->safe(), "{$terms} AND COD_EMPRESA={$company->ID}", "{$params}");
            }
        }
        return $id ?? null;
    }

    public function showImage( $id )
    {
        $dados = $this->load($id);
        if( isset($dados) ){
            $type = $dados->IND_TIPO;
            $img = $dados->ARQ_01;
            header("Content-Type: {$type}");
            return $img;
        }else{
            return false;
        }
    }

    public function destroy()
    {
        if(!empty($this->COD_ARQUIVO)) {
            $this->delete(self::$entity, "COD_ARQUIVO=:COD_ARQUIVO", "COD_ARQUIVO={$this->COD_ARQUIVO}");
        }

        if($this->fail()) {
            $this->message = "Não foi possível remover arquivo";
            return null;
        }
        $this->message = "Arquivo removido com sucesso";
        $this->data = null;

        return $this;
    }

    private function lastId()
    {
        $lastData = $this->all(1, 0, "COD_ARQUIVO", "COD_ARQUIVO DESC");
        return ($lastData ? $lastData[0]->COD_ARQUIVO + 1 : 1);
    }

    private function validateFields()
    {
        return null;
    }

    public function required(): bool
    {
        foreach($this->required as $field) {
            if(empty(trim($this->$field))) {
                $this->message = "O campo {$field} é obrigatório.";
                return false;
            }
        }
        return true;
    }

    public function createThisTable()
    {
        $sql = (new CreateCadArquivosTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateCadArquivosTable())->down(self::$entity);
        return $this->dropTable($sql);
    }
}
