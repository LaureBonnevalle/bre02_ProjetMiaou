<?php

class DashboardController extends Router {

    /**
     * Displays the homepage with the latest news
     *
     * This method is responsible for fetching all the news articles via the `ActualityManager` model,
     * then rendering the 'home' view using the 'layout' layout, passing the necessary data
     * to the view, including the integral configuration and the list of news articles.
     *
     * @param   void
     * @return  void
     */
    public function displayDashboard(): void {
        
        (new \Models\AutoSaveDatabase())->save();
        
        $nbrMessages = (new \Models\ContactsManager())->getAllNotRead();
        $nbrNewUsers = (new \Models\UsersManager())->getAllByStatuts(3);     
        $nbrAlertes  = (new \Models\AlertsManager())->countAlertActives();

        // Render the 'home' view with the 'layout' layout and pass the necessary data to the view
        $this->render('dashboard/home', 'layout', [
            'page'          => 'Panneau d\'administration',
            'nbrMessages'   => $nbrMessages,
            'nbrNewUsers'   => count($nbrNewUsers),
            'nbrAlertes'    => $nbrAlertes
        ]);
    }

    /**
     * Fetches all users from the database and renders the users page.
     *
     * @param  void
     * @return void
     */
    public function allUsers() {

        $users          = (new \Models\UsersManager())->getAll();  
        $status         = (new \Models\StatutsManager())->getAll(); // Retrieve all status
        $sectors        = (new \Models\SectorsManager())->getAll(); // Retrieve all sectors
        $departments    = (new \Models\ItemsManager())->getAllDepartments(1);
        $services       = (new \Models\ItemsManager())->getAllDepartments(2);
        $items = array_merge($departments, $services);

        $this->render('dashboard/users', 'layout', [
            'page'      => "Utilisateurs",
            'users'     => $users,              // Array of user objects fetched from the database
            'sectors'   => $sectors, 
            'items'     => $items,
            'status'    => $status,
        ]);
    }

    /**
     * Retrieves all permutations, triangulations, and quadripartites and renders the 'combinations' view.
     *
     * @param void
     * @return void
     */
    public function getAllPermut() {

        $usersManager = new \Models\PermutManager();        
        $alls = $usersManager->getAllPermutations();
        // decrypt datas
        foreach ($alls as &$all) {
            if (isset($all['firstname1'])) $all['firstname1'] = $this->decrypt($all['firstname1']);
            if (isset($all['lastname1'])) $all['lastname1'] = $this->decrypt($all['lastname1']);
            if (isset($all['firstname2'])) $all['firstname2'] = $this->decrypt($all['firstname2']);
            if (isset($all['lastname2'])) $all['lastname2'] = $this->decrypt($all['lastname2']);
            if (isset($all['firstname3'])) $all['firstname3'] = $this->decrypt($all['firstname3']);
            if (isset($all['lastname3'])) $all['lastname3'] = $this->decrypt($all['lastname3']);
            if (isset($all['firstname4'])) $all['firstname4'] = $this->decrypt($all['firstname4']);
            if (isset($all['lastname4'])) $all['lastname4'] = $this->decrypt($all['lastname4']);
        }
        
        foreach ($alls as &$item) {
            $item = $this->escapeData($item);
        }
        
        $this->render('dashboard/combinations', 'layout', [
            'page'              => "Combinaisons",
            'alls'              => $alls
        ]);
    }

    
    public function getCombinations() {
        
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $usersManager = new \Models\PermutManager();


        if ($data['ref'] == "permutations") {
            $alls = $usersManager->getAllPermutations();
        } else if ($data['ref'] == "triangulations") {
            $alls = $usersManager->getAllTriangulations();
        } else {
            $alls = $usersManager->getAllQuadripartites();
        }

        foreach ($alls as &$all) {
            if (isset($all['firstname1'])) $all['firstname1'] = $this->decrypt($all['firstname1']);
            if (isset($all['lastname1'])) $all['lastname1'] = $this->decrypt($all['lastname1']);
            if (isset($all['firstname2'])) $all['firstname2'] = $this->decrypt($all['firstname2']);
            if (isset($all['lastname2'])) $all['lastname2'] = $this->decrypt($all['lastname2']);
            if (isset($all['firstname3'])) $all['firstname3'] = $this->decrypt($all['firstname3']);
            if (isset($all['lastname3'])) $all['lastname3'] = $this->decrypt($all['lastname3']);
            if (isset($all['firstname4'])) $all['firstname4'] = $this->decrypt($all['firstname4']);
            if (isset($all['lastname4'])) $all['lastname4'] = $this->decrypt($all['lastname4']);
        }

        header('Content-Type: application/json');
        $jsonAlls = json_encode($alls, JSON_PRETTY_PRINT);
        // file_put_contents('documents/result.txt', $jsonAlls);

        echo $jsonAlls;
        exit;
    }

