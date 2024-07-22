<?php

class ColoriageCategories {
    private ?int $id;
    private string $categorie_name;
    private string $categorie_description;

    public function __construct(?int $id, string $categorie_name, string $categorie_description) {
        $this->id = $id;
        $this->categorie_name = $categorie_name;
        $this->categorie_description = $categorie_description;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getCategorieName(): string {
        return $this->categorie_name;
    }

    public function getCategorieDescription(): string {
        return $this->categorie_description;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setCategorieName(string $categorie_name): void {
        $this->categorie_name = $categorie_name;
    }

    public function setCategorieDescription(string $categorie_description): void {
        $this->categorie_description = $categorie_description;
    }
}
?>
