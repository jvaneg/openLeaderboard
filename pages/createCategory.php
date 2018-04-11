<?php
/**
 * Created by PhpStorm.
 * User: kiera
 * Date: 4/5/2018
 * Time: 2:16 PM
 */
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_SESSION['user_id']) && isSiteAdmin($_SESSION['user_id']))
{
    $userID = $_SESSION['user_id'];
}
else
{
    header("Location: /pages/leaderboardSearch.php");
    exit();
}
?>

<!--<h2>Create New Category</h2>-->
<section class="search-container">
    <div class="search-wrapper"><h2>Create New Category</h2></div>
</section>

<div id="newCategoryForm">
    <form action="/dbfiles/createNewCategory.php" method="post">
        <input type="text" name="newCategoryName" placeholder="Category name" required="true"><br>
        <textarea name="newCategoryDesc" rows="7" cols="40" wrap="soft" maxlength="252" placeholder="Category description..."></textarea><br>
        <input type="submit" name="submitNewCategory" value="Create Category">
    </form>
</div>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>