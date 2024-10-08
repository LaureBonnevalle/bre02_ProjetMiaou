<?php

class DefaultController extends AbstractController {
    
    
    public function __construct()
    {
        parent::__construct();
    }
    
    
    
    public function homepage() : void
    {
        
        
        $scripts = $this->addScripts([
            'assets/js/formController.js',
            ]);
            
        $avatar= (new AvatarManager())->getByName("Miaou");
            $this->render("homepage.html.twig", ['avatar'=>$avatar],[$scripts]);
            
    }
    
    public function homepageUser() : void
    {
        if(isset($_SESSION["user"]))
        {   
            $_SESSION["user"];
            $am = new AvatarManager();
            $avatar = $am->getById($_SESSION['user']['avatar']);
            $_SESSION["user"];
            //$_SESSION['error_message'];
             $scripts = $this->addScripts([
            'assets/js/formController.js',
            ]);
            $this->render("homepage-user.html.twig", ['start_time'=>$_SESSION['start_time'],'session'=> $_SESSION,'connected' => $_SESSION['user'],'success_message'=> $_SESSION['success_message'],'avatar'=> [$avatar]],[$scripts]);
        }
        else
        {
            $this->render("login.html.twig", [],[$scripts]);
        }
    }
    public function _404() : void
    {
        $scripts = $this->addScripts([
            'assets/js/formController.js',
            ]);
        $this->render("404.html.twig", [],[$scripts]);
    }
    
    
}