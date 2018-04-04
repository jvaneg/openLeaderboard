<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['submitResultButton']) && isset($_SESSION['user_id']))
{
    $receiverName = mb_strimwidth($_POST['opponentName'],0,252); //TODO this stuff might be bad for users with really long names (best solution: make usernames shorter)
    $senderScore = intval($_POST['senderScore']); //TODO should probably make sure these are numbers
    $receiverScore = intval($_POST['receiverScore']); //TODO should probably make sure these are numbers
    $boardID = $_POST['boardID'];
    $senderID = $_SESSION['user_id'];
    $receiverID = -1;

    $receiverID = getUserIDByName($receiverName); //TODO prevent sql injection stuff here

    if($receiverID != -1)
    {
        //TODO prevent sql injection stuff here
        createMatchSubmission($boardID, $senderID, $senderScore, $receiverID, $receiverScore);
    }
    else
    {
        header("Location: /pages/leaderboard.php?boardid=$boardID");
        exit();
    }


    header("Location: /pages/submitted.php");
    exit();

}
else
{
    header("Location: /pages/leaderboard.php?boardid=$boardID");
    exit();
}
?>