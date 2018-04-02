<?php
$headerPath = $_SERVER['DOCUMENT_ROOT'];
$headerPath .= "/header/header.php";
include_once($headerPath);
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

//$userid = -1;

//$result = viewUsersInLeaderboards();
//$resultCheck = mysqli_num_rows($result);

//if($resultCheck > 1)
//{
//    $row = mysqli_fetch_assoc($result);
//}
?>


<section class="search-container">
    <div class="search-wrapper">
        <h2>User Search</h2>
    </div>
</section>

<div class="leaderboard-search-container">
    <form action="userSearchResults.php" method="GET">
        <input type="text" name="userSearchTerm" placeholder="Search">
        <button type="submit" name="searchUsers">Search</button><br>
    </form>
</div>



<?php
$footerPath = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= "/footer/footer.php";
include_once($footerPath);
?>
