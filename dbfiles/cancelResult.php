<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

if(isset($_POST['cancelSubmission']))
{
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

    $submissionID = $_POST['submission_id'];
    $senderID = $_POST['sender_id'];

    cancelResult($submissionID,$senderID);

    header("Location: /pages/submitted.php?success=true&sub=$submissionID&rec=$senderID");

}
else
{
    header("Location: /pages/submitted.php?success=false");
    exit();
}
?>