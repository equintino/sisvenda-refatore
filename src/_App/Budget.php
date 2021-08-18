<?php

namespace _App;

class Budget extends Controller
{
    private $loading;

    public function __construct()
    {
        parent::__construct();
        $this->loading = theme("assets/img/loading.png");
    }

    public function init(?array $data): void
    {
        $page = "budget";
        $loading = $this->loading;
        $salemanData = $_SESSION["login"];
        $companys = (new \Models\Company())->activeAll();
        $budgetDue = date('Y-m-d', strtotime("+10 days"));

        $this->view->render("budget", [ compact("page","loading","salemanData","companys","budgetDue") ]);
    }
}
