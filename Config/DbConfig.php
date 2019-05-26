<?php
namespace Config;

class DbConfig
{
    public static function getDbConfig()
    {
        return
        ['host' => 'localhost',
        'dbname' =>'Tutorial',
        'user' => 'user',
        'password' => ''];
    }
}