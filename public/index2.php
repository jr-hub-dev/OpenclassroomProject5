<?php
use App\Service\ApodService;

spl_autoload_register(function ($class) {
    echo $class;
    $class = '../' . str_replace("\\", '/', $class) . '.php';
    $class = str_replace("App/", '', $class);
    echo $class;

    if (is_file($class)) {
        echo 1;
        require_once($class);
    } else {
        echo 2;
        //throw new CustomException('Erreur interne de chargement');       
    }
});

new ApodService();
