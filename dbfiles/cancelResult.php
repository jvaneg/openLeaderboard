<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['cancelSubmission']) && isset($_SESSION['user_id']))
{
    $submissionID = $_POST['submission_id'];
    $senderID = $_SESSION['user_id'];

    cancelResult($submissionID,$senderID);

    header("Location: /pages/submitted.php");
    exit();
}
else
{
    header("Location: /pages/submitted.php");
    exit();
}
?>