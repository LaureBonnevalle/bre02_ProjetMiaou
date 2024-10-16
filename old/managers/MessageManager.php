<?php

namespace Models;

class messagesManager extends Database {

    /**
     * Inserts a new user into the database
     *
     * This method takes a `messages` object as a parameter and inserts the contact's information
     * into the database using a predefined SQL query. Extracte from the `messages` object 
     * and passed as parameters to the SQL query.
     *
     * @param messages $newContact - The messages object containing the contact's information to be inserted
     * @return void
     */
    public function insert(messages $newMessages):void {
        $sql = "INSERT INTO `messages`(`receptedDate`, `firstname`, `email`, `content`) VALUES (?, ?, ?, ?)";

        $datas = [
            $newMessages->getReceiptDate(),
            $newMessages->getFirstname(),
            $newMessages->getEmail(),
            $newMessages->getcontent()
        ];
        
        $this->execute($sql, $datas);
    }
    
    public function getAll() {
        $sql = "SELECT * FROM `messages` ORDER BY statut ASC, receptedDate DESC";        
        return $this->findAll($sql);
    }
    
    public function getAllNotRead() {
        $sql = "SELECT COUNT(*) as unread_count FROM `messages` WHERE statut = 0";        
        $result = $this->findOne($sql); // Assurez-vous que 'find' retourne une seule ligne
        
        return $result['unread_count']; // Retourne uniquement le nombre de messages non lus
    }

    public function getOne(messages $content) {
        $sql = "SELECT * FROM `messages` WHERE id = ?";   
        $data = [ $content->getId() ];     
        return $this->findAll($sql, $data);
    }

    public function updateStatut(messages $statut) {
        $sql = "UPDATE `messages` SET `statut` = '1' WHERE id = ?";   
        $data = [ $statut->getId() ];     
        $this->execute($sql, $data);
    }

    public function deleteOne(messages $content) {
        $sql = "DELETE FROM `messages` WHERE id = ?";   
        $data = [ $content->getId() ];     
        $this->execute($sql, $data);
    }
    
}