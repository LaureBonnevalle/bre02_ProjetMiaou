<?php

class Histoires {
    private ?int $id;
    private string $histoire_titre;
    private int $categorie;
    private int $personnage;
    private int $objet;
    private int $lieu;
    private string $histoire_content;
    private string $url;
    private string $audio;

    public function __construct(?int $id, string $histoire_titre, int $categorie, int $personnage, int $objet, int $lieu, string $histoire_content, string $audio) {
        $this->id = $id;
        $this->histoire_titre = $histoire_titre;
        $this->categorie = $categorie;
        $this->personnage = $personnage;
        $this->objet = $objet;
        $this->lieu = $lieu;
        $this->histoire_content = $histoire_content;
        $this->url = $url;
        $this->audio = $audio;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getHistoireTitre(): string {
        return $this->histoire_titre;
    }

    public function getCategorie(): int {
        return $this->categorie;
    }

    public function getPersonnage(): int {
        return $this->personnage;
    }

    public function getObjet(): int {
        return $this->objet;
    }

    public function getLieu(): int {
        return $this->lieu;
    }

    public function getHistoireContent(): string {
        return $this->histoire_content;
    }

    public function getUrl(): string {
        return $this->url;
    }
    
    public function getAudio(): string {
        return $this->audio;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setHistoireTitre(string $histoire_titre): void {
        $this->histoire_titre = $histoire_titre;
    }

    public function setCategorie(int $categorie): void {
        $this->categorie = $categorie;
    }

    public function setPersonnage(int $personnage): void {
        $this->personnage = $personnage;
    }

    public function setObjet(int $objet): void {
        $this->objet = $objet;
    }

    public function setLieu(int $lieu): void {
        $this->lieu = $lieu;
    }

    public function setHistoireContent(string $histoire_content): void {
        $this->histoire_content = $histoire_content;
    }

    public function setUrludio(string $url): void {
        $this->url = $url;
    }
    
    public function setAudio(string $audio): void {
        $this->audio = $audio;
    }
}
?>
