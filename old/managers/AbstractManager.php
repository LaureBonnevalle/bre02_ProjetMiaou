<?php
require_once("ErrorManager.php");

abstract class AbstractManager {
    protected PDO $db;

    
    /**
     * Constructor of the DatabaseManager class.
     * Initializes a new instance of the PDO class for database management.
     * Uses DB_HOST, DB_NAME, DB_USER and DB_PASSWORD constants for connection configuration.
     * Also configures default recovery mode and error handling mode.
     *
     * @throws \PDOException If database connection fails.
    */
    public function __construct()
    {
        $connexion = "mysql:host=".$_ENV["DB_HOST"].";port=3306;charset=".$_ENV["DB_CHARSET"].";dbname=".$_ENV["DB_NAME"];
        $this->db = new PDO(
            $connexion,
            $_ENV["DB_USER"],
            $_ENV["DB_PASSWORD"],
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // Returns an array indexed by the column name
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION       // throws PDOExceptions
            ]
        );
    }
    
    
    /**
     * Method which allows you to execute an SQL query and return a record set.
     *
     * @param    string  $req    - SQL request.
     * @param    array   $params - Parameters array for the query.
     *
     * @return   array           - Array containing a recordset.
    */
    protected function findAll(string $req, array $params = []) {
        try {
            $query = $this->db->prepare($req);
            $query->execute($params);
            return $query->fetchAll();
        } catch (\PDOException $e) {
            self::logError($e->getMessage());
            self::redirectToErrorPage();
        }
    }
    
    
    
    /**
     * Method which allows you to execute an SQL query and return a single record.
     *
     * @param    string  $req    - SQL request.
     * @param    array   $params - Parameters array for the query.
     *
     * @return   array           - Array containing a single record.
    */
    protected function findOne($req, $params = []) {
        try {
            $query = $this->db->prepare($req);
            $query->execute($params);
            return $query->fetch();
        } catch (\PDOException $e) {
            self::logError($e->getMessage());
            self::redirectToErrorPage();
        }
    }
    
    
     /**
     * Method for execute a query with parameters.
     *
     * @param    string  $req    - SQL request.
     * @param    array   $params - Parameters array for the query.
     *
     * @return   void
    */
    protected function execute($sql, $params = []) {
        $query = $this->db->prepare($sql);
        $query->execute($params);
        $query->closeCursor();
    }
    
}