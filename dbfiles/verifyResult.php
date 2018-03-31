<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

if(isset($_POST['verifySubmission']))
{
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

    $submissionID = $_POST['submission_id'];
    $receiverID = $_POST['receiver_id'];

    $resultData = mysqli_fetch_assoc(getResultData($submissionID));

    $resultReceiverID = $resultData['receiver_id'];
    $senderID = $resultData['sender_id'];
    $boardID = $resultData['board_id'];
    $senderScore = $resultData['sender_score'];
    $receiverScore = $resultData['receiver_score'];
    $sndrRatChange = intval($resultData['sndr_rat_change']);
    $rcvrRatChange = intval($resultData['rcvr_rat_change']);


    if($receiverID == $resultReceiverID)
    {
        verifyResult($submissionID, $senderID, $receiverID, $boardID, $senderScore, $receiverScore, $sndrRatChange, $rcvrRatChange);

        updateSkillDivision($receiverID, $boardID);
        updateSkillDivision($senderID,$boardID);
    }
    else
    {
        header("Location: /pages/submitted.php");
        exit();
    }

    header("Location: /pages/submitted.php");

}
else
{
    header("Location: /pages/submitted.php");
    exit();
}
?>