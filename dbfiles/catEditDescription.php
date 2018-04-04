<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['submitNewDesc']) && isset($_SESSION['user_id']))
{
    $newDesc = mb_strimwidth($_POST['newDesc'],0,252);
    $categoryID = $_POST['category_id'];
    $userID = $_SESSION['user_id'];

    //TODO prevent sql injection stuff here
    editCatDescription($userID, $categoryID, $newDesc);

    header("Location: /pages/category.php?categoryid=$categoryID");
    exit();
}
else
{
    header("Location: /pages/leaderboard.php?categoryid=$categoryID");
    exit();
}
?>