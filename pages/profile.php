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

<!--<h1>Profile</h1>-->
<section class="search-container">
    <div class="search-wrapper"><h2>Profile</h2></div>
</section>
<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

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
            <input type="submit" name="submitNewBio" value="Save Bio">
        </form>
    </div>

</div>


<?php
$result = viewManagedLbs($userID);
$resultCheck = mysqli_num_rows($result);
?>

<div id="managedLbs" class="leaderboard-category-container">
    <h1 class="table-heading">Managed Leaderboards</h1>
    <?php if($resultCheck > 0) { ?>
        <ul id="managedList">
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <li><a href="leaderboard.php?boardid=<?=$row['board_id']?>"><?=$row['name']?></a></li>
            <?php } ?>
        </ul>
    <?php }
    else
    {
        echo "<h2>No managed leaderboards yet!</h2>";
    }
    ?>
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

<script src="/js/utilityFunctions.js"></script>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>


