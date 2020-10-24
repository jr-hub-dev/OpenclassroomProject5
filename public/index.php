<?php

use App\Controller\Controller;
use App\Controller\PostController;
use App\Controller\CommentController;
use App\Controller\UserController;

session_start();


spl_autoload_register(function ($class) {
    $class = '../' . str_replace("\\", '/', $class) . '.php';
    $class = str_replace("App/", '', $class);

    if (is_file($class)) {
        require_once($class);
    } else {
        //throw new CustomException('Erreur interne de chargement');       
    }
});


//Page d'accueil
if (!isset($_GET['action']) || 'home' === $_GET['action'] || '' === $_GET['action']) {
    $controller = new Controller;
    $controller->home();
} elseif ('post' === $_GET['objet']) {
    $postController = new PostController;
    if ('postsList' === $_GET['action']) {
        $postController->displayAll();
    }
    if ('view' === $_GET['action']) {
        $postController->view($_GET['id']);
}if ('create' === $_GET['action']) {
    $postController->create();
} elseif ('user' === $_GET['objet']) {
    $userController = new UserController;
    if ('view' === $_GET['action']) {
        $userController->view($_GET['id']);
    }
    //Creation du user
    elseif ('create' === $_GET['action']) {
        $userController->create();
    } elseif ('login' === $_GET['action']) {
        $userController->checkUser();
    } elseif ('logout' === $_GET['action']) {
        $userController->logout();
    }
}}