    //afficher les messages et afficher sur la vue messagerie
    public function displayMessages() {
        $messages = (new \Models\ContactsManager())->getAll();
        $this->render('dashboard/messages', 'layout', [
            'page'      => "Messagerie",
            'messages'  => $messages
        ]);
    }

    public function readMessage() {
        $content = new \Models\Contacts();                                                
        $content->setId($_GET['id']);  

        $message = (new \Models\ContactsManager())->getOne($content);
        $updateStatut = (new \Models\ContactsManager())->updateStatut($content);

        $this->render('dashboard/readMessage', 'layout', [
            'page'      => "Messagerie",
            'message'   => $message,    
            'token'     => $this->generateToken(),
        ]);
    }

    public function deleteMessage() {
        $content = new \Models\Contacts();                                                
        $content->setId($_GET['id']);  

        (new \Models\ContactsManager())->deleteOne($content);

        $messages = (new \Models\ContactsManager())->getAll();
        $this->render('dashboard/messages', 'layout', [
            'page'      => "Messagerie",
            'messages'  => $messages
        ]);
    }

    public function displayValidateCombinations() {
        
        $alertes = (new \Models\AlertsManager())->getAll();

        $this->render('dashboard/validateCombinations', 'layout', [
            'page'      => "Liste des combinaisons",
            'alertes'   => $alertes
        ]);
    }

    public function readAlert() {

        $alert = new \Models\Alerts();                                                
        $alert->setId($_GET['id']);
        

        $resultCombination = (new \Models\AlertsManager())->getOne($alert);

        //var_dump(new \DateTime((new \Models\TimesModel())->dateNow()));
        //var_dump(new \DateTime((new \Models\TimesModel())->addTimeToTime($resultCombination[0]['online'], 0, 0, 15, 0, 0, 0, $oper = "add", $formatEnd = 'Y-m-d H:i:s')));
        $reject = new \Models\RejectsCombinations();                                                
        $reject->setId($_GET['id']);  
        
        
        

        $resultRejects = (new \Models\RejectsCombinationsManager())->getOne($reject);

        $this->render('dashboard/integraleCombination', 'layout', [
            'page'                   => "Alerte intégrale",
            'title'                  => "DÉTAILS DE LA COMBINAISON",
            'resultCombination'      => $resultCombination,
            'resultRejects'          => $resultRejects,
            "dateNow"                => new \DateTime((new \Models\TimesModel())->dateNow()),
            "onlineDateMore15Days"   => new \DateTime((new \Models\TimesModel())->addTimeToTime($resultCombination[0]['online'], 0, 0, 15, 0, 0, 0, $oper = "add", $formatEnd = 'Y-m-d H:i:s')),
        ]);
        
        
    }

    public function displayActuality() {
        $this->render('dashboard/actuality', 'layout', [
            'page'              => "Actualité"
        ]);
    }

    /*public function displayValidateAccounts() {
        $um = new \Models\UsersManager();
        $result = $um->getUsersWithStatusId3(3);
        if ($result !== null) {
        //Output data of each column
        
        
        
        foreach ($result as $el) {
            $firstname = $this->decrypt($el['firstname']);
            $lastname = $this->decrypt($el['lastname']);
            
            echo "id: " . $el["id"]. " - Name: " . $firstname. " " . $lastname. " ". $el["email"] . " " . $el["password"] . " " . $el["matricule"] . " " . $el["roles_id"] . " ". $el["subscriptionEnd"]. " " . $el["statuts_id"] . " " . $el["sectors_id"] . " " . $el["grade"] . " " . $el["qualif"]. " " . $el["dept"] . " " . $el["poste"]. " " . $el["item_1"]. " " . $el["item_2"]. " " . $el["item_3"]. " " . $el["item_4"]. " " . $el["item_5"]. " " . $el["statutary"]. " " . $el["description"]."<br>";
        }
            
            
        } else {
            echo "0 results";
        }
        
        
        //$this->render('dashboard/validateAccount', 'layout', [
        //    'page'              => "Validation des comptes"
        //]);
        
    }*/
    

