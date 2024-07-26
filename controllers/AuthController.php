<?php



class AuthController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login() : void
    {
        $this->render("login.html.twig", []);
    }

    public function checkLogin() : void
    {
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $email = htmlspecialchars($_POST['email']);
        
        
        if (isset($mail) && isset($email))
        {
        $tokenManager = new CSRFTokenManager();
        
            if(isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
            /*echo"<pre>";
            var_dump($_POST['csrf-token']);
            echo"</pre>";*/
            
            
                $um = new UserManager(); // recup utilisateur par son mail
                $user = $um->findByEmail($email);

                    if($user !== null)
                    {  // si user exist avec son mail on verif son password
                        if(password_verify($password, $user->getPassword()))
                        {   // si password verif on ouvre une session et on recup id de utilisateur
                            $_SESSION["user"] = $user->getId();
                            //permet d enlever les messages d'eerreur à la tentative de connexion suivante
                            unset($_SESSION["error-message"]);
    
                            $this->render("homepage-perso.html.twig", ['mess'=> " vous êtes connecté"]); // on redirige vers la page d'acceuil
                        }
                        else
                        {// si password pas verif
                            $_SESSION["error-message"] = "Erreur login information";
                            $this->render("login.html.twig", ["error"=> $_SESSION['error-message']]);
                        }
                    }
                    else
                    { // si user pas trouvé avec son mail
                            $_SESSION["error-message"] = "Erreur login information";
                            $this->render("register.html.twig", ["error"=> $_SESSION['error-message']]);
                    }
            }
            else
            {// si user n'existe pas
                $_SESSION["error-message"] = "Invalide CSRF token";
                $this->render("register.html.twig", ["error"=> $_SESSION['error-message']]);
            }
        }
        else
        {// si les champs du login sont vides
            $_SESSION["error-message"] = "Champs vides";
            $this->render("login.html.twig", ["error"=> $_SESSION['error-message']]);
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
        
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $confirmpassword = password_hash($_POST["confirm-password"], PASSWORD_BCRYPT);
        $cle = md5(microtime(TRUE)*100000);
        $email = htmlspecialchars($_POST['email']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $age = $_POST['age'];
        $message = 0;
        $dessin = 0;
        $statut = "user";
        $actif = 0;

        if(isset($email) && isset($password) && isset($confirmpassword) && isset($prenom))
        {
            //fonction pour verif si mail existe deja
            //if ($_POST["email"]=)
            
           // on verif le token
            $tokenManager = new CSRFTokenManager();
            if(isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
            
            
            {
                
                if($password === $confirmpassword)
                {
                    
                        $user = $um->findByEmail($email);
                        
                        
                        if($user === null)
                        {// si user n'existe pas et il rempli les champs et nettoie les champs pour securite (enlever les morceaux de codes qui pourraient etre introduits)
                        
                            $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
                 
                 
                 
                            if (preg_match($password_pattern, $password)===1)
                            {
                        
                        
                                
                
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
                                    
                                    
                                
                                
                                $user = new Users(null, $email, $password, $prenom, $age, $_POST["avatar"], $message, $_POST["newsletter"], $dessin, $statut, $cle, $actif, new DateTime());
                                
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
                                        $this->render("validation.html.twig", ['activation'=> "Votre compte n'est pas encore activé"]);
                                    }
                                    else
                                    {   //echo "Vous n'êtes pas encore inscrit"
                                        //header("Location: index.php?route=register");
                                        $this->render("register.html.twig", ['noinscrit'=> "Vous n'êtes pas encore inscrit"]);
                                    }
                                
                                }    
                                
                            else
                            {// si utilisateur deja existant avec son username et/ou son mail on redirige vers la page login
                            $this->render("login.html.twig", ['error'=>"Vous avez déjà un compte merci de vous connectez"]);
                            }
                        
                        }
                        else 
                        {//si le password n'a pas les caracteristiques demandées on redirige vers formulaire inscription
                           $this->render("register.html.twig",["error"=>"le mot de passe n'est pas assez fort"]);
                        }
                }
                else
                {// si password n'est pas verif on redirige vers formulaire inscription
                    $this->render("register.html.twig", ['error'=>"les mots de passe ne correspondent pas"]);
                }
            }
            else
            { // si token pas verif on redirige vers le formulaire d insciption
                $this->render("register.html.twig", ['error'=>"token non valide"]);
            }
        }
        }
        
        else
        {// si champs pas remplis erreur on redirige vers le formulaire d'inscription
            $this->render("register.html.twig", ['error'=>"Tous les champs ne sont pas remplis"]);
        }
                                
        
            
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
                
               
                
        
            

        
        }
        
    //}


        
        public function validateMail($mail,$cle ) : void 
        {
            $um = new UserManager();
            
            $data = $this->$um->findByEmail($email);
         
            $clebdd = $data['cle'];    // Récupération de la clé
            $actif = $data['actif']; // $actif contiendra alors 0 ou 1
        
         
         
             // On teste la valeur de la variable $actif récupérée dans la BDD
            if($actif == '1') // Si le compte est déjà actif on prévient
              { //return $active="Votre compte est déjà actif !";
                 $this->render("login.html.twig", ['active'=>"Votre compte est déjà actif !"]);
              }
            else // Si ce n'est pas le cas on passe aux comparaisons
            {
                    if($cle == $clebdd) // On compare nos deux clés    
                    { 
                      // Si elles correspondent on active le compte !    
                      //return $activate= "Votre compte a bien été activé !";
                      $this->render("login.html.twig", ['activate'=>"Votre compte a bien été activé !"]);
             
                      // La requête qui va passer notre champ actif de 0 à 1
                      $query = $this->db->prepare("UPDATE membres SET actif = 1 WHERE email like :email ");
                      $query->bindParam(':email', $email);
                      $query->execute();
                    }
                    else // Si les deux clés sont différentes on provoque une erreur...
                    {
                      //return $errorCle = "Erreur ! Votre compte ne peut être activé...";
                      $this->render("homepage.html.twig", ['error'=> "Erreur ! Votre compte ne peut être activé..."]);
                    }
             }
        }
    
    public function logout() : void
    {
        session_destroy();
        $this->render("homepage.html.twig",[]);
    }
}
