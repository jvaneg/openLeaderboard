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
    <h1>Results for <?php echo $_GET['lbSearchTerm']; ?></h1>

    <?php

    if(empty($_GET['lbSearchTerm']))
    {

        header("Location: leaderboardSearch.php?search=empty");
        exit();
    }
    if(isset($_GET['lbSearchTerm']))
    {
        $search = $_GET['lbSearchTerm'];
        $result = searchLbsByName($search);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0) { ?>

            <table border='1'>
                <tr>
                    <td>Name</td>
                    <td>Number of Users</td>
                </tr>

                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><a href="leaderboard.php?boardid=<?=$row['board_id']?>"><?=$row['name']?></a></td>
                        <td><?=$row['numUsers']?></td>
                    </tr>
                <?php } ?>
            </table>

        <?php } else {
            echo "No results found!";
        } ?>
    <?php } ?>

</div>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>

