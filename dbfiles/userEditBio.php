<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['submitNewBio']) && isset($_SESSION['user_id']))
{
    $newBio = mb_strimwidth($_POST['newBio'],0,252);
    $userID = $_SESSION['user_id'];

    //TODO prevent sql injection stuff here
    editUserBio($userID, $newBio);

    header("Location: /pages/profile.php");
}
else
{
    header("Location: /pages/profile.php");
    exit();
}
?>