<?php
namespace Config;

class RoutesPath
{
    public static function getRoutes()
    {
        return array(
        'tasks/save/([a-z0-9]+)' => 'tasks/save/$1', //actionSave in TasksController
        'tasks/page/([0-9]+)' => 'tasks/page/$1', //actionPage in TasksController
        'task/add' => 'tasks/add', // actionAdd in TasksController
        'login' => 'Login/Login', // actionLogin in LoginController
        'logout' => 'Login/logout', // actionLogout in LoginController
        'tasks' => 'tasks/list', //actionList in TasksController
        '' => 'tasks/list', //actionListttasks in TasksController
        );
    }
}