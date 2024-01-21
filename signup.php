<?php
//Somunachimso Bernard Nzenwa_AGG801_@00652263
session_start();//starts the user's session
require_once("Models/RentalUserDataSet.php");//calls the rental user dataset class
$view = new stdClass();//instantiate an stdClass
$view->pageTitle = "Sign up";//store the current name of the page
$RentalUserDataSet = new RentalUserDataSet();//creates a rental user data set object

//runs if the signup button is clicked
if (isset($_POST['signupBtn'])) {
    $username = htmlentities($_POST['username']);//retrieves the value of username
    $confirmUsername = htmlentities($_POST['confirmUsername']);//retrieves the value of confirmUsername
    $firstName = htmlentities($_POST['firstName']);//retrieves the value of firstName
    $lastName = htmlentities($_POST['lastName']);//retrieves the value of lastName
    $gender = htmlentities($_POST['gender'] ?? '');//checks if the user uploaded a gender and retrieves the value of gender
    $phoneNumber = htmlentities($_POST['phoneNumber'] ?? '');//checks if the user uploaded a phone number and retrieves the value of phoneNumber
    $password = htmlentities($_POST['password']);//retrieves the value of password
    $confirmPassword = htmlentities($_POST['confirmPassword']);//retrieves the value of confirmPassword

    //runs if the value of the username and confirmUsername are equal
    if ($username == $confirmUsername) {
        //runs if the value of the password and confirmPassword are equal
        if ($password == $confirmPassword) {
            $password = password_hash($password, PASSWORD_DEFAULT);//encrypt the password

            //inserts and registers the users inputted details into the database
            $register = $RentalUserDataSet->registerUser($username, $firstName, $lastName, $gender, $phoneNumber, $password);

            //runs if the user has been registered
            if ($register) {
                $user = $RentalUserDataSet->fetchUserDetails($username);//creates a rental user object
                $_SESSION['user_id'] = $user->getUserId();//create a user id session variable
                $_SESSION['username'] = $user->getUsername();//create a username session variable
                $_SESSION["loggedIn"] = true;//sets logged-in session to true
                header("Location: search.php"); //redirects to search page
            } else {
                $view->userWrong = "This username is not available";
            }
        } else {
            $view->passMismatch = "The passwords do not match";
        }
    } else {
        $view->userMismatch = "The usernames do not match";
    }
}
require_once("Views/signup.phtml");
