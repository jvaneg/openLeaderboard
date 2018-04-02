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
        <form action="/pages/createLeaderboard.php">
            <button type="submit" name="createLeaderboard">Create New Leaderboard</button>
        </form>
    <?php } ?>
</div>

<div> <!--class="leaderboard-category-container" -->
    <div name="categoryTitle">
        <h1>View by Category</h1>
        <?php if($loggedIn && isSiteAdmin($userID)) { ?>
            <form action="/pages/categoryAdmin.php">
                <button type="submit" name="manageCategories">Manage Categories</button>
            </form>
        <?php } ?>
    </div>

    <div> <!--class="scrollableList"-->

        <?php $categories = viewCategories(); ?>
        <ul id="list"><!--onclick="addLink()" size="6" multiple="multiple"-->
            <?php while($row = mysqli_fetch_assoc($categories)){ ?>
                <li>
                    <a href="category.php?categoryid=<?=$row['category_id']?>"><?=$row['name']?></a>
                </li>

            <?php }?>
        </ul>
    </div>


<!-- TODO probably just remove all this
    <input type="text" id="txt"<?php if($resultCheck <= 0) {?>
        style = "display: none;"<?php
    }?>>

    <button onclick="addListItem()" type="submit" name="addCat"
        <?php if($resultCheck <= 0) {?>
            style = "display: none;"<?php
        }?>> Add </button>


    <button type="submit" name="editCat"
        <?php if($resultCheck <= 0) {?>
            style = "display: none;"<?php
        }
        ?>> Edit </button>

    <button onclick="deleteListItem()" type="submit" name="removeCat"
        <?php if($resultCheck <= 0) {?>
            style = "display: none;"<?php
        }
        ?>> Remove</button>

//-->


    <script src="/js/cateScript.js"></script>
</div>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>
