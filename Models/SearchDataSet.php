<?php
//Somunachimso Bernard Nzenwa_AGG801_@00652263
require_once("Models/Database.php");
require_once("Models/ChargePoint.php");

class SearchDataSet {
    protected $_dbInstance, $_dbHandle;

    public function __construct() {
        $this->_dbInstance = Database::getInstance(); //create a new instance of Database
        $this->_dbHandle = $this->_dbInstance->getdbConnection(); //get the database connection
    }

    /**
     * Return the searched charge point details
     *
     * @param mixed $search
     */
    public function searchChargePoints($search) {
        $searchTerm = "%{$search}%"; // Add wildcards to allow partial matches

        $statement = $this->_dbHandle->prepare("SELECT * FROM charge_points WHERE street_address LIKE :searchTerm OR city LIKE :searchTerm OR price LIKE :searchTerm OR postcode LIKE :searchTerm");
        $statement->bindParam(':searchTerm', $searchTerm);
        $statement->execute();

        $dataset = [];
        while ($row = $statement->fetch()) {
            $Charger = new ChargePoint($row);
            $dataset[] = $Charger;
        }
        return $dataset; // returns all the charge points' details in an array
    }
}