    public function displayExaminateCombination() {
        
        $usersData = [];
        $user = new \Models\Users();
        // Boucler sur le poste et pour chaque id réaliser une requête sql pour récupérer les données de l'utilisateur
        foreach($_POST as $el) {
            if($el != null) {
                $user->setId(intval($el));
                $userNow = (new \Models\UsersManager())->getOne($user);   
                if ($userNow) {
                    $usersData = array_merge($usersData, $userNow); // Fusion des informations de l'utilisateur au tableau principal
                }            
            }
        }

        // Get the users's profils informations   
        $this->render('dashboard/examinateCombination', 'layout', [
            'page'              => "Examen d'une combinaison détectée",
            'users' => $usersData,
        ]);
    }

    public function decision() {
        //Instancier un tableau de users contenant ttes les infos de chaque user
        $usersData = [];
        $user = new \Models\Users();
        // Boucler sur le poste et pour chaque id réaliser une requête sql pour récupérer les données de l'utilisateur
        foreach($_POST as $el) {
            if($el != null) {
                $user->setId(intval($el));
                $userNow = (new \Models\UsersManager())->getOne($user);   
                if ($userNow) {
                    $usersData = array_merge($usersData, $userNow); // Fusion des informations de l'utilisateur au tableau principal
                }            
            }
        }
        //instancier le tableau d'erreur et recup le model de mesage n°38
        $errors = [];
        $errorMessages = (new \Models\ErrorMessages())->getMessages();
        //verif si champ est rempli si refus
        if (isset($_POST['rejeter'])) {
            //verif si motif n'existe pas ou inf à 30 caracteres et affiche erreur
            if(!isset($_POST['motif']) || strlen(trim($_POST['motif'])) < 30) {
                $errors[] = $errorMessages[38];
                $this->render('dashboard/examinateCombination', 'layout', [
                    'page'      => "Examen d'une combinaison détectée",
                    'users'     => $usersData,
                    'errors'    => $errors
                ]);
            }
        }
       // si pas de message d'erreur ou d'alert on donne les données à la page d'examen des combinaisons 
        if (count($errors) == 0) {
                //gérer et empecher l'affichage des erreurs cote navigateur avec try catch
                try {
                $user = new \Models\Users();
                // Boucler sur le poste et pour chaque id réaliser une requête sql pour récupérer les données  de l'utilisateur
                  
                // instancier un model d'alert
                $newAlert = (new \Models\Alerts());
                    
                // Calcul de la date pour insertion en BDD
                $time = new \Models\TimesModel();
                $date = $time->dateNow();                
                    
                //recupere les données des users de l'alert
                $firstOfficial  = $usersData[0]['id'];
                $secondOfficial = $usersData[1]['id'];
                $thirdOfficial  = $usersData[2]['id'] ?? null;
                $fourthOfficial = $usersData[3]['id'] ?? null;
                //$fiveOfficial = $usersData[4]['id'] ?? null;
                    
                //set alert dans bdd que ce soit valider ou rejeter
                $newAlert->setOnline($date);
                    
                $newAlert->setFirstOfficial($firstOfficial);
                $newAlert->setSecondOfficial($secondOfficial);
            	$newAlert->setThirdOfficial($thirdOfficial);
            	$newAlert->setFourthOfficial($fourthOfficial);
            	//$newAlert->setFourthOfficial($fivehOfficial);            	    
            	
            	// si on appuie sur rejeter on met le statut de l'alerte à 0 et on insere le motif dans l 'alerte de la bdd    
            	if (isset($_POST['rejeter'])){
            	    $newAlert->setStatut(0);
            	    $newAlert->setReason($_POST['motif']);
            	}
            	//si on appuie sur valider on met le statut de l'alerte 1 et le motif vide dans l'alerte de la bdd
            	else if (isset($_POST['valider'])){
            	    $newAlert->setStatut(1);
            	    $newAlert->setReason('');
            	    
            	    //changement du statut à 7 pour tous les fonctionnaires de l'alerte
            	    // faire boucle foreach 
            	    $user = new \Models\Users(); 
            	    foreach ($usersData as $el) {
            	        $user->setId($el['id']);    
                        (new \Models\UsersManager())->changeStatus($user, 7);
            	    }
                } else {
            	    //si autre chose que valider ou rejeter dans name de input de la vue redirect to permut pour afficher la vue
            	    $this->redirectTo('permut');
            	}
            	    
            	// inserer alerte dans bdd
            	$am = (new \Models\AlertsManager());
                $am->insertAlert($newAlert);
                
                // Redirection vers "route=permut
                $this->redirectTo('permut');
            }
            
            catch (\PDOException $e) {
                $this->redirectTo('permut');
            }
        }
    }
    
