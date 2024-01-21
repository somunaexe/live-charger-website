<?php
//Somunachimso Bernard Nzenwa_AGG801_@00652263
require_once ("Models/Database.php");
require_once("Models/RentalUser.php");

class RentalUserDataSet {
    protected $_dbHandle, $_dbInstance;
    private $ids;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();//create a new instance of Database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();//get the database connection
        $this->ids = array();//creates a new array to store the user ids
    }

    /**
     * @param $username
     * @param $firstName
     * @param $lastName
     * @param $gender
     * @param $phoneNumber
     * @param $password
     * @return bool
     *
     * Insert the user details into the database
     */
    public function registerUser($username, $firstName, $lastName, $gender, $phoneNumber, $password)//registers the users details
    {
        $statement = $this->_dbHandle->prepare("SELECT * FROM users WHERE username = '$username'");//prepares the statement
        $statement->execute();//executes the statement
        $row = $statement->fetch();//retrieves the result of the statement

        if(empty($row))
        {
            $newId = "";
            do{
                //adds random digits to make up the user id. This loop runs 8 times
                for($i = 0; $i < 8; $i++){
                    $newId .= "" . mt_rand(0,9);//typecasts the integers to strings and concatenates them
                }
            }
            while($this->checkId($newId));

            $userIds = $this->ids;//point to the array of user ids
            $userIds[] = $newId;//add the new id to the array

            //prepares the statement
            $statement = $this->_dbHandle->prepare("INSERT INTO users (user_id, username, first_name, last_name, gender, phone_number, password) VALUES('$newId', '$username', '$firstName', '$lastName', '$gender', $phoneNumber, '$password')");
            $statement->execute();//executes the statement
            return true;//returns true if the user has been added to the database
        } else {
            return false;//returns false if the user has not been added to the database
        }
    }

    /**
     * @param $username
     * @return RentalUser
     */
    public function fetchUserDetails($username)//fetch the users details from the database
    {
        $statement = $this->_dbHandle->prepare("SELECT * FROM users WHERE username = '$username'");//prepares the statement
        $statement->execute();//executes the statement
        $row = $statement->fetch();//retrieves the result of the statement
        return new RentalUser($row);//returns users details
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function verifyUserLogin($username, $password)//check if the login details are correct
    {
        $statement = $this->_dbHandle->prepare("SELECT password FROM users WHERE username = '$username'");//prepares the statement
        $statement->execute();//executes the statement
        $row = $statement->fetch();//retrieves the result of the statement

        if(empty($row)) {
            return false;//Username does not exist in database
        }
        //checks if the given password matches the returned hash
        if(password_verify($password, $row['password'])){
            return true;//Passwords match
        }else{
            return false;//Passwords do NOT match
        }
    }

    /**
     * @param $newId
     * @return bool
     */
    public function checkId($newId)//checks if the user id has already been allocated to a user
    {
        if(!in_array($newId, $this->ids)){
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function checkForCharger($id)
    {
        $statement = $this->_dbHandle->prepare("SELECT street_address FROM charge_points WHERE owner = '$id'");//prepares the statement
        $statement->execute();//executes the statement

        $row = $statement->fetch();//retrieves the result of the statement

        //runs if the result is empty
        if (empty($row)) {
            return false;//id does not exist in the database
        } else {
            return $row['street_address'];//id exists in the database
        }
    }

    public function updateProfile($username, $first_name, $last_name, $gender, $phone_number)//fetch the charge point details from the database
    {
        $statement = $this->_dbHandle->prepare("UPDATE users SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', phone_number = '$phone_number' WHERE username = '$username'");
        $statement->execute();//executes the statement
        $row = $statement->fetch();
        return new RentalUser($row);//returns users details
    }
}