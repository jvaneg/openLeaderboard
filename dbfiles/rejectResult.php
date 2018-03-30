<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

if(isset($_POST['rejectSubmission']))
{
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

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