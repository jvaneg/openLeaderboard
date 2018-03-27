<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>

<h1>Profile</h1>

<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

    $userid = 1; //placeholder for session stuff

    $result = viewUserNameBio($userid);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
    {
        $row = mysqli_fetch_assoc($result);
        echo $row['name'] . "<br>" . $row['bio'] . "<br>";
    }
    else
    {
        echo "no name or bio - ERROR BAD";
    }
?>



<?php
$userid = 1; //placeholder for session stuff

$result = viewManagedLbs($userid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Managed Leaderboards</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['name'] . " - " . $row['board_id'] . "<br>";
    }
}
else
{
    echo "no managed leaderboards";
}
?>

<?php
$userid = 1; //placeholder for session stuff

$result = viewMemberLbs($userid);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    echo "<h1>Leaderboards</h1>";
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['l_name'] . " - " . $row['rating_num'] . " - " . $row['rank'] . " - " . $row['rank_image'] . "<br>";
    }
}
else
{
    echo "no leaderboards";
}
?>


<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>


