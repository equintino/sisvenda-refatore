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
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE IDTransportadora=:IDTransportadora", "IDTrasportadora={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Transportadora não encontrada do id informado.";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    public function find(string $search, string $columns = "*")
    {
        if(filter_var($search, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE CNPJ=:CNPJ ", "CNPJ={$search}");
        }

        if($this->fail || !$find->rowCount()) {
            $this->message = "Transportadora não encontrada.";
            return null;
        }

        return $find->fetchObject(__CLASS__);
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

    public function save()
    {
        static::$safe = ["IDTransportadora","created_at","updated_at"];
        if(!$this->required()) {
            return null;
        }

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
            $this->otherCompanies(["Cnpj" => $this->CNPJ]);
        }

        ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );

        return null;
    }

    public function create_()
    {
        if($this->find($this->CNPJ)) {
            $this->message = "<span class='warning'>Transporttadora informada já está cadastrada</span>";
        } elseif($this->fail()) {
            $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
        } else {
            $id = $this->otherCompanies(["Cnpj" => $this->CNPJ]);
            $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";

            $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE IDTransportadora=:IDTransportadora", "IDTransportadora={$id}")->fetch();
        }
        return null;
    }

    protected function otherCompanies(array $where=[])
    {
        $this->data->Cnpj = $this->data->CNPJ;
        $this->data->ATIVO = (empty($this->data->StatusAtivo) ?: $this->data->StatusAtivo);
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
            $transport = $this->read("SELECT * FROM " . self::$entity . " WHERE {$terms} AND IDEmpresa={$company->ID}", $params);

            $this->data->IDEmpresa = $company->ID;

            ( !$transport->fetch() ? $id = $this->create(self::$entity, $this->safe()) : $this->update(self::$entity, $this->safe(), "{$terms} AND IDEmpresa=:IDEmpresa", "{$params}") );
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
