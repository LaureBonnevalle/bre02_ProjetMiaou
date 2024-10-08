<?php

class DefaultController extends Router
{
    /*public function __construct()
    {

    }*/
    
    public function homepage() : void
    {
        $this->render('homepage', 'layout', [
            'page'      => 'Accueil',
        ]);
    }
    
    public function homepageUser() : void
    {
        /*if(isset($_SESSION["user"]))
        {
            
            $user = $_SESSION["user"];

           
        }
        else
        {
            $this->render("login.html.twig", []);
        }*/
         $this->render('homepage-user', 'layout', [
                'page'    => 'Accueil',
                //'connect' => $_SESSION['user'],
            ]);
        
    }
    public function _404() : void
    {
        $this->render("404", []);
    }
}