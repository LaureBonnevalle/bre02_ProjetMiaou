<?php


require_once("models/ErrorMessages.php");
require_once("models/TimesModels.php");
require_once("models/SendEmail.php");
require_once("services/Functionality.php");
require_once("services/CSRFTokenManager.php");
require_once("managers/AvatarManager.php");
require_once("managers/AbstractManager.php");


class AuthController extends AbstractController {
    public function __construct()
    {
        parent::__construct();
    }

    public function login() : void
    {  
         $scripts = $this->addScripts(['assets/js/common.js','assets/js/formController.js','assets/js/formFunction.js']);
        
        //var_dump($avatars);
        // Générer le token pour le mettre dans le vue, dans l'input de type hidden
        $tm = new CSRFTokenManager();
        $am = new AvatarManager();
        
        $_SESSION['error_message'] = "";      
        $this->render("login.html.twig", ["token" => $tm->generateCSRFToken(),"avatar" => $am->getById(4)], $scripts);
        return;
        // $template = "register";
        // require "templates/layout.phtml";
    }
    
    public function checkLogin() : void
    {   
        
        /*if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }*/
        $func = new Functionality();
        $um= new UserManager();
        $am = new AvatarManager();
       
        
    if (!$func->checkPostKeys(['email', 'password', 'csrf_token'])) {   
        $_SESSION['error_message'] = "Les champs n'existent pas.";
        $this->render("login.html.twig", ['error_message'=> $_SESSION['error_message']], [$scripts]);
        exit();
    } else {
        
        $data = [
            
            'email' => $func->e(strtolower(trim($_POST['email']))),
            'password' => $_POST['password'],
            'csrf_token'=>$_POST['csrf_token'],
        ];
        
    
        if (isset($data['email']) && isset($data['password']) && isset($data['csrf_token']))
        {  
           $tm = new CSRFTokenManager();
            $tokenVerify= $tm->validateCSRFToken($data['csrf_token']);
              
            if($_SESSION['csrf_token'] == $data['csrf_token'] ) {
                    
        
                
                $result = $um->findByEmail($data['email']);
                //var_dump($result);
                
                //var_dump($data['password']);
        
                    if($result)
                    {  // si user exist avec son mail on verif son password
                        if(password_verify($data['password'], $result['password']))
                        {  
                            $_SESSION["user"] = [
                                "id"        => $result['id'],
                                "firstname" => $result['firstname'],
                                "role"      => $result['role'],
                                "statut"    => $result['statut'],
                                "email"     => $result['email'],
                                "avatar"    => $result['avatar'],
                                "age"       => $result['age'],
                                "newsletter"=> $result['newsletter'],
                            ];
                            
    
                            if($result['statut'] === 1 || $result['statut'] === 2)
                            {
                                
                                $isConnected = $_SESSION["connected"] = true;
                                $isValidate = $_SESSION['user']['statut']=1;
                                $isUser =$_SESSION['user']['statut'] = 1;
                                $isAdmin =$_SESSION['user']['role'] = 2;
                                
                                
                                //permet d enlever les messages d'erreur à la tentative de connexion suivante
                                unset($_SESSION["error-message"]);
                                unset($_SESSION["success-message"]);
                                unset($_SESSION["csrf_token"]);
                                
                                //$this->createSessions($_SESSION['user']);
                                $_SESSION['start_time'] = time();
                                
                                $_SESSION["success_message"] = "Tu es connectés tu peux maintenant accéder aux jeux et activités";
                                //$dc = new DefaultController();
                                //$dc->HomepageUser();
                                //recupere l'avatar de l'utilisateur par l'id de l'avatar de $result
                                $am = new AvatarManager();
                                
                                $avatar = $am->getById($result['avatar']);
                               // header("Location: ?route=homepageUser");
                               // exit();
                               //var_dump($avatar);
                               //die;
                             
                                //$this->redirectTo("homepageUser");
                                $this->render("homepage-user.html.twig", ['session'=> $_SESSION,'success_message'=> $_SESSION['success_message'], "avatar" => $avatar],[$this->getDefaultScripts()]); // on redirige vers la page d'acceuil
                                
                            } else if ($result['statut'] === 0) {
                                
                                $_SESSION["connected"] = false;
                                $_SESSION["error-message"] = 'vous devez modifier votre mot de passe';
                                unset($_SESSION["csrf_token"]);
                                //$this->render("modifypassword.html.twig", ["error"=> $_SESSION['error-message']],[]);
                                //header("Location: ?route=displayModify");
                                //exit();
                                $this->redirectTo("displayModify");
                                
                                
                            } else {
                            $_SESSION["error-message"] = 'votre compte a été banni';
                            //$this->render("homepage.html.twig", ['error_message'=> $_SESSION['error-message']],[]);
                            $this->redirectTo('homepage');
                            
                            }
                        }
                        else
                        {// si password pas verif
                            $_SESSION["error-message"] = "Mot de passe invalide";
                            //$this->render("login.html.twig", ["error_message"=> $_SESSION['error-message']],['common.js']);
                            $this->redirectTo('login');
                        }
                    }
                    else
                    { // si user pas trouvé avec son mail
                            $avatar = (new AvatarManager())->getById(4);
                            $avatars =(new AvatarManager())->findAllAvatars();
                            $_SESSION["error-message"] = "Il n'existe pas de compte avec ce mail";
                            $this->redirectTo('register');
                            //$this->render("register.html.twig", ["error_message"=> $_SESSION['error-message'],"avatars"=> $avatars, "avatar" => $avatar,"error"=> $_SESSION['error-message']],[]);
                    }
            }
            else
            {// si user n'existe pas
                $_SESSION["error-message"] = "Invalide CSRF token";
                //$this->render("login.html.twig", ["error_message"=> $_SESSION['error-message'], $token],[]);
                $this->redirectTo('login');
            }
        }
        else
        {// si les champs du login sont vides
            $_SESSION["error-message"] = "Champs vides";
            //$this->render("login.html.twig", ["error"=> $_SESSION['error-message']],[$this->getDefaultScripts()]);
            $this->redirectTo('login');
        }
    }  
}
    

