<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateSuppliersTable;

class Supplier extends Model implements Models
{
    public static $entity = "Fornecedor";

    /** @var array */
    private $required = [];

    public function load(int $id, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE ID=:ID", "ID={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Fornecedor não encontrado do id informado";
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
            $this->message = "Fornecedor não encontrado";
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
        if(!$this->required()) {
            return null;
        }

        /** Validate Fiels */
        $this->validateFields();

        /** Update */
        if($this->ID) {
            return $this->update_();
        }

        /** Create */
        if(empty($this->ID)) {
            $this->create_();
        }
        return $this;
    }

    private function update_()
    {
        if(!empty($this->ID)) {
            /** increment false in LOJASCOM_N */
            $false = ($this->connectionDetails->local !== "lojascom" ?: false);

            $this->otherCompanies(["CNPJ" => $this->CNPJ], $false);
        }

        ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );

        return null;
    }

    public function create_()
    {
        if($this->find($this->CNPJ)) {
            $this->message = "<span class='warning'>Fornecedor informado já está cadastrado</span>";
        } else {
            /** increment false in LOJASCOM_N */
            $false = ($this->connectionDetails->local !== "lojascom" ?: false);

            $id = $this->otherCompanies(["CNPJ" => $this->CNPJ], $false);
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                return null;
            }
            $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";

            $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE ID=:ID", "ID={$id}")->fetch();
        }
        return null;
    }

    protected function otherCompanies(array $where=[], bool $autoincrement = true)
    {
        $this->data->Cep = $this->data->CEP;
        unset($this->data->StatusAtivo, $this->data->CEP, $this->data->cep);

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
            static::$safe = ["ID","created_at","updated_at","IDTransportadora","transpCompanyId","transpCnpj","Tipo"];
            $supplier = $this->read("SELECT * FROM " . self::$entity . " WHERE {$terms} AND IDEmpresa={$company->ID}", $params);

            $this->data->IDEmpresa = $company->ID;

            if(!$supplier->fetch()) {
                if(!$autoincrement) {
                    static::$safe = array_diff(static::$safe, ["ID"]);
                    $this->data->ID = $this->lastId();
                }
                $id = $this->create(self::$entity, $this->safe());
            } else {
                $this->update(self::$entity, $this->safe(), "{$terms} AND IDEmpresa={$company->ID}", "{$params}");
            }
        }
        return $id ?? null;
    }

    private function lastId(): int
    {
        $lastData = $this->all(1,0,"*","ID DESC");
        return ($lastData ? $lastData[0]->ID + 1 : 1);
    }

    public function destroy()
    {
        if(!empty($this->id)) {
            $this->delete(self::$entity, "ID=:ID", "ID={$this->id}");
        }

        if($this->fail()) {
            $this->message = "Não foi possível remover Fornecedor";
            return null;
        }
        $this->message = "Fornecedor foi removido com sucesso";
        $this->data = null;
        return $this;
    }

    private function validateFields(): void
    {
        if(isset($this->data->Atividade)) {
            $this->data->Atividade = substr($this->data->Atividade, 0, 19);
        }
        if(isset($this->data->InscEstadual)) {
            $this->data->InscEsdatual = $this->data->InscEstadual;
            unset($this->data->InscEstadual);
        }
    }

    public function required(): bool
    {
        foreach($this->required as $field) {
            if(empty(trim($this->$field))) {
                $this->message = "O campo {$field} é obrigatório";
                return false;
            }
        }
        return true;
    }

    public function createThisTable()
    {
        $sql = (new CreateSuppliersTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateSuppliersTable())->down(self::$entity);
        return $this->dropTable($sql);
    }
}
