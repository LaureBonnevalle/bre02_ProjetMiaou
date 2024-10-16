<?php

require_once("controllers/DefaultController.php");
require_once("controllers/AuthController.php");
date_default_timezone_set('Europe/Paris');
require_once("services/Functionality.php");
require_once("controllers/DashboardController.php");
require_once("controllers/GameController.php");
require_once("controllers/ColoriageController.php");
require_once("controllers/StoryController.php");
require_once("controllers/UserController.php");

class Router {
    public function __construct()
    {

    }

    public function handleRequest(array $get)
    {
        $func = new Functionality();
        $dc = new DefaultController();
        $ac = new AuthController();
        $dash = new DashboardController();
        $gm = new GameController();
        $cc = new ColoriageController();
        $sc = new StoryController();
        $uc = new UserController();

        $route = isset($get["route"]) ? $get["route"] : "homepage";

        switch ($route) {
            
            case "homepage":
                $dc->homepage();
            break;
            case "login":
                 $ac->login();
            break;
            case "check-login":
                $ac->checkLogin();
            break;
            case "register":
                $ac->register();
            break;
            case "check-register":
                $ac->checkRegister();
                break;
            case "modifyPassword":
                $ac->modifyPassword();
                break;
            case "homepageUser":
                $dc->homepageUser();
                break;
            case "profile":
                $dc->homepageUser();
                break;
            case "displayModify":
                $ac->displayModify();
                break;
            case "games":
                $gm->displayGame();
                break;
            case "pixelArt":
                $gm->displayPixelArt();
                break;
            case "coloriages":
                $cc->displayDraw();
                break;
            case "coloriagesListe":
                $cc->getColoriagesByCategorieJson();
                break;
            case "stories":
                $sc->displayStories();
                break;
            case "getImage":               
                $sc->getImage();
            break;  
            case "getHistoire":               
                $sc->getHistoire();
            break; 
            case "displayGame":
                $gm->displayGame();
                break;
            case "displayPixelArt":
                $gm->displayPixelArt();
                break;
            case "logout":
                $ac->logout();
                break;   
            case "dashboard":
                if (!$func->isAdmin()) {
                    $this->redirectTo("homepage");
                }
                $dash->displayDashboard();
                break;
            case "gestionDesUtilisateurs":
                $dash->displayUsers();
                break;
            default:
                $dc->_404();
                break;
        }
    }
}

           /* }
        }
        
       /* else if(isset($_SESSION['connected']) && $_SESSION['connected'] === true && $_SESSION['user']['statut'] === 1 && $_SESSION['user']['role'] === 2) {
            // Cas ou l'utilisateur est connecté, et ADMIN
            switch ($route) {
                case "dashbord":
                if(!$this->isAdmin() {
                        $this->redirectTo("homepage");
                    }*/
             /*   case 
                    $dash->displayDashboard();
                break;
                case "gestion des utilisateurs";
                    $dash->displayUsers();
                break;
                default:
                    echo "erreur1";//$dc->_404();
                break;
            }
        }

        else if(isset($_SESSION['connected']) && $_SESSION['connected'] === true && $_SESSION['user']['statut'] === 0 && $_SESSION['user']['role'] === 1) {   
            // Cas ou l'utilisateur est connecté, et USER et avec un compte pas encore validé
            switch ($route) {
                case "displayModify":
                    $ac->displayModify();
                break;
                case "modifyPassword":
                    $ac->modifyPassword();
                break;
                default:
                    echo "erreur2";//$dc->_404();
                break;
            }
        }
        
        else if(!isset($_SESSION['connected']) || $_SESSION['connected'] === false) {
            // Cas ou l'utilisateur n'est pas connecté   
            switch ($route) {
                case "homepage":
                    $dc->homepage();
                    break;
                case "login":
                    $ac->login();
                break;
                case "check-login":
                    $ac->checkLogin();
                    break;
                case "register":
                    $ac->register();
                break;
                case "check-register":
                    $ac->checkRegister();
                break;
                case "displayModify":
                    $ac->displayModify();
                break;
                case "modifyPassword":
                    $ac->modifyPassword();
                break;
                default:
                    echo "erreur3";//$dc->_404();
                break;
            }
        } else {
            echo "erreur";//$dc->_404();
        }








/*
        switch ($route) {
            case "homepage":
                $dc->homepage();
                break;
            case "homepage-user":
            //case "modifyPassword":
            case "displayModify":
            case "games":
            case "coloriages":
            case "stories":
            case "logout":
            case "displayGame":
            case "pixelArt":
                if (isset($_SESSION['connected']) && $_SESSION['connected'] === true && $_SESSION['user']['statut'] === 1 && $_SESSION['user']['role'] === 1) {
                    switch ($route) {
                        case "homepage-user":
                            $dc->homepageUser();
                            break;
                       
                        case "modifyPassword":
                            $ac->modifyPassword();
                            break;
                        case "displayModify":
                            $ac->displayModify();
                            break;
                        case "games":
                            $gc->displayGame();
                             break;
                        case "pixelArt":
                            $gc->displayPixelArt();
                            break;
                        case "coloriages":
                            $cc->displayDraw();
                            break;
                        case "stories":
                            $hc->displayStories();
                            break;
                        case "logout":
                            $ac->logout();
                        break;
                        case "displayGame":
                            $gm->displayGame();
                        break;
                        case "displayPixelArt":
                            $gm->displayPixelArt();
                        break;
                        default:
                            $dc->_404();
                        break;
                        
                    }
                    
                } else if(isset($_SESSION['connected']) && $_SESSION['connected'] === true && $_SESSION['user']['statut'] === 1 && $_SESSION['user']['role'] === 2) {
                    
                    switch ($route) {
                        case "dashbord":
                            $dash->displayDashboard();
                        break;
                        case "gestion des utilisateurs";
                            $dash->displayUsers();
                        break;
                        default:
                            $dc->_404();
                        break;
                }
                } else if(isset($_SESSION['connected']) && $_SESSION['connected'] === true && $_SESSION['user']['statut'] === 0 ) {    
                    switch ($route) {
                        case "displayModify":
                            $ac->displayModify();
                        break;
                        case "modifyPassword":
                            $ac->modifyPassword();
                        break;
                        default:
                            $dc->_404();
                        break;
                }
                } else {
                    $dc->_404();
            }
        case "login":
            $ac->login();
        break;
        case "check-login":
            $ac->checkLogin();
            break;
        case "register":
            $ac->register();
        break;
        case "check-register":
            $ac->checkRegister();
        break;
        case "modifyPassword":
            $ac->modifyPassword();
        break;
        default:
            $dc->_404();
        break;
        }*/

