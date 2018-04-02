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
    header("Location: /pages/leaderboardSearch.php");
    exit();
}
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");
?>

<h2>Create New Leaderboard</h2>

<div id="newLbForm">
    <form action="/dbfiles/createNewLb.php" method="post">
        <input type="text" name="newLbName" placeholder="Leaderboard name"><br>
        <input list="categories" name="newLbCategory" placeholder="Leaderboard category"><br>
        <textarea name="newLbDesc" rows="7" cols="40" wrap="soft" maxlength="252" placeholder="Leaderboard description..."></textarea><br>
        <input type="submit" name="submitNewLeaderboard" value="Create Leaderboard">
    </form>
</div>

<datalist id="categories">
    <?php $categories = viewCategories(); ?>
    <?php while($row = mysqli_fetch_assoc($categories)){ ?>
        <option value="<?=$row['name']?>">
    <?php }?>
</datalist>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>