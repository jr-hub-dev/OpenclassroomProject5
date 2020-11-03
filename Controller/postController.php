<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\CommentManager;

class PostController
{

    private $data = array();
    private $commentClean = array();


    public function cleanData()
    {
        $errors = [];
        if (!empty($_POST)) {

            //Verification du commentaire
            $this->commentClean = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            if (array_key_exists('comment', $this->commentClean) && '' === $this->commentClean['comment']) {
                $errors[] = 'Veuillez entrer un commentaire';
            }
        }

        return $errors;
    }

    /**
     * Afficher vue
     */
    public function view($postId)
    {
        if (!empty($_SESSION)) {

            $postManager = new PostManager();
            $post = $postManager->getPost($postId);

            //Traitement du formulaire
            $errors = $this->cleanData();
            $commentManager = new CommentManager();
            if (!empty($this->commentClean) && empty($errors)) {

                $commentManager->create($postId, $this->commentClean);

                header('Location: index.php?objet=post&action=view&id=' . $postId);
            }

            $comments = $commentManager->getAllByPostId($postId);

            $template = 'postView';
            include '../view/layout.php';
        } else {
            echo "Vous devez être authentifié pour accéder à cette page";
        }
    }


    public function getData()
    {
        $curl = curl_init('https://api.nasa.gov/planetary/apod?api_key=uQ71al00jCuNnjNYTfeGvzsHKWBessjLq2h24HpO');
        curl_setopt_array($curl, [
            CURLOPT_CAINFO => __DIR__ . DIRECTORY_SEPARATOR . '../certif/cert.cer',
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $data = curl_exec($curl);
        if ($data === false) { } else {
            $data = json_decode($data, true);
            echo '<pre>';
            // var_dump($data);
            // var_dump($data['title']);
            echo '</pre>';
        }
        curl_close($curl);

        return $data;
    }

    //Affiche la liste des posts
    public function displayAll()
    {
        if (!empty($_SESSION)) {
            $postManager = new PostManager();
            $posts = $postManager->getPosts();

            $template = 'postsList';
            include '../view/layout.php';
        } else {
            echo "Vous devez être authentifié pour accéder à cette page";
        }
    }
}
