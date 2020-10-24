<?php

namespace App\Model;

use App\Model\Database;
use DateTime;

class PostManager extends Database
{
    //Récupère le post par id
    public function getPost($postId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT post_id, title, img_url, explanation, creation FROM post WHERE post_id = ?'); // formater la date dans la vue + table avec 5 champs
        $req->execute(array($postId));

        return $this->hydrate($req->fetch());
    }

    //Récupère les posts par id
    public function getPosts()
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT post_id, title, img_url, explanation, creation FROM post');
        $req->execute();
        $result = $req->fetchAll();

        $posts = [];
        foreach ($result as $post) {
            $posts[] = $this->hydrate($post);
        }

        return $posts;
    }

    // //Retourne le dernier post
    // public function returnLast()
    // {
    //     $bdd = $this->dbConnect();
    //     $req = $bdd->prepare('SELECT post_id, title, img_url, explanation, creation FROM post WHERE post_id = ( SELECT MAX(post_id) FROM post );');
    //     $req->execute(array());

    //     return $this->hydrate($req->fetch());
    // }

    //Création nouveau post
    public function create($data)
    {
var_dump($data['title']);
var_dump($data['url']);
var_dump($data['explanation']);
var_dump($data['date']);

        $bdd = $this->dbConnect();
        $req = $bdd->prepare('INSERT INTO post(title, img_url, explanation, creation) VALUES (?, ?, ?, ?)');
        
        return $req->execute(array($data['title'], $data['url'], $data['explanation'], $data['date']));
    }

    //Suppression post
    public function delete($postId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('DELETE FROM post WHERE post_id = ?');

        return $req->execute(array($postId));
    }

    //Hydratation de l'objet
    public function hydrate($data)
    {
        var_dump($data['title']);
        $post = new Post();
        $post
            ->setId($data['post_id'])
            ->setTitle($data['title'])
            ->setUrl($data['img_url'])
            ->setExplanation($data['explanation'])
            ->setCreationDate(new Datetime($data['creation']));

        return $post;
    }
}
