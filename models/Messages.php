<?php

class Messages {
    private ?int $id;
    private string $message_prenom;
    private string $message_sujet;
    private string $message_content;
    private DateTime $messageDateEnvoi;

    public function __construct(?int $id, string $message_prenom, string $message_sujet, string $message_content, DateTime $messageDateEnvoi) {
        $this->id = $id;
        $this->message_prenom = $message_prenom;
        $this->message_sujet = $message_sujet;
        $this->message_content = $message_content;
        $this->messageDateEnvoi = $messageDateEnvoi;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getMessagePrenom(): string {
        return $this->message_prenom;
    }

    public function getMessageSujet(): string {
        return $this->message_sujet;
    }

    public function getMessageContent(): string {
        return $this->message_content;
    }

    public function getMessageDateEnvoi(): DateTime {
        return $this->messageDateEnvoi;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setMessagePrenom(string $message_prenom): void {
        $this->message_prenom = $message_prenom;
    }

    public function setMessageSujet(string $message_sujet): void {
        $this->message_sujet = $message_sujet;
    }

    public function setMessageContent(string $message_content): void {
        $this->message_content = $message_content;
    }

    public function setMessageDateEnvoi(DateTime $messageDateEnvoi): void {
        $this->messageDateEnvoi = $messageDateEnvoi;
    }
}
?>

