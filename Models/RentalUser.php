<?php
//Somunachimso Bernard Nzenwa_AGG801_@00652263 implements JsonSerializable
class RentalUser  {
    private $userId, $username, $firstName, $lastName, $gender, $phoneNumber, $password;

    /**
     * RentalUser constructor
     * @param $dbRow
     */
    public function __construct($dbRow)
    {
        $this->userId = $dbRow['user_id'];
        $this->username = $dbRow['username'];
        $this->firstName = $dbRow['first_name'];
        $this->lastName = $dbRow['last_name'];
        $this->gender = $dbRow['gender'];
        $this->phoneNumber = $dbRow['phone_number'];
        $this->password = $dbRow['password'];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return array
     */
    /*public function jsonSerialize()
    {
        return ['_image' => $this->image, '_userId' => $this->userId, '_username' => $this->username, '_firstName' => $this->firstName, '_lastName' => $this->lastName, '_gender' => $this->gender, '_phoneNumber' => $this->phoneNumber,];
    }*/
}