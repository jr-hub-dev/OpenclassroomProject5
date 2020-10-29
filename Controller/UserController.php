<?php

namespace App\Controller;

use App\Model\UserManager;


class UserController

{
    private $userClean = array();

    public function cleanData()
    {
        $errors = [];

        if (!empty($_POST)) {
            $this->userClean = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            if (!empty($this->userClean)) {
                //Verification du login
                if (array_key_exists('userLogin', $this->userClean)) {
                    if ('' === $this->userClean['userLogin']) {
                        $errors[] = 'Veuillez entrer un login';
                    } elseif (strlen($this->userClean['userLogin']) < 5) {
                        $errors[] = 'Votre login doit faire plus de 5 lettres';
                    }
                }
                //Verification du mot de passe
                if (array_key_exists('userPassword', $this->userClean) && '' === $this->userClean['userPassword']) {
                    $errors[] = 'Veuillez entrer un mot de passe';
                }
            }
        }
        return $errors;
    }

    public function view($userId)
    {
        $userManager = new UserManager();
        $user = $userManager->getUser($userId);

        $template = 'userView';
        include '../view/layout.php';
    }

    public function checkUser() //juste check
    {
        $errors = $this->cleanData();

        if (!empty($this->userClean) && empty($errors)) {
            $userManager = new UserManager();
            $login = $this->userClean['userLogin'];
            $password = $this->userClean['userPassword'];
            $userManager->checkUser($login, $password);
        }

        $template = 'loginPage';
        include '../view/layout.php';
    }
    
    public function logout() //juste check
    {
        $userManager = new UserManager;
        $userManager->logout();

        $template = 'logoutPage';
        include '../view/layout.php';
    }
    public function admin() //juste check
    {
        $template = 'adminPage';
        include '../view/layout.php';
    }
    public function displayUsers() //juste check
    {
        $userManager = new UserManager;
        $users = $userManager->displayUsers();

        $template = 'alertsUser';
        include '../view/layout.php';
    }


    //Creation nouveau
    public function create()
    {
        $errors = $this->cleanData();

        if (!empty($this->userClean) && empty($errors)) {

            $userManager = new UserManager();
            $userId = $userManager->checkLoginPassword($this->userClean);

            header('Location: index.php?objet=user&action=view&id=' . $userId);
        }

        $template = 'userCreate';
        include '../view/layout.php';
    }

    public function validUser($userId)
    {
        $userManager = new UserManager();
        $userManager->validUser($userId);
        header('Location: index.php?objet=user&action=alertsUser');
        exit;
    }
    
    public function deleteUser($userId)
    {        
        $userManager = new UserManager();
        $user = $userManager->getuser($userId);

        if (!empty($user)) {
            if ($userManager->delete($userId)) {
                header('Location: index.php');
                exit;
            }
            header('Location: index.php?objet=user&action=delete&id=' . $userId);
        }

        $template = 'cuserDelete';
        include '../view/layout.php';
    }
    //Modifier un user
    public function modify($userId)
    {
        $userManager = new UserManager();
        $user = $userManager->getUser($userId);

        $this->cleanData();

        if (!empty($_POST)) {
            if ($userManager->modify($userId)) {
                header('Location: index.php?objet=user&action=view&id=' . $userId);
            }
        }

        $template = 'userModify';
        include '../view/layout.php';
    }
}
