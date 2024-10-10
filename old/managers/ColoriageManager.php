<?php
require_once('models/ColoriageCategories.php');
require_once('models/Coloriages.php');

class ColoriageManager extends AbstractManager {
public function __construct()
    {
        parent::__construct();
    }

    public function create(Coloriages $coloriage): bool {
        $query = $this->db->prepare("INSERT INTO coloriages (categorie_dessin, dessin_DateHeure, fichier) VALUES (?, ?, ?)");
        return $query->execute([
            $coloriage->getCategorieDessin(),
            $coloriage->getDessinDateHeure()->format('Y-m-d H:i:s'),
            $coloriage->getFichier()
        ]);
    }

    public function read(int $id): ?Coloriages {
        $query = $this->db->prepare("SELECT * FROM coloriages WHERE id = ?");
        $query->execute([$id]);
        $data = $query->fetch();
        if ($data) {
            return new Coloriages($data['id'], $data['categorie_coloriage'],  $data['url']);
        }
        return null;
    }

    public function update(Coloriages $coloriage): bool {
        $query = $this->db->prepare("UPDATE coloriages SET categorie_dessin = ?, dessin_DateHeure = ?, fichier = ? WHERE id = ?");
        return $query->execute([
            $coloriage->getCategorieColoriage(),
            $coloriage->getUrl(),
            $coloriage->getId()
        ]);
    }

    public function delete(Coloriages $coloriage): bool {
        $query = $this->db->prepare("DELETE FROM coloriages WHERE id = ?");
        return $query->execute([$coloriage->getId()]);
    }
    
    public function getAllCategoriesColoriages(): array {
        $query = $this->db->prepare("SELECT * FROM coloriage_categories");
        $query->execute([]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        
    }
     
    
    public function getAllColoriagesByCategorie(int $categorieId): array { 
    $sql = $this->db->prepare('SELECT c.* FROM coloriage c
    INNER JOIN coloriage_categories cc ON c.categorie_coloriage = cc.id
    WHERE cc.id = :categorie_id');

    $sql->execute(['categorie_id' => $categorieId]);
    $coloriages = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $coloriages;
    }
    
    public function jSON($categorieId)
{
    $coloriageManager = new ColoriageManager();
    $coloriages = $this->getAllColoriagesByCategorie($categorieId);

    header('Content-Type: application/json');
    echo json_encode($coloriages);
    exit;
}
}
