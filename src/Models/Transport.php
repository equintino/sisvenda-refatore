<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateTransportsTable;

class Transport extends Model implements Models
{
    public static $entity = "Transportadora";

    /** @var array */
    private $required = [];

    public function load(int $id, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE IDTransportadora=:IDTransportadora", "IDTransportadora={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Transportadora não encontrada do id informado.";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    public function find(string $cnpj, string $columns = "*")
    {
        if(filter_var($cnpj, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE CNPJ=:CNPJ ", "CNPJ={$cnpj}");
        }

        if($this->fail || empty($find)) {
            $this->message = "Transportadora não encontrada.";
            return null;
        }

        return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        //return $find->fetchObject(__CLASS__);
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "RasSocial"): ?array
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

    public function activeAll(int $limit=30, int $offset=0, string $columns = "*", string $order = "RasSocial"): ?array
    {
        $sql = "SELECT {$columns} FROM  " . self::$entity . " WHERE ATIVO=1 " . $this->order($order);
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

    public function save()
    {
        static::$safe = ["IDTransportadora","created_at","updated_at"];
        if(!$this->required()) {
            return null;
        }

        $this->validateFields();

        /** Update */
        if($this->IDTransportadora) {
            return $this->update_();
        }

        /** Create */
        if(empty($this->IDTransportadora)) {
            $this->create_();
        }
        return $this;
    }

    private function update_()
    {
        if(!empty($this->IDTransportadora)) {
            /** increment false in LOJASCOM_N */
            $false = ($this->connectionDetails->local !== "lojascom" ?: false);
            $this->otherCompanies(["Cnpj" => $this->CNPJ], $false);
        }

        ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );

        return null;
    }

    public function create_()
    {
        if(!empty($this->CNPJ) && $this->find($this->CNPJ)) {
            $this->message = "<span class='warning'>Transporttadora informada já está cadastrada</span>";
        } else {
            /** increment false in LOJASCOM_N */
            $false = ($this->connectionDetails->local !== "lojascom" ?: false);
            $id = $this->otherCompanies(["Cnpj" => $this->CNPJ], $false);
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                return null;
            }
            $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";

            $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE IDTransportadora=:IDTransportadora", "IDTransportadora={$id}")->fetch();
        }
        return null;
    }

    protected function otherCompanies(array $where=[], bool $autoincrement = true)
    {
        if(isset($this->data->CNPJ)) {
            $this->data->Cnpj = $this->data->CNPJ;
        }
        if(isset($this->data->StatusAtivo)) {
            $this->data->ATIVO = $this->data->StatusAtivo;
        }
        unset($this->data->CNPJ, $this->data->NomeFantasia, $this->data->StatusAtivo, $this->data->Atividade);
        //InscEsdatual, Fax, Tel02, HomePage

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
            static::$safe = ["IDTransportadora","created_at","updated_at"];
            $transport = $this->read("SELECT * FROM " . self::$entity . " WHERE {$terms} AND IDEmpresa={$company->ID}", $params);

            $this->data->IDEmpresa = $company->ID;

            if(!$transport->fetch()) {
                if(!$autoincrement) {
                    static::$safe = ["created_at","updated_at"];
                    $this->data->IDTransportadora = $this->lastId();
                }
                $id = $this->create(self::$entity, $this->safe());
            } else {
                $this->update(self::$entity, $this->safe(), "{$terms} AND IDEmpresa={$company->ID}", "{$params}");
            }

            //( !$transport->fetch() ? $id = $this->create(self::$entity, $this->safe()) : $this->update(self::$entity, $this->safe(), "{$terms} AND IDEmpresa={$company->ID}", "{$params}") );
        }
        return $id ?? null;
    }

    public function destroy()
    {
        if(!empty($this->id)) {
            $this->delete(self::$entity, "IDTransportadora=:IDTransportadora", "IDTransportadora={$this->id}");
        }

        if($this->fail()) {
            $this->message = "Não foi possível remover Transportadora";
            return null;
        }
        $this->message = "Transportadora foi removida com sucesso";
        $this->data = null;

        return $this;
    }

    private function lastId()
    {
        $lastData = $this->all(1, 0, "IDTransportadora", "IDTransportadora DESC");
        return ($lastData ? $lastData[0]->IDTransportadora + 1 : 1);
    }

    private function validateFields()
    {
        if(isset($this->data->cep)) {
            unset($this->data->cep);
        }
        if(isset($this->data->InscEstadual)) {
            $this->data->InscEsdatual = $this->data->InscEstadual;
            unset($this->data->InscEstadual);
        }
        if(isset($this->data->StatusAtivo)) {
            $this->data->ATIVO = $this->data->StatusAtivo;
            unset($this->data->StatusAtivo);
        }
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
        $sql = (new CreateTransportsTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateTransportsTable())->down(self::$entity);
        return $this->dropTable($sql);
    }
}
