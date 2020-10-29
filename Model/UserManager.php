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
        $req = $bdd ->prepare('SELECT login, password, is_admin FROM user WHERE login = :login');
        // on remplace la chaîne ":login" par la valeur de $loginClean
        $req->bindParam(':login', $loginClean);
        $req->execute();
        $resultat = $req->fetch();
        var_dump($resultat['is_admin']);

        $password_checked = password_verify($passwordClean, $resultat['password']);
        var_dump($password_checked);
        
        if ($password_checked) { 
            $_SESSION['userLogin'] = $loginClean;
            var_dump($_SESSION['userLogin']);
            $role = $resultat['is_admin'] == 1 ? "admin": "user";
            var_dump($role);
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

    public function checkLoginPassword($userClean){
        $login = $userClean['userLogin'];
        $email = $userClean['userEmail'];

        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT login FROM user WHERE login = :login');
        if($req){
            $req->execute([':login'=> $login]);
        }

        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result);
        
        if(!empty($result)){
            var_dump('Le login existe déjà');
            die;
        } else {
            $req2 = $bdd->prepare('SELECT email FROM user WHERE email = :email');
            $result2 = $req2->fetchAll(PDO::FETCH_ASSOC);
            if($req2){
                $req2->execute([':email'=> $email]);
            }
            $result2 = $req2->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result2);
        } if(!empty($result2)){
            var_dump('Cet email est déjà utilisé');
            die;
        } else {
            $this->create($userClean);
        }
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
