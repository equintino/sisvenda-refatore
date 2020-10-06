<?php 

namespace Models;

use Core\Model;
use Database\Migrations\CreateGroupsTable;

class Group extends Model implements Models
{
    protected static $entity = "tb_group";

    /** @var array */
    private $required = [ "name", "access", "active" ];

    public function load(int $id, string $columns = "*")
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id=:id", "id={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Grupo não encontrado do id informado.";
            return null;
        }
        
        return $load->fetchObject(__CLASS__);
    }

    public function find(string $busca, string $columns = "*")
    {
        if(filter_var($busca, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE name=:name ", "name={$busca}");
        }

        if($this->fail || !$find->rowCount()) {
            $this->message = "Grupo não encontrado.";
            return null;
        }
        
        return $find->fetchObject(__CLASS__);
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "id"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM  "
            . self::$entity . " " 
            . $this->order($order) 
            . $this->limit(), "limit={$limit}&offset={$offset}");

        if($this->fail || !$all->rowCount()) {
            $this->message = "Sua consulta não retornou nenhum grupo.";
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
            $groupId = $this->id;
            $group = $this->read("SELECT id FROM " . self::$entity . " WHERE name = :name AND id != :id", 
                "name={$this->name}&id={$groupId}");
            if($group->rowCount()) {
                $this->message = "O Grupo informado já está cadastrado.";
                return null;
            }
            
            $this->update(self::$entity, $this->safe(), "id = :id", "id={$groupId}");
            if($this->fail()) {
                $this->message = "Erro ao atualizar, verifique os dados.";
                return null;
            }

            $this->message = "Dados atualizados com sucesso.";
        }

        /** Create */
        if(empty($this->id)) {
            if($this->find($this->name)) {
                $this->message = "O grupo informado já está cadastrado.";
                return null;
            }
            $groupId = $this->create(self::$entity, $this->safe());
            if($this->fail()) {
                $this->message = "Erro ao cadastrar, verifique os dados.";
                return null;
            }
            $this->message = "Cadastro realizado com sucesso.";
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
            $this->message = "Não foi possível remover o grupo";
            return null;
        }
        $this->message = "Grupo foi removido com sucesso";
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
        $sql = (new CreateGroupsTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateGroupsTable())->down(self::$entity);
        return $this->dropTable($sql);
    }

}