  public function displayValidateAccounts() {

        // Get theprofile all users in waiting for validation account 
        /*$user = new \Models\Users();
        $user->setStatuts_id(3);*/

        $users = (new \Models\UsersManager())->getAllByStatuts(3); // Vous passez directement du controller au manager sans passer par les getters / setters
        
        
        
        
        //var_dump($users);
        //die;

        // Render the login form with errors (if any)
        $this->render('dashboard/validateAccount', 'layout', [
            'page'              => 'Validation des comptes',
            'title'             => "Compte(s) à valider",  
            'users'             => $users
            /*'id'                => $users[0]['id']                                        ?? null,
            'lastname'          => $this->decrypt($this->e($userNow[0]['lastname']))        ?? null,
            'firstname'         => $this->decrypt($this->e($userNow[0]['firstname']))       ?? null,
            'email'             => $this->e($userNow[0]['email'])                           ?? null,
            'matricule'         => $this->e($userNow[0]['matricule'])                       ?? null,
            'created_at'        => $this->e($userNow[0]['created_at'])                      ?? null,
            'subscriptionEnd'   => $userNow[0]['subscriptionEnd']                           ?? null,
            'subscription'      => $this->e($userNow[0]['nbrMonthsRenewalsSubscription'])   ?? null,
            'role'              => $this->e($userNow[0]['role'])                            ?? null,
            'statut'            => $this->e($userNow[0]['statut'])                          ?? null,
            'statuts_id'        => $this->e($userNow[0]['statuts_id'])                      ?? null,
            'grade_name'        => $this->e($userNow[0]['grade_name'])                      ?? null,
            'grade_short_name'  => $this->e($userNow[0]['grade_short_name'])                ?? null,            
            'qualification_name'=> $this->e($userNow[0]['qualification_name'])              ?? null, 
            'sector_name'       => $this->e($userNow[0]['sector_name'])                     ?? null,
            'department_name'   => $this->e($userNow[0]['department_name'])                 ?? null,
            'service_name'      => $this->e($userNow[0]['service_name'])                    ?? null,
            'sector_name'       => $this->e($userNow[0]['sector_name'])                     ?? null,
            'service_id'        => $this->e($userNow[0]['service_id'])                      ?? null,
            'poste_name'        => $this->e($userNow[0]['poste_name'])                      ?? null,
            'item_1_id'         => $userNow[0]['item_1_id']                                 ?? null,
            'item_1_name'       => $userNow[0]['item_1_name']                               ?? null,
            'item_2_id'         => $userNow[0]['item_2_id']                                 ?? null,
            'item_2_name'       => $userNow[0]['item_2_name']                               ?? null,
            'item_3_id'         => $userNow[0]['item_3_id']                                 ?? null,
            'item_3_name'       => $userNow[0]['item_3_name']                               ?? null,
            'item_4_id'         => $userNow[0]['item_4_id']                                 ?? null,
            'item_4_name'       => $userNow[0]['item_4_name']                               ?? null,
            'item_5_id'         => $userNow[0]['item_5_id']                                 ?? null,
            'item_5_name'       => $userNow[0]['item_5_name']                               ?? null,
            'statutary'         => $userNow[0]['statutary']                                 ?? null,*/
        ]);
    }
    
    public function validateProfile() {
        
        $id = (int)$_GET['id'];

        // On va récupérer les infos du user et notamment date de souscription ( NULL ou pas )
        $um = (new \Models\UsersManager());
        $data = $um->getOneById($id);

        $newDate = "";
        // On vérifie si la date de souscription == NULL
        // Si oui, on prend la date actuelle comme référence et on y ajoute 3mois
        // Si non, on ne fait rien, la date d'entrée = date de sortie
        if($data['subscriptionEnd'] === NULL) {
            $timesModel = new \Models\TimesModel();
            $newDate = $timesModel->addTimeToTime($timesModel->dateNow('Y-m-d H:i:s', 'Europe/Paris'), 0, 3, 0, 0, 0, 0, "add", 'Y-m-d H:i:s');
        } else {
            $newDate = $data['subscriptionEnd'];
        }

        // Utilisation des setteurs du modèle Users
        $newUser = new \Models\Users();
        $newUser->setId($id);
        $newUser->setSubscriptionEnd($newDate); 

        // On change le statut de la personne à 4
        $um->changeStatus($newUser, 4);

        // Si la date doit être changer, on la change
        if($newDate != $data['subscriptionEnd'])
            $um->changeDate($newUser);

        // Utilisation des setteurs du modèle RejectsAccounts
        $rejectAccount = new \Models\RejectsAccounts();
        $rejectAccount->setUsersId($id);

        // On supprime tous les rejets éventuels
        (new \Models\RejectsAccountsManager())->deleteRejectsAccounts($rejectAccount);

        // on recup tous les users avec un statut à 3
        $users = (new \Models\UsersManager())->getAllByStatuts(3);
        //on affiche la vue en lui passant les comptes des users en statut 3
        $this->render('dashboard/validateAccount', 'layout', [
            'page'              => 'Validation des comptes',
            'title'             => "Compte(s) à valider",  
            'users'             => $users
        ]);
    }
    
