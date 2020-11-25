<?php

namespace Source\_App;

use Source\Core\View;
use Source\Models\Company;
use Source\Models\Group;
use Source\Classes\AjaxTransaction;

class User extends Controller
{
    protected $page = " login";

    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        $companyId["companyId"] = filter_input(INPUT_GET, "companyId", FILTER_SANITIZE_STRIPPED);
        $companys["companys"] = (new Company())->all();
        $groups["groups"] = (new Group())->all();
        $users["users"] = (new \Source\Models\User())->find(["IDEmpresa" => $companyId["companyId"]]);
        $params = [ $companys, $groups, $companyId, $users ];

        $loading = [ "loading" => theme("img/loading.png") ];
        $page = [ "page" => "login" ];

        echo "<script>var companyId = '" . $companyId["companyId"] . "' </script>";
        $this->view->insertTheme([ $page, $loading ]);
        $this->view->render("login", $params);
    }

    public function list()
    {
        $data = $this->getGet($_GET);
        $login = $_SESSION["login"]->Logon;
        $users = (new \Source\Models\User())->find(["IDEmpresa" => $data["companyId"]]);
        $user = (new \Source\Models\User())->find($login);
        $groups = (new \Source\Models\Group())->all();
        $params = [ $data, compact("login", "users", "user", "groups") ];

        echo "<script>var companyId = '" . $data["companyId"] . "' </script>";
        $this->view->setPath("Modals")->render("login", $params);
    }

    public function add()
    {
        $data = $this->getGet($_GET);
        $groups = (new \Source\Models\Group())->all();
        $params = [ $data, compact("groups") ];

        $this->view->setPath("Modals")->render("login", $params);
    }

    public function edit()
    {
        $data = $this->getGet($_GET);
        $user = (new \Source\Models\User())->find($data["login"]);
        $groups = (new \Source\Models\Group())->all();
        $params = [ $data, compact("user", "groups") ];

        $this->view->setPath("Modals")->render("login", $params);
    }

    public function save()
    {
        $params = $this->getPost($_POST);
        $params["USUARIO"] = &$params["Logon"];
        $params = $this->confSenha($params);
        $user = new \Source\Models\User();

        $user->bootstrap($params);
        $user->save();
        return print(json_encode($user->message()));
    }

    public function update()
    {
        $params = $this->getPost($_POST);
        $user = (new \Source\Models\User())->find($params["Logon"]);

        foreach($params as $key => $value) {
            $user->$key = $value;
        }

        $user->save();
        return print(json_encode($user->message()));
    }

    // public function change()
    // {
    //     $params = $this->getPost($_POST);
    //     $user = (new \Source\Models\User())->find($params["Logon"]);
    //     $user->Senha = $user->crypt($params["Senha"]);
    //     $user->token = null;
    //     $user->save();
    //     return print(json_encode($user->message()));
    // }

    public function reset()
    {
        $params = $this->getPost($_POST);
        $user = (new \Source\Models\User())->find($params["Logon"]);
        $user->token();
        return print(json_encode($user->message()));
    }

    public function delete()
    {
        $params = $this->getPost($_POST);
        $user = (new \Source\Models\User())->find($params["Logon"]);
        $user->destroy();
        return print(json_encode($user->message()));
    }

    private function confSenha(array $params): ?array
    {
        $passwd = $params["Senha"];
        $confPasswd = $params["confSenha"];
        if($passwd !== $confPasswd) {
            print(json_encode("<span class='warning'>A senha não foi confirmada</span>"));
            die;
        }
        else {
            unset($params["confSenha"]);
        }
        return $params;
    }
}
