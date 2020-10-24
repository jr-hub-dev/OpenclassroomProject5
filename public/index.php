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

    //Page Post
} elseif ('post' === $_GET['objet']) {
    $postController = new PostController;
    if ('view' === $_GET['action']) {
        $postController->view($_GET['id']);
        //Creation du post
    } elseif ('create' === $_GET['action']) {
        $postController->create();
        //Modification du post  
    } elseif ('modify' === $_GET['action']) {
        $postController->modify($_GET['id']);
        //Suppression du post
    } elseif ('delete' === $_GET['action']) {
        $postController->delete($_GET['id']);
    }
    //Affiche liste des posts
    elseif ('postsList' === $_GET['action']) {
        $postController->displayAll();
    }
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
} elseif ('comment' === $_GET['objet']) {
    $commentController = new CommentController;
    if ('alert' === $_GET['action']) {
        $commentController->alert($_GET['id']);
    } elseif ('alerts' === $_GET['action']) {
        $commentController->displayAllAlerts();
    }elseif ('delete' === $_GET['action']) {
        $commentController->delete($_GET['id']);
    }elseif ('noAlert' === $_GET['action']) {
        $commentController->noAlert($_GET['id']);
    }
}
