<?php
/**
 * User: arsh
 * Date: 2018-03-30
 * Time: 6:51 PM
 */
?>

<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

?>

<div class="leaderboard-search-result">
    <h1>Result for <?php echo $_GET['userSearchTerm']; ?></h1>

    <?php

    if(empty($_GET['userSearchTerm']))
    {

        header("Location: userSearch.php?search=empty");
        exit();
    }
    if(isset($_GET['userSearchTerm']))
    {
        $search = $_GET['userSearchTerm'];
        $result = searchUsersByName($search);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0) { ?>

        <table border='1'>
            <tr>
                <td>Name</td>
                <td>Number of Boards</td>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><a href="user.php?userid=<?=$row['user_id']?>"><?=$row['name']?></a></td>
                    <td><?=$row['numLBs']?></td>
                </tr>
            <?php } ?>
        </table>

        <?php } ?>
    <?php } ?>

</div>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>

