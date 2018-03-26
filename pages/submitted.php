<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>

<h1>Submitted Matches</h1>

<?php
$userid = 1; //placeholder for session stuff

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT RS.submission_id, L.name AS l_name, RS.board_id, RS.sender_score, RS.receiver_score, U.name, RS.sender_id
        FROM Result_Submission AS RS, User AS U, Leaderboard AS L
        WHERE RS.receiver_id = $userid AND RS.sender_id = U.user_id AND
        RS.board_id = L.board_id";
$result = mysqli_query($connection,$sql);
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

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT RS.submission_id, L.name AS l_name, RS.board_id, RS.sender_score, RS.receiver_score, U.name, RS.receiver_id
        FROM Result_Submission AS RS, User AS U, Leaderboard AS L
        WHERE RS.sender_id = $userid AND RS.receiver_id = U.user_id AND
        RS.board_id = L.board_id";
$result = mysqli_query($connection,$sql);
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
