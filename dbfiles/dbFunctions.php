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

function viewUserNameBio($userID)
{
    $connection = connectToDB();

    $sql = "SELECT `name`, `bio` 
            FROM `User` 
            WHERE `user_id` = $userID";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewManagedLbs($userID)
{
    $connection = connectToDB();

    $sql = "SELECT L.name, L.board_id 
            FROM Board_Admin AS B, Leaderboard AS L 
            WHERE B.user_id = $userID AND B.user_id = L.owner_id";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewMemberLbs($userID)
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
            WHERE C2.user_id = $userID)) AS UB
            ORDER BY UB.board_id, UB.rating_num DESC)AS UB2) AS UB3
            WHERE user_id = $userID";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewLbNameDescription($boardID)
{
    $connection = connectToDB();

    $sql = "SELECT `name`, `description` 
            FROM `Leaderboard` 
            WHERE `board_id` = $boardID";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewLbMembers($boardID)
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
            R.user_id = U.user_id AND L.board_id = $boardID) AS UB
            ORDER BY UB.rating_num DESC)AS UB2) AS UB3";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewPendingVerifications($userID)
{
    $connection = connectToDB();

    $sql = "SELECT RS.submission_id, L.name AS l_name, RS.board_id, RS.sender_score, RS.receiver_score, U.name, RS.sender_id, RS.rcvr_rat_change
            FROM Result_Submission AS RS, User AS U, Leaderboard AS L
            WHERE RS.receiver_id = $userID AND RS.sender_id = U.user_id AND
            RS.board_id = L.board_id";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function viewSubmittedResults($userID)
{
    $connection = connectToDB();

    $sql = "SELECT RS.submission_id, L.name AS l_name, RS.board_id, RS.sender_score, RS.receiver_score, U.name, RS.receiver_id, RS.sndr_rat_change
            FROM Result_Submission AS RS, User AS U, Leaderboard AS L
            WHERE RS.sender_id = $userID AND RS.receiver_id = U.user_id AND
            RS.board_id = L.board_id";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function editUserBio($userID, $userBio)
{
    $connection = connectToDB();

    $sql = "UPDATE User AS U
            SET U.bio = '$userBio'
            WHERE U.user_id = $userID";

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

//TODO remember to cast the stuff being used as numbers to ints
function verifyResult($submissionID, $senderID, $receiverID, $boardID, $senderScore, $receiverScore, $sndrRatChange, $rcvrRatChange)
{
    $connection = connectToDB();


    //get sender rating
    $sql = "SELECT R.rating_num
            FROM Rating AS R
            WHERE R.user_id = $senderID AND R.board_id = $boardID";

    $senderRatResult = mysqli_fetch_assoc(mysqli_query($connection,$sql));
    $newSenderRating = intval($senderRatResult['rating_num']) + $sndrRatChange;


    //get receiver rating
    $sql = "SELECT R.rating_num
            FROM Rating AS R
            WHERE R.user_id = $receiverID AND R.board_id = $boardID";

    $receiverRatResult = mysqli_fetch_assoc(mysqli_query($connection,$sql));
    $newReceiverRating = intval($receiverRatResult['rating_num']) + $rcvrRatChange;


    //update sender rating
    $sql = "UPDATE Rating 
		    SET rating_num = $newSenderRating
			WHERE board_id = $boardID AND user_id = $senderID";

    if (mysqli_query($connection, $sql))
    {
        echo "Record updated successfully";
    }
    else
    {
        echo "Error updating record: " . mysqli_error($connection);
    }


    //update receiver rating
    $sql = "UPDATE Rating 
		    SET rating_num = $newReceiverRating
			WHERE board_id = $boardID AND user_id = $receiverID";

    if (mysqli_query($connection, $sql))
    {
        echo "Record updated successfully";
    }
    else
    {
        echo "Error updating record: " . mysqli_error($connection);
    }


    //create match
    $date = "2018-01-01"; //TODO actual date stuff
    $sql = "INSERT INTO Game_Match (date, sender_score, sndr_rat_change, board_id, submission_id, sender_id, receiver_id, receiver_score, rcvr_rat_change)
            VALUES('$date', $senderScore, $sndrRatChange, $boardID, $submissionID, $senderID, $receiverID, $receiverScore, $rcvrRatChange)";

    if (mysqli_query($connection, $sql))
    {
        echo "Record updated successfully";
    }
    else
    {
        echo "Error updating record: " . mysqli_error($connection);
    }


    //delete submission
    $sql = "DELETE FROM Result_Submission
		    WHERE submission_id = $submissionID";

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

function getResultData($submissionID)
{
    $connection = connectToDB();

    $sql = "SELECT *
            FROM Result_Submission
 	        WHERE submission_id = $submissionID";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}

function isLbMember($userID, $boardID)
{
    $connection = connectToDB();

    $sql = "SELECT *
            FROM Competes_in
 	        WHERE board_id = $boardID AND user_id = $userID";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return (mysqli_num_rows($result) > 0);
}

function hasLbRating($userID, $boardID)
{
    $connection = connectToDB();

    $sql = "SELECT *
            FROM Rating
 	        WHERE board_id = $boardID AND user_id = $userID";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return (mysqli_num_rows($result) > 0);
}

function leaveLeaderboard($userID, $boardID)
{
    $connection = connectToDB();

    $sql = "DELETE FROM Competes_in
		    WHERE board_id = $boardID AND user_id = $userID";

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

function joinLeaderboard($userID, $boardID)
{
    $connection = connectToDB();

    $sql = "INSERT INTO Competes_in (board_id, user_id)
            VALUES ($boardID, $userID)";

    if (mysqli_query($connection, $sql))
    {
        echo "Record updated successfully";
    }
    else
    {
        echo "Error updating record: " . mysqli_error($connection);
    }

    if(!hasLbRating($userID,$boardID))
    {
        $sql = "INSERT INTO Rating (board_id, user_id)
                VALUES ($boardID, $userID)";

        if (mysqli_query($connection, $sql))
        {
            echo "Record updated successfully";
        }
        else
        {
            echo "Error updating record: " . mysqli_error($connection);
        }

        updateSkillDivision($userID,$boardID);
    }

    mysqli_close($connection);
}

function updateSkillDivision($userID, $boardID)
{
    $connection = connectToDB();

    //get user rating
    $sql = "SELECT R.rating_num
            FROM Rating AS R
            WHERE R.user_id = $userID AND R.board_id = $boardID";

    $userRating = mysqli_fetch_assoc(mysqli_query($connection,$sql))['rating_num'];

    //get division data
    $sql = "SELECT division_id
            FROM Skill_Division
            WHERE $userRating >= min_thresh AND $userRating <= max_thresh";

    $newUserDivision = mysqli_fetch_assoc(mysqli_query($connection,$sql))['division_id'];

    //update receiver rating
    $sql = "UPDATE Rating 
		    SET division_id = $newUserDivision
			WHERE board_id = $boardID AND user_id = $userID";

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


