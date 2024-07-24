<?php

class DefaultController extends AbstractController
{
    public function __construct()
    {

    }
    
    public function home() : void
    {
        header("Location: index.php?route=login");
    }
    
    public function profile() : void
    {
        if(isset($_SESSION["user"]))
        {
            $template = "profile";
            $user = $_SESSION["user"];

            require "templates/layout.phtml";
        }
        else
        {
            header("Location: index.php?route=login");
        }
    }
    public function _404() : void
    {
        $template = "404";

        require "templates/layout.phtml";
    }
}