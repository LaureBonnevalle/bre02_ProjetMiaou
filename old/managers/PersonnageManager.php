<?php

class PersonnageManager extends AbstractManager {
    
   public function __construct()
    {
        parent::__construct();
    }
    
    // Ajouter un personnage
    public function add(Personnages $personnage): Personnage {
        $query = $this->db->prepare("
            INSERT INTO personnages (perso_name, perso_description) 
            VALUES (:perso_name, :perso_description)
        ");
        
        $parameters = [
            "perso_name" => $personnage->getPersoName(),
            "perso_description" => $personnage->getPersoDescription()
        ];

        return $query->execute($parameters);
    }

    // Mettre à jour un personnage
    public function update(Personnages $personnage): Personnage {
        $query = $this->db->prepare("
            UPDATE personnages 
            SET perso_name = :perso_name, perso_description = :perso_description 
            WHERE id = :id
        ");
        
        $parameters = [
            "perso_name" => $personnage->getPersoName(),
            "perso_description" => $personnage->getPersoDescription(),
            "id" => $personnage->getId()
        ];

        return $query->execute($parameters);
    }

    // Supprimer un personnage
    public function delete(int $id): Personnage {
        $query = $this->db->prepare("
            DELETE FROM personnages 
            WHERE id = :id
        ");
        
        $parameters = [
            "id" => $id
        ];

        return $query->execute($parameters);
    }

    // Récupérer un personnage par son ID
    public function getById(int $id): ?Personnages {
        $query = $this->db->prepare("
            SELECT * FROM personnages 
            WHERE id = :id
        ");
        
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $data = $query->fetch();

        if ($data) {
            return new Personnages($data['id'], $data['perso_name'], $data['perso_description']);
        }

        return null;
    }

    // Récupérer tous les personnages
    public function getAllPersonnages(): array {
        $query = $this->db->prepare("
            SELECT * FROM personnages
        ");
        $result =$query->execute();
        
        //return $result->fetch(PDO::FETCH_ASSOC);

        $personnages = [];
        while ($result = $query->fetch()) {
            $personnages[] = new Personnages($result['id'], $result['perso_name'], $result['perso_description']);
        }

        return $personnages;
    }
}
?>
