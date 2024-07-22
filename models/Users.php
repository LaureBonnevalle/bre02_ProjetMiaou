<?php

class Users {
    private ?int $id;
    private string $email;
    private string $password;
    private string $prenom;
    private ?int $age;
    private int $avatar;
    private int $message;
    private int $newsletter;
    private string $statut;
    private string $cle;
    private int $actif;
    private DateTime $createdAt;

    public function __construct(?int $id, string $email, string $password, string $prenom, ?int $age, int $avatar, int $message, int $newsletter, string $statut, string $cle, int $actif, DateTime $createdAt ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->prenom = $prenom;
        $this->age = $age;
        $this->avatar = $avatar;
        $this->message = $message;
        $this->newsletter = $newsletter;
        $this->statut = $statut;
        $this->cle = $cle;
        $this->actif = $actif;
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function getAge(): ?int {
        return $this->age;
    }

    public function getAvatar(): int {
        return $this->avatar;
    }

    public function getMessage(): int {
        return $this->message;
    }

    public function getNewsletter(): int {
        return $this->newsletter;
    }

    public function getStatut(): string {
        return $this->statut;
    }

    public function getCle(): string {
        return $this->cle;
    }

    public function getActif(): int {
        return $this->actif;
    }
    
    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function setAge(?int $age): void {
        $this->age = $age;
    }

    public function setAvatar(int $avatar): void {
        $this->avatar = $avatar;
    }

    public function setMessage(int $message): void {
        $this->message = $message;
    }

    public function setNewsletter(int $newsletter): void {
        $this->newsletter = $newsletter;
    }

    public function setStatut(string $statut): void {
        $this->statut = $statut;
    }

    public function setCle(string $cle): void {
        $this->cle = $cle;
    }

    public function setActif(int $actif): void {
        $this->actif = $actif;
    }
    
    public function setCreatedAt(DateTime $createdAt): void {
        $this->createdAt = $createdAt;
    } 
}
?>
