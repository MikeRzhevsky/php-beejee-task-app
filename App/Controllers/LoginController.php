<?php

namespace App\Controllers;
use Views\View;

class LoginController
{
    public function actionLogin()
    {
        if(isset($_POST) && !empty($_POST)) {
            if($_POST['login'] == 'admin' && $_POST['password'] == '123') {
                $_SESSION['admin'] = 'true';
                header("Location: /tasks/");
            }
        }
        $view = new View();
        $view->display(ROOT . '/Views/Layouts/header.php');
        $view->display(ROOT . '/Views/Login/index.php');
        $view->display(ROOT . '/Views/layouts/footer.php');
        return true;
    }

    public function actionLogout()
    {
        session_destroy();
        header("Location: /tasks/");
    }
}