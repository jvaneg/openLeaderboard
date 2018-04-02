<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

$userid = 1; //temp
$brd_id = -1;

$result = viewManagedLbs($userid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    $row = mysqli_fetch_assoc($result);
    $brd_id = $row['board_id'];
}
?>

<section class="search-container">
    <div class="search-wrapper"><h2>Leaderboard Search </h2></div>
</section>

<div class="leaderboard-search-container">

    <form action="leaderboardSearchResults.php" method="GET">
        <input type="text" name="lbSearchTerm" placeholder="Search">
        <button type="submit" name="searchLeaderboard"> Search</button><br>
    </form>
</div>

<div class="leaderboard-category-container">
    <div name="categoryTitle">View by Category </div>

    <div class="scrollableList">

        <?php $categories = viewCategories(); ?>
        <ul onclick="addLink()" size="6" multiple="multiple" id="list">
            <?php while($row = mysqli_fetch_assoc($categories)){ ?>
                <li>
                    <a id="<?=$row['category_id']?>"> <?=$row['name']?> </a>
                </li>

            <?php }?>

<!--            <li><a href="leaderboardCategory.php">TEMP LINKS START NOW</a></li>-->
            <li><a>TEMP LINKS START NOW</a> </li>
            <li><a id="100">hello1</a></li>
            <li><a id="101">hello2</a></li>
            <li><a id="102">hello3</a></li>
            <li><a id="103">hello4</a></li>
            <li><a id="104">hello5</a></li>
            <li><a id="105">hello6</a></li>
            <li><a id="106">hello7</a></li>
            <li><a id="107">hello8</a></li>
            <li><a id="108">hello9</a></li>
            <li><a id="109">hello10</a></li>
        </ul>
    </div>



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



    <script src="/js/cateScript.js"></script>
</div>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>
