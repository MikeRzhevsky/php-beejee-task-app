<?php

namespace App\Controllers;
use App\Models\Tasks;
use Views\View;

class TasksController
{
    public static $tasksOnPage = 3;//in controller only

    public static $sortby  = ["username", "email", "status"];// Field names

    /**
     * @return mixed
     */
    public function getSort()
    {
        $key     = array_search($_GET['sort'], self::$sortby); // See if we have such a name
        $sort = self::$sortby[$key]; // If not, first one will be set automatically. smart enuf
        return $sort;
    }

    /**
     * @param $view
     * @param $isAdd
     */
    public function display($view,$isAdd)
    {
        $view->display(ROOT. '/Views/Layouts/header.php');
        $isAdd?$view->display(ROOT . '/Views/Task/add.php'):$view->display(ROOT. '/Views/Task/index.php');
        $view->display(ROOT. '/Views/Layouts/footer.php');
    }

    /**
     * @return bool
     */
    public function actionList()
    {
        if(isset($_POST) && !empty($_POST) && (!empty($_POST['taskid']) || !empty($_POST['status']) || !empty($_POST['description']) )){ //check post params
            $this->actionSave($_POST['taskid'],$_POST['status'],$_POST['description']);
        }
        $view = new View();
        $view ->tasksList = Tasks::getTasks($this->getSort());
        $view ->numberOfPages = Tasks::getNumberOfPages();
        $this->display($view,false);
        return true;
    }


    /**
     * @param $pageNumber
     * @return bool
     */
    public function actionPage($pageNumber)
    {
        $numberOfPages = Tasks::getNumberOfPages();

        if ($pageNumber < 1 || $pageNumber > $numberOfPages)
            die();

        if(isset($_POST) && !empty($_POST))
            $this->actionSave($_POST['taskid'],$_POST['status'],$_POST['description']);

        $view = new View();
        $view ->numberOfPages = $numberOfPages;
        $view ->tasksList = Tasks::getTasksOnPage($pageNumber,$this->getSort() );
        $this->display($view,false);

        return true;
    }

    /**
     * @return bool
     */
    public function actionAdd()
    {
        if(isset($_POST) && !empty($_POST))
        {
            Tasks::addTaskToDB($_POST, $_FILES);
            header("Location: /tasks/");
        }

        $view = new View();
        $this->display($view,true);

        return true;
    }

    /**
     * @param $id
     * @param $status
     * @param $desc
     * @return bool
     */
    public function actionSave($id,$status,$desc)
    {
        if(!empty($_SESSION) && $_SESSION['admin'] && isset($id) && !empty($id))
        {
            Tasks::saveTaskChanges($id,$desc,$status );
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

        return true;
    }

}