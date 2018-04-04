<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

<?php
if(isset($_SESSION['user_id']))
{
    $userID = $_SESSION['user_id'];
    $loggedIn = true;
}
else
{
    $loggedIn = false;
}
?>

<h2>Leaderboard Page</h2>

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

$boardID = $_GET['boardid'];
$boardName = "";
$boardDescription = "";

$result = viewLbNameDescription($boardID);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    $boardName = $row['name'];
    $boardDescription = $row['description'];
}
else
{
    header("Location: /pages/leaderboardSearch.php");
    $boardName = "No board name available";
    $boardDescription = "No description available";
    exit();
}
?>

<div id="nameDescription">
    <h1><?=$boardName?></h1>
    <div id="description">
        <div><?=$boardDescription?></div>
        <?php if($loggedIn && isLbAdmin($userID, $boardID)) { ?>
            <button onclick="toggleTwoElements('description','descForm')">Edit Description</button>
        <?php } ?>
    </div>
    <?php if($loggedIn && isLbAdmin($userID, $boardID)) { ?>
        <div id="descForm" style="display: none">
            <form action="/dbfiles/lbEditDescription.php" method="post">
                <textarea name="newDesc" rows="7" cols="40" wrap="soft" maxlength="252"><?=$boardDescription?></textarea><br>
                <input type="hidden" name="board_id" value="<?=$boardID?>">
                <input type="submit" name="submitNewDesc" value="Save Description">
            </form>
        </div>
    <?php } ?>
</div>

<?php if($loggedIn) { ?>
    <div id="joinLeave">
        <?php if(!isLbMember($userID, $boardID)) { ?>
            <div id="joinForm">
                <form action="/dbfiles/joinLeaderboard.php" method="post">
                    <input type="hidden" name="board_id" value="<?=$boardID?>">
                    <input type="submit" name="joinLb" value="Join Board">
                </form>
            </div>
        <?php } else { ?>
            <div id="leaveForm">
                <form action="/dbfiles/leaveLeaderboard.php" method="post">
                    <input type="hidden" name="board_id" value="<?=$boardID?>">
                    <input type="submit" name="leaveLb" value="Leave Board">
                </form>
            </div>
            <div id="submitMatchForm">
                <form action="/pages/submitMatch.php" method="post">
                    <input type="hidden" name="board_id" value="<?=$boardID?>">
                    <input type="submit" name="submitMatch" value="Submit Match">
                </form>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<?php

$result = viewLbMembers($boardID);
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
                <th>Wins</th>
                <th>Losses</th>
                <?php if($loggedIn && isLbAdmin($userID, $boardID)) { ?>
                    <th>Remove</th>
                <?php } ?>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?=$row['rank']?></td>
                    <td><a href="user.php?userid=<?=$row['user_id']?>"><?=$row['name']?></a></td>
                    <td><?=$row['rating_num']?></td>
                    <td><img src="<?='/images/'.$row['rank_image']?>"></td>
                    <td><?=$row['wins']?></td>
                    <td><?=$row['losses']?></td>
                    <?php if($loggedIn && isLbAdmin($userID, $boardID)) { ?>
                        <td>
                            <div id="removeForm">
                                <form action="/dbfiles/removeUserFromLb.php" method="post">
                                    <input type="hidden" name="user_id" value="<?=$row['user_id']?>">
                                    <input type="hidden" name="board_id" value="<?=$boardID?>">
                                    <input type="submit" name="removeUser" value="Remove">
                                </form>
                            </div>
                        </td>
                    <?php } ?>
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

<script src="/js/utilityFunctions.js"></script>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>