    public function rejectProfile() {
        $errors = [];
        
        // on instancie un userManager pour appeler la methode pour recup un utilisateur par son id
        $um = new \Models\UsersManager();
        $data = $um->getOneById($_GET['id']);
        
        // On instancie un user en lui mettant son id avec un setter
        $newUser = new \Models\Users();
        $newUser->setId($data['id']);
        //$newUser->setSubscriptionEnd($data['subscriptionEnd']);
        
        if(!isset($_POST['comment']) || strlen(trim($_POST['comment'])) < 20) {
                $errorMessages = (new \Models\ErrorMessages())->getMessages();
                $errors[] = $errorMessages[41];
        } else {
            
            //on passe le statut de cet utilisateur à 12 pour le rejeter
            $um->changeStatus($newUser, 12);    
              
            // on set un rejet avec id user et commentaires
            $rejects = new \Models\RejectsAccounts();
            $rejects->setUsersId($data['id']);
            $rejects->setComment($_POST['comment']);
            $rejects->setCreated_at((new \Models\TimesModel())->dateNow('Y-m-d H:i:s', 'Europe/Paris'));
            
            //on instancie un rejectManager pour inserer les donnée de rejet dans la table des rejets avec le commentaire
            $rm = new \Models\RejectsAccountsManager();
            $rm->insertRejectsAccounts($rejects);
        }
        
        //on envoie les infos à la vue 
        $this->render('dashboard/validateAccount', 'layout', [
            'page'              => 'Validation des comptes',
            'title'             => "Compte(s) à valider",  
            'users'             => (new \Models\UsersManager())->getAllByStatuts(3),
            'errors'            => $errors,  
        ]);
            
    }
    
    public function changeProfileByAdmin() {        
        $user = new \Models\Users(); 
        $user->setId($_GET['id']);     
        $user->setLimit_time($newDate);

        $action = $_GET['action'];
        $id = $_GET['id'];

        switch($action){
            case "off":
                $this->offerTime($id, 10);
                break;
            case "act":                
                (new \Models\UsersManager())->changeStatus($user, 4);
                break;                
            case "bann":                
                (new \Models\UsersManager())->changeStatus($user, 11);
            default:
            break;
        }

        $this->redirectTo("readOneUser&id=".$id);
    }
        

    public function suspensionAdmin() {
        $timesModel = new \Models\TimesModel();
        $newDate = $timesModel->addTimeToTime($timesModel->dateNow('Y-m-d H:i:s', 'Europe/Paris'), 0, 1, 0, 0, 0, 0, "add", 'Y-m-d H:i:s');
    
        $user = new \Models\Users(); 
        $user->setId($_GET['id']);       
        $user->setLimit_time($newDate);

        $am = new \Models\AlertsManager();
        $usersManager = new \Models\UsersManager();
    
        $statusFields = [
            "absFirst_official"  => "statut_first_official",
            "absSecond_official" => "statut_second_official",
            "absThird_official"  => "statut_third_official",
            "absFourth_official" => "statut_fourth_official"
        ];
    
        if (isset($statusFields[$_GET['action']])) {
            $am->updateAlert($_GET['alert'], $statusFields[$_GET['action']], 3);
            $usersManager->changeStatus($user, 4);
        } elseif ($_GET['action'] === "bann") {
            $usersManager->changeStatus($user, 11);
        } elseif ($_GET['action'] === "act") {
            $usersManager->changeStatus($user, 4);
        }
    
        $usersManager->changeLimit_time($user);
        $this->redirectTo("validateCombinations");
    }
    
}