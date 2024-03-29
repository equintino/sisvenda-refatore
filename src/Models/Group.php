<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateGroupsTable;

class Group extends Model implements Models
{
    public static $entity = "tb_group";

    /** @var array */
    private $required = [ "name" ];

    public function load(int $id, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id=:id", "id={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "<span class='warning'>Grupo não encontrado do id informado</span>";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    public function find(string $search, string $columns = "*")
    {
        if(filter_var($search, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE name=:name ", "name={$search}");
        }

        if($this->fail || !$find->rowCount()) {
            $this->message = "<span class='warning'>Grupo não encontrado</span>";
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    public function all(int $limit=30, int $offset=1, string $columns = "*", string $order = "id"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM  "
            . self::$entity . " "
            . $this->order($order)
            . $this->limit(), "limit={$limit}&offset={$offset}");

        if($this->fail || !$all->rowCount()) {
            $this->message = "<span class='warning'>Sua consulta não retornou nenhum grupo</span>";
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function save(): ?Group
    {
        if(!$this->required()) {
            return null;
        }

        /** Update */
        if(!empty($this->id)) {
            $groupId = $this->id;
            $group = $this->read("SELECT id FROM " . self::$entity . " WHERE name = :name AND id != :id",
                "name={$this->name}&id={$groupId}");
            if($group->rowCount()) {
                $this->message = "<span class='warning'>O Grupo informado já está cadastrado</span>";
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$groupId}");
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>";
                return null;
            }

            $this->message = "<span class='success'>Dados atualizados com sucesso</span>";
        }

        /** Create */
        if(empty($this->id)) {
            if($this->find($this->name)) {
                $this->message = "<span class='warning'>O grupo informado já está cadastrado</span>";
                return null;
            }
            $groupId = $this->create(self::$entity, $this->safe());
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                return null;
            }
            $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";
        }
        $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE id=:id", "id={$groupId}")->fetch();

        return $this;
    }

    public function destroy()
    {
        if(!empty($this->id)) {
            $this->delete(self::$entity, "id=:id", "id={$this->id}");
        }

        if($this->fail()) {
            $this->message = "<span class='danger'>Não foi possível remover o grupo</span>";
            return null;
        }
        $this->message = "<span class='success'>Grupo foi removido com sucesso</span>";
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
        $sql = (new CreateGroupsTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateGroupsTable())->down(self::$entity);
        return $this->dropTable($sql);
    }

}
