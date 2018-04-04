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

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

$categoryID = $_GET['categoryid'];
$categoryName = "";
$categoryDescription = "";

$result = viewCatNameDescription($categoryID);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    $categoryName = $row['name'];
    $categoryDescription = $row['description'];
}
else
{
    header("Location: /pages/leaderboardSearch.php");
    $categoryName = "No board name available";
    $categoryDescription = "No description available";
    exit();
}
?>

<div id="nameDescription">
    <h1><?=$categoryName?></h1>
    <div id="description">
        <div><?=$categoryDescription?></div>
        <?php if($loggedIn && isSiteAdmin($userID)) { ?>
            <button onclick="toggleTwoElements('description','descForm')">Edit Description</button>
        <?php } ?>
    </div>
    <?php if($loggedIn && isSiteAdmin($userID)) { ?>
        <div id="descForm" style="display: none">
            <form action="/dbfiles/catEditDescription.php" method="post">
                <textarea name="newDesc" rows="7" cols="40" wrap="soft" maxlength="252"><?=$categoryDescription?></textarea><br>
                <input type="hidden" name="category_id" value="<?=$categoryID?>">
                <input type="submit" name="submitNewDesc" value="Save Description">
            </form>
        </div>
    <?php } ?>
</div>

<div class="leaderboard-search-result">
    <?php
    $result = viewLBByCategory($categoryID);
    $resultCheck = mysqli_num_rows($result);
    ?>

    <?php if($resultCheck > 0) { ?>

        <table border='1'>
            <tr>
                <th>Name</th>
                <th>Number of Users</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><a href="leaderboard.php?boardid=<?=$row['board_id']?>"><?=$row['name']?></a></td>
                    <td><?=$row['numUsers']?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</div>

<script src="/js/utilityFunctions.js"></script>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>