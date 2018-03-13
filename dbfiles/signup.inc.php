<?php


// if the user clicked on the submit buttion then process the form
//else return to signup

// $first_error = $last_error =  $email_error = $uid_error = $pswd_error = "";

//if($_SERVER['submit'] == "POST")
if(isset($_POST['submit']))
{
    include_once 'db.inc.php';
    // $first = mysqli_real_escape_string($connection,$_POST['first']);
    // $last = mysqli_real_escape_string($connection,$_POST['last']);
    // $email = mysqli_real_escape_string($connection,$_POST['email']);
    // $uid = mysqli_real_escape_string($connection,$_POST['uid']);
    // $pswd = mysqli_real_escape_string($connection,$_POST['pswd']);

    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $uid = $_POST['uid'];
    $pswd = $_POST['pswd'];

    
    
    
    // //checking if fields are filled?
    // if(empty($first))
    // {

    //     $first_error = "First name is required";
    //     // $_SESSION["first_error"] = "First name is required";

    //     // header("Location: ../signup.php?signup=empty");
    //     // exit();
    // }

    // if(empty($last))
    // {
    //     $last_error = "Last name is required";
    //     // $_SESSION["last_error"] = "Last name is required";
    // }

    // if(empty($email))
    // {
    //     $email_error = "Email is required";
    //     // $_SESSION["email_error"] = "Email is required";
    // }
    // if(empty($uid))
    // {
    //     $uid_error = "User name is required";
    //     // $_SESSION["uid_error"] = "User name is required";
    // }
    // if(empty($pswd))
    // {
    //     $pswd_error = "Password is required";
    //     // $_SESSION["pswd_error"] = "Password is required";
    // }

    //checking if fields are filled?
    if(empty($first) || empty($last)|| empty($email) || empty($uid) || empty($pswd))
    {
        header("Location: ../pages/signup.php?signup=emptyfield");
        exit();
    }
    else   
    {
        // checking for valid chars
        if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last) )
        {
            header("Location: ../pages/signup.php?signup=invalid");
            exit();
        }
        else
        {
            //checking for valid email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                header("Location: ../pages/signup.php?signup=invalidemail");
                exit();
            }
            else
            {
                //checking for existing user
                $sql = "SELECT * FROM users WHERE user_uid = '$uid'";
                $result = mysqli_query($connection, $sql);
                $resultCheck = mysqli_num_rows($result);
                
                //if >0 we have existing users
                if($resultCheck > 0)
                {
                    header("Location: ../pages/signup.php?signup=usertaken");
                    exit(); 
                }
                else
                {
                    //hash the damm password
                    $hashPswd = password_hash($pswd, PASSWORD_DEFAULT);

                    //setup the query
                    $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pswd) VALUES ('$first', '$last', '$email', '$uid', '$hashPswd');";

                    //now just run the query (insert it into the db)
                     mysqli_query($connection, $sql);
                     header("Location: ../pages/signup.php?signup=success");
                     $success = "Welcome to Elo leaderboard system!";
                     exit();
                }
            }
        }
    }
}
else
{
    header("Location: ../pages/signup.php");
    exit();
}