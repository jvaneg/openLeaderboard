<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

<h1>User Page</h1>

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
    header("Location: ../userSearch.php");
    $userName = "No name available";
    $userBio = "No bio available";
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

<h1>Member Leaderboards</h1>
<div id="memberLBs">
<?php if($resultCheck > 0) { ?>

    <table border='1'>
        <tr>
            <th>Board</th>
            <th>Rank</th>
            <th>Rating</th>
            <th>Division</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><a href="leaderboard.php?boardid=<?=$row[board_id]?>"><?=$row['l_name']?></a></td>
                <td><?=$row['rank']?></td>
                <td><?=$row['rating_num']?></td>
                <td><img src="<?='/images/'.$row['rank_image']?>"></td>
            </tr>
        <?php } ?>
    </table>

<?php }
else
{
    echo "No Leaderboards";
}
?>
</div>


<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>