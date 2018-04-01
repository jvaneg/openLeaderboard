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
$connection = connectToDB();

$userid = 1;
?>


<div class="leaderboard-search-result">
    <h1>Result for <?php echo $_POST['userSearch']; ?></h1>

    <?php

    if(empty($_POST['userSearch']))
    {
        mysqli_close($connection);
        header("Location: leaderboardSearch.php?search=empty");
        exit();
    }
    if(isset($_POST['userSearch']))
    {
        $search = mysqli_real_escape_string($connection, $_POST['userSearch']);
        $result = viewLbName($userid, $search);
        mysqli_close($connection);

        echo "<table border='1'>";
        echo "<col width='200'>";
        echo "<col width='200'>";
        echo "<tr><td>Name</td><td>Number Of Users</td></tr>";

        while($row = mysqli_fetch_assoc($result))
        {
//            echo "<tr><td>{$row['name']}</td><td>{$row['numUsers']}</td></tr>";
            echo "
            <tr>
                <td>
                   <a href=\"leaderboard.php\">
                        <div style=\"height:100%;width:100%\">
                            {$row['name']}
                        </div>
                    </a>
                </td>
                <td>
                    <a href=\"leaderboard.php\">
                        <div style=\"height:100%;width:100%\">
                            {$row['numUsers']}
                        </div>
                    </a>
                </td>
            </tr>";
        }

        echo "</table>";
    }
    ?>



</div>

<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>

