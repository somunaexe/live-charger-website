<?php session_start();
if ($_SESSION['loggedIn']) {
//Somunachimso Bernard Nzenwa_AGG801_@00652263
    require_once("Models/RentalUserDataSet.php");
    $view = new stdClass();
    $view->pageTitle = "My Details";
    $RentalUserDataSet = new RentalUserDataSet();
    $User = $RentalUserDataSet->fetchUserDetails($_SESSION['username']);//creates a rental user object
    /**
     * Runs when the update button is clicked
     */
    if(isset($_POST['updateBtn'])) {
        $firstName = htmlentities($_POST['firstName']);//retrieves the value of firstName
        $lastName = htmlentities($_POST['lastName']);//retrieves the value of lastName
        $gender = htmlentities(isset($_POST['gender']) ? $_POST['gender'] : '');//retrieves the value of gender
        $phoneNumber = htmlentities(isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '');//retrieves the value of phoneNumber

        //updates users account details
        $updated = $RentalUserDataSet->updateProfile($_SESSION['username'], $firstName, $lastName, $gender, $phoneNumber);

        //runs if the users details have been updated
        if ($updated) {
            $user = $RentalUserDataSet->fetchUserDetails($_SESSION['username']);//returns a rental user object
            $view->success = "Your details have been changed!";
        }
    }
    require_once("Views/profile.phtml");
}