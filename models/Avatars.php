<?php

class Avatars {
    private ?int $id;
    private string $name;
    private string $source;
    private string $description;
    private string $caracteristique;
    private string $qualite;

    public function __construct(?int $id, string $name, string $source, string $description, string $caracteristique, string $qualite) {
        $this->id = $id;
        $this->name = $name;
        $this->source = $source;
        $this->description = $description;
        $this->caracteristique = $caracteristique;
        $this->qualite = $qualite;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSource(): string {
        return $this->source;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCaracteristique(): string {
        return $this->caracteristique;
    }

    public function getQualite(): string {
        return $this->qualite;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setSource(string $source): void {
        $this->source = $source;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setCaracteristique(string $caracteristique): void {
        $this->caracteristique = $caracteristique;
    }

    public function setQualite(string $qualite): void {
        $this->qualite = $qualite;
    }
}
?>
