<?php

session_start();

if(isset($_POST['submit']))
{
    include 'db.inc.php';

    $uid = mysqli_real_escape_string($connection, $_POST['uid']);
    $pswd = mysqli_real_escape_string($connection, $_POST['pswd']);


    if(empty($uid) || empty($pswd))
    {
        header("Location: ../index.php?login=empty");
        exit();
    }
    else
    {
        $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
        $result = mysqli_query($connection,$sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck < 1)
        {
            header("Location: ../index.php?login=error");
            exit();
        }
        else
        {
            if($row = mysqli_fetch_assoc($result))
            {
                // check if the password entered is correct
                $hashedPswdCheck = password_verify($pswd, $row['user_pswd']);
                if($hashedPswdCheck == false)
                {
                    header("Location: ../index.php?login=error");
                    exit();
                }
                elseif($hashedPswdCheck == true)
                {
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uid'] = $row['user_uid'];
                    header("Location: ../index.php?login=success");
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