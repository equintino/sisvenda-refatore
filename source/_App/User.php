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

    public function init(?array $data): void
    {
        $companyId = $data["companyId"] ?? null;//filter_input(INPUT_GET, "companyId", FILTER_SANITIZE_STRIPPED);
        $companys = (new Company())->all();
        $groups = (new Group())->all();
        $users = (new \Source\Models\User())->find(["IDEmpresa" => $companyId]);
        $params = [ compact("companys", "groups", "companyId", "users") ];

        $loading = theme("assets/img/loading.png");
        $page = "login";

        echo "<script>var companyId = '" . $companyId . "' </script>";
        $this->view->insertTheme([ compact("page", "loading") ]);
        $this->view->render("login", $params);
    }

    public function list(?array $data): void
    {
        $data["act"] = "list";
        $login = $_SESSION["login"]->Logon;
        $users = (new \Source\Models\User())->find(["IDEmpresa" => $data["companyId"]]);
        $user = (new \Source\Models\User())->find($login);
        $groups = (new \Source\Models\Group())->all();
        $params = [ $data, compact("login", "users", "user", "groups") ];

        echo "<script>var companyId = '" . $data["companyId"] . "' </script>";
        $this->view->setPath("Modals")->render("login", $params);
    }

    public function add(): void
    {
        $data["act"] = "edit";
        $groups = (new \Source\Models\Group())->all();
        $params = [ $data, compact("groups") ];

        $this->view->setPath("Modals")->render("login", $params);
    }

    public function edit(array $data): void
    {
        $data["act"] = "edit";
        $user = (new \Source\Models\User())->find($data["login"]);
        $groups = (new \Source\Models\Group())->all();
        $params = [ $data, compact("user", "groups") ];

        $this->view->setPath("Modals")->render("login", $params);
    }

    public function save(array $data): void
    {
        $data["USUARIO"] = &$data["Logon"];
        $data = $this->confSenha($data);
        $user = new \Source\Models\User();

        $user->bootstrap($data);
        $user->save();
        echo json_encode($user->message());
    }

    public function update(array $data): void
    {
        $user = (new \Source\Models\User())->load($data["id"]);
        foreach($data as $key => $value) {
            $user->$key = $value;
        }

        $user->save();
        echo json_encode($user->message());
    }

    public function reset(array $data): void
    {
        $user = (new \Source\Models\User())->find($data["Logon"]);
        $user->token($data["Logon"]);
        echo json_encode($user->message());
    }

    public function delete(array $data): void
    {
        $user = (new \Source\Models\User())->find($data["Logon"]);
        $user->destroy();
        echo json_encode($user->message());
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
