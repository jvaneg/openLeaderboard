<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

<h2>user page</h2>

<?php
$userid = 1; //placeholder for session stuff

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT `name`, `bio` FROM `User` WHERE `user_id` = $userid";
$result = mysqli_query($connection,$sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    echo $row['name'] . "<br>" . $row['bio'] . "<br>";
}
else
{
    echo "bad bad bad";
}
?>

<?php
$userid = 1; //placeholder for session stuff

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT L.name, L.board_id, R.rating_num, SD.rank_image 
        FROM `User` AS U, Leaderboard AS L, Competes_in AS C, Rating AS R, Skill_Division AS SD
        WHERE U.user_id = $userid AND U.user_id = C.user_id AND
        C.board_id = L.board_id AND L.board_id = R.board_id AND 
        R.division_id = SD.division_id";
$result = mysqli_query($connection,$sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Leaderboards</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['name'] . " - " . $row['rating_num'] . " - " . $row['rank_image'] . "<br>";
    }
}
else
{
    echo "no leaderboards";
}
?>


<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>