<?php

// return [
//     'class' => 'yii\db\Connection',
//     'dsn' => 'mysql:host=' . (getenv('MYSQLHOST') ?: 'shortline.proxy.rlwy.net') . 
//              ';port=' . (getenv('MYSQLPORT') ?: '28704') . 
//              ';dbname=' . (getenv('MYSQLDATABASE') ?: 'railway'),
//     'username' => getenv('MYSQLUSER') ?: 'root',
//     'password' => getenv('MYSQLPASSWORD') ?: 'IZezOaVCEMegHhDKOcfYjetCvqxSQzEJ',
//     'charset' => 'utf8',
// ]; 

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=mysite_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
