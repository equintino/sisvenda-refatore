<?php

namespace Test;

use Source\Database\CreationProcess;

class CreationTableTest
{
    private $class;
    private $data;
    private $busca;

    public function __construct($local)
    {
        $creation = new CreationProcess();
        $creation->define($local);
    }

    public function testTable($class, array $data, array $busca)
    {
        $this->class = $class;
        $this->data = $data;
        echo $this->createTable();
        echo $this->insertData();
        echo $this->findData($busca);
        echo $this->updateData();
        echo $this->deleteData();
        echo $this->destroyTable();
    }

    private function createTable()
    {
        if($this->class->createThisTable()) {
            return "<p style='color: green'>- Teste de criação ok</p>";
        }
        return "<p style='color:red'>- Erro ao criar tabela</p>";
    }

    private function insertData()
    {
        /** test */
        $this->class->bootstrap($this->data);
        $this->class->save();

        return "- " . $this->class->message() . "<br>";
    }

    private function findData($busca)
    {
        foreach($busca as $value) {
            $data = $this->class->find($this->data[$value]);
            if(!empty($data)) {
                echo "<p style='color: green'>- Busca por {$value} - ok</p>";
            }
            else {
                echo "<p style='color: red'>- Busca por {$value} - erro</p>";
            }
        }
    }

    private function updateData()
    {
        $update = $this->class->load(1);
        if($update) {
            foreach($update as $field => $value) {
                $update[$field] = 1;
            }
            $update->save();
            return "- " . $update->message() . "<br>";
        }
    }

    private function deleteData()
    {
        $delete = $this->class->load(1);
        if($delete) {
            $delete->destroy();
            return "- " . $delete->message() . "<br>";
        }
    }

    private function destroyTable()
    {
        if($this->class->dropThisTable()) {
            return "<p style='color: green'>- Exclusão de tabela ok</p>";
        }
        return "<p style='color:red'>- Erro ao exluir tabela</p>";
    }
}
