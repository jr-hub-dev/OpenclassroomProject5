<?php

namespace App\Model;

use App\Model\Database;
use DateTime;
//use Comment (ne marche pas si use Comment est utilisé sous windows en local)

class CommentManager extends Database
{ 

    public function getComment($commentId) 
    {   
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT id, post_id, content, creation FROM comment WHERE id = ?'); // formater la date dans la vue + table avec 5 champs
        $req->execute(array($commentId));

        return $this->hydrate($req->fetch());
    }

    public function getComments() 
    {   
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT id, post_id, content, creation FROM comment'); // formater la date dans la vue + table avec 5 champs
        $req->execute();
        $result = $req->fetchAll();


        $comments = [];
        foreach ($result as $comment) {

            $comments[] = $this->hydrate($comment);
        }
        
        return $comments;
    }

    public function getAllByPostId($postId) 
    {   
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT id, post_id, content, creation FROM comment WHERE post_id = ?'); // formater la date dans la vue + table avec 5 champs
        $req->execute(array($postId));
        
        return $this->hydrateMultiple($req->fetchAll());
    }

    public function getAllByAlert() 
    {   
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT id, post_id, content, creation FROM comment WHERE alert = 1'); // formater la date dans la vue + table avec 5 champs
        $req->execute();
        $result = $req->fetchAll();

        return $this->hydrateMultiple($result);
    }

    public function alert($commentId)
    {           
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('UPDATE comment SET alert = true WHERE id = ?');
        
        $req->execute(array($commentId));
    }

    public function noAlert($commentId)
    {
        $comment = $this->getComment($commentId);
        
        if (!empty($comment)) {
            $bdd = $this->dbConnect();
            $req = $bdd->prepare('UPDATE comment SET alert = 0 WHERE id = :commentId');
            $req->bindParam(':commentId', $commentId);
            $req->execute();
        }
    }

    public function create($postId, $commentClean)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('INSERT INTO comment(post_id, content, creation) VALUES (?, ?, NOW())');
        $req->execute(array($postId, $commentClean['comment']));
    }


    public function delete($commentId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('DELETE FROM comment WHERE id = ?');
        
        return $req->execute(array($commentId));
    }

    public function hydrate($data)
    {
        $comment = new Comment();
        $comment
            ->setId($data['id'])
            ->setPostNumber($data['post_id'])
            ->setContent($data['content'])
            ->setCreationDate(new DateTime($data['creation']))
        ;

        return $comment;    
    }


    public function hydrateMultiple($result)
    {
        $comments = [];
        foreach ($result as $comment) {
            $comments[] = $this->hydrate($comment);
        }
            
        return $comments;
    }
}