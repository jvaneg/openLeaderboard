<?php


/**
 * Purpose: Connects to the database, returns connection variable
 * @return mysqli
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


/**
 * Purpose: Retrieves the name and bio of the specified user
 *          Returns in the form:
 *          name, description
 * @param $userID
 * @return bool|mysqli_result
 */
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


/**
 * Purpose: Searches the user list for user names that contain the specified string (case sensitive)
 *          Return format:
 *          name, user_id, numLBs
 * @param $searchTerm
 * @return bool|mysqli_result
 */
function searchUsersByName($searchTerm)
{
    $connection = connectToDB();

    $searchTerm = mysqli_real_escape_string($connection, $searchTerm); //TODO ask arsh what this is for

    $sql = "SELECT U.name, U.user_id, Count(C.user_id) AS numLBs 
            FROM User AS U, Competes_in AS C 
            WHERE U.name Like '%$searchTerm%' AND U.user_id = C.user_id
            GROUP BY U.name 
            ORDER BY COUNT(C.user_id) DESC";

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


/**
 * Purpose: Returns the names and ids of all leaderboards managed by the specified user
 *          Return format:
 *          name, board_id
 * @param $userID
 * @return bool|mysqli_result
 */
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


/**
 * Purpose: Retrieves some info about every leaderboard the specified user is a member of, including name,
 *          rank, rating, and division
 *          Return format:
 *          l_name, board_id, rating_num, rank, rank_image
 * @param $userID
 * @return bool|mysqli_result
 */
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


/**
 * Purpose: Retrieves the name and description of the specified leaderboard
 *          Returns in the form:
 *          name, description
 * @param $boardID
 * @return bool|mysqli_result
 */
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


/**
 * Purpose: Searches the leaderboard list for board names that contain the specified string (case sensitive)
 *          Return format:
 *          name, board_id, numUsers
 * @param $searchTerm
 * @return bool|mysqli_result
 */
function searchLbsByName($searchTerm)
{
    $connection = connectToDB();

    $searchTerm = mysqli_real_escape_string($connection, $searchTerm); //TODO ask arsh what this is for

    $sql =  "SELECT L.name, L.board_id, COUNT(C.user_id) AS numUsers 
            FROM Competes_in AS C, Leaderboard AS L 
            WHERE L.name Like '%$searchTerm%' AND L.board_id = C.board_id
            GROUP BY L.name";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
}


/**
 * Purpose: Retrieves all the members of the specified leaderboard, ranked by rating and skipping rank on ties
 *          Returns in the form:
 *          name, user_id, rating_num, rank, rank_image
 * @param $boardID
 * @return bool|mysqli_result
 */
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


/**
 * Purpose: Returns all results requests submitted to the specified user
 *          Returns in the form:
 *          submission_id, l_name, board_id, sender_score, receiver_score, name, sender_id, rcvr_rat_change
 * @param $userID
 * @return bool|mysqli_result
 */
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


/**
 * Purpose: Returns all results requests submitted by the specified user
 *          Returns in the form:
 *          submission_id, l_name, board_id, sender_score, receiver_score, name, receiver_id, sndr_rat_change
 * @param $userID
 * @return bool|mysqli_result
 */
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


/**
 * Purpose: Edits the specified user's bio to be the specified bio string
 * @param $userID
 * @param $userBio
 */
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


/**
 * Purpose: Edits the specified user's bio to be the specified bio string
 * Note: userID included so that users who aren't the lb owner can't modify things
 * @param $userID
 * @param $boardID
 * @param $lbDesc
 */
function editLbDescription($userID, $boardID, $lbDesc)
{
    $connection = connectToDB();

    $sql = "UPDATE Leaderboard AS L
            SET L.description = '$lbDesc'
            WHERE L.owner_id = $userID AND L.board_id = $boardID";

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


/**
 * Purpose: Removes a result submitted to the specified user from the database
 * Note: receiverID included as a measure to prevent someone from removing matches they shouldn't be able to
 * @param $submissionID
 * @param $receiverID
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


/**
 * Purpose: Removes a result submitted by the specified user from the database
 * Note: senderID included as a measure to prevent someone from removing matches they shouldn't be able to
 * @param $submissionID
 * @param $senderID
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


/**
 * Purpose: Verfies a result submitted to the specified user
 * Process:
 *  - get sender rating
 *  - calculate new sender rating
 *  - get receiver rating
 *  - calculate new receiver rating
 *  - update sender rating
 *  - update receiver rating
 *  - create match entry in the db from the submission info
 *  - delete the submission from the db
 * Note: convert the inputs to intvals before passing them to this function if they're strings
 * @param $submissionID
 * @param $senderID
 * @param $receiverID
 * @param $boardID
 * @param $senderScore
 * @param $receiverScore
 * @param $sndrRatChange
 * @param $rcvrRatChange
 */
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
    $date = date("Y-m-d");
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

/**
 * Purpose: Gets all the data of a specified result submission from the db
 * @param $submissionID
 * @return bool|mysqli_result
 */
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


/**
 * Purpose: Checks whether or not a specified user is a member of a specified leaderboard
 * @param $userID
 * @param $boardID
 * @return bool
 */
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


/**
 * Purpose: Checks whether or not a specified user is the admin of a specified leaderboard
 * @param $userID
 * @param $boardID
 * @return bool
 */
function isLbAdmin($userID, $boardID)
{
    $connection = connectToDB();

    $sql = "SELECT *
            FROM Leaderboard
 	        WHERE board_id = $boardID AND owner_id = $userID";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return (mysqli_num_rows($result) > 0);
}


/**
 * Purpose: Checks whether or not a specified user is a site administrator
 * @param $userID
 * @return bool
 */
function isSiteAdmin($userID)
{
    $connection = connectToDB();

    $sql = "SELECT *
            FROM Site_Admin
 	        WHERE user_id = $userID";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return (mysqli_num_rows($result) > 0);
}


/**
 * Purpose: Checks if a specified user has a rating on a specified leaderboard yet
 * Note: This is used mainly for users rejoining leaderboards they've left, letting us
 *       maintain their stats
 * @param $userID
 * @param $boardID
 * @return bool
 */
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


/**
 * Purpose: Removes the specified user from the specified leaderboard
 * @param $userID
 * @param $boardID
 */
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


/**
 * Purpose: Adds the specified user to the specified leaderboard
 * @param $userID
 * @param $boardID
 */
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


/**
 * Purpose: Updates the specified user's skill division (rank image) on the specified leaderboard
 * Note: Used after their rating updates
 * @param $userID
 * @param $boardID
 */
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


/**
 * Purpose: Removes a specified user from a specified leaderboard
 *          Only works if the specified admin is an admin of the leaderboard
 * @param $adminID
 * @param $userID
 * @param $boardID
 */
function removeUserFromLb($adminID, $userID, $boardID)
{
    $connection = connectToDB();

    if(isLbAdmin($adminID,$boardID))
    {
        $sql = "DELETE FROM Competes_in
                WHERE board_id = $boardID AND user_id = $userID";

        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }

    mysqli_close($connection);
}


/**
 * Purpose: Checks if a specified leaderboard name already exists in the database
 * @param $lbName
 * @return bool
 */
function lbNameTaken($lbName)
{
    $connection = connectToDB();

    $sql = "DELETE FROM Leaderboard
            WHERE name = '$lbName'";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return (mysqli_num_rows($result) > 0);
}


/**
 * Purpose: Returns the category id of a specified category name
 *          If there is no associated category, returns -1
 * @param $categoryName
 * @return int
 */
function getCategoryIDByName($categoryName)
{
    $connection = connectToDB();

    $sql = "SELECT category_id
            FROM Category
            WHERE name = '$categoryName'";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    if($row = mysqli_fetch_assoc($result))
    {
        return $row['category_id'];
    }
    else
    {
        return -1;
    }
}


/**
 * Purpose: Returns the board id of a specified board name
 *          If there is no associated board, returns -1
 * @param $boardName
 * @return int
 */
function getBoardIDByName($boardName)
{
    $connection = connectToDB();

    $sql = "SELECT board_id
            FROM Leaderboard
            WHERE name = '$boardName'";

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    if($row = mysqli_fetch_assoc($result))
    {
        return $row['board_id'];
    }
    else
    {
        return -1;
    }
}


/**
 * Purpose: Adds a new leaderboard to the database
 *          Returns the new board's id, or -1 if there was a failure creating it
 * @param $name
 * @param $description
 * @param $categoryID
 * @param $userID
 * @return int
 */
function addLeaderboard($name, $description, $categoryID, $userID)
{
    $connection = connectToDB();

    //add user to beard admins
    $sql = "INSERT INTO Board_Admin
            VALUES($userID)";

    if (mysqli_query($connection, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }

    //create new leaderboard
    $sql = "INSERT INTO Leaderboard (name, description, category_id, owner_id)
            VALUES('$name', '$description', $categoryID, $userID)";

    if (mysqli_query($connection, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }

    $boardID = getBoardIDByName($name);

    if($boardID != -1)
    {
        joinLeaderboard($userID, $boardID);
    }

    mysqli_close($connection);

    return $boardID;
}

?>


