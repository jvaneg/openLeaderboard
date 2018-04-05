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

<!--<h2>Leaderboard Page</h2>-->
<section class="search-container">
    <div class="search-wrapper"><h2>Leaderboard Page</h2></div>
</section>


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
                <button onclick="toggleElement('submitModal')">Submit Match</button>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<!-- Submit match modal box -->
<div id="submitModal" class="modal" style="display: none">

    <!-- Modal content -->
    <div class="modal-content">
        <span onclick="toggleElement('submitModal')" class="close">&times;</span>
<!--        <h1>Submit Match</h1>-->
        <section class="modal-content-container">
            <div class="modal-content-wrapper"><h2>Submit Match</h2></div>
        </section>
        <div id="submitForm">
            <form action="/dbfiles/submitMatch.php" method="post">
                <p>Opponent</p>
                <input list="userNames" name="opponentName" placeholder="Opponent's name" required="true"><br>
                <p>Score</p>
                <input type="number" name="senderScore" placeholder="Yours" required="true" min="0" step="1">
                <input type="number" name="receiverScore" placeholder="Theirs" required="true" min="0" step="1"><br>
                <input type="hidden" name="boardID" value="<?=$boardID?>">
                <input type="submit" name="submitResultButton" value="Submit Match Result">
            </form>
        </div>
    </div>
</div>

<?php

$result = viewLbMembers($boardID);
$resultCheck = mysqli_num_rows($result);

?>

<!--<h1>Leaderboard</h1>-->

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

<datalist id="userNames">
    <?php mysqli_data_seek($result,0); ?>
    <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <option value="<?=$row['name']?>">
    <?php }?>
</datalist>

<script src="/js/utilityFunctions.js"></script>
<script>
    var modal = document.getElementById('submitModal');

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>