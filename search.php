<?php session_start(); //starts the user's session
if ($_SESSION['loggedIn']) {
//  Somunachimso Bernard Nzenwa_AGG801_@00652263
    require_once("Models/SearchDataSet.php");
    $view = new stdClass();
    $view->pageTitle = "Search";
    $SearchDataSet = new SearchDataSet();//creates instance of Search Data Set class

    if (isset($_GET['search'])) {
        $searchResult = $SearchDataSet->searchChargePoints($_GET['search']);//find charge points based of the search parameter
        echo json_encode($searchResult);//Encodes the dataset to a JSON
        return;
    }
    require_once("Views/search.phtml");
}