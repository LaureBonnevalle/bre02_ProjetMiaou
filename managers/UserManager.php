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
    public function createUser(User $user) : void
    {
        $createdAt = date('Y-m-d H:i:s');

        $query = $this->db->prepare("INSERT INTO users (email, password, prenom, age, avatar, message, newsletter, statut, cle, actif) VALUES (:email, :password, :prenom, :age, :avatar, :message, :newsletter, :statut, :cle, :actif, createdAt : created_at)");
        $parameters = [
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "prenom" => $user->getPrenom(),
            "age"=> $user->getAge(),
            "avatar"=> $user->getAvatar(),
            "message"=> $user->getMessage(),
            "created_at" => $createdAt(),
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
        
        $query = $this->db->prepare("UPDATE users SET email = :email, password = :password, prenom = :prenom, age = :age, avatar = :avatar, message = :message, newsletter = :newsletter, statut = :statut, cle = :cle, actif = :actif");
        $parameters = [
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "prenom" => $user->getPrenom(),
            "age"=> $user->getAge(),
            "avatar"=> $user->getAvatar(),
            "message"=> $user->getMessage()
            
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
    
    
    
    
}
