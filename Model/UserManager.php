<?php

namespace App\Model;

use App\Model\Database;
use DateTime;
use PDO;

class UserManager extends Database
{

    public function getUser($userId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT id, login, password, email, creation FROM user WHERE id = ?');
        $req->execute(array($userId));

        return $this->hydrate($req->fetch());
    }

    public function getUsers()
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT id, login, password, email, creation FROM user');
        $req->execute();
        $result = $req->fetchAll();

        $users = [];
        foreach ($result as $user) {
            $users[] = $this->hydrate($user);
        }

        return $users;
    }

    /**
     * Permet de 
     * 1 : récupérer un utilisateur
     * 2 : teste le mdp avec celui fournit par l'utilsiateur
     * 3 : assigne le role dans la variable de session de l'utilisateur
     *  
     * 
     * @param string  $loginClean Login de l'utilisateur recherché
     * @param string  $passwordClean le mdp à vérifier
     */
    public function checkUser(string $loginClean, string $passwordClean)
    {   
        $bdd = $this->dbConnect();
        // nous utilisons une requête préparée pour éviter les injections SQL
        $req = $bdd ->prepare('SELECT login, password FROM user WHERE login = :login');
        // on remplace la chaîne ":login" par la valeur de $loginClean
        $req->bindParam(':login', $loginClean);
        $req->execute();
        $resultat = $req->fetch();
        $password_checked = password_verify($passwordClean, $resultat['password']);
        
        if ($password_checked) { 
            $_SESSION['userLogin'] = $loginClean;
            // utilisation de la syntaxe dite 'ternaire'
            // equivalent à if($loginClean == "admin") {$level="admin"} else {$level="user"}
            $role = $loginClean == "admin" ? "admin": "user";
            $_SESSION['userLevel'] = $role;
            header('Location: index.php?action=home');
        }else{
            echo 'Mauvais login ou mot de passe';
        }
    }

    function isAdmin()
    {
        //Si la sesssion existe
        if (array_key_exists('userLevel', $_SESSION)) {

            //Si l'utilisateur est bien administrateur
            if ($_SESSION['userLevel'] === "admin") {
                return "admin";
            }
            //Si l'utilisateur est simple utilisateur
            if ($_SESSION['userLevel'] === "user") {
                return "user";
            }
        }
        return false;
    }

    //Fonction de déconnexion
    public function logout()
    {
        session_destroy();
        $_SESSION = [];
    }
    public function displayUsers()
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT id, login, password, email, creation FROM user WHERE alert = 1'); // formater la date dans la vue + table avec 5 champs
        $req->execute();
        $result = $req->fetchAll();

        return $this->hydrateMultiple($result);
    }

    //Fonction pour création nouvel utilisateur
    public function create($userClean)
    {
        //Cryptage du mot de passe
        $secure_pass = password_hash($userClean['userPassword'], PASSWORD_BCRYPT);

        $bdd = $this->dbConnect();
        $req = $bdd->prepare('INSERT INTO user(login, password, email, creation, alert) VALUES (?, ?, ?, NOW(), 1)');
        $req->execute(array($userClean['userLogin'], $secure_pass, $userClean['userEmail']));

        return $bdd->lastInsertId();
    }

    public function modify($userId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('UPDATE user SET login = ?, password = ?, email = ? = NOW() WHERE id = ?');

        return $req->execute(array(
            $userClean['userLogin'] = $_POST['userLogin'],
            $userClean['userPassword'] = $_POST['userPassword'],
            $userClean['userEmail'] = $_POST['userEmail'],
            $userId
        ));
    }
    //Fonction du suppression utilisateur
    public function delete($userId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('DELETE FROM user WHERE id = ?');

        return $req->execute(array($userId));
    }

    //Hydratation de l'objet utilisateur
    public function hydrate($data)
    {
        $user = new User();
        $user
            ->setId($data['id'])
            ->setLogin($data['login'])
            ->setPassword($data['password'])
            ->setEmail($data['email'])
            ->setCreationDate(new DateTime($data['creation']));

        return $user;
    }

    public function hydrateMultiple($result)
    {
        $users = [];
        foreach ($result as $user) {
            $users[] = $this->hydrate($user);
        }
            
        return $users;
    }
}
