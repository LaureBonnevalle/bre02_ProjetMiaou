<?php
require_once('managers/LieuManager.php');
require_once('managers/ObjetManager.php');
require_once('managers/PersonnageManager.php');

class HistoiresManager extends AbstractManager {
    
   public function __construct()
    {
        parent::__construct();
    }

    public function create(Histoires $histoire): Histoire {
        $query = $this->db->prepare('INSERT INTO histoires (histoire_titre, categorie, personnage, objet, lieu, histoire_content, audio) VALUES (:histoire_titre, :categorie, :personnage, :objet, :lieu, :histoire_content, :audio)');
        $query->bindValue(':histoire_titre', $histoire->getHistoireTitre());
        $query->bindValue(':categorie', $histoire->getCategorie(), PDO::PARAM_INT);
        $query->bindValue(':personnage', $histoire->getPersonnage(), PDO::PARAM_INT);
        $query->bindValue(':objet', $histoire->getObjet(), PDO::PARAM_INT);
        $query->bindValue(':lieu', $histoire->getLieu(), PDO::PARAM_INT);
        $query->bindValue(':histoire_content', $histoire->getHistoireContent());
        $query->bindValue(':audio', $histoire->getAudio());
        return $query->execute();
    }

    public function read(int $id): ?Histoires {
        $query = $this->pdo->prepare('SELECT * FROM histoires WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Histoires($row['id'], $row['histoire_titre'], $row['categorie'], $row['personnage'], $row['objet'], $row['lieu'], $row['histoire_content'], $row['audio']);
        }
        return null;
    }

    public function update(Histoires $histoire): Histoire {
        $query = $this->pdo->prepare('UPDATE histoires SET histoire_titre = :histoire_titre, categorie = :categorie, personnage = :personnage, objet = :objet, lieu = :lieu, histoire_content = :histoire_content, audio = :audio WHERE id = :id');
        $query->bindValue(':histoire_titre', $histoire->getHistoireTitre());
        $query->bindValue(':categorie', $histoire->getCategorie(), PDO::PARAM_INT);
        $query->bindValue(':personnage', $histoire->getPersonnage(), PDO::PARAM_INT);
        $query->bindValue(':objet', $histoire->getObjet(), PDO::PARAM_INT);
        $query->bindValue(':lieu', $histoire->getLieu(), PDO::PARAM_INT);
        $query->bindValue(':histoire_content', $histoire->getHistoireContent());
        $query->bindValue(':audio', $histoire->getAudio());
        $query->bindValue(':id', $histoire->getId(), PDO::PARAM_INT);
        return $query->execute();
    }

    public function delete(int $id): bool {
        $query = $this->pdo->prepare('DELETE FROM histoires WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function getAll(): array {
        $query = $this->pdo->query('SELECT * FROM histoires');
        $histoires = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $histoires[] = new Histoires($row['id'], $row['histoire_titre'], $row['categorie'], $row['personnage'], $row['objet'], $row['lieu'], $row['histoire_content'], $row['audio']);
        }
        return $histoires;
    }
    
    public function getHistoiresByCriteria($personnageId, $lieuId, $objetId) {
        $query = $this->db->prepare(
            "SELECT h.*, p.perso_name AS personnage, o.objet_name AS objet, l.lieu_name AS lieu
            FROM histoires h
            JOIN personnages p ON h.personnage = p.id
            JOIN objets o ON h.objet = o.id
            JOIN lieux l ON h.lieu  
            
            WHERE h.personnage = :personnage AND h.objet = :objet AND h.lieu = :lieu"
        );
       
        $query->execute([
            ':personnage' => $personnage,
            ':lieu' => $lieu,
            ':objet' => $objet
        ]);
       
        return $histoire = $query->fetch(PDO::FETCH_ASSOC);
        var_dump($histoire);
        die;
    }
    
    public function getImageUrl($personnageId, $lieuId, $objetId) {
        $query = $this->db->prepare(
            "SELECT image_url
            FROM histoires
            WHERE personnage_id = :personnageId AND lieu_id = :lieuId AND objet_id = :objetId"
        );
        $query->execute([
            ':personnageId' => $personnageId,
            ':lieuId' => $lieuId,
            ':objetId' => $objetId
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['image_url'] : null;
    }
}
?>