    public function register() : void
    {
        //TODO : récupération des données concernant les avatars (appel à AvatarManager)
        
        $am = new AvatarManager();
        $avatars = $am->findAllAvatars();
        $scripts = $this->addScripts(['assets/js/formController.js','assets/js/formFunction.js', 'assets/js/formController.js']);
        
        //var_dump($avatars);
        // Générer le token pour le mettre dans le vue, dans l'input de type hidden
        $tm = new CSRFTokenManager();
        $scripts= $this->addScripts([
            'assets/js/formController.js',
            ]);
        
        $_SESSION['error_mesage'] = "";      
        $this->render("register.html.twig", [ "avatars" => $avatars, "token" => $tm-> generateCSRFToken()],$scripts);
        // $template = "register";
        // require "templates/layout.phtml";
    }

    public function checkRegister() : void {
        
        
        
        if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        
        $_SESSION['error_message']= 0; 
        
        //var_dump($_SESSION); die;
        
        $func = new Functionality();
        if ($func->checkPostKeys(['email', 'firstname', 'age', 'avatar', 'csrf_token']) /*|| $func->checkPostKeys(['email', 'firstname', 'age', 'avatar', 'newsletter', 'csrf_token'])*/) {
        
            if (!isset($_POST['newsletter']) || empty($_POST['newsletter'])/*$func->checkPostKeys(['email', 'firstname', 'age', 'avatar', 'csrf_token'])*/) {
            
                 $data = [
                              
                    'email'     => $func->e(strtolower(trim($_POST['email']))),       // Removing unnecessary spaces and lowering the email
                    'firstname' => $func->e(ucfirst(trim($_POST['firstname']))),      // Removing unnecessary spaces and lowercaseing the first letter of the firstname, the rest in lowercase. 
                    'age'       => $func->e(trim($_POST['age'])),               // Removing unnecessary spaces the matricule
                    'avatar'    => $_POST['avatar'],
                    //'newsletter' => $_POST['newsletter'],
                    'csrf_token'=> $func->e(trim($_POST['csrf_token'])),
                    
                 ];
                 
                 
               
             //var_dump($_POST);
            //var_dump($data);
            //var_dump($newsletter);
            
            
            
            
            }   
            
            else /*if ($func->checkPostKeys(['email', 'firstname', 'age', 'avatar', 'newsletter', 'csrf_token']))*/ {
            
                 $data = [
                          
                    'email'     =>  $func->e(strtolower(trim($_POST['email']))),       // Removing unnecessary spaces and lowering the email
                    'firstname' =>  $func->e(ucfirst(trim($_POST['firstname']))),      // Removing unnecessary spaces and lowercaseing the first letter of the firstname, the rest in lowercase. 
                    'age'       =>  $func->e(trim($_POST['age'])),  // Removing unnecessary spaces the matricule
                    'avatar'    => $_POST['avatar'],
                    'newsletter'=> $_POST['newsletter'],
                    'csrf_token'=>  $func->e(trim($_POST['csrf_token'])),
                ];
                
                
            
                
            //var_dump($data);
            //var_dump($newsletter);
             
              
            }
                // vérifier que tous les champs du formulaire sont là
            if(isset($data['email']) && isset($data['firstname']) && isset($data['age']) && isset($data['avatar']) && isset($data['csrf_token'])) {
                   
                $tm = new CSRFTokenManager();
                $tokenVerify= $tm->validateCSRFToken($_SESSION['csrf_token']);
             
              //var_dump($data);
            //var_dump($newsletter);
                 
                //var_dump($tokenVerify);die;
                    if($tokenVerify == $data['csrf_token'] ) {
                        
                        //var_dump($_POST);die;
                        $um = new UserManager();
                        $result = $um->findByEmail($data['email']);
                        
                        //var_dump($result);
                       
                        
                        if($result === false) {
                             // Generate a random password for the user
                            
                           // $passwordGenerated   = $func->generateRandomPassword(12);
                            $passwordHash = password_hash($passwordGenerated = $func->generateRandomPassword(12) , PASSWORD_BCRYPT);
                            $passwordView = $passwordGenerated;
                            //$date = new TimesModels();
                            //$createdAt= $date->dateNow('Y-m-d H:i:s', 'Europe/Paris');
                            
                            //$createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $createdDate);
                            //$createdAt = $func->formatDateTime($createdDate);
                            //$currentTimeStamp = new DateTime();
                            //$createdAt = $currentTimeStamp;//->format('Y-m-d H:i:s'); // Affiche la date et l'heure actuelles
                            $createdAt = (new TimesModels())->dateNow('Y-m-d H:i:s');
                            
                            $passwordView = $passwordGenerated;
                            $newUser = new Users(); //($_POST['email'], $password, $_POST['firstname'], $_POST['age'], $_POST['avatar'], $_POST['newsletter'], 1, 0, $createdAt);
            
                            
                            $newUser->setEmail($data['email']);
                            $newUser->setPassword($passwordHash);
                            $newUser->setFirstname($data['firstname']);
                            $newUser->setAge($data['age']);
                            $newUser->setAvatar($data['avatar']); 
                            $newUser->setRole(1);
                            $newUser->setCreatedAt($createdAt);
                        
                            
                            //var_dump($newUser);
                            //die;
                        
                            
                            
                            //var_dump($newUser);die;
                           
                            
                            
                            
                            
                            
                            if (isset($data['newsletter'])) {
                                
                                 
                                $newUser->setNewsletter(1);
                                
                            } else {
                                
                               
                                $newUser->setNewsletter(0);
                            }
                            
                           $user = $um->createUser($newUser);
                            // Prepare success messages
                                //$valids = [$validMessages[0], $validMessages[1], $validMessages[4]];
                                    // Your account creation request has been successfully registered.
                                    // You can now log in with your credentials.
                                    // Un email vient de vous être envoyé avec vos identifiants temporaires 
        
                                // Send confirmation email to the user
                                $sendEmail = new SendEmail();
                                $sendEmail->sendEmailConfirme($data['firstname'], $data['email'], $passwordView);
        
                                $_SESSION['success_message'] = "Un email de validation vient de vous être envoyé";
                                //$this->redirectTo("homepage");
                                
                                $scripts= $this->addScripts(['assets/js/formController.js',]);

                                $this->render("homepage.html.twig", ['success_message'=> $_SESSION['success_message']], $scripts);
                                exit();
                           
                            
                            /*try {
                                 $user = $um->createUser($newUser);
                            
                            // Prepare success messages
                                //$valids = [$validMessages[0], $validMessages[1], $validMessages[4]];
                                    // Your account creation request has been successfully registered.
                                    // You can now log in with your credentials.
                                    // Un email vient de vous être envoyé avec vos identifiants temporaires 
        
                                // Send confirmation email to the user
                                $sendEmail = new SendEmail();
                                $sendEmail->sendEmailConfirme($newUser->getEmail(), $newUser->getFirstname(), $passwordGenerated);
        
                                $_SESSION['success_message'] = "Un email de validation vient de vous être envoyé";
                                //$this->redirectTo("homepage");
                                $this->render("homepage.html.twig", ['success_message'=> $_SESSION['success_message']], []);
                                exit();
                                
                            } catch (Exception $e) {
                                // Handle any errors that occur during user insertion
                                $_SESSION['error_message'] = "Erreur dans l'envoi du formulaire";           // An error occurred while sending the form !
                            }
                                $this->redirect('index.php?route=register');
                                $this->render("homepage.html.twig", ['error_message'=> $_SESSION['error_message']],[$scripts]);
                                exit();}*/
                        }
                        else
                        {
                            $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse.";
                            //$this->render("homepage.html.twig", ['error_message'=> $_SESSION['error_message']],[$scripts]);
                            $this->redirectTo('login');
                                exit();
                        }
                    }
                    else
                    {
                        $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                        $this->render("homepage.html.twig", ['error_message'=> $_SESSION['error_message']],[$scripts]);
                                exit();
                    }
                }
                else
                {
                    $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
                    //$this->render("homepage.html.twig", ['error_message'=> $_SESSION['error_message']],[$scripts]);
                    $this->redirectTo('register');
                                exit();
                }
            }
        
        else {
           $_SESSION['error_message'] = "Les champs n'existent pas";
            //$this->render("homepage.html.twig", ['error_message'=> $_SESSION['error_message']],[$scripts]);
            $this->redirectTo('homepage');
                        exit(); 
        }    
        
        
    }


