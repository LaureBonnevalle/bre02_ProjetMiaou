<?php

class LieuManager extends AbstractManager {
    
   public function __construct()
    {
        parent::__construct();
    }

    public function create(Lieux $lieu): bool {
        $stmt = $this->pdo->prepare('INSERT INTO lieux (lieu_name, lieu_description) VALUES (:lieu_name, :lieu_description)');
        $stmt->bindValue(':lieu_name', $lieu->getLieuName());
        $stmt->bindValue(':lieu_description', $lieu->getLieuDescription());
        return $stmt->execute();
    }

    public function read(int $id): ?Lieux {
        $stmt = $this->pdo->prepare('SELECT * FROM lieux WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Lieux($row['id'], $row['lieu_name'], $row['lieu_description']);
        }
        return null;
    }

    public function update(Lieux $lieu): bool {
        $stmt = $this->pdo->prepare('UPDATE lieux SET lieu_name = :lieu_name, lieu_description = :lieu_description WHERE id = :id');
        $stmt->bindValue(':lieu_name', $lieu->getLieuName());
        $stmt->bindValue(':lieu_description', $lieu->getLieuDescription());
        $stmt->bindValue(':id', $lieu->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM lieux WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM lieux');
        $lieux = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lieux[] = new Lieux($row['id'], $row['lieu_name'], $row['lieu_description']);
        }
        return $lieux;
    }
}
?>