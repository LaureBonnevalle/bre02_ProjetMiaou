<?php

namespace Models;

class ContactsManager extends Database {

    /**
     * Inserts a new user into the database
     *
     * This method takes a `Contacts` object as a parameter and inserts the contact's information
     * into the database using a predefined SQL query. Extracte from the `Contacts` object 
     * and passed as parameters to the SQL query.
     *
     * @param Contacts $newContact - The Contacts object containing the contact's information to be inserted
     * @return void
     */
    public function insert(Messages $newContact):void {
        $sql = "INSERT INTO `messages`(`receptedDate`, `firstname`, `email`, `subject`, `content`) VALUES (?, ?, ?, ?,?)";

        $datas = [
            $newContact->getReceptedDate(),
            $newContact->getFirstname(),
            $newContact->getEmail(),
            $newContact->getSubject(),
            $newContact->getContent()
        ];
        
        $this->execute($sql, $datas);
    }
    
    public function getAll() {
        $sql = "SELECT * FROM `messages` ORDER BY statut ASC, receiptDate DESC";        
        return $this->findAll($sql);
    }
    
    public function getAllNotRead() {
        $sql = "SELECT COUNT(*) as unread_count FROM `messages` WHERE statut = 0";        
        $result = $this->findOne($sql); // Assurez-vous que 'find' retourne une seule ligne
        
        return $result['unread_count']; // Retourne uniquement le nombre de messages non lus
    }

    public function getOne(Contacts $content) {
        $sql = "SELECT * FROM `messages` WHERE id = ?";   
        $data = [ $content->getId() ];     
        return $this->findAll($sql, $data);
    }

    public function updateStatut(Contacts $content) {
        $sql = "UPDATE `messages` SET `statut` = '1' WHERE id = ?";   
        $data = [ $content->getId() ];     
        $this->execute($sql, $data);
    }

    public function deleteOne(Contacts $content) {
        $sql = "DELETE FROM `messages` WHERE id = ?";   
        $data = [ $content->getId() ];     
        $this->execute($sql, $data);
    }
    
}