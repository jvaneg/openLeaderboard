<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>


<h1>Profile</h1>

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

$userid = 1; //temporary
$userName = "";
$userBio = "";

$result = viewUserNameBio($userid);
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
    $userName = "No name available";
    $userBio = "No bio available";
}
?>

<div id="nameBio">
    <h1><?=$userName?></h1>
    <div id="bio">
        <div><?=$userBio?></div>
        <button onclick="toggleTwoElements('bio','bioForm')">Edit Bio</button>
    </div>
    <div id="bioForm" style="display: none">
        <form action="/dbfiles/userEditBio.php" method="post">
            <textarea name="newBio" rows="7" cols="40" wrap="soft" maxlength="252"><?=$userBio?></textarea><br>
            <input type="hidden" name="user_id" value="<?=$userid?>"> <!-- TODO: This is actually super bad and should be taken from session instead -->
            <input type="submit" name="submitNewBio" value="Save Bio">
        </form>
    </div>

</div>


<?php
$result = viewManagedLbs($userid);
$resultCheck = mysqli_num_rows($result);
?>

<div id="managedLbs">
    <h1>Managed Leaderboards</h1>
    <?php if($resultCheck > 0) { ?>
        <ul>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <li><a href="leaderboard.php?boardid=<?=$row[board_id]?>"><?=$row['name']?></a></li>
            <?php } ?>
        </ul>
    <?php }
    else
    {
        echo "No Managed Leaderboards";
    }
    ?>
</div>

<?php

$result = viewMemberLbs($userid);
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

<script src="/js/utilityFunctions.js"></script>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>


