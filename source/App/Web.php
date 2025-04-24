<?php

namespace Source\App;

use League\Plates\Engine;
use Source\App\Api\Faqs;
use Source\Models\Faq\Question;

class Web
{
    private $view;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . "/../../themes/web","php");
    }

    public function home ()
    {
        //echo "<h1>Eu sou a Home...</h1>";
        echo $this->view->render("home",[]);
    }

    public function about ()
    {
        //echo "<h1>Eu sou a Home...</h1>";
        echo $this->view->render("about",[]);
    }

    public function contact ()
    {
        echo $this->view->render("contact",[]);
    }


    public function loginRegister ()
    {
        echo $this->view->render("login-register",[]);
    }

    public function faqs(): void
    {
        // $question = new Question();
        // $questions = $question->selectAll();
        //var_dump($questions);
        // echo $this->view->render("faqs",[
        //     "questions" => $questions
        // ]);
        echo $this->view->render("faqs",[]);
    }
    public function error (array $data)
    {
        var_dump($data);
    }

}