<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['joinLb']))
{
    $boardID = $_POST['board_id'];
    $userID = $_POST['user_id'];


    joinLeaderboard($userID, $boardID);


    header("Location: /pages/leaderboard.php?boardid=$boardID");

}
else
{
    header("Location: /pages/leaderboard.php?boardid=$boardID");
    exit();
}
?>