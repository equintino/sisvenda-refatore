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
        static::$safe = ["ID_PJURIDICA","id","created_at","updated_at"];
        if(!$this->required()) {
            return null;
        }

        /** accent worlds */
        $this->accentWorlds = [ "Situacao" => "Situação", "Credito" => "Crédito", "Salario" => "Salário" ];

        /** Validate fields */
        $this->validateFields();

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

        ( $this->fail() ? $this->message = "<span class='danger'>Erro ao atualizar, verifique os dados</span>" : $this->message = "<span class='success'>Dados atualizados com sucesso</span>" );

        return null;
    }

    public function create_()
    {
        if($this->CPF) {
            if($this->find($this->CPF)) {
                $this->message = "<span class='warning'>Cliente informado já está cadastrado</span>";
            } else {
                $this->otherCompanies(["CPF" => $this->CPF]);
                if($this->fail()) {
                    $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                    return null;
                }
                $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";

                //$data = $this->read("SELECT * FROM " . self::$entity . " WHERE ID_PFISICA=:ID_PFISICA", "ID_PFISICA={$id}");
                //$this->data = ($data? $data->fetch() : null);
            }
            return $this->data;
        } elseif($this->CNPJ) {
            if($this->find($this->CNPJ)) {
                $this->message = "<span class='warning'>Cliente informado já está cadastrado</span>";
            } else {
                $this->otherCompanies(["CNPJ" => $this->CNPJ]);
                if($this->fail()) {
                    $this->message = "<span class='danger'>Erro ao cadastrar, verifique os dados</span>";
                    return null;
                }
                $this->message = "<span class='success'>Cadastro realizado com sucesso</span>";

                //$this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE ID_PJURIDICA=:ID_PJURIDICA", "ID_PJURIDICA={$id}")->fetch();
            }
            //return $this->data;
        }
    }

    /**
     * @var $where array
     */
    protected function otherCompanies(array $where = [])
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
            $this->setSafe("id,DataReg,created_at,ID_PFISICA,ID_PJURIDICA,transpCompanyId,transpCnpj");
            $this->data->IDEmpresa = $company->ID;

            $transport = $this->getTransport($this->data->transpCnpj ?? null, $company->ID);
            if(!empty($transport)) {
                $this->data->IDTransportadora = $transport->IDTransportadora;
            }

            $login = $_SESSION["login"]->Logon ?? null;
            $saleman = $this->getSaleman($login, $company->ID);
            if(!empty($saleman)) {
                $this->data->Vendedor = $saleman->ID_Vendedor;
            }


            if($client->fetch()) {
                $this->setSafe("id,created_at,updated_at,DataReg,transpCompanyId,transpCnpj,Tipo");
                $this->update(self::$entity, $this->safe(), "{$terms} AND IDEmpresa={$company->ID}", "{$params}");
            } else {
                $this->data->DataReg = date("d/m/Y H:i:s");
                $this->setSafe("id,created_at,updated_at,transpCompanyId,transpCnpj,Tipo,DataReg");
                $cpfCnpj = (!empty($this->data->CPF) ? "ID_PFISICA" : "ID_PJURIDICA");
                $this->data->$cpfCnpj = $this->lastId();
                $this->create(self::$entity, $this->safe());
            }
        }
        //return $id ?? null;
    }

    // private function setSafe(string $safe)
    // {
    //     static::$safe = explode(",",$safe);
    // }

    private function lastId(): int
    {
        if(!empty($this->data->CPF)) {
            $lastData = $this->all(1,0,"*","ID_PFISICA DESC");
            $lastId = ($lastData ? $lastData[0]->ID_PFISICA + 1 : 1);
        } else {
            $lastData = $this->all(1,0,"*","ID_PJURIDICA DESC");
            $lastId = ($lastData ? $lastData[0]->ID_PJURIDICA + 1 : 1);
        }
        return $lastId;
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

    private function validateFields(): void
    {
        if(!empty($this->data->Atividade)) {
            $this->data->Atividade = substr($this->data->Atividade, 0, 29);
        }
        if(!empty($this->data->DataNasc)) {
            $this->data->DataNasc = dateFormat($this->data->DataNasc);
        }

        /** Default fields */
        $defaultFields = [
            "Bloqueio" => "NÃO",
            "Situacao" => "BOM",
            "Conceito" => "BOM",
            "Revenda" => 1,
            "Credito" => '1000.0000'
            // "BloqueioAVista" => 0,
            // "BloqueioAPrazo" => 0,
            // "OBSVENDA" => 0,
            // "CFOPe" => 0,
            // "CFOPs" => 0,
            // "PersonalizaE" => 0,
            // "PersonalizaS" => 0,
            // "EspePagamento" => 0,
            // "ECF" => 0,
            // "consumidorFinal" => 0
        ];
        if(!empty($this->data->CPF)) {
            $add = [
                "Sexo" => "MASCULINO",
                "EstCivil" => "SOLTEIRO",
                "Salario" => "0.0000"
            ];
            $defaultFields = array_merge($defaultFields, $add);
        }
        foreach($defaultFields as $k => $v) {
            $k = ($this->accentWorlds[$k] ?? $k);
            $this->data->$k = ($this->data->$k ?? $v);
        }
    }

    private function getTransport(?string $cnpj, int $companyId = null)
    {
        $transport = new Transport();
        $terms = "Cnpj = :Cnpj AND IDEmpresa = :IDEmpresa";
        $params = "Cnpj={$cnpj}&IDEmpresa={$companyId}";
        return $transport->read("SELECT * FROM " . $transport::$entity . " WHERE {$terms}", $params)->fetch();
    }

    private function getSaleman(?string $login, int $companyId = null)
    {
        $saleman = new Saleman();
        $terms = "LogON = :LogON AND IDEmpresa = :IDEmpresa";
        $params = "LogON={$login}&IDEmpresa={$companyId}";
        return $saleman->read("SELECT * FROM " . $saleman::$entity . " WHERE {$terms}", $params)->fetch();
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
