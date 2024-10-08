<?php

/**
 * Class Config
 *
 * A configuration class that provides constants and autoloading for the application.
 */
class Config {

    /**
     * Register an autoloader function.
     * The autoloader function attempts to load a class file based on the namespace and class name.
     * It converts the namespace separator '\' to a directory separator '/' and includes the file.
     * @param string $class The fully-qualified class name.
    */
    public static function registerAutoloader() {

        spl_autoload_register(function($class) {
            require_once lcfirst(str_replace('\\', '/', $class)) . '.php'; // require_once controllers/HomeController.php
        });
    }


    /**
     * Retrieves the configuration settings.
     *
     * This method fetches the configuration settings based on the specified element.
     * If no element is specified, it returns the entire configuration.
     *
     * @param   string $elem    - The specific configuration element to retrieve. Defaults to "all".
     * @return  mixed           - The configuration settings for the specified element, or all settings if "all" is specified.
     */
    public static function getConfig($elem = "all") {

        $configurations = [
            'db' => [
                "local" => [
                    'host'      => 'localhost',
                    'dbname'    => '....',
                    'user'      => '....',
                    'password'  => '....',
                ],
                "laure" => [
                    'host'      => 'db.3wa.io',
                    'dbname'    => 'laurebonnevalle_ApprendreAvecMiaou',
                    'user'      => 'laurebonnevalle',
                    'password'  => '0143d153a0a995dd144dbabddf0210fe',
                    'stripePublicKey' =>'pk_test_51PZ7U8RrG5wqDvdWxbZlymcj37zISMNFYC6sf82jAm5BpXp7boOhMDbDbyqAKrIOodfUTQQMExvzynj7PZ2xs2bF00i2d8bPaS',
                    'stripeSecretKey' =>'sk_test_51PZ7U8RrG5wqDvdWyVj6h4eR9yI8Jf3pO41XpOsuTh27XgCEFegIDDJnzSONb3c1v5q02psnovhojwEIsy1y9tIx00bjlNcJoR',  
                ], 
            ],

            'infos' => [
                'db_connection'     => 'laure',
                'title'             => 'Apprendre Avec Miaou',
                'catchSentence'     => 'Jeux et activités pour enfants',
                'icon'              => 'assets/img/Logo.png', // type="image/png
                'logo'              => 'assets/img/Logo.png',
                'altLogo'           => 'Logo du site représenté par ...',
                'createdBy'         => 'Laure BONNEVALLE',
                'secretKeyEncrypt'  => 'ByzUunzBm9gNbchKJlR62SiKMDjoyBRz',
                'stripeSecretKey'   => 'laure',
                'stripePublicKey'   => 'laure',
                'contactUs' => [
                    'address' => '9 La Guermonnais 35720 Mesnil-Roch, France',
                    'phone' => '(+33) 6 21 03 27 13'
                ],
                'connection'    => [
                    'email' => ['customers' => 'email'],
                    'pwd'   => ['customers' => 'password'],
                ],
                'expeditorEmail'    => 'ApprendreAvecMiaou@gmail.com',
                'css'               => 'assets/css/style.css',
                'fonts' => [
                    'https://fonts.googleapis.com/css2?family=Arsenal+SC:ital,wght@0,400;0,700;1,400;1,700&family=Playwrite+DE+Grund:wght@100..400&display=swap',
                    'https://fonts.googleapis.com/css2?family=Arsenal+SC:ital,wght@0,400;0,700;1,400;1,700&family=Playwrite+DE+Grund:wght@100..400&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap',
                    'https://fonts.googleapis.com/css2?family=Playwrite+DE+Grund:wght@100..400&display=swap',
                ],
                'js' => [
                    'Accueil' => [ 
                        'assets/js/',
                        'assets/js/',

                        'assets/js/htmlVerifications.js', // A retirer lors de la livraison ainsi que les fichiers correspondants
                    ],
                    'Inscription' => [
                        'assets/js/',
                        'assets/js/formController.js',

                        'assets/js/htmlVerifications.js', // A retirer lors de la livraison ainsi que les fichiers correspondants
                    ],
                    'Connexion' => [
                        'assets/js/',
                        'assets/js/home.js',
                        'assets/js/formController.js',

                        'assets/js/htmlVerifications.js', // A retirer lors de la livraison ainsi que les fichiers correspondants
                    ],
                    'Contact' => [
                        'assets/js/',
                        'assets/js/formController.js',

                        'assets/js/htmlVerifications.js', // A retirer lors de la livraison ainsi que les fichiers correspondants
                    ],
                    'Jeux' => [
                        'assets/js/',
                        'assets/js/ajaxFromSearchCombinations.js',
                        
                        'assets/js/htmlVerifications.js', // A retirer lors de la livraison ainsi que les fichiers correspondants
                    ],
                    'Utilisateurs' => [
                        'assets/js/common.js',
                        'assets/js/ajaxSearchUsers.js',
                    ],                    
                    'Panneau d\'administration' =>[
                        'assets/js/common.js',

                    ],                   
                    'Mon profil' =>[ // Affichage du profil général
                        'assets/js/common.js',
                        'assets/js/home.js',
                        'assets/js/ajaxFormProfile.js',  
                        'assets/js/formController.js',

                    ],                   
                    'Messagerie' =>[ // Affichage de la messagerie
                        'assets/js/common.js',
                    ],
                    'Actualité' =>[ // Affichage de l'actualité'
                        'assets/js/common.js',
                    ],
                    'Coloriages' =>[ // Affichage des combinaisons
                        'assets/js/common.js',
                    ],
                    'Histoires' =>[ // Affichage des comptes à vérifier
                        'assets/js/common.js',
                    ],
                    '' =>[ // Affichage de la page d'examen d'une combinaison
                        'assets/js/common.js',                        
                        //'assets/js/formController.js', // Ne pas activer sinon le formulaire ne fonctionne plus car il manque une clé
                    ],
                    'profil' => [ // Formulaire de modification du profil
                        'assets/js/common.js',   
                        'assets/js/ajaxFormProfile.js',  
                        'assets/js/htmlVerifications.js', // A retirer lors de la livraison ainsi que les fichiers correspondants
                    ],
                    'Profil utilisateur' =>[ // Affichage du profil d'un utilisateur par l'admin
                        'assets/js/common.js',   
                        //'assets/js/htmlVerifications.js',
                    ],
                    'Paiement' => [ // Page de paiement
                        'assets/js/common.js',
                        //'assets/js/client.js',
                        //'assets/js/payForm.js',
                        'assets/js/app.js',
                    ],
                    '' => [ //Page d'abonnement
                        'assets/js/common.js',
                    ],
                    '' => [ //Page de réponse du paiement
                        'assets/js/common.js',
                        'assets/js/app.js',
                        'assets/js/home.js',
                    ],
                    '' => [  // Affichage de l'intégralité d'une combinaison
                        'assets/js/common.js',
                    ],
                    '' => [  // Affichage de a page de prise de décision suite a refus d'une alerte de la part d'un utilisateur
                        'assets/js/common.js',
                    ],
                    'Modification mot de passe' => [// page de modif de mot de passe
                        'assets/js/common.js',
                        'assets/js/formController.js',
                    ],  
                    'Mot de passe oublié' => [// page de demande de modif suite oubli
                        'assets/js/common.js',
                        'assets/js/formController.js',
                    ],
                    'Changement de mot de passe' => [ // page de changement de mot de passe dans Profile
                        'assets/js/common.js',
                        'assets/js/formController.js',
                    ],
                    
                ],
            ],

            'sessionName'   => 'user',              // Nom de la session.
            'tokenName'     => 'tokenVerify',       // Name of token.
            'searchIsAdmin' => 'roles_id',              // La clé du tableau de session permettant de déterminer le role de l'utilisateur.

            'nav' => [
                'all'=>[                                    // Regardless of whether the user is logged in or not
                    'Accueil'                   => 'homepage',
                    'Contact'                   => 'contactUs',
                    'Actualités'                => 'actualities',
                    
                ],
                'notConnected' => [                         // if the user is not logged in
                    'Connexion'                 => 'connect',
                    'Inscription'               => 'register',
                ],
                'connected' => [                              // if the user is logged in
                    'Accueil'                   => 'homepage-user',
                    'Déconnexion'               => 'disconnect',
                    'Profil'                    => 'profile',
                    'Coloriages'                => 'colorings',
                    'Jeux'                      => 'games',
                    'Histoires'                 => 'stories',
                ],
                'connectedAndAdmin' => [                    // if the user is logged in AND admin
                    /* 'allUsers'                  => 'allUsers', */
                    /*'Combinaisons détectées'    => 'permut',*/
                    'DashBoard'                 => 'dash'
                ],
                
                    
            ],

             'routes' =>[
                'homepage'           => 'homepage',              // Route "home" par défaut ( la page d'accueil )
                'error404'          => 'error404',              // Route de redirection vers la page 404
                'register'          => 'register',              // Route vers le formulaire de création de compte
                'connection'        => 'connect',               // Route pour la connexion
                'changePassword'    => 'modifyPassword',        // Route vers le formulaire de modification de mot de passe
                'profile'           => 'profile',               // Route vers le formulaire de complément d'informations
                'disconnection'     => 'disconnect',            // Route pour la déconnexion
                'dashboard'         => 'dash',                  // Route vers le dashboard
                'contact'           => 'contactUs',             // Route vers le formulaire de contact
                'generalProfile'    => 'generalProfile',        // Route vers l'affichage du profil général
                'changeUserPassword' => 'modifyPasswordByUser',   // Route vers le formulaire de changement de mot de passe dans le generalProfile
                'messagerie'        => 'messagerie',            // Route vers l'affichage de la messagerie
                'actuality'         => 'actuality',             // Route vers l'affichage de l'actualité
                'validateAccount'   => 'validateAccount',       // Route vers la validation des comptes
                'readOneUser'       => 'readOneUser',           // Route vers l'affichage d'un utilisateur pour l'admin
                'readMessage'       => 'readMessage',           // Route de lecture des messages
                'deleteMessage'     => 'deleteMessage',         // Route de suppression des messages
                'changeProfileByAdmin' => 'changeProfileByAdmin',  //Route de modif de profil par admin
                'suspensionAdmin'   => 'suspensionAdmin',       //Route de suspension par admin
                'forgottenPassword' => 'forgottenPassword',     // Route vers la modification de mot de passe suite mot de passe oublié
                
                
                'authorizations' => [
                    'table'         => 'customers',
                    'column'        => 'id_roles',
                    'valueIsAdmin'  => 3
                ],
                [
                    'homepage'              => ['DefaultController',    'homepage',                      false,  false],
                    'register'              => ['UsersController',      'register',                     false,  false],
                    'contactUs'             => ['ContactController',    'contactUs',                    false,  false],
                    'connect'               => ['ConnectController',    'login',                        false,  false],
                    'modifyPassword'        => ['ConnectController',    'modifyPassword',               false,  false],
                    'checkout'              => ['PaymentController',    'displayCheckout',              false,  false],
                    'subscription'          => ['PaymentController',    'displaySubscription',          false,  false],
                    'checkPayment'          => ['PaymentController',    'SendToStripe',                 true,   false],
                    'showPaymentResult'     => ['PaymentController',    'showPaymentResult',            true,   false],
                    'decisionUser'          => ['UsersController',      'decisionUser',                 true,   false],
                    'readAlertUser'         => ['UsersController',      'readAlertUser',                true,   false],
                    'forgottenPassword'     => ['ConnectController',    'forgottenPassword',            false, false],

                    'disconnect'            => ['ConnectController',    'disconnection',                true,  false],
                    'profile'               => ['UsersController',      'displayGeneralProfile',        true,  false],
                    'generalProfile'        => ['UsersController',      'modifyDetails',                true,  false],
                    'changeUserPassword'    => ['UsersController',      'modifyPasswordByUser',         true,  false],
                    'ajaxServicesByDept'    => ['UsersController',      'searchServicesByDept',         true,  false],
                    'ajaxSearchUsers'       => ['UsersController',      'ajaxSearchUsers',              true,  false],
                    'readOneUser'           => ['UsersController',      'readOneUserById',              true,  false],
                    'logout'                => ['UsersController',      'disconnect',                   true,  false],

                    'ajax'                  => ['DashboardController',  'getCombinations',              true,  false],
                    'permut'                => ['DashboardController',  'getAllPermut',                 true,  false],
                    'allUsers'              => ['DashboardController',  'allUsers',                     true,  false],
                    'dash'                  => ['DashboardController',  'displayDashboard',             true,  true],
                    'messagerie'            => ['DashboardController',  'displayMessages',              true,  false],
                    'validateCombinations'  => ['DashboardController',  'displayValidateCombinations',  true,  false],
                    'actuality'             => ['DashboardController',  'displayActuality',             true,  false],
                    'validateAccount'       => ['DashboardController',  'displayValidateAccounts',      true,  false],
                    'examinate'             => ['DashboardController',  'displayExaminateCombination',  true,  false],
                    'decision'              => ['DashboardController',  'decision',                     true,  false],
                    'valider'               => ['DashboardController',  'validateProfile',              true,  false],
                    'rejeter'               => ['DashboardController',  'rejectProfile',                true,  false],
                    'readMessage'           => ['DashboardController',  'readMessage',                  true,  true ],
                    'deleteMessage'         => ['DashboardController',  'deleteMessage',                true,  true ],
                    'readAlert'             => ['DashboardController',  'readAlert',                    true,  true ],
                    'changeProfileByAdmin'  => ['DashboardController',  'changeProfileByAdmin',         true,  true ],
                    'suspensionAdmin'       => ['DashboardController',  'suspensionAdmin',              true,  true ],
                ]
            ],
        ];

        if($elem != "all")
            return $configurations[$elem];
        return $configurations;
    }
}
