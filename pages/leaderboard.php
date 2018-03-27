<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

    <h2>Leaderboard Page</h2>

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");
$boardid = $_GET['boardid'];

$result = viewLbNameDescription($boardid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    echo $row['name'] . "<br>" . $row['description'] . "<br>";
}
else
{
    echo "no name or bio - ERROR BAD"; //redirect to leaderboard search page
}
?>

    <h2>Join/Leave - Submit Match (these dont do anything)</h2>

<?php

$result = viewLbMembers($boardid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Leaderboard</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['rank'] . " - " . '<a href= "user.php?userid='.$row[user_id].'">'.$row['name'].'</a>' . " - " . $row['rating_num'] . " - " . $row['rank_image'] . "<br>";
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