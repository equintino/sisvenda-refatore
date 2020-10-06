<?php

namespace Models;

use Core\Model;
use Database\Migrations\CreateUsersTable;

class User extends Model implements Models
{
    /** @var string $entity database table */
    protected static $entity = "tb_usuario";

    /** @var array filds required */
    private $required = [ "Logon", "Senha", "IDEmpresa", "Visivel", "USUARIO", "Nome", "Email" ];

    public function setPasswd(string $passwd)
    {
        $this->Senha = $this->crypt($passwd);
    }

    public function load(int $id, string $columns = "*"): ?User
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id=:id", "id={$id}");

        if($this->fail || !$load->rowCount()) {
            $this->message = "Usuario não encontrado do id informado.";
            return null;
        }
        
        return $load->fetchObject(__CLASS__);
    }

    public function find(string $busca, string $columns = "*"): ?User
    {
        $login = &$busca;
        if(filter_var($busca, FILTER_VALIDATE_EMAIL)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Email=:Email", "Email={$busca}");
        }
        elseif(filter_var($login, FILTER_SANITIZE_STRIPPED)) {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Logon=:Logon", "Logon={$login}");
        }
        else {
            $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE Nome=:Nome", "Nome={$login}");
        }

        if($this->fail || !$find->rowCount()) {
            $this->message = "Usuario não encontrado do email informado.";
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
            $this->message = "Sua consulta não retornou usuários.";
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
                $this->message = "O e-mail informado já está cadastrado.";
                return null;
            }
            
            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
            if($this->fail()) {
                $this->message = "Erro ao atualizar, verifique os dados.";
                return null;
            }

            $this->message = "Dados atualizados com sucesso.";
        }

        /** Create */
        if(empty($this->id)) {
            if($this->find($this->Email) || $this->find($this->Logon)) {
                $this->message = "O e-mail ou login informado já está cadastrado.";
                return null;
            }
            $userId = $this->create(self::$entity, $this->safe());
            if($this->fail()) {
                $this->message = "Erro ao cadastrar, verifique os dados.";
                return null;
            }
            $this->message = "Cadastro realizado com sucesso.";
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
            $this->message = "Não foi possível remover o usuário";
            return null;
        }
        $this->message = "Usuário foi removido com sucesso";
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

        if(!filter_var($this->Email, FILTER_VALIDATE_EMAIL)) {
            $this->message = "O formato do e-mail não parece válido.";
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

    protected function crypt($passwd)
    {
        return base64_encode($passwd);
        /** new project */
        //return crypt($passwd, "rl");
    }

    public function validate($passwd, $hash): bool
    {
        return $passwd === base64_decode($hash);
        /** new project */
        //return crypt($passwd, $hash) == $hash;
    }

}
