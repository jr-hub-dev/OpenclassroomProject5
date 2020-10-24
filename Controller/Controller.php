<?php

namespace App\Controller;



class Controller
{   //Redirection vers home
    public function home()
    {
        $template = 'home';
        include '../view/layout.php';
    }
}
