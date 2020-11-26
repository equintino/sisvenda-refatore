<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Database\Migrations\CreateUsersTable;
use Source\Models\Group;

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

    public function load(int $id, string $columns = "*"): ?User
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id=:id", "id={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "<span class='warning'>Usuario não encontrado do id informado</span>";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    /** @var $busca array|string */
    public function find($search, string $columns = "*")
    {
        $login = &$search;
        if(is_array($search)) {
            foreach($search as $columnName => $value) {
                $params = "{$columnName}=:{$columnName}";
                $terms = "{$columnName}={$value}";
            }
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$params} AND Nome != 'Administrador' ", $terms);
        }
        elseif(filter_var($search, FILTER_VALIDATE_EMAIL)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Email=:Email", "Email={$search}");
        }
        elseif(filter_var($login, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Logon=:Logon", "Logon={$login}");
        }
        else {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Nome=:Nome", "Nome={$login}");
        }

        if($this->fail || !$find->rowCount()) {
            $this->message = "<span class='warning'>Usuario não encontrado do email informado</span>";
            return null;
        }

        return (is_array($search) ? $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__) : $find->fetchObject(__CLASS__));
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*", string $order = "id"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM  "
            . self::$entity . " "
            . $this->order($order)
            . $this->limit(), "limit={$limit}&offset={$offset}");

        if($this->fail || !$all->rowCount()) {
            $this->message = "<span class='warning'>Sua consulta não retornou usuários</span>";
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function save(): ?User
    {
        if(!$this->required()) {
            return null;
        }

        /** Update */
        if(!empty($this->id)) {
            $userId = $this->id;
            $email = $this->read("SELECT id FROM " . self::$entity . " WHERE Email = :Email AND id != :id",
                "Email={$this->Email}&id={$userId}");
            if($email->rowCount()) {
                $this->message = "<span class='warning'>O e-mail informado já está cadastrado</span>";
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>";
                return null;
            }

            $this->message = "<span class='success'>Dados atualizados com sucesso</span>";
        }

        /** Create */
        if(empty($this->id)) {
            if($this->find($this->Email)) {
                $this->message = "<span class='warning'>O e-mail informado já está cadastrado</span>";
                return null;
            }
            elseif($this->find($this->Logon)) {
                $this->message = "<span class='warning'>O login informado já está cadastrado</span>";
                return null;
            }
            $userId = $this->create(self::$entity, $this->safe());
            if($this->fail()) {
                $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                return null;
            }
            $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";
        }
        $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE id=:id", "id={$userId}")->fetch();

        return $this;
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

    // public function crypt($passwd)
    // {
    //     return base64_encode($passwd);
    //     /** new project */
    //     //return crypt($passwd, "rl");
    // }

    // public function validate($passwd, $hash)
    // {
    //     return $passwd === base64_decode($hash->Senha);
    //     /** new project */
    //     //return crypt($passwd, $hash) == $hash;
    // }

    public function token(string $login = null)
    {
        $userId = $this->id;
        if(!empty($userId)) {
            $this->token = crypt("Gera Token", "rl");
            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
        }
        if($this->fail()) {
            $this->message = "<span class='danger'>Erro ao resetar senha, tente novamente</span>";
            return null;
        }
        $this->message = "<span class='warning'>Nova senha de <span class='uppercase'>{$login}</span> será cadastrada no próximo login</span>";
    }

}
