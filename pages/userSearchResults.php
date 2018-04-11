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

<!--<div class="result-title"> </div>-->

<section class="search-container">
    <div class="search-wrapper"><h2>Result for <?php echo $_GET['userSearchTerm']; ?></h2></div>
</section>

<div class="leaderboard-search-result">

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
                    <th>Name</th>
                    <th>Number of Boards</th>
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