<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>

<h1>Profile</h1>

<?php
    $userid = 1; //placeholder for session stuff

    include($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/db.inc.php");

    $sql = "SELECT `name`, `bio` FROM `User` WHERE `user_id` = $userid";
    $result = mysqli_query($connection,$sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
    {
        $row = mysqli_fetch_assoc($result);
        echo $row['name'] . "<br>" . $row['bio'] . "<br>";
    }
    else
    {
        echo "bad bad bad";
    }
?>

<h1>Managed Leaderboards</h1>

<h1>Leaderboards</h1>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>


