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
        $am = new AvatarManager();
        $avatars = $am->findAll();
        
        var_dump($avatars);
       
        $this->render("register.html.twig", ["avatars"=>$avatars]);
        // $template = "register";
        // require "templates/layout.phtml";
    }

    public function checkRegister() : void
    {
        $um = new UserManager();
        
        

        if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["prenom"]))
        {
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $cle = md5(microtime(TRUE)*100000);
            $email = $_POST['email'];
            $age = $_POST['age'];
            $message = 0;
            $dessin = 0;
            $statut = "user";
            $actif = 0;
            
            
            
            
            if (isset($_POST["newsletter"]))
            {
                $_POST["newsletter"]=1;
                
            }
            else
            {
                $_POST["newsletter"]=0;
            }
            
            if(isset($_POST['avatar']))
            {
                switch($_POST['avatar']){
                    case "1":  
                        $_POST["avatar"]= 1;
                    break;
                    case "2":  
                        $_POST["avatar"]= 2;
                    break;
                    case "3":  
                        $_POST["avatar"]= 3;
                    break;
                    case "4":  
                        $_POST["avatar"]= 4;
                    break;
                    case "5":  
                        $_POST["avatar"]= 5;
                    break;
                    case "6":  
                        $_POST["avatar"]= 6;
                    break;
            }

            $user = new Users(null, $email, $password, $_POST["prenom"], $age, $_POST["avatar"], $message, $_POST["newsletter"], $dessin, $statut, $cle, $actif, new DateTime());
            
            var_dump($user);
            
            /*$user->setId();*/
            // Préparation du mail contenant le lien d'activation
            /*  $destinataire = $email;
                $sujet = "Activer votre compte" ;
                $entete = "From: ApprendreAvecMiaou@hotmail.com" ;
                 
                // Le lien d'activation est composé du login(log) et de la clé(cle)
                $message = 'Bienvenue sur Apprendre avec Miaou,
                 
                Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
                ou copier/coller dans votre navigateur Internet.
                 
                http://https://laurebonnevalle.sites.3wa.io/Projet_ApprendreAvecMiaou/bre02_ProjetMiaou/index.php?route=validate'.urlencode($email).'&cle='.urlencode($cle).'
                 
                 
                ---------------
                Ceci est un mail automatique, Merci de ne pas y répondre.';
                 
                 
                mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail*/
                
                //envoie sur un page de validation du compte
                
               
                
            $um->createUser($user);
                

            if($user->getId() !== null && $active === 1)
            {
                
                
                //$_SESSION["user"] = $user;
                //echo "Vous êtes déjà inscrits vous pouvez vous connecter";
                $this->render("login.html.twig", ['active'=>"Vous êtes déjà inscrit vous pouvez vous connecter"]);
                
            }
            else if ($user->getId() !== null && $active == 0)
            {
                //echo "Votre compte n'est pas activé";
                //header("Location: index.php?route=validation");
                $this->render("validate.html.twig", ['activation'=> "Votre compte n'est pas encore activé"]);
            }
        }
        else
        {
            //echo "Vous n'êtes pas encore inscrit"
            //header("Location: index.php?route=register");
            $this->render("register.html.twig", ['noinscrit'=> "Vous n'êtes pas encore inscrit"]);
        }
    }
    
    /*public function validateMail($mail,$cle ) : void {
    
            $data = new UserManager->findByEmail($email);
         
            $clebdd = $data['cle'];    // Récupération de la clé
            $actif = $data['actif']; // $actif contiendra alors 0 ou 1
          }
         
         
        // On teste la valeur de la variable $actif récupérée dans la BDD
        if($actif == '1') // Si le compte est déjà actif on prévient
          {
             //return $active="Votre compte est déjà actif !";
             $this->render("validate.html.twig", ['active'=>"Votre compte est déjà actif !");
          }
        else // Si ce n'est pas le cas on passe aux comparaisons
          {
             if($cle == $clebdd) // On compare nos deux clés    
               {
                  // Si elles correspondent on active le compte !    
                  //return $activate= "Votre compte a bien été activé !";
                  $this->render("validate.html.twig", ['activate'=>"Votre compte a bien été activé !");
         
                  // La requête qui va passer notre champ actif de 0 à 1
                  $query = $this->db->prepare("UPDATE membres SET actif = 1 WHERE email like :email ");
                  $query->bindParam(':email', $email);
                  $query->execute();
               }
             else // Si les deux clés sont différentes on provoque une erreur...
               {
                  //return $errorCle = "Erreur ! Votre compte ne peut être activé...";
                  $this->render("validate.html.twig", ['error'=> "Erreur ! Votre compte ne peut être activé...");
               }
          }
    }*/
    }
    public function logout() : void
    {
        session_destroy();
        header("Location: index.php?route=login");
    }
}