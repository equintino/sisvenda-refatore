<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateConfigsTable;

class Config extends Model implements Models
{
    public static $entity = "configs";

    /** @var array */
    private $required = [ "name","type","address","db","user" ];

    public function load(int $id, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id=:id", "id={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "<span class='warning'>Configuração não encontrada do id informado</span>";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    public function find(string $search, string $columns = "*")
    {
        if(filter_var($search, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE name=:name AND active=1", "name={$search}");
        }

        if($this->fail || !$find->rowCount()) {
            $this->message = "<span class='warning'>Configuração não encontrada</span>";
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "id"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM  "
            . self::$entity . " WHERE active=1 "
            . $this->order($order)
            . $this->limit(), "limit={$limit}&offset={$offset}");

        if($this->fail || !$all->rowCount()) {
            $this->message = "<span class='warning'>Sua consulta não retornou nenhum registro</span>";
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function save()
    {
        if(!$this->required()) {
            return null;
        }

        /** Update */
        if(!empty($this->id)) {
            $configId = $this->id;
            $config = $this->read("SELECT id FROM " . self::$entity . " WHERE name = :name AND id != :id",
                "name={$this->name}&id={$configId}");
            if($config->rowCount()) {
                $this->message = "<span class='warning'>Existe um mesmo nome de Configuração já cadastrada</span>";
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$configId}");
            if($this->fail()) {
                $this->message = "<span class='error'>Erro ao atualizar, verifique os dados</span>";
                return null;
            }

            $this->message = "<span class='success'>Dados atualizados com sucesso</span>";
        }

        /** Create */
        if(empty($this->id)) {
            if($this->find($this->name)) {
                $this->message = "<span class='warning'>Existe um mesmo nome de Configuração já cadastrada</span>";
                return null;
            }
            $configId = $this->create(self::$entity, $this->safe());
            if($this->fail()) {
                $this->message = "<span class='error'>Erro ao cadastrar, verifique os dados</span>";
                return null;
            }
            $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";
        }
        $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE id=:id", "id={$configId}")->fetch();

        return $this;
    }

    public function destroy()
    {
        if(!empty($this->id)) {
            $this->delete(self::$entity, "id=:id", "id={$this->id}");
        }

        if($this->fail()) {
            $this->message = "<span class='warning'>Não foi possível remover a Configuração</span>";
            return null;
        }
        $this->message = "<span class=success'>Configuração foi removida com sucesso</span>";
        $this->data = null;

        return $this;
    }

    public function required(): bool
    {
        foreach($this->required as $field) {
            if(empty(trim($this->$field))) {
                $this->message = "<span class='warning'>O campo {$field} é obrigatório</span>";
                return false;
            }
        }

        return true;
    }

    public function createThisTable()
    {
        $sql = (new CreateConfigsTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateConfigsTable())->down(self::$entity);
        return $this->dropTable($sql);
    }

    protected function crypt(string $passwd)
    {
        return base64_encode($passwd);
    }
}
