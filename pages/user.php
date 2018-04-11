<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>


<!--<section class="search-container">-->
<!--    <div class="search-wrapper"><h2>User</h2></div>-->
<!--</section>-->

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

$userID = $_GET['userid'];
$userName = "";
$userBio = "";

$result = viewUserNameBio($userID);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    $userName = $row['name'];
    $userBio = $row['bio'];
}
else
{
    //redirect to user search page
    header("Location: /pages/userSearch.php");
    $userName = "No name available";
    $userBio = "No bio available";
    exit();
}
?>

<div id="nameBio">

    <h1><?=$userName?></h1>
    <div id="bio">
        <?=$userBio?>
    </div>
</div>

<?php
$result = viewMemberLbs($userID);
$resultCheck = mysqli_num_rows($result);
?>

<h1 class="table-heading">Leaderboards</h1>

<div id="memberLBs">
<?php if($resultCheck > 0) { ?>

    <table border='1'>
        <tr>
            <th>Board</th>
            <th>Rank</th>
            <th>Rating</th>
            <th>Division</th>
            <th>Wins</th>
            <th>Losses</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><a href="leaderboard.php?boardid=<?=$row['board_id']?>"><?=$row['l_name']?></a></td>
                <td><?=$row['rank']?></td>
                <td><?=$row['rating_num']?></td>
                <td><img src="<?='/images/'.$row['rank_image']?>"></td>
                <td><?=$row['wins']?></td>
                <td><?=$row['losses']?></td>
            </tr>
        <?php } ?>
    </table>

<?php }
else
{
    echo "<h2>No leaderboards yet!</h2>";
}
?>
</div>

<?php

$matchResults = findMatchesByUser($userID);
$matchResultCheck = mysqli_num_rows($matchResults);

?>

<h1 class="table-heading">Recent Matches</h1>
<!--Div id is same as above table so we don't need to copy CSS and im lazy-->
<div id="memberLBs">
    <?php if($matchResultCheck > 0)
    {
        $count = 0;
        ?>

        <table border='1'>
            <tr>
                <th>Date</th>
                <th>Board</th>
                <th>Opponent</th>
                <th>Score</th>
            </tr>
            <?php
            while($row = mysqli_fetch_assoc($matchResults)) {
                $boardName = mysqli_fetch_assoc(getLeaderboardNameById($row['board_id']));
                if($row['sender_id'] == $userID)
                {
                    $opponentID = $row['receiver_id'];
                    $score = $row['sender_score'] . "-" . $row['receiver_score'];
                }
                else
                {
                    $opponentID = $row['sender_id'];
                    $score = $row['receiver_score'] . "-" . $row['sender_score'];
                }
                $opponentName = mysqli_fetch_assoc(getUsernameByID($opponentID));
                ?>
                <tr>
                    <td><?=$row['date']?></td>
                    <td><a href="leaderboard.php?boardid=<?=$row['board_id']?>"><?=$boardName['name']?></a></td>
                    <td><a href="user.php?userid=<?=$opponentID?>"><?=$opponentName['name']?></a></td>
                    <td><?=$score?></td>
                </tr>
                <?php
                $count++;
                if($count > 9)
                    break;
            } ?>
        </table>
    <?php }
    else
    {
        echo "<h2>No matches yet!</h2>";
    }
    ?>
</div>


<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>