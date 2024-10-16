<?php

class Lieux {
    private ?int $id;
    private string $lieu_name;
    private string $lieu_description;
    private string $url;
    private string $alt;

    public function __construct(?int $id, string $lieu_name, string $lieu_description) {
        $this->id = $id;
        $this->lieu_name = $lieu_name;
        $this->lieu_description = $lieu_description;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getLieuName(): string {
        return $this->lieu_name;
    }

    public function getLieuDescription(): string {
        return $this->lieu_description;
    }
    
    public function getUrl(): string {
        return $this->url;
    }
    
    public function getAlt(): string {
        return $this->alt;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setLieuName(string $lieu_name): void {
        $this->lieu_name = $lieu_name;
    }

    public function setLieuDescription(string $lieu_description): void {
        $this->lieu_description = $lieu_description;
    }
    
    public function setUrl(string $url): void {
        $this->url = $url;
    }
    
    public function setAlt(string $alt): void {
        $this->alt = $alt;
    }
}
?>
