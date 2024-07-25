<?php

require_once("controllers/DefaultController.php");
require_once("controllers/AuthController.php");

class Router
{
    public function __construct()
    {

    }

    public function handleRequest(array $get)
    {
        $dc = new DefaultController();
        $ac = new AuthController();

        if(isset($get["route"]) && $get["route"] === "login")
        {
            $ac->login();
        }
        else if(isset($get["route"]) && $get["route"] === "check-login")
        {
            $ac->checkLogin();
        }
        else if(isset($get["route"]) && $get["route"] === "register")
        {
            $ac->register();
        }
        else if(isset($get["route"]) && $get["route"] === "check-register")
        {
            $ac->checkRegister();
        }
        //page test validateEmail
        else if (isset($get["route"]) && $get["route"] === "validation")
        {
            $ac->checkRegister();
        }
        else if(isset($get["route"]) && $get["route"] === "validate")
        {
            $ac->validateMail();
        }
        else if(isset($get["route"]) && $get["route"] === "logout")
        {
            $ac->logout();
        }
        else if(isset($get["route"]) && $get["route"] === "homepage-user")
        {
            $dc->profile();
        }
        else if(!isset($get["route"]))
        {
            $dc->home();
        }
        else
        {
            $dc->_404();
        }
    }
}