<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>

<h1>Profile</h1>

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
        echo "no name or bio - ERROR BAD";
    }
?>



<?php
$userid = 1; //placeholder for session stuff

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT L.name, L.board_id FROM Board_Admin AS B, Leaderboard AS L WHERE B.user_id = $userid AND B.user_id = L.owner_id";
$result = mysqli_query($connection,$sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Managed Leaderboards</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['name'] . " - " . $row['board_id'] . "<br>";
    }
}
else
{
    echo "no managed leaderboards";
}
?>

<?php
$userid = 1; //placeholder for session stuff

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT UB3.l_name, UB3.board_id, UB3.rating_num, UB3.rank, UB3.rank_image
        FROM
        (SELECT UB2.l_name, UB2.board_id, UB2.user_id, UB2.name, UB2.rating_num, UB2.rank_image,
          @curRank := CASE WHEN @boardID <> UB2.board_id THEN 1 ELSE IF(@prevRank = UB2.rating_num, @curRank, @incRank) END AS rank,
          @incRank := IF(@boardID <> UB2.board_id, 2, @incRank + 1),
          @prevRank := UB2.rating_num,
          @boardID := UB2.board_id AS board_set
        FROM
        (SELECT @curRank := 0, @prevRank := NULL, @incRank := 1, @boardID := 0) AS vars,
        (SELECT * 
        FROM
        (SELECT L.name AS l_name, L.board_id, U.user_id, U.name, R.rating_num, SD.rank_image
        FROM `User` AS U, Rating AS R, Competes_in AS C, Leaderboard AS L, Skill_Division AS SD
        WHERE U.user_id = C.user_id AND C.board_id = L.board_id AND
        R.board_id = L.board_id AND R.division_id = SD.division_id AND
        R.user_id = U.user_id AND 
        L.board_id IN 
        (SELECT DISTINCT C2.board_id
        FROM Competes_in AS C2
        WHERE C2.user_id = $userid)) AS UB
        ORDER BY UB.board_id, UB.rating_num DESC)AS UB2) AS UB3
        WHERE user_id = $userid";
$result = mysqli_query($connection,$sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Leaderboards</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['l_name'] . " - " . $row['rating_num'] . " - " . $row['rank'] . " - " . $row['rank_image'] . "<br>";
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


