<?php

class Objets {
    private int $id;
    private string $objet_name;
    private string $objet_description;
    private string $url;
    private string $alt;
    

    public function __construct(int $id, string $objet_name, string $objet_description) {
        $this->id = $id;
        $this->objet_name = $objet_name;
        $this->objet_description = $objet_description;
    }

    // Getter pour id
    public function getId(): int {
        return $this->id;
    }

    // Setter pour id
    public function setId(int $id): void {
        $this->id = $id;
    }

    // Getter pour objet_name
    public function getObjetName(): string {
        return $this->objet_name;
    }
    
    public function getUrl(): string {
        return $this->url;
    }
    
    public function getAlt(): string {
        return $this->alt;
    }

    // Setter pour objet_name
    public function setObjetName(string $objet_name): void {
        $this->objet_name = $objet_name;
    }

    // Getter pour objet_description
    public function getObjetDescription(): string {
        return $this->objet_description;
    }

    // Setter pour objet_description
    public function setObjetDescription(string $objet_description): void {
        $this->objet_description = $objet_description;
    }
    public function setUrl(string $url): void {
        $this->url = $url;
    }
    
    public function setAlt(string $alt): void {
        $this->alt = $alt;
    }
}
?>
