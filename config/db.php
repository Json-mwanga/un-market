<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . (getenv('MYSQLHOST') ?: 'shortline.proxy.rlwy.net') . 
             ';port=' . (getenv('MYSQLPORT') ?: '28704') . 
             ';dbname=' . (getenv('MYSQLDATABASE') ?: 'railway'),
    'username' => getenv('MYSQLUSER') ?: 'root',
    'password' => getenv('MYSQLPASSWORD') ?: 'IZezOaVCEMegHhDKOcfYjetCvqxSQzEJ',
    'charset' => 'utf8',
];

