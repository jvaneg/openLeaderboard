<?php

session_start();

if(isset($_POST['submit']))
{
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

    // $connection = connectToDB();
    // $uid = mysqli_real_escape_string($connection, $_POST['uid']);
    // $name = mysqli_real_escape_string($connection, $_POST['name']);
    // $pswd = mysqli_real_escape_string($connection, $_POST['pswd']);
    // mysqli_close($connection);

    $name = $_POST['name'];
    $pswd = $_POST['pswd'];

    if(empty($name) || empty($pswd))
    {
        header("Location: /index.php?login=empty");
        exit();
    }
    else
    {
        $result  = checkUserInDB($name);
        $resultCheck = mysqli_num_rows($result);

        //if no such user found from in the db
        if($resultCheck < 1)
        {
            header("Location: /index.php?login=error");
            exit();
        }
        else
        {
            if($row = mysqli_fetch_assoc($result))
            {
                $hashPswd = password_verify($pswd,$row['pswd']);
                if($hashPswd == false)
                {
                    header("Location: /index.php?login=error");
                    exit();
                }
                elseif($hashPswd == true)
                {
                    $_SESSION['user_id'] = $row['user_id'];
                    header("Location: /pages/profile.php");
                    exit();
                }
            }
        }
    }
}
else
{
    header("Location: ../index.php?login=error");
    exit();
}