<?php

namespace Source\App;

use League\Plates\Engine;

class Admin
{
    private $view;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . "/../../themes/adm","php");
    }

    public function home ()
    {
        echo $this->view->render("home",[]);
    }

    public function registers ()
    {
        echo $this->view->render("registers",[]);
    }

    public function users ()
    {
        echo $this->view->render("users",[]);
    }

}