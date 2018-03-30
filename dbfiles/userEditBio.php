<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 27/03/18
 * Time: 11:21 PM
 */

if(isset($_POST['submitNewBio'])) //if($_SERVER['submit'] == "POST")
{
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

    $newBio = mb_strimwidth($_POST['newBio'],0,252);
    $userid = $_POST['user_id'];

    //TODO prevent sql injection stuff here
    editUserBio($userid, $newBio);

    header("Location: /pages/profile.php");

}
else
{
    header("Location: /pages/profile.php");
    exit();
}
?>