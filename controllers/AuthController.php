<?php



class AuthController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login() : void
    {
        $template = "login";

        require "templates/layout.phtml";
    }

    public function checkLogin() : void
    {
        if(isset($_POST["email"]) && isset($_POST["password"]))
        {
            $um = new UserManager();

            $user = $um->findOne($_POST["email"]);

            if($user->getId() !== null)
            {
                if(password_verify($_POST["password"], $user->getPassword()))
                {
                    $_SESSION["user"] = $user;
                    header("Location: index.php?route=profile");
                }
                else
                {
                    header("Location: index.php?route=login");
                }
            }
            else
            {
                header("Location: index.php?route=login");
            }
        }
        else
        {
            header("Location: index.php?route=login");
        }
    }

    public function register() : void
    {
        //TODO : récupération des données concernant les avatars (appel à AvatarManager)
       
        $this->render("register.html.twig", []);
        // $template = "register";
        // require "templates/layout.phtml";
    }

    public function checkRegister() : void
    {
        $um = new UserManager();

        if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]))
        {
            $password = password_hash($_POST["passowrd"], PASSWORD_BCRYPT);

            $user = new User($_POST["username"], $_POST["email"], $password, "USER", new DateTime());
            $um->create($user);

            if($user->getId() !== null)
            {
                $_SESSION["user"] = $user;
                header("Location: index.php?route=accueilPerso");
            }
            else
            {
                header("Location: index.php?route=register");
            }
        }
        else
        {
            header("Location: index.php?route=register");
        }
    }

    public function logout() : void
    {
        session_destroy();
        header("Location: index.php?route=login");
    }
}