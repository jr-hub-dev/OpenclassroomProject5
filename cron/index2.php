<?php

use App\Service\ApodService;

spl_autoload_register(function ($class) {
    echo $class;
    $class = __DIR__ .
        '/' . str_replace(
            "App/",
            DIRECTORY_SEPARATOR . '../Service/',
            $class
        );
        echo $class . "\n";

    if (is_file($class)) {
        echo 1;
        require_once($class);
    } else {
        echo 2;
        //throw new CustomException('Erreur interne de chargement');       
    }
});

new ApodService();
