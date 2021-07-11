<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateSalesTable;

class Sale extends Model implements Models
{
    public static $entity = "Venda";

    /** @var array */
    private $required = [];

    public function load(int $salesOrder, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE IDVenda_NEW=:IDVenda_NEW", "IDVenda_NEW={$salesOrder}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Pedido de Venda não encontrado";
            return null;
        }
        return $load->fetchObject(__CLASS__);
    }

    public function find(string $salesOrder, string $columns = "*")
    {
        if(filter_var($salesOrder, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Pedido=:Pedido ", "Pedido={$salesOrder}");
        }

        if($this->fail || empty($find)) {
            $this->message = "Pedido não encontrado.";
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

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "Pedido"): ?array
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

    public function activeAll(int $limit=30, int $offset=0, string $columns = "*", string $order = "Pedido"): ?array
    {
        $sql = "SELECT {$columns} FROM  " . self::$entity . " WHERE Status!='C' AND Status!='CO' " . $this->order($order);
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

    public function readDataTable(string $sql, array $where=null)
    {
        return $this->read($sql);
    }

    public function save()
    {
        static::$safe = ["IDVenda_NEW","created_at","updated_at"];
        if(!$this->required()) {
            return null;
        }

        $this->validateFields();

        /** Update */
        if($this->IDVenda_NEW) {
            return $this->update_();
        }

        /** Create */
        if(empty($this->IDVenda_NEW)) {
            $this->create_();
        }
        return $this;
    }

    private function update_()
    {
        static::$safe = ['IDVenda_NEW','created_at','updated_at','file'];
        if(!empty($this->IDVenda_NEW)) {
            //$this->otherCompanies(["Pedido" => $this->Pedido]);
            $terms = "IDVenda_NEW=:IDVenda_NEW";
            $params = "IDVenda_NEW={$this->IDVenda_NEW}";
            $this->update(self::$entity, $this->safe(), "{$terms}", "{$params}");
        }

        ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );
        return null;
    }

    public function create_()
    {
        if(!empty($this->IDVenda_NEW) && $this->find($this->IDVenda_NEW)) {
            $this->message = "<span class='warning'>Vendedor informado já está cadastrado</span>";
        } else {
            $IDVenda_NEW = $this->otherCompanies(["Pedido" => $this->Pedido]);
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                return null;
            }
            $this->message = "<span class='success'>Pedido salvo com sucesso</span>";

            $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE IDVenda_NEWr=:IDVenda_NEW", "IDVenda_NEW={$IDVenda_NEW}")->fetch();
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
            $transport = $this->read("SELECT * FROM " . self::$entity . " WHERE {$terms} AND IDEmpresa={$company->ID}", $params);

            $this->data->IDEmpresa = $company->ID;

            if(!$transport->fetch()) {
                if(!$autoincrement) {
                    static::$safe = ["created_at","updated_at"];
                    $this->data->ID_vendedor = $this->lastId();
                }
                $id = $this->create(self::$entity, $this->safe());
            } else {
                $this->update(self::$entity, $this->safe(), "{$terms} AND IDEMPRESA={$company->ID}", "{$params}");
            }
        }
        return $id ?? null;
    }

    public function destroy()
    {
        if(!empty($this->IDVenda_NEW)) {
            $this->delete(self::$entity, "IDVenda_NEW=:IDVenda_NEW", "IDVenda_NEW={$this->IDVenda_NEW}");
        }

        if($this->fail()) {
            $this->message = "Não foi possível remover pedido";
            return null;
        }
        $this->message = "Pedido removido com sucesso";
        $this->data = null;
        return $this;
    }

    private function lastId()
    {
        $lastData = $this->all(1, 0, "Pedido", "Pedido DESC");
        return ($lastData ? $lastData[0]->Pedido + 1 : 1);
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
        $sql = (new CreateSalesTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateSalesTable())->down(self::$entity);
        return $this->dropTable($sql);
    }
}
