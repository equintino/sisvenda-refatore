<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateClientsTable;

class Client extends Model implements Models
{
    public static $entity = "PFisica";

    /** @var array */
    private $required = [];

    public function load(int $id, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE ID_PFISICA=:ID_PFISICA", "ID_PFISICA={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Cliente não encontrada do id informado.";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    public function find(string $search, string $columns = "*")
    {
        if(filter_var($search, FILTER_SANITIZE_STRIPPED)) {
            if(strlen($search) < 18) {
                $where = " WHERE CPF=:CPF ";
                $param = "CPF={$search}";
            } else {
                $where = " WHERE CNPJ=:CNPJ ";
                $param = "CNPJ={$search}";
            }
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . $where, $param);
        }

        if($this->fail || !$find->rowCount()) {
            $this->message = "Cliente não encontrada.";
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "id"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM  "
            . self::$entity . " WHERE 1=1 "
            . $this->order($order)
            . $this->limit(), "limit={$limit}&offset={$offset}");

        if($this->fail || !$all->rowCount()) {
            $this->message = "Sua consulta não retornou nenhum registro.";
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function save()
    {
        static::$safe = ["ID_PFISICA","ID_PJURIDICA","id","created_at","updated_at"];
        if(!$this->required()) {
            return null;
        }

        /** Update */
        if($this->ID_PFISICA || $this->ID_PJURIDICA) {
            return $this->update_();
        }

        /** Create */
        if(empty($this->ID_PFISICA) || empty($this->ID_PJURIDICA)) {
            $this->create_();
        }

        return $this;
    }

    private function update_()
    {
        if(!empty($this->ID_PFISICA)) {
            $this->otherCompanies(["CPF" => $this->CPF]);
        } elseif(!empty($this->ID_PJURIDICA)) {
            $this->otherCompanies(["CNPJ" => $this->CNPJ]);
        }

        /** Vendedor/IDEmpresa, IDTransportadora/IDEmpresa */
        ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );

        return null;
    }

    public function create_()
    {
        if($this->CPF) {
            if($this->find($this->CPF)) {
                $this->message = "<span class='warning'>Cliente informado já está cadastrado</span>";
            } elseif($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
            } else {
                $id = $this->otherCompanies(["CPF" => $this->CPF]);
                $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";

                $data = $this->read("SELECT * FROM " . self::$entity . " WHERE ID_PFISICA=:ID_PFISICA", "ID_PFISICA={$id}");
                $this->data = ($data? $data->fetch() : null);
            }
            return null;
        } elseif($this->CNPJ) {
            if($this->find($this->CNPJ)) {
                $this->message = "<span class='warning'>Cliente informado já está cadastrado</span>";
            } elseif($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
            } else {
                $id = $this->otherCompanies(["CNPJ" => $this->CNPJ]);
                $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";

                $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE ID_PJURIDICA=:ID_PJURIDICA", "ID_PJURIDICA={$id}")->fetch();
            }
            return null;
        }
    }

    protected function otherCompanies(array $where=[])
    {
        unset($this->data->cep);

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
            $client = $this->read("SELECT * FROM " . self::$entity . " WHERE {$terms} AND IDEmpresa={$company->ID}", $params);
            $this->data->IDEmpresa = $company->ID;

            ( !$client->fetch() ? $id = $this->create(self::$entity, $this->safe()) : $this->update(self::$entity, $this->safe(), "{$terms} AND IDEmpresa=:IDEmpresa", "{$params}") );
        }
        return $id ?? null;
    }

    public function destroy()
    {
        if(!empty($this->id)) {
            $this->delete(self::$entity, "ID_PFISICA=:ID_PFISICA", "ID_PFISICA={$this->id}");
        }

        if($this->fail()) {
            $this->message = "Não foi possível remover Cliente";
            return null;
        }
        $this->message = "Cliente foi removido com sucesso";
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
        $sql = (new CreateClientsTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateClientsTable())->down(self::$entity);
        return $this->dropTable($sql);
    }
}
