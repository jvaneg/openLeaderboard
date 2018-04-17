<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['submitNewLeaderboard']) && isset($_SESSION['user_id']))
{
    $lbName = mb_strimwidth($_POST['newLbName'],0,252);
    $lbDescription = mb_strimwidth($_POST['newLbDesc'],0,252);
    $lbCategoryName = mb_strimwidth($_POST['newLbCategory'],0,252);
    $userID = $_SESSION['user_id'];
    $boardID = -1;

    $lbCategoryID = getCategoryIDByName($lbCategoryName);

    //TODO prevent sql injection stuff here
    if(!(($lbCategoryID == -1) || lbNameTaken($lbName)))
    {
        //TODO prevent sql injection stuff here
        $boardID = addLeaderboard($lbName, $lbDescription, $lbCategoryID, $userID);
    }

    if($boardID != -1)
    {
        header("Location: /pages/leaderboard.php?boardid=$boardID");
        exit();
    }
    else
    {
        header("Location: /pages/createLeaderboard.php?success=false");
        exit();
    }
}
else
{
    header("Location: /pages/createLeaderboard.php?success=false");
    exit();
}
?>