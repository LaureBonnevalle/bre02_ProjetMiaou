<?php

class ObjetsManagerextends AbstractManager {
    
   public function __construct()
    {
        parent::__construct();
    }

    // Ajouter un objet
    public function add(Objets $objet): bool {
        $query = $this->db->prepare("
            INSERT INTO objets (objet_name, objet_description) 
            VALUES (:objet_name, :objet_description)
        ");
        
        $parameters = [
            "objet_name" => $objet->getObjetName(),
            "objet_description" => $objet->getObjetDescription()
        ];

        return $query->execute($parameters);
    }

    // Mettre à jour un objet
    public function update(Objets $objet): bool {
        $query = $this->db->prepare("
            UPDATE objets 
            SET objet_name = :objet_name, objet_description = :objet_description 
            WHERE id = :id
        ");
        
        $parameters = [
            "objet_name" => $objet->getObjetName(),
            "objet_description" => $objet->getObjetDescription(),
            "id" => $objet->getId()
        ];

        return $query->execute($parameters);
    }

    // Supprimer un objet
    public function delete(int $id): bool {
        $query = $this->db->prepare("
            DELETE FROM objets 
            WHERE id = :id
        ");
        
        $parameters = [
            "id" => $id
        ];

        return $query->execute($parameters);
    }

    // Récupérer un objet par son ID
    public function getById(int $id): ?Objets {
        $query = $this->db->prepare("
            SELECT * FROM objets 
            WHERE id = :id
        ");
        
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $data = $query->fetch();

        if ($data) {
            return new Objets($data['id'], $data['objet_name'], $data['objet_description']);
        }

        return null;
    }

    // Récupérer tous les objets
    public function getAll(): array {
        $query = $this->db->query("
            SELECT * FROM objets
        ");

        $objets = [];
        while ($data = $query->fetch()) {
            $objets[] = new Objets($data['id'], $data['objet_name'], $data['objet_description']);
        }

        return $objets;
    }
}
?>
