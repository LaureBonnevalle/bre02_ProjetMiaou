<?php

class DefaultController extends AbstractController {
    
    public function __construct()
    {
        parent::__construct();
    }

    public function homepage() : void
    {   
        $avatar = (new AvatarManager())->getByName("Miaou");
         unset($_SESSION['start_time']);
        $_SESSION['start_time'] = time(); // Initialiser le timer lors de l'affichage de la page d'accueil
        $timesModels = new TimesModels();
        $elapsedTime = $timesModels->getElapsedTime();
        $this->render("homepage.html.twig", ['elapsed_time' =>$elapsedTime, 'avatar' => $avatar, 'start_time' => $_SESSION['start_time']]);
    }

    public function homepageUser() : void
    {
        if (isset($_SESSION["user"])) {
            $am = new AvatarManager();
            $avatar = $am->getById($_SESSION['user']['avatar']);
            $_SESSION["user"];
            $timesModels = new TimesModels();
            $elapsedTime = $timesModels->getElapsedTime();
            $scripts = $this->addScripts([
                'assets/js/formController.js',
            ]);
            $this->render("homepage-user.html.twig", [
                'elapsed_time' =>$elapsedTime,
                'session' => $_SESSION,
                'connected' => $_SESSION['user'],
                'success_message' => $_SESSION['success_message'],
                'avatar' => [$avatar]
            ], [$scripts]);
        } else {
            $this->redirectTo('login');
        }
    }

    public function logout() : void
    {
        // Réinitialiser le timer lors de la déconnexion
        //echo "<script>localStorage.removeItem('startTime');</script>";
        unset($_SESSION['start_time']);
        $_SESSION[$session] = [];

        // Destroy the entire session, including all session data
        session_destroy();
        
        session_start();
        
        $_SESSION['error_message'] = "Déconnexion effectuée !";

        // Redirect to the default 'home' route if the 'route' parameter is not set
        $this->redirectTo('homepage');
    }
        
        
    

    public function _404() : void
    {
        $this->render("page404.html.twig", []);
    }
}
