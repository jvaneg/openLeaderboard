<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>

<h1>Submitted Matches</h1>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");
$userid = 1; //placeholder for session stuff

$result = viewPendingVerifications($userid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Awaiting Verification</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['submission_id'] . " - " . $row['l_name'] . " - " . $row['name'] . " - " . $row['sender_score'] . " - " . $row['receiver_score'] . " - Verify / Reject" . "<br>";
    }
}
else
{
    echo "no submissions awaiting verification";
}
?>


<?php
$userid = 1; //placeholder for session stuff

$result = viewSubmittedResults($userid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Results Submitted</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['submission_id'] . " - " . $row['l_name'] . " - " . $row['name'] . " - " . $row['sender_score'] . " - " . $row['receiver_score'] . "<br>";
    }
}
else
{
    echo "no results submitted";
}
?>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>
