<?php session_start(); //starts the user's session
if ($_SESSION['loggedIn']) {
//Somunachimso Bernard Nzenwa_AGG801_@00652263
    $view = new stdClass();
    $view->pageTitle = "Request";

    if (isset($_POST['requestBtn'])) {
        header('Location: search.php');//redirects to search page
    }
    require_once("Views/request.phtml");
}