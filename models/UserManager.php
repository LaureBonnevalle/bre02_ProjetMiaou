<?php


class UserManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getDb() : PDO
    {
        return $this->db;
    }

   
    
    //créer un user
    public function createUser(Users $user) : void
    {
        $createdAt = date('Y-m-d H:i:s');
        $cle = 

        $query = $this->db->prepare("INSERT INTO users (email, password, prenom, age, avatar, message, newsletter, dessin, statut, cle, actif, created_at) VALUES (:email, :password, :prenom, :age, :avatar, :message, :newsletter, :dessin, :statut, :cle, :actif, : created_at)");
        $parameters = [
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "prenom" => $user->getPrenom(),
            "age"=> $user->getAge(),
            "avatar"=> $user->getAvatar(),
            "message"=> $user->getMessage(),
            "newsletter"=>$user->getNewsletter(),
            "dessin"=>$user->getDessin(),
            "statut"=>$user->getStatut(),
            "cle"=>$user->getCle(),
            "actif"=>$user->getActif(),
            "created_at" => $createdAt
        ];

        $query->execute($parameters);

        $user->setId($this->db->lastInsertId());

    }
    
    //lire un user avec son id
    public function read(int $id): ?Users 
    {
      
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $db->bindValue(':id', $id, PDO::PARAM_INT);
        $parameters = [
            "email" => $email
        ];

        $query->execute($parameters);
        $data = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            return new Users($data['id'], $data['email'], $data['password'], $data['prenom'], $data['age'], $data['avatar'], $data['message'], $data['newsletter'], $data['statut'], $data['cle'], $data['actif'], $data['created_at']);
        }
        return null;
    }
    
    //trouver un user par son mail
    public function findByEmail(string $email) : ? User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE email=:email');

        $parameters = [
            "email" => $email
        ];

        $query->execute($parameters);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if($data)
        {
            if ($data) {
            return new Users($data['id'], $data['email'], $data['password'], $data['prenom'], $data['age'], $data['avatar'], $data['message'], $data['newsletter'], $data['statut'], $data['cle'], $data['actif'], $data['created_at']);
        }
        return null;
    }
    }
    
    //mettre à jour un user
    public function update(Users $user): User
    {
        
        $query = $this->db->prepare("UPDATE users SET email = :email, password = :password, prenom = :prenom, age = :age, avatar = :avatar, message = :message, newsletter = :newsletter, statut = :statut, actif = :actif");
        $parameters = [
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "prenom" => $user->getPrenom(),
            "age"=> $user->getAge(),
            "avatar"=> $user->getAvatar(),
            "message"=> $user->getMessage(),
            "newsletter"=>$user->getNewsletter(),
            "statut"=>$user->gestStatut(),
            "actif"=>$user->getActif()
            
        ];

        $data = $query->execute($parameters);

        
        
        if($data)
        {
           
            return Users($data['id'], $data['email'], $data['password'], $data['prenom'], $data['age'], $data['avatar'], $data['message'], $data['newsletter'], $data['statut'], $data['cle'], $data['actif'], $data['created_at']);
        }
        ;
        
    }
    //detruire un user par son id
    public function delete(int $id): bool {
        $query= $this->db->prepare("DELETE FROM users WHERE id = :id");
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $data = $query->fetch(PDO::FETCH_ASSOC);
       ;
    }
    
    //detruire un user par son mail
    public function deleteByEmail(int $email): bool {
        $query= $this->db->prepare("DELETE FROM users WHERE email = :email");
        $parameters = [
            "email" => $email
        ];

        $query->execute($parameters);
        $data = $query->fetch(PDO::FETCH_ASSOC);
       ;
    }
    
public function validation()
{
    
}
    
    
 public function validateMail() : void 
        {
            $user = new Users();
            $clebdd = $data['cle'];    // Récupération de la clé
            $actif = $data['actif']; // $actif contiendra alors 0 ou 1
        
         
         
             // On teste la valeur de la variable $actif récupérée dans la BDD
            if(isset ($clebdd && $user->getActif == '0')) // Si le compte est déjà actif on prévient
              { //return $active="Votre compte est déjà actif !";
                 
              }
            else // Si ce n'est pas le cas on passe aux comparaisons
            {
                    if($_GET['cle'] === $clebdd) // On compare nos deux clés    
                    { 
             
                      // La requête qui va passer notre champ actif de 0 à 1
                      $query = $this->db->prepare("UPDATE membres SET actif = 1 WHERE email like :email ");
                      $query->bindParam(':email', $email);
                      $query->execute();
                      
                      // Si elles correspondent on active le compte !    
                      //return $activate= "Votre compte a bien été activé !";
                      //$this->render("login.html.twig", ['activate'=>"Votre compte a bien été activé vous pouvez vous connectez !"]);
                    }
                    else // Si les deux clés sont différentes on provoque une erreur...
                    {
                      //return $errorCle = "Erreur ! Votre compte ne peut être activé...";
                      //$this->render("homepage.html.twig", ['error'=> "Erreur ! Votre compte ne peut être activé..."]);
                    }
             }
        }   
    
    
    
}
