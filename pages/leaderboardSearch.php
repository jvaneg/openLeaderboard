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
?>

<section class="search-container">
    <div class="search-wrapper"><h2>Leaderboards</h2></div>
</section>

<div class="leaderboard-search-container">

    <form action="/pages/leaderboardSearchResults.php" method="GET">
        <input type="text" name="lbSearchTerm" placeholder="Search">
        <button type="submit" name="searchLeaderboard"> Search</button><br>
    </form>
</div>

<div>
    <?php if($loggedIn) { ?>
        <form action="/pages/createLeaderboard.php" method="POST">
            <button type="submit" name="createLeaderboard">Create New Leaderboard</button>
        </form>
        <?php if(isSiteAdmin($userID)) { ?>
            <form action="/pages/createCategory.php" method="POST">
                <button type="submit" name="createCategory">Create New Category</button>
            </form>
        <?php } ?>
    <?php } ?>
</div>


<?php

$categories = viewCategories();

?>

<div id="leaderboardCategories">
    <?php if(mysqli_num_rows($categories) > 0) { ?>
</div>

    <table border='1'>
        <tr>
            <th>Category</th>
            <?php if(isSiteAdmin($userID)) { ?>
                <th>Options</th>
            <?php } ?>
        </tr>
        <?php while($row = mysqli_fetch_assoc($categories)) { ?>
            <tr>
                <td><a href="category.php?categoryid=<?=$row['category_id']?>"><?=$row['name']?></a></td>
                <?php if(isSiteAdmin($userID)) { ?>
                    <td>
<!--                        TODO add CSS for the remove button-->
                        <div id="removeForm">
                            <form action="/dbfiles/removeCategoryFromDb.php" method="POST">
                                <input type="hidden" name="category_id" value="<?=$row['category_id']?>">
                                <input type="hidden" name="user_id" value="<?=$userID?>">
                                <input type="submit" name="removeCategory" value="Remove">
                            </form>
                        </div>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
<?php } ?>


<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>