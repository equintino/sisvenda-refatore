<?php

namespace Source\Controllers;

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
        $act["act"] = filter_input(INPUT_GET, "act", FILTER_SANITIZE_STRIPPED);
        $login["login"] = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRIPPED);
        $companyId["companyId"] = filter_input(INPUT_GET, "companyId", FILTER_SANITIZE_STRIPPED);
        $users["users"] = (new \Source\Models\User())->find(["IDEmpresa" => $companyId["companyId"]]);
        $user["user"] = (new \Source\Models\User())->find($login["login"]);
        $groups["groups"] = (new \Source\Models\Group())->all();
        $params = [ $act, $login, $companyId, $users, $user ];

        echo "<script>var companyId = '" . $companyId["companyId"] . "' </script>";
        $this->view->setPath("Modals")->render("login", $params);
    }

    public function add()
    {
        $act = filter_input(INPUT_GET, "act", FILTER_SANITIZE_STRIPPED);
        $login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRIPPED);
        $companyId = filter_input(INPUT_GET, "companyId", FILTER_SANITIZE_STRIPPED);
        $users = (new \Source\Models\User())->find(["IDEmpresa" => $companyId]);
        $user = (new \Source\Models\User())->find($login);
        $groups = (new \Source\Models\Group())->all();
        echo "<script>var companyId = '" . $companyId . "' </script>";
        require __DIR__ . "/../Modals/login.php";
    }

    public function edit()
    {
        // $act = filter_input(INPUT_GET, "act", FILTER_SANITIZE_STRIPPED);
        // $login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRIPPED);
        // $companyId = filter_input(INPUT_GET, "companyId", FILTER_SANITIZE_STRIPPED);
        // $users = (new \Source\Models\User())->find(["IDEmpresa" => $companyId]);
        // $user = (new \Source\Models\User())->find($login);
        // $groups = (new \Source\Models\Group())->all();
        // echo "<script>var companyId = '" . $companyId . "' </script>";
        require __DIR__ . "/../Modals/login.php";
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

    public function change()
    {
        $params = $this->getPost($_POST);
        $user = (new \Source\Models\User())->find($params["Logon"]);
        $user->Senha = $user->crypt($params["Senha"]);
        $user->token = null;
        $user->save();
        return print(json_encode($user->message()));
    }

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
        $senha = $params["Senha"];
        $confSenha = $params["confSenha"];
        if($senha !== $confSenha) {
            print(json_encode("<span class='warning'>A senha não foi confirmada</span>"));
            die;
        }
        else {
            unset($params["confSenha"]);
        }
        return $params;
    }
}
