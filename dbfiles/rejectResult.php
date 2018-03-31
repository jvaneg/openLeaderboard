<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['rejectSubmission']))
{
    $submissionID = $_POST['submission_id'];
    $receiverID = $_POST['receiver_id'];

    rejectResult($submissionID,$receiverID);

    header("Location: /pages/submitted.php");

}
else
{
    header("Location: /pages/submitted.php");
    exit();
}
?>