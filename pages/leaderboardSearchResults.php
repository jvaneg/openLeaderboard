<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>


<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

?>

<section class="search-container">
    <div class="search-wrapper"><h2>Results for <?php echo $_GET['lbSearchTerm']; ?></h2></div>
</section>

<div class="leaderboard-search-result">


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
                    <th>Name</th>
                    <th>Number of Users</th>
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