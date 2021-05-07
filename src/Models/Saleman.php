<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateSalemansTable;

class Saleman extends Model implements Models
{
    public static $entity = "Vendedor";

    /** @var array */
    private $required = [];

    public function load(int $id, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE ID_Vendedor=:ID_Vendedor", "ID_Vendedor={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Transportadora não encontrada do id informado.";
            return null;
        }
        return $load->fetchObject(__CLASS__);
    }

    public function find(string $login, string $columns = "*")
    {
        if(filter_var($login, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE LogON=:LogON ", "LogON={$login}");
        }

        if($this->fail || empty($find)) {
            $this->message = "Vendedor não encontrado.";
            return null;
        }

        return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        //return $find->fetchObject(__CLASS__);
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "LogON"): ?array
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
        static::$safe = ["ID_Vendedor","created_at","updated_at"];
        if(!$this->required()) {
            return null;
        }

        $this->validateFields();

        /** Update */
        if($this->ID_Vendedor) {
            return $this->update_();
        }

        /** Create */
        if(empty($this->ID_Vendedor)) {
            $this->create_();
        }
        return $this;
    }

    private function update_()
    {
        if(!empty($this->ID_Vendedor)) {
            /** increment false in LOJASCOM_N */
            $false = ($this->connectionDetails->local !== "lojascom" ?: false);
            $this->otherCompanies(["LogON" => $this->LogON], $false);
        }

        ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );

        return null;
    }

    public function create_()
    {
        if(!empty($this->LogON) && $this->find($this->LogON)) {
            $this->message = "<span class='warning'>Vendedor informado já está cadastrado</span>";
        } else {
            /** increment false in LOJASCOM_N */
            $false = ($this->connectionDetails->local !== "lojascom" ?: false);
            $id = $this->otherCompanies(["LogON" => $this->LogON], $false);
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                return null;
            }
            $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";

            $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE ID_Vendedor=:ID_Vendedor", "ID_Vendedor={$id}")->fetch();
        }
        return null;
    }

    protected function otherCompanies(array $where=[], bool $autoincrement = true)
    {
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

            if(!$transport->fetch()) {
                if(!$autoincrement) {
                    static::$safe = ["created_at","updated_at"];
                    $this->data->ID_vendedor = $this->lastId();
                }
                $id = $this->create(self::$entity, $this->safe());
            } else {
                $this->update(self::$entity, $this->safe(), "{$terms} AND IDEmpresa={$company->ID}", "{$params}");
            }
        }
        return $id ?? null;
    }

    public function destroy()
    {
        if(!empty($this->id)) {
            $this->delete(self::$entity, "ID_Vendedor=:ID_Vendedor", "ID_Vendedor={$this->id}");
        }

        if($this->fail()) {
            $this->message = "Não foi possível remover cadastro";
            return null;
        }
        $this->message = "Cadastro removido com sucesso";
        $this->data = null;

        return $this;
    }

    private function lastId()
    {
        $lastData = $this->all(1, 0, "ID_Vendedor", "ID_Vendedor DESC");
        return ($lastData ? $lastData[0]->ID_Vendedor + 1 : 1);
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
        $sql = (new CreateSalemansTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateSalemansTable())->down(self::$entity);
        return $this->dropTable($sql);
    }
}