    public function displayModify() : void
    {
        //TODO : récupération des données concernant les avatars (appel à AvatarManager)
        $scripts= $this->addScripts([
            'assets/js/formController.js', 'assets/formFunction.js'
            ]);
        //$am = new AvatarManager();
       // $avatars = $am->findAllAvatars();
        $scripts = $this->addScripts(['assets/js/common.js','assets/js/formController.js','assets/js/formFunction.js']);
        
        //var_dump($avatars);
        // Générer le token pour le mettre dans le vue, dans l'input de type hidden
        $tm = new CSRFTokenManager();
        $token = $tm->generateCSRFToken();
        $_SESSION['csrf_token'] = $token;
        
        $_SESSION['error_message'] = "Vous devez Modifier votre mot de passe";      
        $this->render("modifypassword.html.twig", ["token" => $token, "error_message"=> $_SESSION['error_message']], [$scripts]);
        // $template = "register";
        // require "templates/layout.phtml";
    }

    public function modifyPassword() { 
        
        if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        
        $errors = [];
        
        var_dump($_POST);
        
        $func = new Functionality();
        $errorMessages = new ErrorMessages();
        $errorMessages->getMessages();
        $tm = new CSRFTokenManager();
        if ($func->checkPostKeys(['email', 'old_password', 'new_password', 'confirm_new_password', 'csrf_token'])) {
                        
            $data = [
                'email'                 => strtolower(trim($_POST['email'])),
                'old_password'          => trim($_POST['old_password']),
                'new_password'          => trim($_POST['new_password']),               
                'confirm_new_password'  => trim($_POST['confirm_new_password']),
                'csrf_token'            => trim($_POST['csrf_token']),
            ];
            
                if(empty($data['email']) || !$func->validateEmail($data['email'])) {
                // Message d'erreur que l'email ne peut pas être vide
                $errors[] = $errorMessages[2];
                }
                
                // old_password est il vide ? A t il bien 8 caractères, ...
                if(!$func->validatePassword($data['old_password'])) {
                    $errors[] = $errorMessages[1]; // Le mot de passe doit faire au moins 8 caractères ...... !
                }
                // new_password est il vide ? A t il bien 8 caractères, ...
                if(!$func->validatePassword($data['new_password'])) {
                    $errors[] = $errorMessages[1]; // Le mot de passe doit faire au moins 8 caractères ...... !
                }
                if($data['new_password'] == $data['old_password']) {
                    $errors[] = $errorMessages[24]; // Le mot de passe old doit etre different du new ...... !  
                }
                if($data['new_password'] !== $data['confirm_new_password']) {
                    $errors[] = $errorMessages[23]; // Le mot de passe new doit etre egal au confirm new ...... !  
                }
                
                if ( !($tokenVerify= $tm->validateCSRFToken($_SESSION['csrf_token']))) {
                    $errors[] = $errorMessages[43]; // token invalide ...... !  
                }
                //var_dump($_POST, $errors); die;
                
                if(count($errors) == 0) {
                    // Je continu le traitement 
                    $um = new UserManager();
                    //recupere un user par son mail
                    $search = $um->findByEmail($_SESSION['user']['email']);
            
                    
                    
                    // Vérifier si l'ancien MDP renseigné dans le forumlaire est bien = à l'ancien de la BDD ($search['password']
                    if ($search == null) {
                        $errors[] = $errorMessages[44]; // Le mot de passe doit faire au moins 8 caractères ...... !
                    }
                    else {
                        $user = new Users();  
                        $user->setId($_SESSION['user']['id']);
                        $user->setPassword(password_hash($data['new_password'], PASSWORD_DEFAULT));                                     
                  
                               
                        $um = new UserManager();         
                        $um->changePasswordAndStatut($user); // Vérifier la suite
                        
                        
                        // Modification de la session
                        $_SESSION['user']["statut"] = 1;
                        $_SESSION['connected'] = true;
                        
                        unset($_SESSION["error-message"]);
                        unset($_SESSION["success-message"]);
                        $_SESSION['start_time'] = time();       
                        
                        $_SESSION["success_message"] = "Tu es connectés tu peux maintenant accéder aux jeux et activités";
                        //$dc = new DefaultController();
                        //$dc->HomepageUser();
                        //recupere l'avatar de l'utilisateur par l'id de l'avatar de $result
                        //$am = new AvatarManager();
                        //$avatar = $am->getById($search['avatar']);
                        header("Location: ?route=homepageUser");
                        exit();
                        
                        //$this->render("homepageUser.html.twig", ['error_message'=> $_SESSION['error_message']],[$this->getDefaultScript()]); // on redirige vers la page d'acceuil
                                                   
                    
                    }    
                } else {
                    $errors[] = $errorMessages[38]; // Il y a des erreur sur le formulaire.....
                    //$this->render("ModifyPassword.html.twig", ['error_message'=> $_SESSION['error_message']],$data); // on redirige
                    $this->redirectTo('displayModify');
                }  
        } else {
            $errors[] = $errorMessages[0];
            //$this->render("homepage.html.twig", ['error_message'=> $_SESSION['error_message']],[$this->getDefaultScript()]); // on redirige
            $this->redirectTo('homepage');
        }
            
           
            
    }
    
    



        
       


        
        public function validateMail($email,$cle ) : void 
        {
            $um = new UserManager();
            
            $data = $this->um->findByEmail($email);
         
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
                      
             
                      // La requête qui va passer notre champ actif de 0 à 1
                      $query = $this->db->prepare("UPDATE membres SET actif = 1 WHERE email like :email ");
                      $query->bindParam(':email', $email);
                      $query->execute();
                      
                      // Si elles correspondent on active le compte !    
                      //return $activate= "Votre compte a bien été activé !";
                      $this->render("login.html.twig", ['success_message'=>"Votre compte a bien été activé vous pouvez vous connectez !"]);
                    }
                    else // Si les deux clés sont différentes on provoque une erreur...
                    {
                      //return $errorCle = "Erreur ! Votre compte ne peut être activé...";
                      $this->render("homepage.html.twig", ['error_message'=> "Erreur ! Votre compte ne peut être activé..."]);
                    }
             }
        }
    
    public function logout() : void
    {
        session_destroy();
        $this->render("homepage.html.twig",[]);
    }
}
