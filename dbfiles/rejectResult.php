<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['rejectSubmission']) && isset($_SESSION['user_id']))
{
    $submissionID = $_POST['submission_id'];
    $receiverID = $_SESSION['user_id'];

    rejectResult($submissionID,$receiverID);

    header("Location: /pages/submitted.php");
    exit();
}
else
{
    header("Location: /pages/submitted.php");
    exit();
}
?>