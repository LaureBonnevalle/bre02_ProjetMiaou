<?php

class Personnages {
    private ?int $id;
    private string $perso_name;
    private string $perso_description;

    public function __construct(?int $id, string $perso_name, string $perso_description) {
        $this->id = $id;
        $this->perso_name = $perso_name;
        $this->perso_description = $perso_description;
    }

    // Getter pour id
    public function getId(): ?int {
        return $this->id;
    }

    // Setter pour id
    public function setId(?int $id): void {
        $this->id = $id;
    }

    // Getter pour perso_name
    public function getPersoName(): string {
        return $this->perso_name;
    }

    // Setter pour perso_name
    public function setPersoName(string $perso_name): void {
        $this->perso_name = $perso_name;
    }

    // Getter pour perso_description
    public function getPersoDescription(): string {
        return $this->perso_description;
    }

    // Setter pour perso_description
    public function setPersoDescription(string $perso_description): void {
        $this->perso_description = $perso_description;
    }
}
?>
