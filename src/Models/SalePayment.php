<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateSalePaymentsTable;

class SalePayment extends Model implements Models
{
    public static $entity = "Venda_FormaPag";

    /** @var array */
    private $required = [];

    public function load(int $id, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id=:id", "id={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Forma de pagamento não encontrada";
            return null;
        }
        return $load->fetchObject(__CLASS__);
    }

    public function find(string $salesOrder, string $columns = "*")
    {
        // if(filter_var($salesOrder, FILTER_SANITIZE_STRIPPED)) {
        //     $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Pedido=:Pedido ", "Pedido={$salesOrder}");
        // }

        // if($this->fail || empty($find)) {
        //     $this->message = "Produto não encontrado.";
        //     return null;
        // }
        // return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
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

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "Item"): ?array
    {
        // $sql = "SELECT {$columns} FROM  " . self::$entity . " WHERE 1=1 " . $this->order($order);
        // if($limit !== 0) {
        //     $all = $this->read($sql . $this->limit(), "limit={$limit}&offset={$offset}");
        // } else {
        //     $all = $this->read($sql);
        // }

        // if($this->fail || !$all->rowCount()) {
        //     $this->message = "Sua consulta não retornou nenhum registro.";
        //     return null;
        // }
        // return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    // public function activeAll(int $limit=30, int $offset=0, string $columns = "*", string $order = "Item"): ?array
    // {
    //     $sql = "SELECT {$columns} FROM  " . self::$entity . " WHERE 1=1 " . $this->order($order);
    //     if($limit !== 0) {
    //         $all = $this->read($sql . $this->limit(), "limit={$limit}&offset={$offset}");
    //     } else {
    //         $all = $this->read($sql);
    //     }

    //     if($this->fail || !$all->rowCount()) {
    //         $this->message = "Sua consulta não retornou nenhum registro.";
    //         return null;
    //     }

    //     return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    // }

    // public function readDataTable(string $sql, array $where=null)
    // {
    //     return $this->read($sql);
    // }

    public function save()
    {
        // static::$safe = ["IdxProd","created_at","updated_at"];
        // if(!$this->required()) {
        //     return null;
        // }

        // $this->validateFields();

        // /** Update */
        // if($this->IdxProd) {
        //     return $this->update_();
        // }

        // /** Create */
        // if(empty($this->IdxProd)) {
        //     $this->create_();
        // }
        // return $this;
    }

    // private function update_()
    // {
    //     if(!empty($this->IdxProd)) {
    //         var_dump($this->IdxProd);die;
    //         $this->update(self::$entity, $this->safe(), "IdxProd=:IdxProd", "IdxProd=" . $this->IdxProd);
    //     }

    //     ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );
    //     return null;
    // }

    // public function create_()
    // {
    //     if(!empty($this->IdxProd) && $this->find($this->IdxProd)) {
    //         $this->message = "<span class='warning'>Produto informado já está cadastrado</span>";
    //     } else {
    //         $id = $this->create(self::$entity, $this->safe());
    //         if($this->fail()) {
    //             $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
    //             return null;
    //         }
    //         $this->message = "<span class='success'>Produto salvo com sucesso</span>";

    //         $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE IdxProd=:IdxProd", "IdxProd={$id}")->fetch();
    //     }
    //     return null;
    // }

    public function destroy()
    {
        if(!empty($this->id)) {
            $this->delete(self::$entity, "id=:id", "id={$this->id}");
        }

        if($this->fail()) {
            $this->message = "Não foi possível remover forma de pagamento";
            return null;
        }
        $this->message = "Forma de pagamento removido com sucesso";
        $this->data = null;
        return $this;
    }

    private function lastId()
    {
        $lastData = $this->all(1, 0, "id", "id DESC");
        return ($lastData ? $lastData[0]->id + 1 : 1);
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
        $sql = (new CreateSalePaymentsTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateSalePaymentsTable())->down(self::$entity);
        return $this->dropTable($sql);
    }
}
