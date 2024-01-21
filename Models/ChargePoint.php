<?php
//Somunachimso Bernard Nzenwa_AGG801_@00652263

class ChargePoint implements JsonSerializable {
    private $streetAddress, $city, $postcode, $latitude, $longitude, $price, $owner;

    public function __construct($dbRow) {
        $this->streetAddress = $dbRow['street_address'];
        $this->city = $dbRow['city'];
        $this->postcode = $dbRow['postcode'];
        $this->latitude= $dbRow['lat'];
        $this->longitude = $dbRow['lon'];
        $this->price = $dbRow['price'];
        $this->owner = $dbRow['owner'];
    }

    /**
     * @return mixed
     */
    public function getStreetAddress() {
        return $this->streetAddress;
    }

    /**
     * @return mixed
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getPostcode() {
        return $this->postcode;
    }

    /**
     * @return mixed
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getOwner() {
        return $this->owner;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(){
        return ['_address' => $this->streetAddress.','.$this->city.','.$this->postcode,'_latitude' => $this->latitude, '_longitude' => $this->longitude, '_price' => $this->price,];
    }
}

