<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

    <h2>Leaderboard Page</h2>

<?php
$boardid = 1; //placeholder for session stuff

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT `name`, `description` FROM `Leaderboard` WHERE `board_id` = $boardid";
$result = mysqli_query($connection,$sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    echo $row['name'] . "<br>" . $row['description'] . "<br>";
}
else
{
    echo "no name or bio - ERROR BAD";
}
?>

    <h2>Join/Leave - Submit Match (these dont do anything)</h2>

<?php
$boardid = 1; //placeholder for session stuff

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT UB3.name, UB3.user_id, UB3.rating_num, UB3.rank, UB3.rank_image
        FROM
        (SELECT UB2.user_id, UB2.name, UB2.rating_num, UB2.rank_image,
          @curRank := IF(@prevRank = UB2.rating_num, @curRank, @incRank) AS rank,
          @incRank := @incRank + 1,
          @prevRank := UB2.rating_num
        FROM
        (SELECT @curRank := 0, @prevRank := NULL, @incRank := 1) AS vars,
        (SELECT * 
        FROM
        (SELECT U.user_id, U.name, R.rating_num, SD.rank_image
        FROM `User` AS U, Rating AS R, Competes_in AS C, Leaderboard AS L, Skill_Division AS SD
        WHERE U.user_id = C.user_id AND C.board_id = L.board_id AND
        R.board_id = L.board_id AND R.division_id = SD.division_id AND
        R.user_id = U.user_id AND L.board_id = $boardid) AS UB
        ORDER BY UB.rating_num DESC)AS UB2) AS UB3";
$result = mysqli_query($connection,$sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Leaderboard</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['rank'] . " - " . $row['name'] . " - " . $row['rating_num'] . " - " . $row['rank_image'] . "<br>";
    }
}
else
{
    echo "no participants";
}
?>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>