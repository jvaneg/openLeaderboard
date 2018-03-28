<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

<h2>Leaderboard Page</h2>

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

$boardid = $_GET['boardid'];
$boardName = "";
$boardDescription = "";

$result = viewLbNameDescription($boardid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    $boardName = $row['name'];
    $boardDescription = $row['description'];
}
else
{
    //redirect to leaderboard search page
    $boardName = "No board name available";
    $boardDescription = "No description available";
}
?>

<div id="nameDescription">
    <h1><?=$boardName?></h1>
    <div id="description">
        <?=$boardDescription?>
    </div>
</div>

<h2>Join/Leave - Submit Match (these dont do anything)</h2>

<?php

$result = viewLbMembers($boardid);
$resultCheck = mysqli_num_rows($result);

?>

<h1>Leaderboard</h1>
<div id="lbMembers">
    <?php if($resultCheck > 0) { ?>

        <table border='1'>
            <tr>
                <th>Rank</th>
                <th>User</th>
                <th>Rating</th>
                <th>Division</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?=$row['rank']?></td>
                    <td><a href="user.php?userid=<?=$row[user_id]?>"><?=$row['name']?></a></td>
                    <td><?=$row['rating_num']?></td>
                    <td><img src="<?='/images/'.$row['rank_image']?>"></td>
                </tr>
            <?php } ?>
        </table>

    <?php }
    else
    {
        echo "No members yet!";
    }
    ?>
</div>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>