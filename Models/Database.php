<?php
//Somunachimso Bernard Nzenwa_AGG801_@00652263

class Database {
    protected static $_dbInstance;
    protected $_dbHandle; //handles the db connection

    public static function getInstance() {
        $host = 'poseidon.salford.ac.uk';
        $dbName = 'agg801_user';
        $username = 'agg801';
        $password = 'Dwayne674201#';
        if (self::$_dbInstance === null) {
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }
        return self::$_dbInstance;
    }

    private function __construct($username, $password, $host, $database) {
        try{
            $this->_dbHandle = new PDO("mysql:host=$host; dbname=$database", $username, $password);
        }catch(PDOException $e){ //catches any PDOException within the database

            echo $e->getMessage();//print the exception message
        }
    }

    // return the PDO database connection
    public function getdbConnection()
    {
        return $this->_dbHandle;
    }

    // destroy the PDO connection. ONLY USE WHEN NO LONGER NEEDED!
    public function __destruct()
    {
        $this->_dbHandle = null;
    }
}