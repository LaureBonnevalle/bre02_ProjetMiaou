<?php

namespace Models;

class Database extends ErrorManager {

    protected $bdd;

    /**
     * Constructor of the DatabaseManager class.
     * Initializes a new instance of the PDO class for database management.
     * Uses DB_HOST, DB_NAME, DB_USER and DB_PASS constants for connection configuration.
     * Also configures default recovery mode and error handling mode.
     *
     * @throws \PDOException If database connection fails.
    */
    public function __construct() {
        try {
            $this->bdd = new \PDO("mysql:host=" . DB_CONFIG[INTEGRAL_CONFIG['infos']['db_connection']]['host'] .
                ";dbname=" . DB_CONFIG[INTEGRAL_CONFIG['infos']['db_connection']]['dbname'] .
                ";charset=utf8", DB_CONFIG[INTEGRAL_CONFIG['infos']['db_connection']]['user'],
                DB_CONFIG[INTEGRAL_CONFIG['infos']['db_connection']]['password'], [
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // Returns an array indexed by the column name
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION       // throws PDOExceptions
            ]);
        } catch (\PDOException $e) {
            self::logError($e->getMessage());   // Error logging.
            self::redirectToErrorPage();        // Redirects user to error page.
        }
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
            $query = $this->bdd->prepare($req);
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
            $query = $this->bdd->prepare($req);
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
        $query = $this->bdd->prepare($sql);
        $query->execute($params);
        $query->closeCursor();
    }
}