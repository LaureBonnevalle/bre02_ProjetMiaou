<?php


require_once("models/Lieux.php");

class LieuManager extends AbstractManager {
    
   public function __construct()
    {
        parent::__construct();
    }

    public function create(Lieux $lieu): bool {
        $query = $this->db->prepare('INSERT INTO lieux (lieu_name, lieu_description) VALUES (:lieu_name, :lieu_description)');
        $query->bindValue(':lieu_name', $lieu->getLieuName());
        $query->bindValue(':lieu_description', $lieu->getLieuDescription());
        return $query->execute();
    }

    public function read(int $id): ?Lieux {
        $query = $this->db->prepare('SELECT * FROM lieux WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Lieux($row['id'], $row['lieu_name'], $row['lieu_description']);
        }
        return null;
    }

    public function update(Lieux $lieu): bool {
        $query = $this->db->prepare('UPDATE lieux SET lieu_name = :lieu_name, lieu_description = :lieu_description WHERE id = :id');
        $query->bindValue(':lieu_name', $lieu->getLieuName());
        $query->bindValue(':lieu_description', $lieu->getLieuDescription());
        $query->bindValue(':id', $lieu->getId(), PDO::PARAM_INT);
        return $query->execute();
    }

    public function delete(int $id): bool {
        $query = $this->db->prepare('DELETE FROM lieux WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function getAllLieux(): array {
        $query = $this->db->query('SELECT * FROM lieux');
        $lieux = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $lieux[] = new Lieux($row['id'], $row['lieu_name'], $row['lieu_description']);
        }
        return $lieux;
    }
    
    public function getById(int $id)  {
        
        //file_put_contents('text2.txt', $id);
        
        $query = $this->db->prepare("
            SELECT * FROM lieux 
            WHERE id = :id
        ");
        
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        return $query->fetch();
    }
}
?>