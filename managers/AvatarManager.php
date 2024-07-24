<?php

class AvatarManager extends AbstractManager {
    
   public function __construct()
    {
        parent::__construct();
    }

    // Ajouter un avatar
    public function add(Avatars $avatar): Avatar {
        $query = $this->db->prepare("
            INSERT INTO avatars (name, source, description, caracteristique, qualite) 
            VALUES (:name, :source, :description, :caracteristique, :qualite)
        ");
        
        $parameters = [
            "name" => $avatar->getName(),
            "source" => $avatar->getSource(),
            "description" => $avatar->getDescription(),
            "caracteristique" => $avatar->getCaracteristique(),
            "qualite" => $avatar->getQualite()
        ];

        return $query->execute($parameters);
    }

    // Mettre à jour un avatar
    public function update(Avatars $avatar): Avatar {
        $query = $this->db->prepare("
            UPDATE avatars 
            SET name = :name, source = :source, description = :description, caracteristique = :caracteristique, qualite = :qualite 
            WHERE id = :id
        ");
        
        $parameters = [
            "name" => $avatar->getName(),
            "source" => $avatar->getSource(),
            "description" => $avatar->getDescription(),
            "caracteristique" => $avatar->getCaracteristique(),
            "qualite" => $avatar->getQualite(),
            "id" => $avatar->getId()
        ];

        return $query->execute($parameters);
    }

    // Supprimer un avatar
    public function delete(int $id): bool {
        $query = $this->db->prepare("
            DELETE FROM avatars 
            WHERE id = :id
        ");
        
        $parameters = [
            "id" => $id
        ];

        return $query->execute($parameters);
    }

    // Récupérer un avatar par son ID
    public function getById(int $id): ?Avatars {
        $query = $this->db->prepare("
            SELECT * FROM avatars 
            WHERE id = :id
        ");
        
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $data = $query->fetch();

        if ($data) {
            return new Avatars($data['id'], $data['name'], $data['source'], $data['description'], $data['caracteristique'], $data['qualite']);
        }

        return null;
    }

    // Récupérer tous les avatars
    //public function getAll(): array {
    //   $query = $this->db->query("
    //       SELECT * FROM avatars
    //    ");

    //    $avatars = [];
    //    while ($avatars = $query->fetchAll()) {
    //        $avatars[] = new Avatars($data['id'], $data['name'], $data['source'], $data['description'], $data['caracteristique'], $data['qualite']);
    //    }

    //   return $avatars;
    //}
    
    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM avatars');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $avatars = [];

        foreach($result as $item)
        {
            $avatar = new Avatars($item["id"],$item["name"],$item["source"],$item["description"],$item["caracteristique"],$item["qualite"]);
            
            $avatars[] = $avatar;
        }

        return $avatars;
    }
    
}
?>
