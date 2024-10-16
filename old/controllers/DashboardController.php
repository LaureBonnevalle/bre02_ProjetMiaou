<?php

class DashboardController extends AbstractController {

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
        
        $scripts = $this->addScripts(['assets/js/common.js','assets/js/formController.js','assets/js/formFunction.js']);
        $nbrMessages = (new ContactsManager())->getAllNotRead();    

        // Render the 'home' view with the 'layout' layout and pass the necessary data to the view
        $this->render('dashboard.html.twig', [
            
            'nbrMessages'   => $nbrMessages,
            
        ], $scripts);
    }

    /**
     * Fetches all users from the database and renders the users page.
     *
     * @param  void
     * @return void
     */
    public function allUsers() {

        $validateUsers         = (new UserManager())->getAllBtStatut(1) ;
        $users        = (new UserManager())->getAll(); // Retrieve all status
      

        $this->render('dashboard.html.twig', [ ], $scripts
            
        );
    }

    /**
     * Retrieves all permutations, triangulations, and quadripartites and renders the 'combinations' view.
     *
     * @param void
     * @return void
     */
    

    
    

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

    


    public function displayActuality() {
        $this->render('dashboard/actuality', 'layout', [
            'page'              => "Actualité"
        ]);
    }

    
    
  public function displayValidateAccounts() {

        // Get theprofile all users in waiting for validation account 
        /*$user = new \Models\Users();
        $user->setStatuts_id(3);*/

        $users = (new \Models\UsersManager())->getAllByStatut(1); // Vous passez directement du controller au manager sans passer par les getters / setters
        
        
        
        
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
        $user = new Users(); 
        $user->setId($_GET['id']);  
        $user->setPassword($_GET['password']);

        $action = $_GET['action'];
        $id = $_GET['id'];
        $password=password_hash($_GET['password']);

        switch($action){
            case "avatar":
                $this->changeAvatar($id);
                break;
            case "password":                
                (new UserManager())->changePassword($user, $password);
                break;                
            case "bann":                
                (new UserManager())->changeStatut($user, 3);
            default:
            break;
        }

        $this->redirectTo("readOneUser&id=".$id);
    }
        

    
    
}