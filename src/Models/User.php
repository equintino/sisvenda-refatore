<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateUsersTable;
use Models\Group;

class User extends Model implements Models
{
    /** @var Models\Group */
    private $group;

    /** @var string $entity database table */
    public static $entity = "tb_usuario";

    /** @var array filds required */
    private $required = [ "Logon", "Senha", "IDEmpresa", "USUARIO", "Nome", "Email" ];

    public function getEntity()
    {
        return self::$entity;
    }

    public function setPasswd(string $passwd)
    {
        $this->Senha = $this->crypt($passwd);
    }

    public function load(int $id, string $columns = "*", bool $msgDb = false): ?User
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id=:id", "id={$id}", $msgDb);

        if($this->fail || !$load->rowCount()) {
            $this->message = "<span class='warning'>Usuario não encontrado do id informado</span>";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    /** @var $busca array|string */
    public function find($search, string $columns = "*", bool $msgDb = false)
    {
        $login = &$search;
        if(is_array($search)) {
            foreach($search as $columnName => $value) {
                $params = "{$columnName}=:{$columnName}";
                $terms = "{$columnName}={$value}";
            }
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$params} AND Nome != 'Administrador' ", $terms, $msgDb);
        } elseif(filter_var($search, FILTER_VALIDATE_EMAIL)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Email=:Email", "Email={$search}", $msgDb);
        } elseif(filter_var($login, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Logon=:Logon", "Logon={$login}", $msgDb);
        } else {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Nome=:Nome", "Nome={$login}", $msgDb);
        }

        if($this->fail || !$find->rowCount()) {
            if(!$msgDb) {
                $this->message = "<span class='warning'>Usuario não encontrado do email informado</span>";
            } else {
                $this->message = (empty($this->fail()) ?: $this->fail()->errorInfo[2]);
            }
            return null;
        }

        return (is_array($search) ? $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__) : $find->fetchObject(__CLASS__));
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "id", bool $msgDb = false): ?array
    {
        $all = $this->read("SELECT {$columns} FROM  "
            . self::$entity . " "
            . $this->order($order)
            . $this->limit(), "limit={$limit}&offset={$offset}", $msgDb);

        if($this->fail || !$all->rowCount()) {
            $this->message = "<span class='warning'>Sua consulta não retornou usuários</span>";
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function save(bool $msgDb = false): ?User
    {
        if(!$this->required()) {
            return null;
        }

        /** Update */
        if(!empty($this->id)) {
            $this->update_($msgDb);
        }

        /** Create */
        if(empty($this->id)) {
            $this->create_($msgDb);
        }
        $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE id=:id", "id={$this->id}")->fetch();

        return $this;
    }

    private function update_(bool $msgDb)
    {
        $email = $this->read("SELECT id FROM " . self::$entity . " WHERE Email = :Email AND id != :id",
            "Email={$this->Email}&id={$this->id}");
        if($email->rowCount()) {
            $this->message = "<span class='warning'>O e-mail informado já está cadastrado</span>";
            return null;
        }

        $this->update(self::$entity, $this->safe(), "id = :id", "id={$this->id}");
        if($this->fail()) {
            $this->message = (!$msgDb ? "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->fail()->errorInfo[2]);
            return null;
        }
        $this->message = "<span class='success'>Dados atualizados com sucesso</span>";
    }

    private function create_(bool $msgDb)
    {
        if($this->find($this->Email, "*", $msgDb)) {
            $this->message = "<span class='warning'>O e-mail informado já está cadastrado</span>";
            return null;
        } elseif($this->find($this->Logon, "*", $msgDb)) {
            $this->message = "<span class='warning'>O login informado já está cadastrado</span>";
            return null;
        }

        $this->id = $this->create(self::$entity, $this->safe());
        if($this->fail()) {
            $this->message = (!$msgDb ? "<span class='danger'>Erro ao cadastrar, verifique os dados</span>" : $this->fail()->errorInfo[2]);
            return null;
        }
        $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";
    }

    public function destroy(): ?User
    {
        if(!empty($this->id)) {
            $this->delete(self::$entity, "id=:id", "id={$this->id}");
        }

        if($this->fail()) {
            $this->message = "<span class='danger'>Não foi possível remover o usuário</span>";
            return null;
        }
        $this->message = "<span class='success'>Usuário foi removido com sucesso</span>";
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

        if(!filter_var($this->Email, FILTER_VALIDATE_EMAIL)) {
            $this->message = "<span class='warning'>O formato do e-mail não parece válido</span>";
            return false;
        }

        return true;
    }

    public function createThisTable()
    {
        $sql = (new CreateUsersTable())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateUsersTable())->down(self::$entity);
        return $this->dropTable($sql);
    }

    public function getGroup(): ?Group
    {
        if(!empty($this->Group_id)) {
            return $this->group = (new Group())->load($this->Group_id);
        }
        return $this->group = null;
    }

    public function token(string $login = null)
    {
        if(!empty($this->id)) {
            $this->token = crypt("Gera Token", "rl");
            $this->update(self::$entity, $this->safe(), "id = :id", "id={$this->id}");
        }
        if($this->fail()) {
            $this->message = "<span class='danger'>Erro ao resetar senha, tente novamente</span>";
            return null;
        }
        $this->message = "<span class='warning'>Nova senha de <span class='uppercase'>{$login}</span> será cadastrada no próximo login</span>";
    }

}
