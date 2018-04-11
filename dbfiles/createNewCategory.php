<?php
/**
 * Created by PhpStorm.
 * User: kieran
 * Date: 4/5/2018
 * Time: 1:32 PM
 */

session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

if(isset($_POST['submitNewCategory']) && isset($_SESSION['user_id']) && isSiteAdmin($_SESSION['user_id']))
{
    $categoryName = mb_strimwidth($_POST['newCategoryName'],0,252);
    $categoryDescription = mb_strimwidth($_POST['newCategoryDesc'],0,252);
    $userID = $_SESSION['user_id'];
    $categoryID = -1;

    if(!categoryNameTaken($categoryName))
    {
        //TODO prevent sql injection stuff here
        $categoryID = addCategory($userID, $categoryName, $categoryDescription);
    }
    else
    {
        $categoryID = getCategoryIDByName($categoryName);
        header("Location: /pages/category.php?categoryid=$categoryID");
        exit();
    }

    if($categoryID != -1)
    {
        header("Location: /pages/category.php?categoryid=$categoryID");
        exit();
    }
    else
    {
        header("Location: /pages/createCategory.php&success=false");
        exit();
    }
}
else
{
    header("Location: /pages/createCategory.php&success=false");
    exit();
}
?>