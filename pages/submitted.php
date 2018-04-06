<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>

<?php
if(isset($_SESSION['user_id']))
{
    $userID = $_SESSION['user_id'];
}
else
{
    header("Location: /index.php");
    exit();
}
?>

<!--<h1>Submitted Matches</h1>-->
<section class="search-container">
    <div class="search-wrapper"><h2>Submitted Matches</h2></div>
</section>


<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

$result = viewPendingVerifications($userID);
$resultCheck = mysqli_num_rows($result);
?>

<h1>Awaiting Verification</h1>
<div id="pendingVers">
    <?php if($resultCheck > 0) { ?>

        <table border='1'>
            <tr>
                <th>Submission id</th>
                <th>Board</th>
                <th>Opponent</th>
                <th>Score</th>
                <th>Rating Change</th>
                <th>Verify</th>
                <th>Reject</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?=$row['submission_id']?></td>
                    <td><a href="leaderboard.php?boardid=<?=$row['board_id']?>"><?=$row['l_name']?></a></td>
                    <td><a href="user.php?userid=<?=$row['sender_id']?>"><?=$row['name']?></a></td>
                    <td><?=$row['receiver_score']?> : <?=$row['sender_score']?></td>
                    <td><?=$row['rcvr_rat_change']?></td>
                    <td>
                        <div id="verifyForm">
                            <form action="/dbfiles/verifyResult.php" method="post">
                                <input type="hidden" name="submission_id" value="<?=$row['submission_id']?>">
                                <input type="submit" name="verifySubmission" value="Verify">
                            </form>
                        </div>
                    </td>
                    <td>
                        <div id="rejectForm">
                            <form action="/dbfiles/rejectResult.php" method="post">
                                <input type="hidden" name="submission_id" value="<?=$row['submission_id']?>">
                                <input type="submit" name="rejectSubmission" value="Reject">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>

    <?php }
    else
    {
        echo "No submissions awaiting verification!";
    }
    ?>
</div>


<?php
$result = viewSubmittedResults($userID);
$resultCheck = mysqli_num_rows($result);
?>

<h1>Submitted Results</h1>
<div id="pendingVers">
    <?php if($resultCheck > 0) { ?>

        <table border='1'>
            <tr>
                <th>Submission id</th>
                <th>Board</th>
                <th>Opponent</th>
                <th>Score</th>
                <th>Rating Change</th>
                <th>Cancel</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?=$row['submission_id']?></td>
                    <td><a href="leaderboard.php?boardid=<?=$row['board_id']?>"><?=$row['l_name']?></a></td>
                    <td><a href="user.php?userid=<?=$row['receiver_id']?>"><?=$row['name']?></a></td>
                    <td><?=$row['sender_score']?> : <?=$row['receiver_score']?></td>
                    <td><?=$row['sndr_rat_change']?></td>
                    <td>
                        <div id="cancelForm">
                            <form action="/dbfiles/cancelResult.php" method="post">
                                <input type="hidden" name="submission_id" value="<?=$row['submission_id']?>">
                                <input type="submit" name="cancelSubmission" value="Cancel">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>

    <?php }
    else
    {
        echo "No results submitted!";
    }
    ?>
</div>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>
