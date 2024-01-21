<?php
//Somunachimso Bernard Nzenwa_AGG801_@00652263
session_start(); //starts the user's session
require_once ("Models/RentalUserDataSet.php");
require_once ("Models/ChargePointDataSet.php");
$view = new stdClass();
$view->pageTitle = "Login";
$_SESSION['loggedIn'] = false;//sets the users log in status to false
$_SESSION['charger'] = false;//the user does not own a charger

/**
 * Runs when the login button is pressed
 */
if(isset($_POST["loginBtn"])) {
    $username = htmlentities($_POST['username']);//retrieves inputted username
    $password = htmlentities($_POST['password']);//retrieves inputted password
    $RentalUserDataSet = new RentalUserDataSet();//creates an instance of the RentalUserDataset class
    $correct = $RentalUserDataSet->verifyUserLogin($username, $password);//checks if the information sent by the user is correct

//  runs if the inserted details are correct
    if($correct){
        $user = $RentalUserDataSet->fetchUserDetails($username);//create and returns a rental user object

        $_SESSION['loggedIn'] = true;//starts a logged-in session
        $_SESSION["user_id"] = $user->getUserID();//starts a user id session
        $_SESSION['username'] = $user->getUsername();//create a username session variable
        $chargerCheck = $RentalUserDataSet->checkForCharger($_SESSION["user_id"]);//checks if the user owns a charge point

        if ($chargerCheck){
            $_SESSION['charger'] = true;//starts a charger session
        }
//      redirect the user to the search page after logged in correctly
        header("Location: search.php");
    }else {
//      display an error message when wrong information is entered
        $view->wrongLogIn = "Wrong username or password";
    }
}
require_once("Views/index.phtml");
