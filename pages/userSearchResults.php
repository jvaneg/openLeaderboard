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

        header("Location: userSearch.php?search=empty");
        mysqli_close($connection);
        exit();
    }
    if(isset($_POST['searchUsers'])) //if(isset($_POST['userSearch']))
    {
        $search = mysqli_real_escape_string($connection, $_POST['userSearch']);
        $result = viewUsersInLeaderboards($search);
        mysqli_close($connection);
        echo "<table border='1'>";
        echo "<col width='200'>";
        echo "<col width='200'>";
        echo "<tr><td>Name</td><td>Number Of Leaderboards</td></tr>";

        while($row = mysqli_fetch_assoc($result))
        {
//            echo "<tr><td>{$row['name']}</td><td>{$row['numLBs']}</td></tr>";
            echo "
            <tr>
                <td>
                
                    <a href=\"user.php\">
                        <div style=\"height:100%;width:100%\">
                            {$row['name']}
                        </div>
                    </a>
                </td>
                <td>
                    <a href=\"user.php\">
                        <div style=\"height:100%;width:100%\">
                            {$row['numLBs']}
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

