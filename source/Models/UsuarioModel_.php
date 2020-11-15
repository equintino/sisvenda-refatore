<?php

namespace Source\Model;

use Source\Dao\Dao4;
use Source\Dao\CriterioBusca;
use Source\Model\Parameter\Find;
use Source\Core\Model;

/**
 * Description of UsuarioModel
 *
 * @author edmilson
 */
class UsuarioModel extends Model {
    protected $guarded = [
    ];

    protected $tabela = 'Usuário';
    public $campos;
    private $find;
    private $dao4;
    private $search;
    private $model;

    public function __construct()
    {
        $this->dao4 = new Dao4();
        $this->search = new CriterioBusca();
        $this->find = new Find();
        $this->model = new Model();

        $this->search->setTabela('Usuário');
    }

    public function getCampos()
    {
        return $this->campos;
    }

    public function getAll($n)
    {
        //$dao4 = new Dao4();
        //$search = new CriterioBusca();
        //$search->setTabela($this->tabela);
        $this->search->setTop($n);
        $this->search->setArray( array() );
        $this->dao4->setOrder( array( "desc" => "Visivel" ) );
        $this->dao4->setCampos($this->getCampo($this->tabela));

        foreach ($this->dao4->encontre($this->search) as $v)
        {
            $resp[] = $v->getArray();
        }

        return $resp;
    }

    public function find()
    {
        return $this->find;
    }

    public function update( Model $model )
    {
        /*$model->getArray()->setDataCancelado(date("Y-m-d H:i:s"));
            $this->dao4->setWhere( array( "IDEMPRESA" => $model->getArray()
                ->getIDEmpresa(), "Pedido" => $model->getArray()
                    ->getPedido() ) );

        return $this->dao4->grava( $model );*/
    }

    public function save( $obj )
    {
        /*$this->dao4->setWhere( array( "IDEMPRESA" => $obj->getIDEmpresa()
            , "Pedido" => $obj->getPedido() ) );*/

        /**
         * @example path description
         * <P> Impredir que tente gravar campos inexistentes </p>
         */
        /*$methods = get_class_methods($obj);
        foreach( $methods as $class )
        {
            if(preg_match('/^get/', $class))
            {
                if($obj->$class() !== null )
                {
                    $field = substr($class,3);
                    if(!in_array($field, $this->getCampo($this->search
                        ->getTabela())))
                    {
                        $setField = "set" . $field;
                        $obj->$setField(null);
                    }
                }
            }
        }

        $this->model->setArray($obj);
        $this->model->setTabela($this->search->getTabela());

        return $this->dao4->grava( $this->model );*/
    }

    public function getFind()
    {
        return $this->find;
    }

    public function setFind( CriterioBusca $search )
    {
        $search->setTabela($this->tabela);

        if(isset($this->find))
        {
            //$this->find->dao4->setIndex("Pedido");

            $this->find->search = $search;
        }

        return $this->find;
    }

    public function setWhere($search)
    {
        $this->dao4->setWhere($search->getArray());
        var_dump($search, $this->dao4);
    }

    private function setValida($search)
    {
        var_dump($search);die;
    }

}
