<?php

class DefaultController extends AbstractController
{
    /*public function __construct()
    {

    }*/
    
    public function homepage() : void
    {
        $this->render("homepage.html.twig", []);
    }
    
    public function homepageUser() : void
    {
        if(isset($_SESSION["user"]))
        {
            
            $user = $_SESSION["user"];

            $this->render("homepage-user.html.twig", ['connect' => $_SESSION['user']]);
        }
        else
        {
            $this->render("login.html.twig", []);
        }
    }
    public function _404() : void
    {
        $this->render("404.html.twig", ['connect' => $_SESSION['user']]);
    }
}