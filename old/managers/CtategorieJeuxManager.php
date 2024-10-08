<?php

class CategorieJeuxManager extends AbstarctManager {
    public function __construct()
    {
        parent::__construct();
    }

    public function create(CategorieJeux $categorie): bool {
        $query = $this->db->prepare("INSERT INTO categorie_jeux (categorie_name, categorie_description) VALUES (?, ?)");
        return $query->execute([
            $categorie->getCategorieName(),
            $categorie->getCategorieDescription()
        ]);
    }

    public function read(int $id): ?CategorieJeux {
        $query = $this->db->prepare("SELECT * FROM categorie_jeux WHERE id = ?");
        $query->execute([$id]);
        $data = $query->fetch();
        if ($data) {
            return new CategorieJeux($data['id'], $data['categorie_name'], $data['categorie_description']);
        }
        return null;
    }

    public function update(CategorieJeux $categorie): bool {
        $query = $this->db->prepare("UPDATE categorie_jeux SET categorie_name = ?, categorie_description = ? WHERE id = ?");
        return $query->execute([
            $categorie->getCategorieName(),
            $categorie->getCategorieDescription(),
            $categorie->getId()
        ]);
    }

    public function delete(CategorieJeux $categorie): bool {
        $query = $this->db->prepare("DELETE FROM categorie_jeux WHERE id = ?");
        return $query->execute([$categorie->getId()]);
    }
}
