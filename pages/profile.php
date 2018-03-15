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

$sql = "SELECT L.name, L.board_id, R.rating_num, SD.rank_image 
        FROM `User` AS U, Leaderboard AS L, Competes_in AS C, Rating AS R, Skill_Division AS SD
        WHERE U.user_id = $userid AND U.user_id = C.user_id AND
        C.board_id = L.board_id AND L.board_id = R.board_id AND 
        R.division_id = SD.division_id AND R.user_id = U.user_id";
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
$userid = 1; //placeholder for session stuff

include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

$sql = "SELECT UB2.l_name, UB2.board_id, UB2.user_id, UB2.name, UB2.rating_num,
          @rank_number:=CASE WHEN @boardID <> UB2.board_id THEN 1 ELSE @rank_number+1 END AS rank,
          @boardID:=UB2.board_id AS board_set
        FROM
        (SELECT @rank_number:= 0) s,
        (SELECT @boardID:= 0) c,
        (SELECT * 
        FROM
        (SELECT L.name AS l_name, L.board_id, U.user_id, U.name, R.rating_num
        FROM `User` AS U, Rating AS R, Competes_in AS C, Leaderboard AS L, Skill_Division AS SD
        WHERE U.user_id = C.user_id AND C.board_id = L.board_id AND
        R.board_id = L.board_id AND R.division_id = SD.division_id AND
        R.user_id = U.user_id AND 
        L.board_id IN 
        (SELECT DISTINCT C2.board_id
        FROM Competes_in AS C2
        WHERE C2.user_id = $userid)) AS UB
        ORDER BY UB.board_id, UB.rating_num DESC)AS UB2";
$result = mysqli_query($connection,$sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Leaderboards</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['l_name'] . " - " .$row['name'] . " - " . $row['rating_num'] . " - " . $row['rank'] . "<br>";
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


