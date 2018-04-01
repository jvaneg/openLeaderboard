<?php
/**
 *
 * User: joel
 * Date: 27/03/18
 * Time: 12:46 AM
 */

function connectToDB()
{
    // setting up vars for db
    $dbServername = "localhost";
    $dbUsername = "root";

    $dbPassword = "joelisgreat";
    $dbName = "openLeaderboard";

    // connecting to db
    $connection = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

    if ($connection->connect_error) {
        die("Connection failed [check db.inc.php?]: " . $connection->connect_error);
    }

    return $connection;
}

function viewUserNameBio($userid)
{
    $connection = connectToDB();

    $sql = "SELECT `name`, `bio` 
            FROM `User` 
            WHERE `user_id` = $userid";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewUsersInLeaderboards($userSearch)
{
    $connection = connectToDB();

    $sql = "SELECT U.name, Count(U.user_id) AS numLBs 
            FROM User AS U, Competes_in AS C 
            WHERE U.user_id = C.user_id AND U.name Like '%$userSearch%'
            GROUP BY U.name 
            ORDER BY COUNT(C.board_id) DESC";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewCategories()
{
    $connection = connectToDB();

    $sql = "SELECT C.category_id, C.name, COUNT(L.board_id)
            FROM Category AS C, Leaderboard AS L
            WHERE C.category_id = L.category_id
            GROUP BY C.category_id
            ORDER BY COUNT(L.board_id) DESC";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewManagedLbs($userid)
{
    $connection = connectToDB();

    $sql = "SELECT L.name, L.board_id 
            FROM Board_Admin AS B, Leaderboard AS L 
            WHERE B.user_id = $userid AND B.user_id = L.owner_id";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewMemberLbs($userid)
{
    $connection = connectToDB();

    $sql = "SELECT UB3.l_name, UB3.board_id, UB3.rating_num, UB3.rank, UB3.rank_image
            FROM
            (SELECT UB2.l_name, UB2.board_id, UB2.user_id, UB2.name, UB2.rating_num, UB2.rank_image,
              @curRank := CASE WHEN @boardID <> UB2.board_id THEN 1 ELSE IF(@prevRank = UB2.rating_num, @curRank, @incRank) END AS rank,
              @incRank := IF(@boardID <> UB2.board_id, 2, @incRank + 1),
              @prevRank := UB2.rating_num,
              @boardID := UB2.board_id AS board_set
            FROM
            (SELECT @curRank := 0, @prevRank := NULL, @incRank := 1, @boardID := 0) AS vars,
            (SELECT * 
            FROM
            (SELECT L.name AS l_name, L.board_id, U.user_id, U.name, R.rating_num, SD.rank_image
            FROM `User` AS U, Rating AS R, Competes_in AS C, Leaderboard AS L, Skill_Division AS SD
            WHERE U.user_id = C.user_id AND C.board_id = L.board_id AND
            R.board_id = L.board_id AND R.division_id = SD.division_id AND
            R.user_id = U.user_id AND 
            L.board_id IN 
            (SELECT DISTINCT C2.board_id
            FROM Competes_in AS C2
            WHERE C2.user_id = $userid)) AS UB
            ORDER BY UB.board_id, UB.rating_num DESC)AS UB2) AS UB3
            WHERE user_id = $userid";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewLbNameDescription($boardid)
{
    $connection = connectToDB();

    $sql = "SELECT `name`, `description` 
            FROM `Leaderboard` 
            WHERE `board_id` = $boardid";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewLbName($userid, $userSearch)
{
    $connection = connectToDB();

    $sql =  "SELECT L.name, COUNT(U.user_id) AS numUsers 
            FROM User AS U, Competes_In AS C, Board_Admin AS B, Leaderboard AS L 
            WHERE U.user_id = $userid AND (U.user_id = C.user_id OR U.user_id = B.user_id) AND L.name Like '%$userSearch%'
            GROUP BY L.name";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewLbMembers($boardid)
{
    $connection = connectToDB();

    $sql = "SELECT UB3.name, UB3.user_id, UB3.rating_num, UB3.rank, UB3.rank_image
            FROM
            (SELECT UB2.user_id, UB2.name, UB2.rating_num, UB2.rank_image,
              @curRank := IF(@prevRank = UB2.rating_num, @curRank, @incRank) AS rank,
              @incRank := @incRank + 1,
              @prevRank := UB2.rating_num
            FROM
            (SELECT @curRank := 0, @prevRank := NULL, @incRank := 1) AS vars,
            (SELECT * 
            FROM
            (SELECT U.user_id, U.name, R.rating_num, SD.rank_image
            FROM `User` AS U, Rating AS R, Competes_in AS C, Leaderboard AS L, Skill_Division AS SD
            WHERE U.user_id = C.user_id AND C.board_id = L.board_id AND
            R.board_id = L.board_id AND R.division_id = SD.division_id AND
            R.user_id = U.user_id AND L.board_id = $boardid) AS UB
            ORDER BY UB.rating_num DESC)AS UB2) AS UB3";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewPendingVerifications($userid)
{
    $connection = connectToDB();

    $sql = "SELECT RS.submission_id, L.name AS l_name, RS.board_id, RS.sender_score, RS.receiver_score, U.name, RS.sender_id, RS.rcvr_rat_change
            FROM Result_Submission AS RS, User AS U, Leaderboard AS L
            WHERE RS.receiver_id = $userid AND RS.sender_id = U.user_id AND
            RS.board_id = L.board_id";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewSubmittedResults($userid)
{
    $connection = connectToDB();

    $sql = "SELECT RS.submission_id, L.name AS l_name, RS.board_id, RS.sender_score, RS.receiver_score, U.name, RS.receiver_id, RS.sndr_rat_change
            FROM Result_Submission AS RS, User AS U, Leaderboard AS L
            WHERE RS.sender_id = $userid AND RS.receiver_id = U.user_id AND
            RS.board_id = L.board_id";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function editUserBio($userid, $userBio)
{
    $connection = connectToDB();

    $sql = "UPDATE User AS U
            SET U.bio = '$userBio'
            WHERE U.user_id = $userid";

    if (mysqli_query($connection, $sql))
    {
        echo "Record updated successfully";
    }
    else
    {
        echo "Error updating record: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}

/*
 * Note: receiverID included as a measure to prevent someone from removing matches they shouldn't be able to
 */
function rejectResult($submissionID, $receiverID)
{
    $connection = connectToDB();

    $sql = "DELETE FROM Result_Submission
 	        WHERE submission_id = $submissionID AND receiver_id = $receiverID";

    if (mysqli_query($connection, $sql))
    {
        echo "Record updated successfully";
    }
    else
    {
        echo "Error updating record: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}


/*
 * Note: senderID included as a measure to prevent someone from removing matches they shouldn't be able to
 */
function cancelResult($submissionID, $senderID)
{
    $connection = connectToDB();

    $sql = "DELETE FROM Result_Submission
 	        WHERE submission_id = $submissionID AND sender_id = $senderID";

    if (mysqli_query($connection, $sql))
    {
        echo "Record updated successfully";
    }
    else
    {
        echo "Error updating record: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}



?>


