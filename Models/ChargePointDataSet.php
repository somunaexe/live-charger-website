<?php
//Somunachimso Bernard Nzenwa_AGG801_@00652263
require_once ("Models/Database.php");
require_once("Models/ChargePoint.php");

class ChargePointDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * Adds a charge point to the database
     *
     * @param $streetAddress
     * @param $city
     * @param $postcode
     * @param $latitude
     * @param $longitude
     * @param $price
     * @param $owner
     * @return bool
     */
    public function registerChargePoint($streetAddress, $city, $postcode, $latitude, $longitude, $price, $owner) {
        $statement = $this->_dbHandle->prepare("SELECT * FROM charge_points WHERE street_address = '$streetAddress'");
        $statement->execute();//executes the statement
        $row = $statement->fetch();
        if(empty($row))
        {
            $statement = $this->_dbHandle->prepare("INSERT INTO charge_points (street_address, city, postcode, latitude, longitude, price, owner) VALUES('$streetAddress', '$city', '$postcode', '$latitude', '$longitude', '$price', '$owner')");
            $statement->execute();//executes the statement
            return true;//Charge point has been registered
        } else {
            return false;//Charge point has NOT been registered
        }
    }

    /**
     * Return details of a charge point
     *
     * @param $streetAddress
     * @return ChargePoint
     * @return false
     */
    public function fetchChargePointDetails($streetAddress)//fetch the charge point details from the database
    {
        $statement = $this->_dbHandle->prepare("SELECT * FROM charge_points WHERE street_address = '$streetAddress'");
        $statement->execute();//executes the statement
        $row = $statement->fetch();//retrieves the query result
        return new ChargePoint($row);//returns chargers details
    }

    /**
     * Update the details of a charge point
     *
     * @param $streetAddress
     * @param $city
     * @param $postcode
     * @param $latitude
     * @param $longitude
     * @param $price
     * @param $streetAdd
     * @return ChargePoint
     */
    public function updateDetails($streetAddress, $city, $postcode, $latitude, $longitude, $price, $streetAdd)//fetch the charge point details from the database
    {
        $statement = $this->_dbHandle->prepare("UPDATE charge_points SET street_address = '$streetAddress', city = '$city', postcode = '$postcode', lat = '$latitude', lon = '$longitude', price = '$price' WHERE street_address = '$streetAdd'");
        $statement->execute();//executes the statement
        $row = $statement->fetch();//retrieves the query result
        return new ChargePoint($row);//returns charge point details
    }
}