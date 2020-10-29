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
     *
     *  @param string  $loginClean Login de l'utilisateur recherché
     * @param string  $passwordClean le mdp à vérifier
     */
    public function checkUser(string $loginClean, string $passwordClean)
    {
        $bdd = $this->dbConnect();
        // nous utilisons une requête préparée pour éviter les injections SQL
        $req = $bdd->prepare('SELECT login, password, is_admin, alert FROM user WHERE login = :login');
        // on remplace la chaîne ":login" par la valeur de $loginClean
        $req->bindParam(':login', $loginClean);
        $req->execute();
        $resultat = $req->fetch();

        $password_checked = password_verify($passwordClean, $resultat['password']);

        $this->checkAlert($resultat, $password_checked, $loginClean);
    }

    /**
     * Permet de vérifier si l'inscription de l'utilisateur est validée avant connexion
     */
    public function checkAlert($resultat, $password_checked, $loginClean)
    {
        if ($resultat['alert'] == 0) {
            if ($password_checked) {
                $this->roleAssign($resultat, $loginClean);
            } else {
                echo 'Mauvais login ou mot de passe';
            }
        } elseif ($resultat['alert'] == 1) {
            echo 'Votre inscription est en attente';
        }
    }

    /**
     * Permet d'assigner les roles SESSION admin ou simple user aux utilisateurs
     *
     *  @param string  $loginClean Login de l'utilisateur recherché
     * @param string  $passwordClean le mdp à vérifier
     */
    public function roleAssign($resultat, string $loginClean)
    {
        $_SESSION['userLogin'] = $loginClean;
        $role = $resultat['is_admin'] == 1 ? "admin" : "user";
        $_SESSION['userLevel'] = $role;
        header('Location: index.php?action=home');
    }
    /**
     * Permet de dispacher le $_SESSION['userLevel'] : admin ou simple user
     */
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

    /**
     * Fonction de logout
     */
    public function logout()
    {
        session_destroy();
        $_SESSION = [];
    }

    /**
     * Permet de récupérer la liste des utilisateurs à valider
     */
    public function displayUsers()
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT id, login, password, email, creation FROM user WHERE alert = 1'); // formater la date dans la vue + table avec 5 champs
        $req->execute();
        $result = $req->fetchAll();

        return $this->hydrateMultiple($result);
    }

    /**
     * Permet de vérifier si login et email n'existent pas deja en db lors du sign up
     */
    public function checkLoginPassword($userClean)
    {
        $login = $userClean['userLogin'];
        $email = $userClean['userEmail'];

        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT login FROM user WHERE login = :login');
        if ($req) {
            $req->execute([':login' => $login]);
        }
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //On test si le login existe ou non en db
        if (!empty($result)) {
            echo 'Le login existe déjà';
            exit;
            //Si le login est ok, on test si l'email existe ou pas en db
        } else {
            $req2 = $bdd->prepare('SELECT email FROM user WHERE email = :email');
            $result2 = $req2->fetchAll(PDO::FETCH_ASSOC);
            if ($req2) {
                $req2->execute([':email' => $email]);
            }
            $result2 = $req2->fetchAll(PDO::FETCH_ASSOC);
        }
        if (!empty($result2)) {
            echo 'Cet email est déjà utilisé';
            exit;
            //Si le login ou l'email sont tous les deux ok, on enregistre l'utilisateur en db
        } else {
            $this->create($userClean);
        }
    }

    /**
     * Permet d'enregistrer le nouvel utilisateur avec une alerte fixée à 1 pour ressortir à valider par l'admin
     */
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

    /**
     * Permet de supprimer un utilisateur lors de la validation de l'inscription
     */
    public function delete($userId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('DELETE FROM user WHERE id = ?');

        return $req->execute(array($userId));
    }

    /**
     * Hydration de l'objet user
     */
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

    /**
     * Hydration multiple pour faire ressortir liste des nouveaux utilisateurs
     */
    public function hydrateMultiple($result)
    {
        $users = [];
        foreach ($result as $user) {
            $users[] = $this->hydrate($user);
        }

        return $users;
    }
}
