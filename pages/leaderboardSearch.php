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
    <?php } ?>
</div>

<div class="leaderboard-category-container"> <!--class="leaderboard-category-container" -->
    <div name="categoryTitle">
        <h1>View by Category</h1>
        <?php if($loggedIn && isSiteAdmin($userID)) { ?>
            <form action="/pages/categoryAdmin.php" method="POST">
                <button type="submit" name="manageCategories">Manage Categories</button>
            </form>
        <?php } ?>
    </div>

    <div>
        <?php $categories = viewCategories(); ?>

        <!--        TODO maybe change this to a table (so we can have the same table layout as the rest of the tables)? you should still have the same functionalities  -->
        <ul id="list">
            <?php while($row = mysqli_fetch_assoc($categories)){ ?>
                <li>
                    <a href="category.php?categoryid=<?=$row['category_id']?>"><?=$row['name']?></a>
                </li>

            <?php }?>
        </ul>
    </div>
</div>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>
