<?php

//@MikeRzhevsky miker.ru@gmail.com
spl_autoload_register(function($class) {
    require   ROOT . '/' . str_replace('\\','/',$class) . '.php';
});
