<?php
/**
 * Created by PhpStorm.
 * User: kiera
 * Date: 4/10/2018
 * Time: 7:38 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['removeCategory']) && isset($_SESSION['user_id']))
{
    $categoryID = $_POST['category_id'];
    $userID = $_POST['user_id'];

    removeCategoryFromDb($userID, $categoryID);

    header("Location: /pages/leaderboardSearch.php");
    exit();
}
else
{
    header("Location: /pages/leaderboardSearch.php");
    exit();
}
?>