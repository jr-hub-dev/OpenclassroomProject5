<?php

namespace App\Controller;

use App\Model\CommentManager;

class CommentController
{
    private $commentClean = array();
    //Permet de signaler un commentaire
    public function alert($commentId)
    {
        $commentManager = new CommentManager();
        $commentManager->alert($commentId);
        $template = 'signal';
        include '../view/layout.php';
    }

    //Permet de signaler un commentaire
    public function noAlert($commentId)
    {
        $commentManager = new CommentManager();
        $commentManager->noAlert($commentId);
        header('Location: index.php?objet=comment&action=alertsComment');
        exit;
    }

    //Permet d'afficher les alertes
    public function displayAllAlerts()
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->getAllByAlert();
        $template = 'alertsComment';
        include '../view/layout.php';
    }

    //Supprimer un comment
    public function delete($commentId)
    {
        $commentManager = new CommentManager();
        $comment = $commentManager->getcomment($commentId);

        if (!empty($comment)) {
            if ($commentManager->delete($commentId)) {
                header('Location: index.php');
                exit;
            }
            header('Location: index.php?objet=comment&action=delete&id=' . $commentId);
        }

        $template = 'commentDelete';
        include '../view/layout.php';
    }

    //Affiche la list des comments
    public function displayAll()
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->getComments(); //get AllbyAlert
    }
}
