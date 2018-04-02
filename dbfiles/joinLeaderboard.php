<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['joinLb']) && isset($_SESSION['user_id']))
{
    $boardID = $_POST['board_id'];
    $userID = $_SESSION['user_id'];

    joinLeaderboard($userID, $boardID);

    header("Location: /pages/leaderboard.php?boardid=$boardID");
    exit();
}
else
{
    header("Location: /pages/leaderboard.php?boardid=$boardID");
    exit();
}
?>