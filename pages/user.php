<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

<h2>user page</h2>

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

$userid = $_GET['userid'];


$result = viewUserNameBio($userid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    echo $row['name'] . "<br>" . $row['bio'] . "<br>";
}
else
{
    echo "bad bad bad"; //redirect to user search page
}
?>

<?php

$result = viewMemberLbs($userid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Leaderboards</h1>";

    echo "<table border='1'>
          <tr>
          <th>Board</th>
          <th>Rating</th>
          <th>Rank</th>
          <th>Division</th>
          </tr>";
    while($row = mysqli_fetch_assoc($result))
    {
        //echo '<a href= "leaderboard.php?boardid='.$row[board_id].'">'.$row['l_name'].'</a>' . " - " . $row['rating_num'] . " - " . $row['rank'] . " - " . $row['rank_image'] . "<br>";
        echo "<tr>";
        echo "<td>" . '<a href= "leaderboard.php?boardid='.$row[board_id].'">'.$row['l_name'].'</a>' . "</td>";
        echo "<td>" . $row['rating_num'] . "</td>";
        echo "<td>" . $row['rank'] . "</td>";
        echo "<td>" . '<img src="'.$row['rank_image'].'">' . "</td>";
        echo "</tr>";
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