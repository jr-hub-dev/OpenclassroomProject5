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
                        $errors[] = '<p class ="errorLogin">Veuillez entrer un login</p>';
                    } elseif (strlen($this->userClean['userLogin']) < 5) {
                        $errors[] = '<p class ="errorLogin">Votre login doit faire plus de 5 lettres</p>';
                    }
                }
                //Verification du mot de passe
                if (array_key_exists('userPassword', $this->userClean) && '' === $this->userClean['userPassword']) {
                    $errors[] = '<p id="errorMdp">Veuillez entrer un mot de passe';
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
        if (empty($_SESSION)) {
            $errors = $this->cleanData();

            if (!empty($this->userClean) && empty($errors)) {
                $userManager = new UserManager();
                $login = $this->userClean['userLogin'];
                $password = $this->userClean['userPassword'];
                $userManager->checkUser($login, $password);
            }

            $template = 'loginPage';
            include '../view/layout.php';
        } else {
            echo 'Vous êtes déjà loguer';
        }
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
        $userManager = new UserManager();
        $userManager->isAdmin();
        if (!empty($_SESSION) && $_SESSION['userLevel'] == 'admin') {
            $template = 'adminPage';
            include '../view/layout.php';
        } else {
            header('Location: index.php?action=home');
        }
    }
    public function displayUsers() //juste check
    {
        $userManager = new UserManager();
        $userManager->isAdmin();
        if (!empty($_SESSION)) {
            $userManager = new UserManager;
            $users = $userManager->displayUsers();

            $template = 'alertsUser';
            include '../view/layout.php';
        } else {
            header('Location: index.php?action=home');
        }
    }


    //Creation nouveau
    public function create()
    {
        $errors = $this->cleanData();

        if (!empty($this->userClean) && empty($errors)) {

            $userManager = new UserManager();
            $userManager->checkLoginPassword($this->userClean);

            $template = 'validationPage';
            include '../view/layout.php';
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

        $template = 'userDelete';
        include '../view/layout.php';
    }
    //Modifier un user
    /**
     * Test le fichier à uploader
     */
    public function testFile()
    {
        if (!empty($_SESSION)) {

            if (isset($_POST['submit'])) {

                $maxSize = 2000000;
                $validExt = array('.jpg', '.jpeg', '.png');
                $fileSize = $_FILES['uploaded_file']['size'];
                $fileName = $_FILES['uploaded_file']['name'];
                $fileExt = "." . strtolower(substr(strrchr($fileName, '.'), 1));

                if ($_FILES['uploaded_file']['error'] > 0) {
                    echo 'une erreur est survenue';
                } elseif ($fileSize > $maxSize) {
                    echo '<p class ="uploadError">le fichier est trop gros</p>';
                } elseif (!in_array($fileExt, $validExt)) {

                    echo '<p class ="uploadError">L\'extension n\'est pas bonne (le fichier doit être un format .jpg .jpeg ou .png)</p>';
                } else {
                    $this->upload($fileExt);
                }
            }
            $template = 'fileUpload';
            include '../view/layout.php';
        } else {
            echo "Vous devez être identifié pour accéder à cette page";
        }
    }
    /**
     * Upload du fichier
     */
    public function upload($fileExt)
    {
        $userManager = new UserManager();
        $userManager->uploadFile($fileExt);
    }
}
